<?php

  class HomeController extends Controller {

    public function default_action() {

      /* Getting The [DB Connection] Instance */
      $db = DB::getInstance();

      include_once MODELS_URL . "restaurant.php";

      $restaurant = Restaurant::get_restaurant(1);

      /* Getting Page Data */
      $variables["custom_css"] = "home";
      $variables["foods"] = $restaurant->get_foods();
      $variables["categories"] = $restaurant->get_categories();

      /* Including The Page Requirments */
      $template = new Template();
      $template->view("home", 3, $variables);

    }

  }


?>