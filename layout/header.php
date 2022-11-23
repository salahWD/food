
<!-- Header -->
<header id="header" class="<?= $header_class ?? "absolute transparent";?>">

  <div class="container">
    <div class="row">
      <div class="col-md-3">
          <!-- Logo -->
          <div class="module module-logo light">
              <a href="<?= Router::route($restaurant->url_name);?>">
                <img src="<?= $restaurant->logo;?>" alt="" width="88">
              </a>
          </div>
      </div>
      <div class="col-md-9">
        <!-- Navigation -->
        <nav class="module module-navigation left mr-4">
          <ul id="nav-main" class="nav nav-main">
            <li><a href="<?= Router::route($restaurant->url_name);?>">Home</a></li>
            <?php if (isset($header_menus) && is_array($header_menus) && count($header_menus) > 0):?>
              <li class="has-dropdown">
                <a href="#">Menus</a>
                <div class="dropdown-container">
                  <ul class="dropdown-mega">
                    <?php foreach($header_menus as $menu):?>
                      <li><a href="<?= Router::route("$restaurant->url_name/menu/$menu->id");?>"><?= $menu->name;?></a></li>
                    <?php endforeach;?>
                  </ul>
                  <div class="dropdown-image">
                    <img src="<?= IMAGES_URL . "components/dropdown-about.jpg";?>" alt="">
                  </div>
                </div>
              </li>
            <?php endif;?>
            <li><a href="page-offers.html">Offers</a></li>
            <li><a href="page-contact.html">Contact</a></li>
          </ul>
        </nav>
        <div class="module left">
          <a href="http://wa.me/<?= $restaurant->whatsapp;?>" class="btn btn-primary"><span>Order</span></a>
        </div>
      </div>
      <!-- <div class="col-md-2">
          <a href="#" class="module module-cart right" data-toggle="panel-cart">
              <span class="cart-icon">
                  <i class="ti ti-shopping-cart"></i>
                  <span class="notification" style="display: none;">0</span>
              </span>
              <span class="cart-value">$<span class="value">0.00</span></span>
          </a>
      </div> -->
    </div>
  </div>

</header>
<!-- Header / End -->

<!-- Header - Mobile -->
<header id="header-mobile" class="light">

  <div class="module module-nav-toggle">
      <a href="#" id="nav-toggle" data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
  </div>

  <div class="module module-logo">
    <a href="<?= $restaurant->url_name;?>">
      <img src="<?= $restaurant->logo;?>" alt="">
    </a>
  </div>

  <!-- <a href="#" class="module module-cart" data-toggle="panel-cart">
      <i class="ti ti-shopping-cart"></i>
      <span class="notification">0</span>
  </a> -->

</header>
<!-- Header - Mobile / End -->


<!-- Panel Cart -->
<!-- <div id="panel-cart">
    <div class="panel-cart-container">
      <div class="panel-cart-title">
        <h5 class="title">Your Cart</h5>
        <button class="close" data-toggle="panel-cart"><i class="ti ti-close"></i></button>
      </div>
      <div class="panel-cart-content cart-details">
        <table class="cart-table">
          <tr>
            <td class="title">
              <span class="name"><a href="#product-modal" data-toggle="modal">Beef Burger</a></span>
              <span class="caption text-muted">Large (500g)</span>
            </td>
            <td class="price">$9.00</td>
            <td class="actions">
              <a href="#product-modal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a>
              <a href="#" class="action-icon"><i class="ti ti-close"></i></a>
            </td>
          </tr>
          <tr>
            <td class="title">
              <span class="name"><a href="#product-modal" data-toggle="modal">Extra Burger</a></span>
              <span class="caption text-muted">Small (200g)</span>
            </td>
            <td class="price text-success">$9.00</td>
            <td class="actions">
              <a href="#product-modal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a>
              <a href="#" class="action-icon"><i class="ti ti-close"></i></a>
            </td>
          </tr>
        </table>
        <div class="cart-summary">
            <div class="row">
                <div class="col-7 text-right text-muted">Order total:</div>
                <div class="col-5"><strong>$<span class="cart-products-total">0.00</span></strong></div>
            </div>
            <div class="row">
                <div class="col-7 text-right text-muted">Devliery:</div>
                <div class="col-5"><strong>$<span class="cart-delivery">0.00</span></strong></div>
            </div>
            <hr class="hr-sm">
            <div class="row text-lg">
                <div class="col-7 text-right text-muted">Total:</div>
                <div class="col-5"><strong>$<span class="cart-total">0.00</span></strong></div>
            </div>
        </div>
        <div class="cart-empty">
            <i class="ti ti-shopping-cart"></i>
            <p>Your cart is empty...</p>
        </div>
      </div>
    </div>
    <a href="checkout.html" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to checkout</span></a>
</div> -->

<!-- Panel Mobile -->
<nav id="panel-mobile">
  <div class="module module-logo bg-dark dark">
      <a href="#">
        <img src="<?= $restaurant->logo_secondary ?? $restaurant->logo;?>" alt="" width="88">
      </a>
      <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
  </div>
  <nav class="module module-navigation"></nav>
  <div class="module module-social">
      <h6 class="text-sm mb-3">Follow Us!</h6>
      <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
      <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
      <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
      <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
      <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
  </div>
</nav>


<!-- Content -->
<div id="content">
