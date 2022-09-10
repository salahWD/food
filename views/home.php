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