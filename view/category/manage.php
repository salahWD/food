<div class="container">
  <div class="row justify-content-center mt-5">
    <form class="col-9" id="form">

      <div class="text-center mb-4">
        <img style="max-width:255px;max-height:255px;width:255px;height:255px;" id="img-preview" src="<?php echo $category->image;?>" alt="<?php echo $category->name;?> image" class="img-fluid img-thumbnail m-auto">
        <button type="button" id="update-img-btn" class="btn btn-success edit-btn"><i class="fa fa-edit"></i></button>
        <input type="file" name="image" id="update-img-input" class="hidden">
      </div>

      <div class="col form-outline mb-4">
        <label class="form-label" for="foodname">name</label>
        <input type="text" id="foodname" class="form-control" value="<?php echo $category->name;?>" />
      </div>

      <div class="col form-outline mb-4">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control" id="description" rows="4"><?php echo $category->description;?></textarea>
      </div>
  
      <button id="send-btn" data-form="#form" data-type="category" type="button" class="col btn btn-primary btn-block mb-4"><i class="fas fa-save"></i> save</button>
    </form>
  </div>

</div>