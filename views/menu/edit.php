<!-- Page Title -->
<div id="menuImage" class="page-title bg-light" style="background: url(<?= $menu_info->image;?>) no-repeat;background-size:cover;">
  <div class="container">
    <div class="row">
      <div class="btns-flow-right">
        <button class="btn btn-danger" id="MenuDelete" data-action="delete"><i class="fa-solid fa-lg fa-trash"></i></button>
        <button class="btn btn-success" id="MenuimageBtn"><i class="fa fa-image"></i></button>
        <input type="file" name="image" id="MenuimageInput" class="hide">
      </div>
      <div class="col-lg-8 offset-lg-4">
        <h1 class="menu-title" id="editableTitle" contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off'><?= $menu_info->name;?></h1>
        <h4 class="menu-desc text-muted" id="editableDesc" contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off'><?= $menu_info->description;?></h4>
      </div>
    </div>
  </div>
</div>

<!-- Page Content -->
<div class="page-content">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-10 offset-md-1" role="tablist" id="categoriesContainer">
        <?php if (isset($categories) && is_array($categories) && count($categories) > 0):?>
          <?php foreach($categories as $i => $cat):?>
            <!-- Menu Category -->
            <div class="menu-category edited" id="cat-<?= $i+1;?>" data-id="<?= $cat->id;?>">
              <button class="btn btn-danger delete-cat">
                <span class="confairm-msg">Delete Category</span>
                <i class="fa-solid fa-trash"></i>
              </button>
              <button class="btn btn-success image-btn">
                <span class="error-msg">unacceptable file</span>
                <i class="fa fa-sm fa-image" aria-hidden="true"></i>
              </button>
              <input type="file" id="cat-<?= $i+1;?>-image" class="hide imageInput" name="image">
              <div class="menu-category-title">
                <div class="bg-image" style="background-image: url(<?= $cat->image?>);">
                  <img class="bg-image" src="<?= $cat->image?>">
                </div>
                <h2 class="title" contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off'><?= $cat->name?></h2>
              </div>
              <div id="cat1menu" class="menu-category-content collapse show">
                <button class="btn btn-info add-food">Add Food <i class="ml-3 fa fa-plus" aria-hidden="true"></i></button>

                <?php if (isset($cat->foods) && is_array($cat->foods) && count($cat->foods) > 0):?>
                  <?php foreach($cat->foods as $foo):?>
                    <!-- Menu Item -->
                    <div class="menu-item menu-list-item food-item" data-id="<?= $foo->id?>">
                      <div class="row align-items-center">
                        <div class="col-sm-6 mb-2 mb-sm-0">
                          <h6 contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off' class="mb-0 food-name"><?= $foo->name;?></h6>
                          <span contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off' class="text-muted text-sm food-desc"><?= $foo->description;?></span>
                        </div>
                        <div class="col-sm-6 text-sm-right">
                          <span class="text-md mr-4"><span class="text-muted">from</span> <?= $restaurant->currency->icon;?><input type="number" class="food-price" value="<?= $foo->price;?>"></span>
                          <a href="<?= Router::route("$restaurant->url_name/f/$foo->id");?>" class="btn btn-outline-secondary btn-sm" data-action="open-cart-modal" data-id="1"><span>Go To</span></a>
                          <buton class="delete-btn btn btn-outline-danger btn-sm"><i class=" fa-solid fa-x"></i></buton>
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
      <div class="mb-3 col-md-10 offset-md-1" role="tablist">
        <button type="button" class="btn btn-success btn-block" id="addCategory">
          <span>add category <i class="ml-2 fa fa-plus"></i></span>
        </button>
      </div>
      <div class="col-md-10 offset-md-1" role="tablist">
        <button type="submit" class="btn btn-success" data-action="edit" id="submitBtn"><span>Submit <i class="ml-2 fa fa-send"></i></span></button>
      </div>
    </div>
  </div>
</div>
