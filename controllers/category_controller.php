<?php

class CategoryController extends Controller {

  public function default_action() {

     /* Getting Data */
      $view_data["categories"] = Category::get_all(1);

     /* Initial View */
      $template = new Template("manage-category.css");
      $template->view("category/get-all", $view_data);

  }

  public function get_category_action($cat_id) {

     /* Initial Objects And Connection */

      $category = new Category();

     /* Getting Data */
      $view_data["foods"] = $category->get_foods($cat_id);
      $count = count($view_data["foods"]);
      $view_data["currency"] = $_SESSION["Restaurant"]->currency;

     /* Including The Page Requirments */

      $template = new Template();

      if ($count != NULL && $count > 0) {
        $template->view("food/getall", $view_data);
      }else {
        $view_data["error_msg"] = "this category is not avalible!";
        $template->view("error", $view_data);
      }

  }

  public function get_menu_action() {

     /* Initial Objects And Connection */

      global $restaurant;

     /* Getting Data */
      $view_data["categories"] = Category::get_all($restaurant->id);
      $view_data["currency"] = $restaurant->currency;

     /* Including The Page Requirments */

      $template = new Template();

      if ($count != NULL && $count > 0) {
        $template->view("food/getall", $view_data);
      }else {
        $view_data["error_msg"] = "this category is not avalible!";
        $template->view("error", $view_data);
      }

  }

}


?>
