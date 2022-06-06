<?php

class Category {
  private $db;

  public function __construct($db, $data = NULL) {
    
    if ($data != NULL) {
      foreach($data as $dat => $value) {
        $this->$dat = $value;
      }
    }
    $this->db = $db;

  }

  public function get_foods($cat_id) {
    
    $sql = $this->db->prepare("SELECT * FROM foods WHERE category = ?");
    $sql->execute([$cat_id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchAll(PDO::FETCH_OBJ);
    }else {
      return [];
    }

  }

  public function get_all($R_id) {
    
    $sql = $this->db->prepare("SELECT * FROM categories WHERE R_id = ?");
    $sql->execute([$R_id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchAll(PDO::FETCH_CLASS, 'Category', [$this->db]);
    }else {
      return false;
    }

  }

}