<?php

class manage_controller extends controller {
  
  public function default_action() {

    $this->admin_check();
    
    include MODELS_URL . "manage.php";
    $manage = new Manage($_SESSION["user"]->id);

    $view_data["foods"] = $manage->get_permetted_foods();

    $view_data["general"] = $manage->select_general("name");
    $currency = $manage->get_currency();
    $view_data["currency"] = $currency->icon;
    
    $template = new Template(null, 3, true);
    $template->view("food/manage.php", $view_data);

  }

}

?>