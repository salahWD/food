<?php

  if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])) {
    header("Location: " . Router::route($restaurant->url_name . "/dashboard"));
    exit();
  }else {
    if (isset($_SESSION["errors"]) && !empty($_SESSION["errors"]) && is_array($_SESSION["errors"]) && count($_SESSION["errors"]) > 0) {
      $errors = $_SESSION["errors"];
    }else {
      $errors = [];
    }
  }
?>

<section class="section section-lg">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <!-- Book a Table -->
        <div class="utility-box">
          <div class="utility-box-title bg-dark dark">
            <div class="bg-image" style="background-image: url(&quot;http://assets.suelo.pl/soup/img/photos/modal-review.jpg&quot;);"><img src="http://assets.suelo.pl/soup/img/photos/modal-review.jpg" alt="" style="display: none;"></div>
            <div>
              <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span>
              <h4 class="mb-0"><?= $restaurant->name;?></h4>
              <p class="lead text-muted mb-0">login to manage your restaurant.</p>
            </div>
          </div>
          <form method="POST" action="<?= Router::route($restaurant->url_name . "/login");?>" id="booking-form" class="booking-form" data-validate="true">
            <div class="utility-box-content">
              <?php if(isset($errors) && !empty($errors) && is_array($errors) && count($errors) > 0): ?>
                <?php foreach($errors as $err):?>
                  <?php if(is_array($err) && count($err) > 0): ?>
                    <?php foreach($err as $error_text):?>
                      <p class="text-danger small-text text-center"><?= $error_text;?></p>
                    <?php endforeach;?>
                  <?php else: ?>
                    <p class="text-danger small-text text-center"><?= $err;?></p>
                  <?php endif; ?>
                <?php endforeach;?>
              <?php endif; ?>
              <div class="form-group">
                <label>username:</label>
                <input type="text" name="username" class="form-control" required <?= isset($_SESSION["login_username"]) ? 'value="' . $_SESSION["login_username"] . '"': "";?>>
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="form-group">
                <span style="text-align:left;  display: inline-block;">
                  <a class="small-text" href="">Forgot password?</a>
                </span>
              </div>
            </div>
            <button class="utility-box-btn btn btn-secondary btn-block btn-lg btn-submit" type="submit">
              <span class="description">Login!</span>
              <span class="success">
                <svg x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg>
              </span>
              <span class="error">Try again...</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

</section>


<?php
  unset($_SESSION["errors"]);
  unset($_SESSION["login_username"]);
?>
