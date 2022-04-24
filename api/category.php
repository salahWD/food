<?php

  if(isset($URL[2]) && is_numeric($URL[2])) {

    $id = intval($URL[2]);

    $result = $db->table('foods')->select('id, name, price, description, image')->where("category", $id)->get();

    if ($db->getCount() == 0) {
      $result = $db->table('foods')->select('id, name, price, description, image')->get();
    }
  }else {
    $result = $db->table('foods')->select('id, name, price, description, image')->get();
  }

  echo $result->toJson();
  exit();

?>