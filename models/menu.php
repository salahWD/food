<?php

class Menu {
  public static function get_menu($id) {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT * FROM menus WHERE id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchObject("Menu");
    }else {
      return NULL;
    }

  }

  public static function get_menus($R_id, int $count = 50) {// restaurant id

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT * FROM menus WHERE restaurant = ? LIMIT $count");
    $sql->execute([$R_id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchAll(PDO::FETCH_CLASS, "Menu");
    }else {
      return [];
    }

  }

  private static function get_foods($id) {// menu id

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare(
      "SELECT F.name, F.price, SUBSTRING_INDEX(F.description, ' ', 7) AS description, F.id, F.category FROM foods F
      INNER JOIN categories C ON F.category = C.id
      INNER JOIN menus M ON C.menu = M.id
      WHERE M.id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      include_once MODELS_URL . "food.php";
      return $sql->fetchAll(PDO::FETCH_CLASS, 'Food');
    }else {
      return [];
    }

  }

  public static function get_categories($id) {// menu id

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT * FROM categories WHERE menu = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {

      include_once MODELS_URL . "category.php";
      $categories = $sql->fetchAll(PDO::FETCH_CLASS, 'Category');
      $foods = self::get_foods($id);

      foreach ($foods as $foo) {
        foreach ($categories as $cat) {
          if ($foo->category == $cat->id) {
            $cat->foods[] = $foo;
          }
        }
      }

      return $categories;
    }else {
      return [];
    }

  }

  public static function get_menus_list($R_id, ...$cols) {

    $db = DBC::get_instance();

    $columns = implode(", ", $cols);
    $sql = $db->dbh->prepare("SELECT $columns FROM menus WHERE restaurant = ?");
    $sql->execute([$R_id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchAll(PDO::FETCH_CLASS, 'Menu');
    }else {
      return [];
    }

  }

  public function insert_menu($name = "Untitled Menu", $desc = "This is menu description", $image, $categories = [], $cat_imgs) {

    /* ==== init ==== */
    include_once MODELS_URL . "manage.php";
    global $restaurant;
    $this->name         = Manage::check_text($name, 2);
    $this->description  = Manage::check_text($desc, 2);
    $this->image        = Router::route("img/menus/default.jpg");
    $errors             = [];

    /* ==== check ==== */
    if ($this->name == null) {
      $errors[] = "menu name is invalid!";
    }
    if ($this->description == null) {
      $errors[] = "menu description is invalid!";
    }
    if (isset($image) && !empty($image)) {
      $this->image = Manage::upload_img($image, IMAGES_PATH . "menus/") ?? $this->image;
    }

    foreach($categories as $i => $cat) {

      if ($cat != null) {

        $cat->name = Manage::check_text($cat->name, 4) ?? null;

        if ($cat->name == null) {
          $errors[] = "category name is invalid!";
        }
        if (isset($cat_imgs[$i]) && !empty($cat_imgs[$i])) {
          $cat->image = Manage::upload_img($cat_imgs[$i], IMAGES_PATH . "categories/");
          if ($cat->image == null) {// http://food.test/sanabel/img/categories/image.jpg
            $cat->image = Router::route("img/categories/default.jpg");
          }
        }else {
          $cat->image = Router::route("img/categories/default.jpg");
        }

        if (isset($cat->foods) && count($cat->foods) > 0) {
          foreach ($cat->foods as $food) {
            $food->name = Manage::check_text($food->name, 4) ?? null;
            $food->desc = Manage::check_text($food->desc, 4) ?? null;

            if ($food->name == null) {
              $errors[] = "food name is invalid!";
            }
            if ($food->desc == null) {
              $errors[] = "food description is invalid!";
            }
            if (!isset($food->price) || !is_numeric(intval($food->price)) || intval($food->price) < 0) {
              $errors[] = "food price is invalid!";
            }
          }

        }

      }

    }

    /* ==== insert / save ==== */
    if (count($errors) == 0) {

      $db = DBC::get_instance();

      $sql = $db->dbh->prepare("INSERT INTO menus (name, description, image, restaurant) VALUES (:name, :desc, :image, :rest)");
      $result = $sql->execute([
        ":name"   => $this->name,
        ":desc"   => $this->description,
        ":image"  => $this->image,
        ":rest"   => $restaurant->id
      ]);

      $menu_id = $db->dbh->lastInsertId();
      foreach ($categories as $i => $cat) {

        $sql = $db->dbh->prepare("INSERT INTO categories (name, image, menu) VALUES (:name, :image, :menu)");
        $result = $sql->execute([
          ":name"   => $cat->name,
          ":image"  => $cat->image,
          ":menu"   => $menu_id
        ]);
        $cat_id = $db->dbh->lastInsertId();

        if (is_array($cat->foods) && count($cat->foods) > 0) {

          foreach ($cat->foods as $food) {

            $sql = $db->dbh->prepare("INSERT INTO foods (name, price, description, image, category) VALUES (:name, :price, :desc, :img, :cat)");
            $result = $sql->execute([
              ":name"   => $food->name,
              ":price"  => $food->price,
              ":desc"   => $food->desc,
              ":img"   => Router::route("img/foods/default.jpg"),
              ":cat"    => $cat_id
            ]);
          }

        }

      }

      return $result;

    }else {
      print_r($errors);
    }

  }

  public function has_access($admin_id) {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare(
      "SELECT M.id FROM users U
      INNER JOIN restaurants R ON R.id = U.restaurant_id
      INNER JOIN menus M ON M.restaurant = R.id
      WHERE U.id = ?");
    $sql->execute([$admin_id]);

    if ($sql->rowCount() > 0) {
      $accessed_menus = $sql->fetchAll(PDO::FETCH_COLUMN, 0);
      return in_array($this->id, $accessed_menus);
    }else {
      return false;
    }


  }

  public function update_menu($admin_id, $name, $desc, $image, $categories = [], $cat_imgs = []) {

    /* ==== init ==== */
    include_once MODELS_URL . "manage.php";
    include_once MODELS_URL . "category.php";
    global $restaurant;
    $this->name         = Manage::check_text($name, 2);
    $this->description  = Manage::check_text($desc, 2);
    $errors             = [];

    /* ==== check ==== */
    if ($this->id == null || !intval($this->id) > 0) {
      $errors[] = "menu id is invalid!";
    }
    if ($this->name == null) {
      $errors[] = "menu name is invalid!";
    }
    if ($this->description == null) {
      $errors[] = "menu description is invalid!";
    }
    if (isset($image) && !empty($image)) {
      $this->image = Manage::upload_img($image, IMAGES_PATH . "menus/");
    }

    foreach($categories as $i => $cat) {

      if ($cat != null) {

        $cat->name  = Manage::check_text($cat->name, 4);

        if ($cat->name == null) {
          $errors[] = "category name is invalid!";
        }

        if (isset($cat->id) && is_numeric(intval($cat->id)) && intval($cat->id) > 0) {// update cateogry
          if (isset($cat_imgs[$i]) && !empty($cat_imgs[$i])) {// update category with new image
            $cat->image = Manage::upload_img($cat_imgs[$i], IMAGES_PATH . "categories/");
            if ($cat->image == null) {
              $cat->image = Router::route("img/categories/default.jpg");
            }
          }
        }else {
          if (isset($cat_imgs[$i]) && !empty($cat_imgs[$i])) {// new category with an image
            $cat->image = Manage::upload_img($cat_imgs[$i], IMAGES_PATH . "categories/");
            if ($cat->image == null) {
              $cat->image = Router::route("img/categories/default.jpg");
            }
          }else {// new category with no image
            $cat->image = Router::route("img/categories/default.jpg");
          }
        }

        if (!isset($cat->id) && (!isset($cat->image) || !is_string($cat->image) || strlen($cat->image) < 20)) {// 20 => https://food.test/img/categories/img_name.jpg
          $errors[] = "category image is invalid!";
        }

        if (isset($cat->foods) && is_array($cat->foods) && count($cat->foods) > 0) {
          foreach ($cat->foods as $food) {
            $food->name = Manage::check_text($food->name, 4) ?? null;
            $food->desc = Manage::check_text($food->desc, 4) ?? null;

            if ($food->name == null) {
              $errors[] = "food name is invalid!";
            }
            if ($food->desc == null) {
              $errors[] = "food description is invalid!";
            }
            if (!is_numeric(intval($food->price)) || intval($food->price) < 0) {
              $errors[] = "food price is invalid!";
            }
          }

        }

      }

    }

    /* ==== insert / save ==== */
    if (count($errors) == 0) {

      $db = DBC::get_instance();

      /* update menu data */

      $image_on = "";
      $exec = [
        ":name"   => $this->name,
        ":desc"   => $this->description,
        ":id"     => $this->id
      ];

      if (isset($this->image) && is_string($this->image) && strlen($this->image) > 20) {
        $image_on = ", image = :image";
        $exec[":image"] = $this->image;
      }

      $sql = $db->dbh->prepare(
        "UPDATE menus SET name = :name, description = :desc $image_on WHERE id = :id");
      $result = $sql->execute($exec);

      /* get accessed categories */
      $sql = $db->dbh->prepare(
        "SELECT C.id FROM users U
        INNER JOIN restaurants R ON R.id = U.restaurant_id
        INNER JOIN menus M ON M.restaurant = R.id
        INNER JOIN categories C ON C.menu = M.id
        WHERE U.id = ?");
      $sql->execute([$admin_id]);
      $accessed_cats = $sql->fetchAll(PDO::FETCH_COLUMN, 0);

      foreach ($categories as $cat) {

        if (isset($cat->id) && !empty($cat->id) && intval($cat->id) > 0 ) {// update category
          if (in_array($cat->id, $accessed_cats)) {

            $image_on = "";
            $exec = [
              ":name" => $cat->name,
              ":id" => $cat->id
            ];

            if (isset($cat->image) && !empty($cat->image) && is_string($cat->image) && strlen($cat->image) > 20) {
              $exec[":image"] = $cat->image;
              $image_on = ", image = :image";
            }

            /* UPDATE Category Data */
            $stmt = "UPDATE categories SET name = :name $image_on WHERE id = :id";
            $sql = $db->dbh->prepare($stmt);
            $result = $sql->execute($exec);

            if (count($cat->foods) > 0) {

              /* get accessed food */
              $accessed_foods = Category::get_accessed_foods($cat->id);
              if (count($cat->foods) > 0) {
                foreach ($cat->foods as $food) {
                  if (isset($food->id) && !empty($food->id) && intval($food->id) > 0 ) {
                    if (in_array($food->id, $accessed_foods)) {

                      $sql = $db->dbh->prepare(
                        "UPDATE foods SET name = :name, price = :price, description = :desc WHERE id = :id");
                      $result = $sql->execute([
                        ":name"   => $food->name,
                        ":price"  => $food->price,
                        ":desc"   => $food->desc,
                        ":id"    => $food->id
                      ]);
                    }else {
                      echo "no accessed food";
                      exit();
                    }
                  }else {

                    // insert food
                    $sql = $db->dbh->prepare("INSERT INTO foods (name, price, description, image, category) VALUES (:name, :price, :desc, :img, :cat)");
                    $result = $sql->execute([
                      ":name"   => $food->name,
                      ":price"  => $food->price,
                      ":desc"   => $food->desc,
                      ":img"   => Router::route("img/foods/default.jpg"),
                      ":cat"    => $cat->id
                    ]);

                  }
                }
              }
            }

          }else {
            return false;
            exit();
          }

        }else {// insert cat

          Category::insert_category($cat->name, $cat->image, $this->id, $cat->foods);
        }
      }

      return $result;

    }else {
      print_r($errors);
    }


  }

  public function delete_menu() {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("DELETE FROM menus WHERE id = ?");
    $res = $sql->execute([$this->id]);

    return $res;

  }

  public function delete_category($cats_ids) {
    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT C.id FROM categories C WHERE C.menu = ?");
    $sql->execute([$this->id]);
    $accessed_cats = $sql->fetchAll(PDO::FETCH_COLUMN, 0);

    $ids_lis = [];

    foreach ($cats_ids as $cat) {
      if (in_array($cat, $accessed_cats)) {
        array_push($ids_lis, $cat);
      }
    }

    if (count($ids_lis) > 0) {
      $strimp = implode(",", $ids_lis);
      $sql = $db->dbh->prepare("DELETE FROM categories WHERE id IN ($strimp)");
      return $sql->execute();
    }else {
      return false;
    }
  }

  public function delete_foods($foods_ids) {
    $db = DBC::get_instance();

    $sql = $db->dbh->prepare(
      "SELECT F.id FROM foods F
      INNER JOIN categories C ON C.id = F.category
      WHERE C.menu = ?");
    $sql->execute([$this->id]);
    $accessed_cats = $sql->fetchAll(PDO::FETCH_COLUMN, 0);

    $ids_lis = [];

    foreach ($foods_ids as $food) {
      if (in_array($food, $accessed_cats)) {
        array_push($ids_lis, $food);
      }
    }

    if (count($ids_lis) > 0) {
      $strimp = implode(",", $ids_lis);
      $sql = $db->dbh->prepare("DELETE FROM foods WHERE id IN ($strimp)");
      return $sql->execute();
    }else {
      return false;
    }
  }

}
