<?php

class Manage {

  public function __construct(private $admin_id) {}
  
  public function get_general() {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT * FROM general WHERE id = ?");
		$sql->execute([$_SESSION["user"]->id]);

    if ($sql->rowCount() > 0) {

      return $sql->fetch(PDO::FETCH_LAZY);

    }else {
      return false;
    }

  }

  public function select_general($selector) {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT $selector FROM general WHERE id = ?");
		$sql->execute([$_SESSION["user"]->id]);

    if ($sql->rowCount() > 0) {

      return $sql->fetch(PDO::FETCH_LAZY);

    }else {
      return false;
    }

  }

  public function get_permetted_foods() {

    $db = DBC::get_instance();
    $db = $db->dbh;

    $sql = $db->prepare(
      "SELECT foods.* FROM users
      INNER JOIN general ON general.id = users.restaurant_id
      INNER JOIN categories ON categories.restaurant_id = general.id
      INNER JOIN foods ON foods.category = categories.id
      WHERE users.id = ?");

    $sql->execute([$this->admin_id]);

      if ($sql->rowCount() > 0) {
        return $sql->fetchAll(PDO::FETCH_CLASS, "Order");
      }else {
        return [];
      }

  }

  public function get_currency() {

    $db = DBC::get_instance();
    $db = $db->dbh;

    $sql = $db->prepare(
      "SELECT currencies.icon FROM users
      INNER JOIN general ON general.id = users.restaurant_id
      INNER JOIN currencies ON currencies.id = general.currency
      WHERE users.id = ?");

    $sql->execute([$this->admin_id]);

      if ($sql->rowCount() > 0) {
        return $sql->fetch(PDO::FETCH_LAZY);
      }else {
        return [];
      }

  }

}



?>