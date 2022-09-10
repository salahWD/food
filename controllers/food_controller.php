<?php

  class FoodController extends Controller {

    public function default_action($id) {

      include_once MODELS_URL . "food.php";
      include_once MODELS_URL . "restaurant.php";

      $food = Food::get_food($id);
      $variables["food"] = $food;
      
      $currency = Restaurant::get_currency(1);
      $variables["currency"] = $currency;

      $template = new Template();
      
      if ($variables["food"] == NULL) {
        
        $variables["error_msg"] = "this food is not avalible.";
        $template->view("error", 3, $variables);

      }else {

        $template->view("food/get", 3, $variables);

      }

    }

  }


?>