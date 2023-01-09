<!-- Page Title -->
<div id="menuImage" class="page-title bg-light" style="background: url(<?= Router::route('img/categories/default-empty-category-image.jpg');?>) no-repeat;background-size:cover;">
  <div class="container">
    <div class="row">
      <button class="btn btn-success image-btn" id="MenuimageBtn"><i class="fa fa-image"></i></button>
      <input type="file" name="image" id="MenuimageInput" class="hide">
      <div class="col-lg-8 offset-lg-4">
        <h1 class="menu-title" id="editableTitle" contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off'>Untitled Menu</h1>
        <h4 class="menu-desc text-muted" id="editableDesc" contenteditable="true" autocomplete='off' spellcheck='false' autocorrect='off'>This is menu description</h4>
      </div>
    </div>
  </div>
</div>

<!-- Page Content -->
<div class="page-content">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-10 offset-md-1" role="tablist" id="categoriesContainer">

      </div>
      <div class="mb-3 col-md-10 offset-md-1" role="tablist">
        <button type="button" class="btn btn-success btn-block" id="addCategory">
          <span>add category <i class="ml-2 fa fa-plus"></i></span>
        </button>
      </div>
      <div class="col-md-10 offset-md-1" role="tablist">
        <button type="submit" class="btn btn-success" data-action="add" id="submitBtn"><span>Submit <i class="ml-2 fa fa-send"></i></span></button>
      </div>
    </div>
  </div>
</div>
