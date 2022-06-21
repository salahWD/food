<?php

class manage_general_controller extends controller {
  
  public function default_action() {// manage all foods

    $this->admin_check();

    include MODELS_URL . "manage.php";
    $manage = new Manage($_SESSION["user"]->id);

    $result["general"] = $manage->select_general("name");

    $result["configration"] = $manage->get_general();
    $result["currencies"] = $manage->get_currencies();

    $template = new Template("", 3, true);
    $template->view("general.php", $result);

  }

  public function update_action($data, $files) {// edit spesefic food

    $this->admin_check();
    if (isset($_SESSION["user"]->id) && !empty($_SESSION["user"]->id) && is_numeric(intval($_SESSION["user"]->id))) {

      $id = $_SESSION["user"]->id;// admin id

      include MODELS_URL . "manage.php";
      $manage = new Manage($id);
  
      $res = $manage->update_general($id, $data, $files);
      echo json_encode($res);
      
    }else {
      echo "Error";
    }
  }

}

?>
