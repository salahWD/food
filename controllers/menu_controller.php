<?php

  class MenuController extends Controller {

    /*  show menu page  */
    public function default_action($id) {

      global $restaurant;

      include_once MODELS_URL . "menu.php";

      $variables["menu_info"] = Menu::get_menu($id);

      if ($variables["menu_info"] == NULL) {

        header("Location: " . Router::route($restaurant->url_name));
        exit();

      }else {

        $variables["header_class"]  = "light";// header class => default: transparent absolute
        $variables["custom_css"]    = "menu";
        $variables["restaurant"]    = $restaurant;
        $variables["categories"]    = Menu::get_categories($id);

        $template = new Template();
        $template->view("menu/get", 3, $variables);

      }

    }

    /*  show add menu page  */
    public function add_action() {

      global $restaurant;

      include_once MODELS_URL . "menu.php";

      if (Router::isset_session("admin")) {

        $variables["header_class"] = "light";// header class => default: transparent absolute
        $variables["restaurant"]    = $restaurant;
        $variables["custom_css"]    = "menu";
        $variables["custom_js"]     = "add_menu";

        $template = new Template();

        $template->view("menu/add", 3, $variables);

      }else {
        header("Location: " . Router::route($restaurant->url_name));
        exit();

      }

    }

    /*  handle post data and insert menu  */
    public function insert_action($info) {

      global $restaurant;

      include_once MODELS_URL . "menu.php";
      $admin = Router::get_admin_session();

      if (!empty($admin) && $admin->restaurant_id == $restaurant->id) {

        $menu = new Menu();

        $cat_imgs = [];
        foreach($info as $i => $post) {
          if (substr_count($i, "cat-") > 0) {
            $cat_imgs[$i] = $post;
          }
        }
        $result = $menu->insert_menu($info["name"], $info["desc"], $info["image"], json_decode($info["categories"]), $cat_imgs);

        echo json_encode(["success" => $result]);
        exit();
      }else {
        echo json_encode(["success" => false]);
        exit();
      }

    }

    /*  edit menu page  */
    public function edit_action($id) {

      global $restaurant;

      include_once MODELS_URL . "menu.php";
      $admin = Router::get_admin_session();

      if (!empty($admin) && $admin->restaurant_id == $restaurant->id) {

        $variables["menu_info"] = Menu::get_menu($id);

        if ($variables["menu_info"] == NULL) {

          header("Location: " . Router::route($restaurant->url_name));
          exit();

        }else {

          $variables["header_class"]  = "light";// header class => default: transparent absolute
          $variables["custom_css"]    = "menu";
          $variables["custom_js"]     = "add_menu";
          $variables["restaurant"]    = $restaurant;
          $variables["categories"]    = Menu::get_categories($id);

          $template = new Template();
          $template->view("menu/edit", 3, $variables);

        }

      }else {
        header("Location: " . Router::route($restaurant->url_name));
        exit();
      }

    }

    /*  update menu data  */
    public function update_action($params) {

      global $restaurant;

      include_once MODELS_URL . "menu.php";
      $admin = Router::get_admin_session();

      if (!empty($admin)) {

        $menu = new Menu();
        $menu->id = $params["menu_id"];

        if ($menu->has_access($admin->id)) {

          $cat_imgs = [];
          foreach($params as $i => $post) {
            if (substr_count($i, "cat-") > 0) {
              $cat_imgs[$i] = $post;
            }
          }

          $res = $menu->update_menu($admin->id, $params["name"], $params["desc"], $params["image"], json_decode($params["categories"]), $cat_imgs);
          echo json_encode(["success" => $res]);
        }else {
          echo json_encode(["success" => false, "error" => "no access"]);
        }

      }else {
        echo json_encode(["success" => false, "error" => "no admin permission"]);
      }
      exit();

    }

  }


?>
