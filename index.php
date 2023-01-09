<?php

	/* Include Restaurants Files */

	include_once "config.php";
	include_once "class.php";
	include_once "DB.php";
	include_once "connection.php";
  include_once MODELS_URL . "restaurant.php";

	/* Starting The Session */
	session_start();

	/* Initial The Cart */
	// $cart = new Cart();
	// $_SESSION["cart"] = $cart;

	/* ========== Routing And Handling Requests ==========*/
	$router = new Router();

  $request_parse = parse_url($_SERVER["REQUEST_URI"]);
  $url = $router->restaurant_name($request_parse["path"]);

	### Get Restaurant Segneture ###

  $restaurant = Restaurant::get_restaurant_by_name($router->restaurant_name);

  if (isset($restaurant) && !empty($restaurant) && is_object($restaurant) && get_class($restaurant) == "Restaurant") {

    ### Get Requests ###

    $router->get("/login", function () {
      include CONTROLLERS_URL . "login_controller.php";

      $login_controller = new LoginController();
      $login_controller->run_action("default");
    });

    $router->get("", function () {// Home is / === "" but most be "" to work
      // creatting a controller
      include CONTROLLERS_URL . "home_controller.php";
      $home_controller = new HomeController();
      $home_controller->run_action("default");

    });

    /*
      $router->get("/cart", function () {

        $view_data["foods"] 			= $_SESSION["cart"]->get_view_data();
        $view_data["total_price"] = $_SESSION["cart"]->calculate_total();
        $view_data["currency"] 		= $_SESSION["restaurant"]->currency;
        $template = new Template();
        $template->view("cart", $view_data);

      });
    */

    $router->get("/menu/{id}", function ($params) {

      // creatting a controller
      include CONTROLLERS_URL . "menu_controller.php";
      global $restaurant;

      $C = new MenuController();
      $admin = Router::get_admin_session();

      if (!empty($admin) && $admin->restaurant_id == $restaurant->id) {
        $action = "edit";
      }else {
        $action = "default";
      }

      $C->run_action($action, $params["id"]);

    });

    $router->get("/menu/add", function () {

      // creatting a controller
      include MODELS_URL . "menu.php";
      include CONTROLLERS_URL . "menu_controller.php";

      $C = new MenuController();

      $C->run_action("add");

    });

    $router->get("/logout", function () {
      global $restaurant;
      // clear session and logout
      session_unset();
      session_destroy();
      session_write_close();
      setcookie(session_name(),'',0,'/');
      header("Location: " . M_URL . $restaurant->url_name);
      exit();

    });

    $router->get("/f/{id}", function ($params) {
      include CONTROLLERS_URL . "food_controller.php";
      $C = new FoodController();
      $id = $params["id"];
      if ($id != NULL) {
        $C->run_action("default", $params["id"]);
      }else {
        header("Location: " . M_URL);
        exit();
      }

    });


    ###  POST Requests  ###

    $router->post("/login", function ($data) {

      include CONTROLLERS_URL . "login_controller.php";

      $login_controller = new LoginController();
      $login_controller->run_action("login", $data["username"], $data["password"]);
      exit();

    });

    $router->post("/manage/food/{param}", function ($post_data, $action) {

      if ($action == "delete_food") {

        if (is_numeric(intval($post_data["food_id"]))) {

          include MODELS_URL . "manage.php";

          $admin = Router::get_session_admin();
          $manage = new Manage($admin->id);

          $res = $manage->delete_food(intval($post_data["food_id"]));

          echo json_encode($res);
        }else {
          echo json_encode(false);
        }

      }else if ($action == "update_food") {

        if (is_numeric(intval($post_data["id"]))) {

          include MODELS_URL . "manage.php";

          $manage = new Manage($_SESSION["admin"]->id);
          $res = $manage->update_food($post_data, $_FILES);
          echo json_encode($res);
        }else {
          echo json_encode(false);
        }
      }

    });

    $router->post("/manage/category/{param}", function ($post_data, $action) {

      if (isset($post_data["id"]) && is_numeric(intval($post_data["id"]))) {

        include MODELS_URL . "manage.php";

        $admin = Router::get_session_admin();
        $manage = new Manage($admin->id);

        if ($action == "delete_category") {
          $res = $manage->delete_category(intval($post_data["id"]));

        }else if ($action == "update_category") {
          $res = $manage->update_category($post_data, $_FILES);

        }else {
          echo json_encode(false);
          exit();
        }

        echo json_encode($res);
        exit();

      }else {
        echo json_encode(false);
        exit();
      }

    });

    $router->post("/manage/restaurants", function () {

      include CONTROLLERS_URL . "manage_Restaurants_controller.php";
      $manage_controller = new manage_Restaurants_controller();
      $manage_controller->run_action("update", $_POST, $_FILES);

    });

    $router->post("/menu/add", function ($info) {

      include CONTROLLERS_URL . "menu_controller.php";
      $C = new MenuController();
      $C->run_action("insert", $info);

    });

    $router->post("/menu/edit", function ($info) {

      include CONTROLLERS_URL . "menu_controller.php";
      $C = new MenuController();
      $C->run_action("update", $info);

    });

    $router->post("/menu/delete", function ($info) {

      include CONTROLLERS_URL . "menu_controller.php";
      $C = new MenuController();
      $C->run_action("delete", $info);

    });

    $router->add_404(function() {
      echo "<h1>404</h1>";
    });


    ######  API Requests  ######


    // $router->post("api/cart/{param}", function ($post_data, $action) {

    // 	if ($action == "default") {
    // 		$result = $_SESSION["cart"]->add_order($post_data["id"], intval($post_data["count"]));
    // 		$_SESSION["cart"]->set_cookie();

    // 		echo json_encode($result);

    // 	}elseif ($action == "confirm") {

    // 		$result = $_SESSION["cart"]->pay_cart($_SESSION["Restaurant"]->order_msg);
    // 		$_SESSION["cart"]->set_cookie();
    // 		echo json_encode(["whatsapp" => $_SESSION["Restaurant"]->whatsapp, "msg" => $result]);

    // 	}elseif ($action == "update") {

    // 		$result = $_SESSION["cart"]->update_food_count($post_data["id"], $post_data["new_count"]);
    // 		$_SESSION["cart"]->set_cookie();

    // 		echo json_encode(["total_price" => $_SESSION["cart"]->calculate_total()]);

    // 	}elseif ($action == "deleteorder") {

    // 		$result = $_SESSION["cart"]->delete_order($post_data["id"]);
    // 		$_SESSION["cart"]->set_cookie();
    // 		echo json_encode($result);
    // 	}elseif ($action == "delete") {

    // 		$result = $_SESSION["cart"]->clear_cart();
    // 		$_SESSION["cart"]->set_cookie();
    // 		echo json_encode(["total_price" => $_SESSION["cart"]->calculate_total()]);

    // 	}

    // 	exit();
    // });

    $router->get("/api/category/{id}", function ($params = NULL) {

      extract($params);

      $db = DBC::get_instance()->dbh;

      if ($id != NULL) {

        $stmt = $db->prepare("SELECT * FROM foods WHERE category = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
          $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
          echo json_encode($data);
          return true;
        }

      }

      $stmt = $db->prepare("SELECT * FROM foods");
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

      echo json_encode($data);

    });


    $router->run($url, false);// false => $is_admin


  }else {

    echo "<h1>No Restaurant!!</h1>";
    echo "<br><br>";
    echo "<h1>food's Home Page Should Be Here</h1>";

  }

?>
