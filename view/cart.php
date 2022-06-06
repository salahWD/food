
<div class="container">
  <?php if (count($foods) > 0):?>
    <div class="row mt-4">
      <?php foreach ($foods as $i => $food):?>
        <article class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item food-container">
          <figure>
            <img src="<?php echo $food->image;?>" alt="Image" class="img-fluid tm-gallery-img">
            <figcaption>
              <h4 class="tm-gallery-title"><a href="<?php echo M_URL . "food/" . $food->id;?>"><?php echo $food->name;?></a></h4>
              <p class="tm-gallery-description"><?php echo $food->description;?></p>
              <p class="tm-gallery-price"><?php echo $food->price;?> <small><?php echo $currency;?></small></p>
            </figcaption>
          </figure>
          <div class="count-manage d-flex justify-content-around">
            
            <button type="button" class="btn btn-danger delete-food-completly" data-food="<?php echo $food->id;?>">
              <i class="fa fa-trash"></i>
            </button>

            <div class="btn bordered border-success order-counter"><?php echo $food->ordered_count;?></div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderCount<?php echo $i;?>">
              <i class="fa fa-edit"></i>
            </button>

            <!-- Start Popup Modal -->
            <div class="modal fade" id="orderCount<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="orderCountTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title text-right" id="exampleModalLongTitle">حدد عدد الطلب</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body d-flex flex-direction-row">
                    <button data-input="input<?php echo $i;?>" class="order-count-changer-add btn btn-success mr-2"><i class="fa-solid fa-circle-up"></i></button>
                    <input id="input<?php echo $i;?>" type="number" class="order-count form-control" value="<?php echo $food->ordered_count;?>" placeholder="حدد عدد الطلبات">
                    <button data-input="input<?php echo $i;?>" class="order-count-changer-drop btn btn-danger ml-2"><i class="fa-solid fa-circle-down"></i></button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary submet-btn edit" data-dismiss="modal" data-food="<?php echo $food->id;?>">تأكيد</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Popup Model -->
          </div>
        </article>
      <?php endforeach;?>
    </div>
    <div class="row">
      <div class="d-flex w-100 align-items-center mt-4 flex-column">
        <p>
          <span id="total-price"><?php echo $total_price . " " . $currency;?></span>
          :المجموع الكلي
        </p>
        <button id="confirm-order" class="btn btn-block btn-success"><i class="fa-solid fa-basket-shopping"></i> تأكيد الطلب</button>
      </div>
    </div>
  <?php else:?>
    <div class="alert alert-danger mt-4 text-center">
      <h3 class="title">عذرا</h3>
      <p class="lead">يبدو انك لا تملك اي منتجات في سلتك</p>
    </div>
  <?php endif;?>

  <pre>
    <?php // print_r($_SESSION["cart"]);?>
  </pre>  

</div>



