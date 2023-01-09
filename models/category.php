<?php

class Category {

  public function __construct($data = NULL) {

    if ($data != NULL) {
      foreach($data as $dat => $value) {
        $this->$dat = $value;
      }
    }

  }

  public function get_foods($cat_id) {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT * FROM foods WHERE category = ?");
    $sql->execute([$cat_id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchAll(PDO::FETCH_OBJ);
    }else {
      return [];
    }

  }

  public static function get_accessed_foods($cat_id) {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT id FROM foods WHERE category = ?");
    $sql->execute([$cat_id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchAll(PDO::FETCH_COLUMN, 0);
    }else {
      return [];
    }

  }

  public static function insert_category($cat_name, $cat_image, $menu, $foods) {

    if ($cat_image == null) {
      $cat_image = Router::route("img/categories/default.jpg");
    }

    $db = DBC::get_instance();
    $sql = $db->dbh->prepare(
      "INSERT INTO categories (name, image, menu) VALUES (:name, :image, :menu)");
    $res =$sql->execute([
      ":name"   => $cat_name,
      ":image"  => $cat_image,
      ":menu"   => $menu
    ]);

    if ($res) {
      $cat_id = $db->dbh->lastInsertId();
      if (is_array($foods) && count($foods) > 0) {

        foreach ($foods as $food) {

          $sql = $db->dbh->prepare("INSERT INTO foods (name, price, description, image, category) VALUES (:name, :price, :desc, :img, :cat)");
          $sql->execute([
            ":name"   => $food->name,
            ":price"  => $food->price,
            ":desc"   => $food->desc,
            ":img"   => Router::route("img/foods/default.jpg"),
            ":cat"    => $cat_id
          ]);
        }
      }
    }

    return $res;

  }

}


