<?php
	session_start();

	/* Handling The Request */

	$pages = [
		"home",
	];

	$only_page  = [
		"login",
	];

	$api  = [
		"category",
	];

	$admin_page  = [
		"dashboard",
		"general"
	];

	$operation_dirs  = [
		"category",
		"food",
	];
	
	if (isset($_GET["url"]) && !empty($_GET["url"])) {

		$get_arguments = $_GET["url"];
		$get_arguments = rtrim($get_arguments, '/');
		$URL = explode('/', $get_arguments);
		
	}else {
		$URL[0] = "home";
	}

	/* Include General Files */

	include "config.php";
	include "DB.php";

	// Create Connection Instance To DB
	$db = DB::getInstance();

	// get general "site info"
	$configration = $db->table('general')->get()[0];
	/* Routing And Page Includes */

	if ($URL[0] == "data") {
		if (isset($URL[1]) && !empty($URL[1])) {
			if (in_array($URL[1], $api)) {
				include "api/" . $URL[1] . ".php";
				exit();
			}else {
				header("Location: " . M_URL . "home");
				exit();
			}
		}else {
			header("Location: " . M_URL . "home");
			exit();
		}
	}elseif (in_array($URL[0], $only_page)) {
		
		include "layout/head.php";
		include "view/" . $URL[0] . ".php";
		include "layout/close.php";
		exit();

	}elseif (in_array($URL[0], $admin_page)) {
	}elseif (in_array($URL[0], $operation_dirs)) {
		
		include "layout/head.php";
		include "layout/admin_header.php";
		
		if (!isset($URL[1])) {// index

			include "view/" . $URL[0] . "/index.php";

		}else if (is_numeric($URL[1])) {// [get] or [update] or [delete] spesefic item

			if ($_SERVER["REQUEST_METHOD"] == "GET") {

				include "view/" . $URL[0] . "/get.php";

			}else {

				if (isset($_POST["delete"])) {

					include "view/" . $URL[0] . "/delete.php";
					
				}else {

					include "view/" . $URL[0] . "/update.php";

				}
			}
		}else if ($URL[1] == "add") {

			include "view/" . $URL[0] . "/add.php";

		}

		include "layout/admin_footer.php";
		include "layout/close.php";

		exit();

	}elseif (in_array($URL[0], $pages)) {
		
		include "layout/head.php";
		include "layout/header.php";
		include "view/" . $URL[0] . ".php";
		include "layout/footer.php";
		include "layout/close.php";
		exit();

	}elseif ($URL[0] == "logout") {
		session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
		header("Location: " . M_URL . "home");
		exit();
	}else {
		include "layout/head.php";
		include "layout/header.php";
		include "view/home.php";
		include "layout/footer.php";
		include "layout/close.php";
		exit();
	}

	/* Routing And Page Includes */
?>