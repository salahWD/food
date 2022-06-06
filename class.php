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

      if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
        $temp = new Template(null, 2, true);
        $temp->view("error_no_admin_login.php");
        exit();
      }else {
				if (get_class($_SESSION["user"]) != "User") {
					$temp = new Template(null, 2, true);
					$temp->view("error_no_admin_login.php");
				}
			}

    }

  }


	/* Router Class */

	class Router {

		private $url;
		private $id = NULL;
		private $action = "default";

		public function __construct($url) {

			$this->url = $url;

		}

		public function post($page, $execution) {

			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$page = explode("/", $page);
				$aci = array_search("#action", $page);// action index
				
				if ($aci) {
					unset($page[$aci]);
					if (isset($this->url[$aci])) {
						$this->action = $this->url[$aci];
						unset($this->url[$aci]);
					}
				}
				
				foreach($page as $key => $attr) {// 0 = food, 1 = $id
					if (!isset($this->url[$key]) || $this->url[$key] != $attr)  {
						return false;
					}
				}
				
				$execution($_POST, $this->action);
				exit();

			}else {
				return false;
			}

		}

		public function get($page, $execution) {
			
			if ($_SERVER["REQUEST_METHOD"] == "GET") {

				$page = explode("/", $page);
				$idi = array_search("#id", $page);// id index
				$aci = array_search("#action", $page);// action index

				if ($idi) {
					unset($page[$idi]);
					if (isset($this->url[$idi]) && is_numeric($this->url[$idi])) {
						$this->id = intval($this->url[$idi]);
						unset($this->url[$idi]);
					}
				}
				
				if ($aci) {
					unset($page[$aci]);
					if (isset($this->url[$idi])) {
						$this->action = $this->url[$aci];
						unset($this->url[$aci]);
					}
				}
				
				// echo $id;
				// print_r($page);
				// echo "<br>";
				// print_r($this->url);
				// echo "<br>";
				// echo "<hr>";
				foreach($page as $key => $attr) {// 0 = food, 1 = $id
					if (!isset($this->url[$key]) || $this->url[$key] != $attr)  {
						return false;
					}
				}
				
				$execution($this->id, $this->action);
				exit();

			}else {
				return false;
			}

		}

		public static function get_path($page) {
			return M_URL . $page;
		}

	}


	/* Template Class */
	class Template {

		public function __construct(private $custom_css = NULL, private $include_level = 3, private $is_admin = false) {
			/*
				include level = [
					1 => just the page
					2 => page with head and close
					3 => page with header and footer
				]
				==============
				only header and footer are linked with [theme files] but
				open and close containes only information so they are'nt linked with theme files
			*/
		}

		public function view($view_name, $pass = NULL) {

			$custom_css = $this->custom_css;// in header it catch $custom_css variable and includes it as stylesheet

			if (is_array($pass)) {// extract all $pass[variables] to be global to use in included view
				foreach ($pass as $key => $value) {
					$$key = $value;
				}
			}

			if ($this->include_level > 1) {
				include LAYOUT_URL . "head.php";
			}

			if ($this->is_admin) {

				if ($this->include_level > 2) {
					include LAYOUT_URL . "admin_header.php";
				}

				include VIEWS_URL . $view_name;
				
				if ($this->include_level > 2) {
					include LAYOUT_URL . "admin_footer.php";
				}

			}else {
				
				if ($this->include_level > 2) {
					include LAYOUT_URL . "header.php";
				}

				include VIEWS_URL . $view_name;

				if ($this->include_level > 2) {
					include LAYOUT_URL . "footer.php";
				}
			}

			if ($this->include_level > 1) {
				include LAYOUT_URL . "close.php";
			}

		}

	}

	class General {
		public $id;
		public $name;
		public $number;
		public $whatsapp;
		public $order_msg;
		public $address;
		public $currency;
		public $username;
		public $password;
		private $db;

		public function __construct($db) {
			$this->db = $db;
		}


		public static function get_data($connection, $id) {

			$sql = $connection->dbh->prepare("SELECT * FROM general WHERE id = ?");
			$sql->execute([$id]);

			if ($sql->rowCount() > 0) {
				$data = $sql->fetchObject("general", [NULL]);
				$data->currency = self::get_currency($connection, $data->currency);
				return $data;
			}else {
				return false;
			}

		}

		public static function get_currency($connection, $c_id) {

			$sql = $connection->dbh->prepare("SELECT icon FROM currencies WHERE id = ?");
			$sql->execute([$c_id]);

			if ($sql->rowCount() > 0) {
				return $sql->fetch(PDO::FETCH_NUM)[0];
			}else {
				return $c_id;
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

			$this->db = DBC::get_instance()->dbh;

			$sql = $this->db->prepare("SELECT id, price FROM foods WHERE id = ?");
			$sql->execute([$order_id]);

			if ($sql->rowCount() > 0) {
				$order = $sql->fetchObject("Order");
				$order->ordered_count = $count;
				$this->orders[] = $order;
				$this->db = NULL;
				return true;
			}else {
				$this->db = NULL;
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
	
	class User {
		public $id;
		public $username;
		public $password;
		public $permission;
	}
?>