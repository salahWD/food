<div class="container">
  <div class="row mt-4">
    <?php foreach ($foods as $food):?>
      <article class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item">
        <figure>
          <img src="<?php echo $food->image;?>" alt="Image" class="img-fluid tm-gallery-img">
          <figcaption>
            <h4 class="tm-gallery-title"><a href="<?php echo M_URL . "food/" . $food->id;?>"><?php echo $food->name;?></a></h4>
            <p class="tm-gallery-description"><?php echo $food->description;?></p>
            <p class="tm-gallery-price"><?php echo $food->price;?> <small><?php echo $currency;?></small></p>
          </figcaption>
        </figure>
        <div class="border btns-holder d-flex justify-content-around p-2 rounded">
          <input type="hidden" class="food-id" value="<?php echo $food->id;?>">
          <button class="btn btn-primary edit-btn"><i class="fa fa-edit"></i></button>
          <button class="btn btn-danger delete-btn"><i class="fa fa-trash"></i></button>
        </div>
      </article>
    <?php endforeach;?>
  </div>
</div>