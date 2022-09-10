<?php

class dashboard_controller extends controller {

  public function default_action() {
		/*
		
			1- check if admin
			2- check and get the restaurant id
			3- get the restaurant's required data
			4- view the data

		*/

		
    $this->admin_check();
		
    include MODELS_URL . "manage.php";
    $manage = new Manage($_SESSION["user"]->id);
		
		if ($manage->has_restaurant()) {
			
			$name = $manage->select_Restaurants("name");
			$view_data["Restaurants"] = $name;
			$template = new Template(null, 3, true);
			$template->view("dashboard", $view_data);
			
		}else {
			echo "There is No Restaurant To Be Managed For You! From Index.php";
			exit();
		}

  }

}

?>