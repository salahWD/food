<?php

class Manage {

  public function __construct(private $admin_id) {}

  public function has_restaurant() {
    
    $db = DBC::get_instance();

    $sql = $db->dbh->prepare("SELECT restaurant_id FROM users WHERE id = ?");
		$sql->execute([$_SESSION["user"]->id]);

    if ($sql->rowCount() > 0) {

      return $sql->fetch(PDO::FETCH_LAZY);

    }else {
      return false;
    }
  }

  public function get_Restaurants() {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare(
      "SELECT * FROM Restaurants
      INNER JOIN users ON users.restaurant_id = Restaurants.id
      WHERE users.id = ?");
		$sql->execute([$this->admin_id]);

    if ($sql->rowCount() > 0) {

      return $sql->fetch(PDO::FETCH_LAZY);

    }else {
      return false;
    }

  }

  public function select_Restaurants($selector) {

    $db = DBC::get_instance();

    $sql = $db->dbh->prepare(
      "SELECT Restaurants.$selector FROM Restaurants
      INNER JOIN users ON users.restaurant_id = Restaurants.id
      WHERE users.id = ?");
		$sql->execute([$this->admin_id]);

    if ($sql->rowCount() > 0) {

      return $sql->fetch(PDO::FETCH_LAZY);

    }else {
      return false;
    }

  }

  public function get_permitted_foods() {

    $db = DBC::get_instance();
    $db = $db->dbh;

    $sql = $db->prepare(
      "SELECT foods.* FROM users
      INNER JOIN Restaurants ON Restaurants.id = users.restaurant_id
      INNER JOIN categories ON categories.restaurant_id = Restaurants.id
      INNER JOIN foods ON foods.category = categories.id
      WHERE users.id = ?");

    $sql->execute([$this->admin_id]);

      if ($sql->rowCount() > 0) {
        return $sql->fetchAll(PDO::FETCH_CLASS, "Order");
      }else {
        return [];
      }

  }

  public function get_permitted_categories() {

    $db = DBC::get_instance();
    $db = $db->dbh;

    $sql = $db->prepare(
      "SELECT categories.* FROM users
      INNER JOIN Restaurants ON Restaurants.id = users.restaurant_id
      INNER JOIN categories ON categories.restaurant_id = Restaurants.id
      WHERE users.id = ?");

    $sql->execute([$this->admin_id]);

      if ($sql->rowCount() > 0) {
        include MODELS_URL . "category.php";
        return $sql->fetchAll(PDO::FETCH_CLASS, "Category");
      }else {
        return [];
      }

  }

  public function get_currency() {

    $db = DBC::get_instance();
    $db = $db->dbh;

    $sql = $db->prepare(
      "SELECT currencies.* FROM users
      INNER JOIN Restaurants ON Restaurants.id = users.restaurant_id
      INNER JOIN currencies ON currencies.id = Restaurants.currency
      WHERE users.id = ?");

    $sql->execute([$this->admin_id]);

      if ($sql->rowCount() > 0) {
        return $sql->fetch(PDO::FETCH_LAZY);
      }else {
        return [];
      }

  }

  public function get_currencies() {

    $db = DBC::get_instance();
    $db = $db->dbh;

    $sql = $db->prepare("SELECT currencies.* FROM currencies");
    $sql->execute();

      if ($sql->rowCount() > 0) {
        return $sql->fetchAll();
      }else {
        return [];
      }

  }

  public function delete_food($id) {
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare("DELETE FROM foods WHERE id = ?");
    $result = $sql->execute([$id]);

    return $result;

  }

  public function delete_category($id) {
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare("DELETE FROM categories WHERE id = ?");
    $result = $sql->execute([$id]);

    return $result;

  }

  public function manage_food($id) {
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare("SELECT * FROM foods WHERE id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      return $sql->fetchObject("Order");
    }else {
      return false;
    }


  }

  public function manage_caterogy($id) {
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare("SELECT * FROM categories WHERE id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
      include MODELS_URL . "category.php";
      return $sql->fetchObject("Category");
    }else {
      return false;
    }


  }

  public function update_food($data, $files) {

    if (!empty($data)) {
      $check_array = ["id", "name", "price", "description"];
      foreach($check_array as $check) {
        if (!isset($data[$check]) || empty($data[$check])) {
          return false;
        }
      }
    }

    /* ==== Image Checks ==== */
    if (isset($files["image"]["name"]) && !empty($files["image"]["name"])) {

      $img = $files["image"];
      $accepted_imgs = [IMAGETYPE_WEBP, IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_JPC];

      if (!in_array(exif_imagetype($img["tmp_name"]), $accepted_imgs)) {
        return ["success" => false, "error" => "image type is not valid!"];
      }
      if ($img["size"] > 2621440) {// 2.5MB by Bytes
        return ["success" => false, "error" => "image size can't be more then 2.5MB!"];
      }
      if ($img["error"] != 0) {
        return ["success" => false, "error" => "error number: " . $img["error"] . "!"];
      }

      $image_name = $this->upload_img($img, FOOD_IMAGES);

      if ($image_name) {
        $query = "UPDATE `foods` SET name = ?, price = ?, description = ?, image = ? WHERE id = ?";
        $execute = [$data["name"], $data["price"], $data["description"], $image_name, $data["id"]];
      }else {
        return ["success" => false, "error" => "error uploading the image!"];
      }
    }else {
      // update data without updating the image
      $query = "UPDATE `foods` SET name = ?, price = ?, description = ? WHERE id = ?";
      $execute = [$data["name"], $data["price"], $data["description"], $data["id"]];
    }
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare($query);
    $result = $sql->execute($execute);

    if ($result) {
      return ["success" => true, "error" => ""];
    }else {
      return ["success" => false, "error" => "error updating DB data"];
    }

  }

  public function update_category($data, $files) {

    if (!empty($data)) {
      $check_array = ["id", "name", "description"];
      foreach($check_array as $check) {
        if (!isset($data[$check]) || empty($data[$check])) {
          return false;
        }
      }
    }

    /* ==== Image Checks ==== */
    if (isset($files["image"]["name"]) && !empty($files["image"]["name"])) {

      $img = $files["image"];
      $accepted_imgs = [IMAGETYPE_WEBP, IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_JPC];

      if (!in_array(exif_imagetype($img["tmp_name"]), $accepted_imgs)) {
        return ["success" => false, "error" => "image type is not valid!"];
      }
      if ($img["size"] > 2621440) {// 2.5MB by Bytes
        return ["success" => false, "error" => "image size can't be more then 2.5MB!"];
      }
      if ($img["error"] != 0) {
        return ["success" => false, "error" => "error number: " . $img["error"] . "!"];
      }

      $image_name = $this->upload_img($img, CATEGORIES_IMAGES);

      if ($image_name) {
        $query = "UPDATE `categories` SET name = ?, description = ?, image = ? WHERE id = ?";
        $execute = [$data["name"], $data["description"], $image_name, $data["id"]];
      }else {
        return ["success" => false, "error" => "error uploading the image!"];
      }
    }else {
      // update data without updating the image
      $query = "UPDATE `categories` SET name = ?, description = ? WHERE id = ?";
      $execute = [$data["name"], $data["description"], $data["id"]];
    }
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare($query);
    $result = $sql->execute($execute);

    if ($result) {
      return ["success" => true, "error" => ""];
    }else {
      return ["success" => false, "error" => "error updating DB data"];
    }

  }

  public function update_Restaurants($id, $data, $files) {

    if (!empty($data)) {

      $restaurant_id = $this->select_Restaurants("id");

      $check_array = ["phone", "whatsapp", "msg", "address", "currency"];
      foreach($check_array as $check) {
        if (!isset($data[$check]) || empty($data[$check])) {
          return false;
        }
      }
    }

    /* ==== Image Checks ==== */
    if (isset($files["image"]["name"]) && !empty($files["image"]["name"])) {

      $img = $files["image"];
      $accepted_imgs = [IMAGETYPE_WEBP, IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_JPC];

      if (!in_array(exif_imagetype($img["tmp_name"]), $accepted_imgs)) {
        return ["success" => false, "error" => "image type is not valid!"];
      }
      if ($img["size"] > 2621440) {// 2.5MB by Bytes
        return ["success" => false, "error" => "image size can't be more then 2.5MB!"];
      }
      if ($img["error"] != 0) {
        return ["success" => false, "error" => "error number: " . $img["error"] . "!"];
      }

      $image_name = $this->upload_img($img, LOGOS_IMAGES);

      if ($image_name) {
        $query = "UPDATE `Restaurants` SET `number` = ?, whatsapp = ?, order_msg = ?, `address` = ?, `currency` = ?, logo = ? WHERE id = ?";
        $execute = [$data["phone"], $data["whatsapp"], $data["msg"], $data["address"], $data["currency"], $image_name, $id];
      }else {
        return ["success" => false, "error" => "error uploading the image!"];
      }
    }else {
      // update data without updating the image
      $query = "UPDATE `Restaurants` SET `number` = ?, whatsapp = ?, order_msg = ?, `address` = ?, `currency` = ? WHERE id = ?";
      $execute = [$data["phone"], $data["whatsapp"], $data["msg"], $data["address"], $data["currency"], $id];
    }
    
    $db = DBC::get_instance();
    $sql = $db->dbh->prepare($query);
    $result = $sql->execute($execute);

    if ($result) {
      return ["success" => true, "error" => ""];
    }else {
      return ["success" => false, "error" => "error updating DB data"];
    }

  }

  // public function get_Restaurants($id) {

  //   if (!empty($data)) {
  //     $check_array = ["id", "name", "description"];
  //     foreach($check_array as $check) {
  //       if (!isset($data[$check]) || empty($data[$check])) {
  //         return false;
  //       }
  //     }
  //   }

  //   /* ==== Image Checks ==== */
  //   if (isset($files["image"]["name"]) && !empty($files["image"]["name"])) {

  //     $img = $files["image"];
  //     $accepted_imgs = [IMAGETYPE_WEBP, IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_JPC];

  //     if (!in_array(exif_imagetype($img["tmp_name"]), $accepted_imgs)) {
  //       return ["success" => false, "error" => "image type is not valid!"];
  //     }
  //     if ($img["size"] > 2621440) {// 2.5MB by Bytes
  //       return ["success" => false, "error" => "image size can't be more then 2.5MB!"];
  //     }
  //     if ($img["error"] != 0) {
  //       return ["success" => false, "error" => "error number: " . $img["error"] . "!"];
  //     }

  //     $image_name = $this->upload_img($img, CATEGORIES_IMAGES);

  //     if ($image_name) {
  //       $query = "UPDATE `categories` SET name = ?, description = ?, image = ? WHERE id = ?";
  //       $execute = [$data["name"], $data["description"], $image_name, $data["id"]];
  //     }else {
  //       return ["success" => false, "error" => "error uploading the image!"];
  //     }
  //   }else {
  //     // update data without updating the image
  //     $query = "UPDATE `categories` SET name = ?, description = ? WHERE id = ?";
  //     $execute = [$data["name"], $data["description"], $data["id"]];
  //   }
    
  //   $db = DBC::get_instance();
  //   $sql = $db->dbh->prepare($query);
  //   $result = $sql->execute($execute);

  //   if ($result) {
  //     return ["success" => true, "error" => ""];
  //   }else {
  //     return ["success" => false, "error" => "error updating DB data"];
  //   }

  // }

  private function generate_img_name($ext) {
    return substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 16 ) . "." . $ext;
  }

  public function upload_img($image, $url) {
    $img_name_array = explode(".", $image["name"]);
    $ext = end($img_name_array);
    $image_name = $this->generate_img_name($ext);
    $result = move_uploaded_file($image["tmp_name"], $url . $image_name);
    $dir = basename($url);
    if ($result) {
      return Router::get_path("img" . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR) . $image_name;
    }else {
      return false;
    }
  }

}



?>