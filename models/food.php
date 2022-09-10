<?php

class Food {

  public static function get_food($id) {
    
    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT * FROM foods WHERE id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchObject("Food");
    }else {
      return NULL;
    }

  }

}