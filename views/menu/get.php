<!-- Page Title -->
<div id="menuImage" class="page-title bg-light" style="background: url(<?= $menu_info->image;?>) no-repeat;background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-4">
                <h1 class="mb-0 menu-title"><?= $menu_info->name;?></h1>
                <h4 class="text-muted mb-0 menu-desc"><?= $menu_info->description;?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="page-content">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-10 offset-md-1" role="tablist">
        <?php if (isset($categories) && is_array($categories) && count($categories) > 0):?>
          <?php foreach($categories as $cat):?>
            <!-- Menu Category -->
            <div id="<?= $cat->name;?>" class="menu-category">
              <div class="menu-category-title collapse-toggle collapsed" role="tab" data-target="#Menu<?= $cat->name;?>" data-toggle="collapse" aria-expanded="false">
                <div class="bg-image" style="background-image: url(&quot;<?= $cat->image;?>&quot;);"><img src="<?= $cat->image;?>" alt="" style="display: none;"></div>
                <h2 class="title"><?= $cat->name;?></h2>
              </div>
              <div id="Menu<?= $cat->name;?>" class="menu-category-content collapse">

                <?php if (isset($cat->foods) && is_array($cat->foods) && count($cat->foods) > 0):?>
                  <?php foreach($cat->foods as $foo):?>
                    <!-- Menu Item -->
                    <div class="menu-item menu-list-item">
                      <div class="row align-items-center">
                        <div class="col-sm-6 mb-2 mb-sm-0">
                          <a href="<?= Router::route("$restaurant->url_name/f/$foo->id");?>">
                            <h6 class="mb-0"><?= $foo->name;?></h6>
                          </a>
                          <span class="text-muted text-sm">Beef, cheese, potato, onion, fries</span>
                        </div>
                        <div class="col-sm-6 text-sm-right">
                          <span class="text-md mr-4"><span class="text-muted">from</span> <?= $restaurant->currency->icon;?><span class="price" data-product-base-price=""><?= $foo->price;?></span></span>
                          <button class="btn btn-outline-secondary btn-sm" data-action="open-cart-modal" data-id="1"><span>Order</span></button>
                        </div>
                      </div>
                    </div>
                  <?php endforeach;?>
                <?php endif;?>
              </div>
            </div>
          <?php endforeach;?>
        <?php else:?>
          <div class="text-center mt-5 mb-4 alert alert-warning" role="alert">
            <strong>Warning!</strong> This Menu Is Empty, Go <a href="<?= Router::route($restaurant->url_name);?>">Home</a>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
