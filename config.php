<?php

  define("M_URL", "http://food.test" . DIRECTORY_SEPARATOR);
  define("M_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR);
  define("CONTROLLERS_URL", dirname(__FILE__) . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR );
  define("MODELS_URL", dirname(__FILE__) . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR );
  define("LAYOUT_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR . "layout" . DIRECTORY_SEPARATOR);
  define("VIEW_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR);
  define("CSS_URL", "http://localhost" . DIRECTORY_SEPARATOR . "food" . DIRECTORY_SEPARATOR . "css"  . DIRECTORY_SEPARATOR);
  define("IMAGES_URL", dirname(__FILE__) . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR);
  define("FOOD_IMAGES", dirname(__FILE__) . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "foods" . DIRECTORY_SEPARATOR);
  define("CATEGORIES_IMAGES", dirname(__FILE__) . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "categories" . DIRECTORY_SEPARATOR);
  define("LOGOS_IMAGES", dirname(__FILE__) . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "logos" . DIRECTORY_SEPARATOR);
  
  /* DB Congif */
  
  define("USERNAME", "root");
  define("PASSWORD", "");
  define("DATABASE", "food");
  define("HOST", "localhost");


  function validate($input_name, $validate_type, $post_method = INPUT_POST) {
    if (filter_has_var(INPUT_POST, $input_name)) {
      return filter_input(INPUT_POST, $input_name, $validate_type);
    }else {
      return NULL;
    }
  }

  function upload_img($img) {
    /*
      =======- $file_uploads -=======
      this variable is to use when upload a file in localhost
      becuse of you have to write /food in the url
    */
    $file_uploads = "/food/img/category/";
    $alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $image_name = "";

    for ($i=0; $i < 10; $i++) { 
      $image_name .= $alpha[rand(0, strlen($alpha)-1)];
    }

    $image_name .= ".";

    $name_array = explode(".", $img["name"]);
    $ext = end($name_array);

    move_uploaded_file($img["tmp_name"],  $_SERVER['DOCUMENT_ROOT'] . $file_uploads . $image_name . $ext);
    
    return M_PATH . "img/category/" . $image_name . $ext;
  }

?>