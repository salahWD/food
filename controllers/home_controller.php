<?php

  class HomeController extends Controller {

    public function default_action() {

      /* Getting The [DB Connection] Instance */
      $db = DB::getInstance();

      $_SESSION["general"] = General::get_data(DBC::get_instance(), 1);

      /* Adding CSS Files */
      $custom_css = "home";// it can be an array

      /* Getting Page Data */
      $view_data["foods"] = $db->table("foods")->get();
      $view_data["categories"] = $db->table("categories")->select("id, name")->get();

      /* Including The Page Requirments */
      $template = new Template($custom_css);
      $template->view("home.php", $view_data);

    }

    public function get_food($id) {

      /* Getting The [DB Connection] Instance */
      $db = DB::getInstance();

      /* Adding CSS Files */
      // $custom_css = "home";// it can be an array

      /* Getting Page Data */
      $currency_id = $db->table("general")->select("currency")->where(1)->get()[0];
      $view_data["currency"] = $db->table("currencies")->where($currency_id->currency)->get()[0];
      $view_data["food"] = $db->table("foods")->where($id)->get()[0];
      
      if ($view_data["food"] == NULL) {
        
        $view_data["error_msg"] = "this food is not avalible.";
        $template = new Template();
        $template->view("error.php", $view_data);

      }else {

        /* Including The Page Requirments */
        // $template = new Template($custom_css);
        $template = new Template();
        $template->view("food/get.php", $view_data);

      }

    }

  }


?>