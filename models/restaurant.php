<?php

class Restaurant {
  public $id;
  public $name;
  public $number;
  public $whatsapp;
  public $order_msg;
  public $address;
  public $currency;
  public $username;
  public $password;


  public static function get_restaurant($id) {

    $sql = DBC::get_instance()->dbh->prepare("SELECT * FROM restaurants WHERE id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      $data = $sql->fetchObject("Restaurant");
      $data->currency = self::get_currency($data->currency);
      return $data;
    }else {
      return false;
    }

  }

  public static function get_restaurant_by_name($name) {

    $sql = DBC::get_instance()->dbh->prepare("SELECT * FROM restaurants WHERE url_name = ?");
    $sql->execute([$name]);

    if ($sql->rowCount() > 0) {
      $data = $sql->fetchObject("Restaurant");
      $data->currency = self::get_currency($data->id);
      return $data;
    }else {
      return false;
    }

  }

  public static function get_currency($id) {

    $db = DBC::get_instance()->dbh;
    $sql = $db->prepare(
      "SELECT C.* FROM restaurants R
      INNER JOIN currencies C ON C.id = R.currency
      WHERE R.id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetch(PDO::FETCH_OBJ);
    }else {
      return $id;
    }

  }

  public function get_foods(int $count = NULL) {

    $db = DBC::get_instance();

    if (!is_null($count)) {
      $limit = "LIMIT $count";
    }

    $sql = $db->dbh->prepare(
      "SELECT F.* FROM Restaurants R
      INNER JOIN menus M ON M.restaurant = R.id
      INNER JOIN categories C ON C.menu = M.id
      INNER JOIN foods F ON F.category = C.id
      WHERE R.id = ? $limit");
    $sql->execute([$this->id]);

    if ($sql->rowCount() > 0) {
      include_once MODELS_URL . "food.php";

      return $sql->fetchAll(PDO::FETCH_CLASS, "Food");
    }else {
      return [];
    }

  }

  public function get_categories() {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare(
      "SELECT C.* FROM Restaurants R
      INNER JOIN menus M ON M.restaurant = R.id
      INNER JOIN categories C ON C.menu = M.id
      WHERE R.id = ?");
    $sql->execute([$this->id]);

    if ($sql->rowCount() > 0) {
      include_once MODELS_URL . "food.php";

      return $sql->fetchAll(PDO::FETCH_CLASS, "Food");
    }else {
      return [];
    }

  }

}
