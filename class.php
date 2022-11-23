<?php

  /* Controller class */
  class Controller {

    public function run_action($action = "default", ...$args) {

      $action .= "_action";
      if (method_exists($this, $action)) {
        $this->$action(...$args);
      }
    }

    protected function admin_check() {

      if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"])) {
        $temp = new Template("error", 2, true);
        $temp->view("login_error");
        exit();
      }else {
        if (get_class($_SESSION["admin"]) != "Admin") {
          $temp = new Template("error", 2, true);
          $temp->view("login_error");
        }
      }

    }

  }

	class Router {
		private $handlers = [];
		private $not_found;
		public 	$restaurant_name;
		private const GET_METHOD  = "GET";
		private const POST_METHOD = "POST";
		private const ID          = "{id}";
		private const PARAM       = "{param}";

		public function get($url, $handler) {
			$this->add_handler(self::GET_METHOD, $url, $handler);
		}

		public function get_admin($url, $handler) {
			$this->add_handler(self::GET_METHOD, $url, $handler, true/* admin check */);
		}

		public function post($url, $handler) {
			$this->add_handler(self::POST_METHOD, $url, $handler);
		}

		public function post_admin($url, $handler) {
      $this->add_handler(self::POST_METHOD, $url, $handler, true/* admin check */);
		}

		protected function add_handler($method, $url, $handler, $admin_check = false) {
			$this->handlers[$method . ":" . $url] = [
				"url" => $url,
				"method" => $method,
				"handler" => $handler,
				"admin_check" => $admin_check,
			];
		}

		public function add_404($handler) {
			$this->not_found = $handler;
		}

		protected function has_id($url, $current_url) {
			/* $url => handler url like (=>url, funciton () {) */

			if (str_contains($url, self::ID)) {

				$allowed = ["*"];
				$path_arr = explode("/", $url);
				$id_index = array_search(self::ID, $path_arr);
				$url_arr = explode("/", $current_url);
				$id = isset($url_arr[$id_index]) ? $url_arr[$id_index]: null;

				if (is_numeric($id) && $id > 0 || in_array($id, $allowed)) {
					return $id;
				}else {
					return false;
				}
			}

		}

		public function restaurant_name($url) {

			$url_arr = explode("/", $url);
			if (is_string($url_arr[1]) && strlen($url_arr[1]) > 3) {

				$this->restaurant_name = $url_arr[1];
				return str_replace(implode("/", array_slice($url_arr, 0, 2)), "", $url);

			}else {
				return $url;
			}

		}

		protected function has_param($url, $current_url) {
			/* $url => handler url like (=>url, funciton () {) */

				if (str_contains($url, self::PARAM)) {

					$path_arr = explode("/", $url);
					$id_index = array_search(self::PARAM, $path_arr);

					$url_arr = explode("/", $current_url);
					$title = isset($url_arr[$id_index]) && !empty($url_arr[$id_index]) ? $url_arr[$id_index]: null;

					if ($title != null && is_string($title) && strlen($title) > 0) {
						return $title;
					}else {
						return false;
					}

				}

		}

		public function run($request_url, $is_admin = false) {
			$method         = $_SERVER["REQUEST_METHOD"];
			$callback = null;
			$id = null;
			$param = null;

			foreach($this->handlers as $i => $handler) {

				$id = null;
				$param = null;

				if (($handler["admin_check"] === true && $is_admin) || $handler["admin_check"] === false) {

					$id = $this->has_id($handler["url"], $request_url);
					$param = $this->has_param($handler["url"], $request_url);

					if ($id != false) {

						$handler["url"] = str_replace(self::ID, $id, $handler["url"]);

						if ($request_url == $handler["url"] && $handler["method"] == $method) {
							$callback = $handler["handler"];
							break;
						}
						continue;
					}else if ($param != false) {

						$handler["url"] = str_replace(self::PARAM, $param, $handler["url"]);
						if ($request_url == $handler["url"] && $handler["method"] == $method) {

							$callback = $handler["handler"];
							break;
						}
						continue;
					}else if ($request_url == $handler["url"] && $handler["method"] == $method) {
            // echo "<br>" . $request_url . "<br><br>";
						$callback = $handler["handler"];

					}
				}else {
					continue;
				}

			}

			if (!$callback) {
				if (!empty($this->not_found)) {
					$callback = $this->not_found;
				}
			}

			call_user_func_array($callback, [
				array_merge($_GET, $_POST, $_FILES, ["id" => $id, "param" => $param, "restaurant" => $this->restaurant_name])
			]);
			exit();

		}

		public static function route($page) {
			return M_URL . $page;
		}

		public static function set_session($name, $value) {
			if (!isset($_SESSION)) {
				session_start();
			}
			if (isset($_SESSION[$name])) {
				unset($_SESSION[$name]);
			}
			return $_SESSION[$name] = $value;
		}

		public static function get_session($name, $delete) {
			if (!isset($_SESSION)) {
				session_start();
			}
			if (isset($_SESSION[$name])) {
				$errors = $_SESSION[$name];
				if ($delete) {
					unset($_SESSION[$name]);
				}
				return $errors;
			}else {
				return null;
			}
		}

		public static function set_admin_session($admin_data) {
			if (!isset($_SESSION)) {
				session_start();
			}
      $_SESSION["admin"] = base64_encode(serialize($admin_data));
		}

		public static function get_admin_session() {
			if (!isset($_SESSION)) {
				session_start();
			}
			if (isset($_SESSION["admin"])) {
				// include_once MODELS_PATH . "admin.php";
				return unserialize(base64_decode($_SESSION["admin"]));
			}else {
				return null;
			}
		}

		public static function isset_session($name) {
			if (!isset($_SESSION)) {
				session_start();
			}
			return isset($_SESSION[$name]);
		}

	}

	class Template {

		public static function view($page, $level = 3, $variables = null) {
			/*
				$page   => view page in /views/$page
				$level  => require level [
					1 => only the $page,
					2 => $page with head and body close,
					3 => $page with header and footer,
					4 => $page with the header,
					5 => $page with the footer,
				]
			*/
			if (!empty($variables)) {
				extract($variables);
			}

			if ($level > 1) {
        include_once LAYOUT_PATH . "head.php";
			}

			if ($level == 3 || $level == 4 ) {
        include_once MODELS_URL . "menu.php";
        $header_menus = Menu::get_menus_list($restaurant->id, "id", "name");
				include_once LAYOUT_PATH . "header.php";
			}

			include_once VIEW_PATH . $page . ".php";// include the actual $page

			if ($level == 3 || $level == 5) {
				include_once LAYOUT_PATH . "footer.php";
			}
			if ($level > 1) {
				include_once LAYOUT_PATH . "close.php";
			}
		}

	}

	class Cart {
		public $db;
		public $orders = [];

		public function __construct() {

			$cookie_cart = $this->get_cookie();

			if ($cookie_cart) {

				if (count($cookie_cart->orders) > 0) {
					foreach($cookie_cart->orders as $order) {
						$this->add_order($order->id, $order->ordered_count);
					}
				}

			}

		}

		public function get_cookie() {

			if (isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) {
				$cookie = unserialize($_COOKIE["cart"]);
				if (get_class($cookie) == "Cart") {
					return $cookie;
				}else {
					return false;
				}
			}else {
				return false;
			}

		}

		public function set_cookie() {
			$month = time() + 108000;// 60 * 60 * 30
			setcookie("cart", serialize($this), $month, "/");
		}

		public function add_order($order_id, int $count = 1) {

			if (count($this->orders) > 0) {
				foreach($this->orders as $order) {
					if ($order->id == $order_id) {
						$order->ordered_count += $count;
						return true;
					}
				}

			}

			$db = DBC::get_instance()->dbh;

			$sql = $db->prepare("SELECT id, price FROM foods WHERE id = ?");
			$sql->execute([$order_id]);

			if ($sql->rowCount() > 0) {
				$order = $sql->fetchObject("Order");
				$order->ordered_count = $count;
				$this->orders[] = $order;
				return true;
			}else {
				return false;
			}

		}

		public function update_food_count($order_id, $new_count) {

			foreach($this->orders as $order) {
				if ($order->id == $order_id) {
					$order->ordered_count = $new_count;
					return true;
				}
			}
			return false;
		}

		public function delete_order($order_id) {

			foreach($this->orders as $i => $order) {
				if ($order->id == $order_id) {
					unset($this->orders[$i]);
					return true;
				}
			}
			return false;
		}

		public function calculate_total() {

			$total_price = 0;

			if (count($this->orders) > 0) {

				foreach ($this->orders as $order) {

					$total_price += intval($order->price) * intval($order->ordered_count);

				}
			}

			return $total_price;

		}

		public function clear_cart() {
			unset($this->orders);
			$this->orders = [];
			return true;
		}

		public function get_view_data() {

			$db = DBC::get_instance();

			if (count($this->orders) > 0) {

				$ids = [];
				$sql = "SELECT * FROM foods WHERE id IN (";

				foreach ($this->orders as $i => $order) {

					$ids[] = intval($order->id);

					if ($i == 0) {
						$sql .= "? ";
					}else {
						$sql .= ", ?";
					}
				}

				$sql .= ")";

				$stmt = $db->dbh->prepare($sql);
				$stmt->execute([...$ids]);

				if ($stmt->rowCount() > 0) {
					$orders = $stmt->fetchAll(PDO::FETCH_CLASS, "Order");

					foreach($orders as $show) {// the order's Data from DB to show them
						foreach($this->orders as $data) {// the order's data from cart [id, price, ordered_count]
							if ($show->id == $data->id) {
								$show->ordered_count = $data->ordered_count;
							}
						}
					}

					return $orders;
				}else {
					return [];
				}

			}else {
				return [];
			}

		}

		public function get_all_orders($selector) {

			$db = DBC::get_instance();
			$ids = [];

			foreach($this->orders as $order) {
				array_push($ids, $order->id);
			}

			$sql = $db->dbh->prepare("SELECT " . $selector . " FROM foods WHERE id IN ( ?" . str_repeat(", ?", count($this->orders) - 1) . ")");
			$sql->execute([...$ids]);

			if ($sql->rowCount() > 0) {
				return $sql->fetchAll(PDO::FETCH_ASSOC);
			}else {
				return false;
			}

		}

		public function pay_cart($msg) {

			$price = $this->calculate_total();

			$msg = explode("##", $msg);
			$full_msg = [];

			$names = $this->get_all_orders("name");
			$names = implode(", ", array_column($names, "name"));

			$full_msg = $msg[0] . $names . $msg[1];

			return $full_msg;

		}

	}

	class Order {
		public $id;
		public $price;
		public $ordered_count;
	}

	class Admin {
		public $id;
		public $username;
		public $password;
		public $permission;
	}

?>
