<?php

  class HomeController extends Controller {

    public function default_action() {

      /* Getting The [DB Connection] Instance */
      $db = DB::getInstance();

      include_once MODELS_URL . "restaurant.php";
      include_once MODELS_URL . "menu.php";

      global $restaurant;

      /* Getting Page Data */
      $variables["restaurant"] = $restaurant;
      $variables["menus"] = Menu::get_menus($restaurant->id);
      $variables["categories"] = $restaurant->get_categories();
      $variables["custom_css"] = "home";

      /* Including The Page Requirments */
      $template = new Template();
      $template->view("home", 3, $variables);

    }

  }


?>
