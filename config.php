<?php

  define("M_URL", "http://localhost/food/");
  define("CSS_DIR", "http://localhost/food/css/");
  
  function router($page) {
    return M_URL . $page;
  }

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
    
    return M_URL . "img/category/" . $image_name . $ext;
  }

?>