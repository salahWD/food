<?php

class manage_Restaurants_controller extends controller {

  public function default_action() {// manage all foods

    $this->admin_check();

    include MODELS_URL . "manage.php";
    $manage = new Manage($_SESSION["admin"]->id);

    $result["Restaurants"] = $manage->select_Restaurants("name");

    $result["configration"] = $manage->get_Restaurants();
    $result["currencies"] = $manage->get_currencies();

    $template = new Template("", 3, true);
    $template->view("restaurants", $result);

  }

  public function update_action($data, $files) {// edit spesefic food

    $this->admin_check();
    if (isset($_SESSION["admin"]->id) && !empty($_SESSION["admin"]->id) && is_numeric(intval($_SESSION["admin"]->id))) {

      $id = $_SESSION["admin"]->id;// admin id

      include MODELS_URL . "manage.php";
      $manage = new Manage($id);

      $res = $manage->update_Restaurants($id, $data, $files);
      echo json_encode($res);

    }else {
      echo "Error";
    }
  }

}

?>
