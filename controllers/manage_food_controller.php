<?php

class manage_food_controller extends controller {

  public function default_action() {// manage all foods

    $this->admin_check();

    include MODELS_URL . "manage.php";
    $manage = new Manage($_SESSION["admin"]->id);

    $view_data["foods"] = $manage->get_permitted_foods();

    $view_data["Restaurants"] = $manage->select_Restaurants("name");// [header] requires it
    $currency = $manage->get_currency();
    $view_data["currency"] = $currency->icon;

    $template = new Template(null, 3, true);
    $template->view("food/manage-all", $view_data);

  }

  public function manage_action($id) {// edit spesefic food

    $this->admin_check();
    if (isset($id) && !empty($id) && is_numeric(intval($id))) {

      include MODELS_URL . "manage.php";
      $manage = new Manage($_SESSION["admin"]->id);

      /* === Header Requires === */
      $view_data["Restaurants"] = $manage->select_Restaurants("name");

      /* === Page Data === */
      $view_data["food"] = $manage->manage_food($id);
      $currency = $manage->get_currency();
      $view_data["currency"] = $currency->icon;

      /* === Page Show === */
      $template = new Template(null, 3, true);
      $template->view("food/manage", $view_data);

    }else {
      echo "Error";
    }
  }

}

?>
