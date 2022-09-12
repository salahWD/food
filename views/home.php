    <!-- Content -->
    <div id="content">

        <!-- Section - Main -->
        <section class="section section-main section-main-2 bg-dark dark">

            <div id="section-main-2-slider" class="section-slider inner-controls">
                <!-- Slide -->
                <div class="slide">
                    <div class="bg-image zooming"><img src="http://assets.suelo.pl/soup/img/photos/slider-burger_dark.jpg" alt=""></div>
                    <div class="container v-center">
                        <h1 class="display-2 mb-2">Get 10% off coupon</h1>
                        <h4 class="text-muted mb-5">and use it with your next order!</h4>
                        <a href="page-offers.html" class="btn btn-outline-primary btn-lg"><span>Get it now!</span></a>
                    </div>
                </div>
                <!-- Slide -->
                <div class="slide">
                    <div class="bg-image zooming"><img src="http://assets.suelo.pl/soup/img/photos/slider-dessert_dark.jpg" alt=""></div>
          <div class="container v-center">
              <h1 class="display-2 mb-2">Delicious Desserts</h1>
              <h4 class="text-muted mb-5">Order it online even now!</h4>
              <a href="menu-list-collapse.html" class="btn btn-outline-primary btn-lg"><span>Order now!</span></a>
          </div>
          </div>
          <!-- Slide -->
          <div class="slide">
              <div class="bg-image zooming"><img src="http://assets.suelo.pl/soup/img/photos/slider-pasta_dark.jpg" alt=""></div>
              <div class="container v-center">
                  <h4 class="text-muted">New product!</h4>
                  <h1 class="display-2">Boscaiola Pasta</h1>
                  <div class="btn-group">
                      <button class="btn btn-outline-primary btn-lg" data-action="open-cart-modal" data-id="1"><span>Add to cart</span></button>
                      <span class="price price-lg">from $9.98</span>
                  </div>
              </div>
            </div>
          </div>

        </section>

        <!-- Section - Featured Products -->
        <section class="section right">

          <div class="container">
            <h1 class="mb-6">Featured Products</h1>
            <div class="row">
              <?php if (is_array($foods) && count($foods) > 0):?>
                <?php foreach($foods as $food):?>
                  <div class="col-md-4">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <img src="<?= $food->image;?>" alt="">
                        </div>
                        <div class="card-body">
                            <h5 class="mb-1"><?= $food->name;?></h5>
                            <span class="text-muted text-sm"><?= substr($food->description, 40);?></span>
                            <div class="row align-items-center mt-4">
                                <div class="col-sm-6"><span class="text-md mr-4"><span class="text-muted">from</span> <span data-product-base-price><?= $food->price;?></span> <small><?= $restaurant->currency->icon?></small></span></div>
                                <div class="col-sm-6 text-sm-right mt-2 mt-sm-0"><button class="btn btn-outline-primary btn-sm" data-action="open-cart-modal" data-id="<?= $food->id;?>"><span>Order</span></button></div>
                            </div>
                        </div>
                    </div>
                  </div>
                <?php endforeach;?>
              <?php else:?>
                <div class="col">
                  <div class="alert alert-warning text-center" role="alert">
                    <p class="lead mt-4"><strong>Warning!</strong> This restaurant has no foods (it sales quality not quantity ) (:</p>
                  </div>
                </div>
              <?php endif;?>
            </div>
            <div class="text-center mt-5">
                <a href="<?= Router::route("$restaurant->url_name/products");?>" class="btn btn-primary"><span>View Menu</span></a>
            </div>
          </div>

        </section>

        <!-- Section - Menu -->
        <section class="section cover protrude pull-up-20">

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
          <?php if (is_array($categories) && count($categories) > 0):?>
            <?php foreach($categories as $cat):?>
              <!-- Menu Sample -->
              <div class="menu-sample">
                <a href="menu-list-navigation.html#Burgers">
                  <img src="<?= $cat->image;?>" alt="" class="image">
                  <h3 class="title"><?= $cat->name;?></h3>
                </a>
              </div>
            <?php endforeach;?>
          <?php else:?>
            <div class="col">
              <div class="alert alert-warning text-center" role="alert">
                <p class="lead mt-4"><strong>Warning!</strong> This restaurant has no foods (it sales quality not quantity ) (:</p>
              </div>
            </div>
          <?php endif;?>
          </div>

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

        <!-- Footer -->
        <footer id="footer dark bg-dark">

            <div class="container">
                <!-- Footer 1st Row -->
                <div class="footer-first-row row">
                    <div class="col-lg-3 text-center">
                        <a href="index.html"><img src="assets/img/logo-light-teal.svg" alt="" width="88" class="mt-5 mb-5"></a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h5 class="text-muted">Latest news</h5>
                        <ul class="list-posts">
                            <li>
                                <a href="blog-post.html" class="title">How to create effective webdeisign?</a>
                                <span class="date">February 14, 2015</span>
                            </li>
                            <li>
                                <a href="blog-post.html" class="title">Awesome weekend in Polish mountains!</a>
                                <span class="date">February 14, 2015</span>
                            </li>
                            <li>
                                <a href="blog-post.html" class="title">How to create effective webdeisign?</a>
                                <span class="date">February 14, 2015</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <h5 class="text-muted">Subscribe Us!</h5>
                        <!-- MailChimp Form -->
                        <form action="//suelo.us12.list-manage.com/subscribe/post-json?u=ed47dbfe167d906f2bc46a01b&amp;id=24ac8a22ad" id="sign-up-form" class="sign-up-form validate-form mb-5" method="POST">
                            <div class="input-group">
                                <input name="EMAIL" id="mce-EMAIL" type="email" class="form-control" placeholder="Tap your e-mail..." required>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-submit" type="submit">
                                        <span class="description">Subscribe</span>
                                        <span class="success">
                                            <svg x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/></svg>
                                        </span>
                                        <span class="error">Try again...</span>
                                    </button>
                                </span>
                            </div>
                        </form>
                        <h5 class="text-muted mb-3">Social Media</h5>
                        <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
                        <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
                        <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <!-- Footer 2nd Row -->
                <div class="footer-second-row">
                    <span class="text-muted">Copyright Soup 2020©. Made with love by Suelo.</span>
                </div>
            </div>

            <!-- Back To Top -->
            <button id="back-to-top" class="back-to-top"><i class="ti ti-angle-up"></i></button>

        </footer>
        <!-- Footer / End -->

    </div>
    <!-- Content / End -->

<?php /*
    <div class="container">
      <main>
        <header class="row tm-welcome-section">
          <h2 class="col-12 text-center tm-section-title">Home Page</h2>
          <p class="col-12 text-center">Here Is Some Content</p>
        </header>

        <div class="tm-paging-links">
          <select id="category-selector" class="category-selector form-control">
            <option value="*">All Categories</option>
            <?php foreach ($categories as $cat):?>
              <option value="<?php echo $cat->id;?>"><?php echo $cat->name;?></option>
            <?php endforeach;?>
          </select>
        </div>

        <!-- Gallery -->
        <div class="row tm-gallery">

          <div id="gallery-page" class="tm-gallery-page">

            <?php foreach ($foods as $food):?>
              <article class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item">
                <figure>
                  <img src="<?php echo $food->image;?>" alt="Image" class="img-fluid tm-gallery-img" />
                  <figcaption>
                    <h4 class="tm-gallery-title"><a href="<?php echo M_URL . "food/" . $food->id;?>"><?php echo $food->name;?></a></h4>
                    <p class="tm-gallery-description"><?php echo $food->description;?></p>
                    <p class="tm-gallery-price"><?php echo $food->price;?>$</p>
                  </figcaption>
                </figure>
              </article>
            <?php endforeach;?>
          </div>

        </div>
        <div class="tm-section tm-container-inner">
          <div class="row">
            <div class="col-md-6">
              <figure class="tm-description-figure">
                <img src="img/img-01.jpg" alt="Image" class="img-fluid" />
              </figure>
            </div>
            <div class="col-md-6">
              <div class="tm-description-box">
                <h4 class="tm-gallery-title">Special Offer</h4>
                <p class="tm-mb-45">Redistributing this template as a downloadable ZIP file on any template collection site is strictly prohibited. You will need to for additional permissions about our templates. Thank you.</p>
                <a href="about" class="tm-btn tm-btn-default tm-right">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
     */?>
