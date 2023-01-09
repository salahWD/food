<!-- Section - Main -->
<section class="section section-main section-main-3 bg-dark dark">

    <div class="bg-image bg-fixed" style="background-image: url(&quot;http://assets.suelo.pl/soup/img/photos/hero-burger.jpg&quot;);"><img src="http://assets.suelo.pl/soup/img/photos/hero-burger.jpg" alt="" style="display: none;"></div>

    <div class="container v-center">
        <div class="row">
            <div class="col-md-7 offset-md-3">
                <h1 class="display-2">We do <strong>The Best Burgers</strong> in London</h1>
                <h4 class="text-muted mb-5">Taste it now with our online order!</h4>
                <a href="page-offers.html" class="btn btn-outline-primary btn-lg"><span>Order now</span></a>
            </div>
        </div>
    </div>

</section>

<!-- Section - About -->
<section class="section section-bg-edge">

  <div class="image right col-md-6 offset-md-6">
      <div class="bg-image" style="background-image: url(&quot;http://assets.suelo.pl/soup/img/photos/bg-burger.jpg&quot;);"><img src="http://assets.suelo.pl/soup/img/photos/bg-burger.jpg" alt="" style="display: none;"></div>
  </div>

  <div class="container">
    <div class="col-lg-5 col-md-9">
      <div class="rate mb-5 rate-lg"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star"></i></div>
      <h1 class="display-2">Why <strong>our</strong> food?</h1>
      <p class="lead text-muted mb-5">Donec a eros metus. Vivamus volutpat leo dictum risus ullamcorper condimentum. Cras sollicitudin varius condimentum. Praesent a dolor sem....</p>
      <!-- Feature -->
      <div class="feature feature-1">
        <div class="feature-icon icon icon-primary"><i class="ti ti-desktop"></i></div>
        <div class="feature-content">
          <h4 class="mb-2">Online Order</h4>
          <p class="text-muted mb-0">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
        </div>
      </div>
        <!-- Feature -->
      <div class="feature feature-1">
        <div class="feature-icon icon icon-primary"><i class="ti ti-heart"></i></div>
        <div class="feature-content">
          <h4 class="mb-2">Perfect Taste</h4>
          <p class="text-muted mb-0">Vivamus volutpat leo dictum risus ullamcorper condimentum.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section - Menu -->
<section class="section cover protrude pull-up-10">

  <?php if (isset($menus) && is_array($menus) && count($menus) > 0):?>
    <div class="menu-sample-carousel carousel inner-controls" data-slick='{
        "dots": true,
        "slidesToShow": 3,
        "slidesToScroll": 1,
        "infinite": true,
        "responsive": [
            {
                "breakpoint": 991,
                "settings": {
                    "slidesToShow": 2,
                    "slidesToScroll": 1
                }
            },
            {
                "breakpoint": 690,
                "settings": {
                    "slidesToShow": 1,
                    "slidesToScroll": 1
                }
            }
        ]
    }'>
      <?php foreach($menus as $menu):?>
        <!-- Menu Sample -->
        <div class="menu-sample">
          <a href="<?= Router::route("$restaurant->url_name/menu/$menu->id");?>">
            <img src="<?= $menu->image;?>" alt="" class="image">
            <h3 class="title"><?= $menu->name;?></h3>
          </a>
        </div>
      <?php endforeach;?>
    </div>
  <?php else:?>
    <div class="text-center mt-5 mb-4 alert alert-warning" role="alert">
      <strong>Warning!</strong> Restaurant Has No Menus
    </div>
  <?php endif;?>

  <?php
    $admin = Router::get_admin_session();
    if (!is_null($admin) && get_class($admin) == "Admin"):
  ?>
    <h3 class="add-menu">
      <a class="btn btn-info" href="<?= Router::route("$restaurant->url_name/menu/add");?>">
        <span>
          add menu
          <i class="fa fa-plus"></i>
        </span>
      </a>
    </h3>
  <?php endif;?>

</section>

<!-- Section - Offers -->
<section class="section section-lg bg-light">

    <div class="container">
        <h1 class="text-center mb-6">Special offers</h1>
        <div class="carousel" data-slick='{"dots": true}'>
            <!-- Special Offer -->
            <div class="special-offer">
                <img src="http://assets.suelo.pl/soup/img/photos/special-burger.jpg" alt="" class="special-offer-image">
                <div class="special-offer-content">
                    <h2 class="mb-2">Free Burger</h2>
                    <h5 class="text-muted mb-5">Get free burger from orders higher that $40!</h5>
                    <ul class="list-check text-lg mb-0">
                        <li>Only on Tuesdays</li>
                        <li class="false">Order higher that $40</li>
                        <li>Unless one burger ordered</li>
                    </ul>
                </div>
            </div>
            <!-- Special Offer -->
            <div class="special-offer">
                <img src="http://assets.suelo.pl/soup/img/photos/special-pizza.jpg" alt="" class="special-offer-image">
                <div class="special-offer-content">
                    <h2 class="mb-2">Free Small Pizza</h2>
                    <h5 class="text-muted mb-5">Get free burger from orders higher that $40!</h5>
                    <ul class="list-check text-lg mb-0">
                        <li>Only on Weekends</li>
                        <li class="false">Order higher that $40</li>
                    </ul>
                </div>
            </div>
            <!-- Special Offer -->
            <div class="special-offer">
                <img src="http://assets.suelo.pl/soup/img/photos/special-dish.jpg" alt="" class="special-offer-image">
                <div class="special-offer-content">
                    <h2 class="mb-2">Chip Friday</h2>
                    <h5 class="text-muted mb-5">10% Off for all dishes!</h5>
                    <ul class="list-check text-lg mb-0">
                        <li>Only on Friday</li>
                        <li>All products</li>
                        <li>Online order</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>
