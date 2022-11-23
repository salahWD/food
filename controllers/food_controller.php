<?php

  class FoodController extends Controller {

    public function default_action($id) {

      global $restaurant;

      include_once MODELS_URL . "food.php";
      include_once MODELS_URL . "restaurant.php";

      $variables["food"] = Food::get_food($id);


      if ($variables["food"] == NULL) {

        header("Location: " . Router::route($restaurant->url_name));
        exit();

      }else {

        $variables["header_class"] = "light";// header class => default: transparent absolute
        $variables["restaurant"] = $restaurant;
        $variables["currency"] = $restaurant->currency;

        $template = new Template();

        $template->view("food/get", 3, $variables);

      }

    }

  }


?>
