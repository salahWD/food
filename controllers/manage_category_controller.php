<?php

class manage_category_controller extends controller {

  public function default_action() {// manage all

    $this->admin_check();

    include MODELS_URL . "manage.php";
    $manage = new Manage($_SESSION["admin"]->id);

    $view_data["categories"] = $manage->get_permitted_categories();

    $view_data["Restaurants"] = $manage->select_Restaurants("name");// [header] requires it

    $template = new Template(null, 3, true);
    $template->view("category/manage-all", $view_data);

  }

  public function manage_action($id) {// edit spesefic food

    $this->admin_check();
    if (isset($id) && !empty($id) && is_numeric(intval($id))) {

      include MODELS_URL . "manage.php";
      $manage = new Manage($_SESSION["admin"]->id);

      /* === Header Requires === */
      $view_data["Restaurants"] = $manage->select_Restaurants("name");

      /* === Page Data === */
      $view_data["category"] = $manage->manage_caterogy($id);
      $currency = $manage->get_currency();
      $view_data["currency"] = $currency->icon;

      /* === Page Show === */
      $template = new Template(null, 3, true);
      $template->view("category/manage", $view_data);

    }else {
      echo "Error: page id is not valid!";
    }
  }

  public function delete_action($id) {

    $this->admin_check();
    if (isset($id) && !empty($id) && is_numeric(intval($id))) {

      include MODELS_URL . "manage.php";
      $manage = new Manage($_SESSION["admin"]->id);
      $result = $manage->delete_category(intval($id));
      echo json_encode($result);

    }else {
      echo "Error: page id is not valid!";
    }
  }

}

?>
