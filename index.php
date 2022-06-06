<?php
	
	/* Include General Files */

	include "config.php";
	include "class.php";
	include "DB.php";
	include "connection.php";

	/* Starting The Session */
	session_start();
	/* Initial The Cart */
	$cart = new Cart();
	$_SESSION["cart"] = $cart;

	/* Splitting Get Request Into Array For Better URL */
	if (isset($_GET["url"]) && !empty($_GET["url"])) {

		$get_arguments = rtrim($_GET["url"], '/');

		$URL = explode('/', $get_arguments);
	}else {
		$URL[0] = "home";
	}


	/* Routing And Handling Requests */
	$router = new Router($URL);

	###### Get Requests ######

	$router->get("login", function () {
		
		include CONTROLLERS_URL . "login_controller.php";
	
		$login_controller = new LoginController();
		$login_controller->run_action();
	});
	
	$router->get("home", function () {
		// creatting a controller
		include CONTROLLERS_URL . "home_controller.php";
		$home_controller = new HomeController();
		$home_controller->run_action();
		
	});

	$router->get("cart", function () {

		$view_data["foods"] 			= $_SESSION["cart"]->get_view_data();
		$view_data["total_price"] = $_SESSION["cart"]->calculate_total();
		$view_data["currency"] 		= $_SESSION["general"]->currency;
		$template = new Template();
		$template->view("cart.php", $view_data);

	});
	
	$router->get("logout", function () {

		// clear session and logout
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		header("Location: " . M_URL . "home");
		exit();

	});

	$router->get("data/category/#id", function ($id = NULL) {
		
		// proccessing the info and login
		$db = DB::getInstance();
		
		if ($id != NULL) {
			$data = $db->table("foods")->where("category", $id)->get()->toJson();
		}else {
			$data = $db->table("foods")->get()->toJson();
		}
		echo $data;

	});

	$router->get("category/#id", function ($id = NULL) {
		
		// creatting a controller
		include MODELS_URL . "category.php";
		include CONTROLLERS_URL . "category_controller.php";
		$category_controller = new CategoryController();

		if ($id != NULL && is_numeric($id)) {
			$category_controller->run_action("get_category", $id);
		}else {
			$category_controller->run_action();
		}
		
	});

	$router->get("food/#id", function ($id) {
		
		// creatting a controller
		include CONTROLLERS_URL . "home_controller.php";
		$home_controller = new HomeController();

		if ($id != NULL) {
			$home_controller->get_food($id);
		}else {
			header("Location: " . M_URL . "home");
			exit();
		}
		
	});

	$router->get("manage/food", function () {

		include CONTROLLERS_URL . "manage_controller.php";
		$manage_controller = new manage_controller();
		$manage_controller->run_action();

	});

	$router->get("dashboard", function () {

		include CONTROLLERS_URL . "dashboard_controller.php";
		$dashboard_controller = new dashboard_controller();
		$dashboard_controller->run_action();

	});
	

	######  POST Requests  ######

	$router->post("data/cart/#action", function ($post_data, $action) {

		if ($action == "default") {
			$result = $_SESSION["cart"]->add_order($post_data["id"], intval($post_data["count"]));
			$_SESSION["cart"]->set_cookie();
			
			echo json_encode($result);
			
		}elseif ($action == "confirm") {

			$result = $_SESSION["cart"]->pay_cart($_SESSION["general"]->order_msg);
			$_SESSION["cart"]->set_cookie();
			echo json_encode(["whatsapp" => $_SESSION["general"]->whatsapp, "msg" => $result]);

		}elseif ($action == "update") {
			
			$result = $_SESSION["cart"]->update_food_count($post_data["id"], $post_data["new_count"]);
			$_SESSION["cart"]->set_cookie();

			echo json_encode(["total_price" => $_SESSION["cart"]->calculate_total()]);

		}elseif ($action == "deleteorder") {
			
			$result = $_SESSION["cart"]->delete_order($post_data["id"]);
			$_SESSION["cart"]->set_cookie();
			echo json_encode($result);
		}elseif ($action == "delete") {
			
			$result = $_SESSION["cart"]->clear_cart();
			$_SESSION["cart"]->set_cookie();
			echo json_encode(["total_price" => $_SESSION["cart"]->calculate_total()]);

		}
		
		exit();
	});

	$router->post("login", function ($data) {

		include CONTROLLERS_URL . "login_controller.php";

		$login_controller = new LoginController($data["username"], $data["pass"]);
		$login_controller->login();
		print_r($login_controller);
		exit();

	});

	// $admin_page  = [
	// 	"dashboard",
	// 	"general"
	// ];

	// $operation_dirs  = [
	// 	"category",
	// 	"food",
	// ];
?>
