<div class="placeholder">
  <div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo Router::get_path("img") . DIRECTORY_SEPARATOR;?>simple-house-01.jpg">
  
    <div class="tm-header">
        <div class="container">
        <div class="row tm-header-inner">
          <div class="col-md-6 col-12">
            <img src="<?php echo Router::get_path("img") . DIRECTORY_SEPARATOR;?>simple-house-logo.png" alt="Logo" class="tm-site-logo" /> 
            <div class="tm-site-text-box">
              <h1 class="tm-site-title">My restaurant</h1>
              <h6 class="tm-site-description">order your food quickly</h6>	
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<span class="cart-container">
  <a href="<?php echo Router::get_path("cart");?>">
    <i class="fa fa-shopping-cart"></i>
  </a>
  <span id="notification" data-number="<?php echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]->orders): 0;?>" class="notification"><?php echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]->orders): 0;?></span>
  <button id="clear-cart" class="clear-cart btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>  
</span>