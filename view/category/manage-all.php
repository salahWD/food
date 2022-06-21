<div class="container">
  <div class="row pt-4 pb-4">
    <?php foreach($categories as $cat):?>
      <div style="transition: 0.5s;transform: opacity(1);" class="col-lg-3 col-md-4 col-sm-10 offset-md-0 offset-sm-1 d-flex justify-content-center">
        <a href="<?php echo Router::get_path("manage/category/$cat->id/manage");?>">
          <div class="card">
              <img class="card-img-top rounded img-fluid p-3" src="<?php echo $cat->image;?>">
              <div class="card-body">
                  <h5 class="font-weight-bold text-dark">
                      <?php echo $cat->name;?>
                    </h5>
                  <div class="d-flex flex-row my-2">
                      <div class="text-muted"><?php echo substr($cat->description, 0, 30);?></div>
                  </div> 
                  <div class="btn-container">
                    <input type="hidden" class="id-value" value="<?php echo $cat->id;?>">
                    <a class="btn w-100 rounded my-2 border border-primary" href="<?php echo Router::get_path("manage/category/$cat->id/manage");?>">Manage <i class="fa fa-edit"></i></a>      
                    <button data-type="categiry" class="btn delete-btn btn-danger bg-white text-danger w-100 rounded my-2 border border-danger">Delete <i class="fa fa-trash"></i></a>      
                  </div>
              </div>
          </div>
        </a>
      </div>
    <?php endforeach;?>

  </div>
</div>