<?php

  class HomeController extends Controller {

    public function default_action() {

      /* Getting The [DB Connection] Instance */
      $db = DB::getInstance();

      include_once MODELS_URL . "restaurant.php";

      global $restaurant;

      /* Getting Page Data */
      $variables["restaurant"] = $restaurant;
      $variables["foods"] = $restaurant->get_foods(3);
      $variables["categories"] = $restaurant->get_categories();

      /* Including The Page Requirments */
      $template = new Template();
      $template->view("home", 3, $variables);

    }

  }


?>
