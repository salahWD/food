<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* ========  Trim Data  ======== */
    foreach ($_POST as $k => $v) {
      $_POST[$k] = trim($v);
    }

    /* ========  Validate Data  ======== */
    $title        = validate("title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title_e      = false;
    $description  = validate("description", FILTER_SANITIZE_SPECIAL_CHARS);
    $desc_e       = false;


    /* ========  data Validation  ======== */
    
    if (strlen($title) <= 0) {
      $title_e = true;
    }

    if (strlen($description) <= 0) {
      $desc_e = true;
    }

    if (isset($_FILES['cat_img']) && !empty($_FILES['cat_img']["size"])) {

      $img = $_FILES["cat_img"];

      $types = [
        "image/jpeg",
        "image/jpg",
        "image/png",
        "image/svg+xml",
        "image/webp",
      ];

      /* ========  Image Validation  ======== */
      if ($img["size"] > 41943040) {// 41943040 = 5MB
        $img_e = "image size is very big!";
      }
      if (!in_array($img["type"], $types)) {
        $img_e = "image type is unacceptable!";
      }
    }else {
      $img_e = "no image selected!";
    }


    /* ========  Upload Image And Insert Data  ======== */

    if (!isset($img_e) && !$title_e && !$desc_e) {

      $img_link = upload_img($img);

      $db->insert('categories', [
        'name'          => $title,
        'description'   => $description,
        'image'	        => $img_link
      ]);

      header("Location: " . M_URL . "category");
      exit();
      
    }

  }

?>

<div class="container pt-5">
  <div class="text-center mb-4">
    <div class="img-container mb-4">
      <img src="https://via.placeholder.com/500x200/09f/fff" alt="logo" class="img-fluid img-thumbnail <?php if(isset($img_e) && !empty($img_e)) {echo "border-danger";}?>">
      <div class="edit-container">
        <?php if(isset($img_e) && !empty($img_e)) {?>
          <span class="text-danger"><?php echo $img_e;?></span>
        <?php }?>
        <button id="update-img-btn" class="edit-img-btn img-thumbnail"><i class="fa-solid fa-camera"></i></button>
      </div>
    </div>
    <h2 class="title">Create Category</h2>
  </div>
  <div class="card info-container text-center">
    <div class="card-body">
      <p class="card-text text-dark mb-4">please fill out all of the input fields</p>
      <form class="form" method="POST" action="<?php echo router("category");?>" enctype="multipart/form-data">
        <input class="hidden" type="file" name="cat_img" id="update-img-input">
        <div class="form-group">
          <label for="title">title</label>
          <input
                type="text"
                class="form-control <?php echo $title_e ? "is-invalid": "";?>"
                id="title"
                name="title"
                require
                placeholder="category title"
                value="<?php echo isset($title) ? $title: "";?>">
            <div class="invalid-feedback">
              title can't be empty
            </div>

          </div>
          <div class="form-group">
            <label for="description">description</label>
            <textarea
                type="number"
                class="form-control <?php echo $desc_e ? "is-invalid": "";?>"
                id="description"
                name="description"
                require
                placeholder="category description"
          ><?php echo isset($description) ? $description: "";?></textarea>
          <div class="invalid-feedback">
            description can't be empty
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>