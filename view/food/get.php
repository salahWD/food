<div class="container">
  <div class="d-flex align-items-center justify-content-center mt-5">


  <article class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item food-container">
    <figure>
      <img src="<?php echo $food->image;?>" alt="Image" class="img-fluid tm-gallery-img">
      <figcaption>
        <h4 class="tm-gallery-title"><a href="http://localhost\food\food/1"><?php echo $food->name;?></a></h4>
        <p class="tm-gallery-description"><?php echo $food->description;?></p>
        <p class="tm-gallery-price"><?php echo $food->price;?><?php echo $currency->icon;?></p>
      </figcaption>
    
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderCount">
        <i class="fa fa-cart-plus"></i> اطلب
      </button>

      <!-- Start Popup Modal -->
      <div class="modal fade" id="orderCount" tabindex="-1" role="dialog" aria-labelledby="orderCountTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-right" id="exampleModalLongTitle">حدد عدد الطلب</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body d-flex flex-direction-row">
              <button data-input="input0" class="order-count-changer-add btn btn-success mr-2"><i class="fa-solid fa-circle-up"></i></button>
              <input id="input0" type="number" class="form-control order-count" value="1" placeholder="حدد عدد الطلبات">
              <button data-input="input0" class="order-count-changer-drop btn btn-danger ml-2"><i class="fa-solid fa-circle-down"></i></button>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
              <button type="button" class="btn btn-primary submet-btn" data-dismiss="modal">تأكيد</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Popup Model -->

    </figure>
  </article>




  </div>
</div>