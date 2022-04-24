<?php

  $configration = $db->table("general")->get()[0];

?>

<div class="container pt-5 pb-5" style="min-height: calc(100vh - 400px);">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">manage food</h5>
          <hr>
          <p class="card-text">manage all items in your menu</p>
          <a href="<?php echo M_URL;?>food" class="btn btn-primary mt-3"><i class="fa-solid fa-utensils"></i></a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">manage category</h5>
          <hr>
          <p class="card-text">manage all categories in the menu.</p>
          <a href="<?php echo M_URL;?>category" class="btn btn-primary mt-3"><i class="fa-solid fa-layer-group"></i></a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">general info</h5>
          <hr>
          <p class="card-text">to edit teasturant's general info</p>
          <a href="<?php echo M_URL;?>general" class="btn btn-primary mt-3"><i class="fa-regular fa-pen-to-square"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
