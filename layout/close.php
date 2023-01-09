    <!-- Modal / Product -->
    <div class="modal fade product-modal" id="product-modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lg dark bg-dark">
                    <div class="bg-image"><img src="http://assets.suelo.pl/soup/img/photos/modal-add.jpg" alt=""></div>
                    <h4 class="modal-title">Specify your dish</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti ti-close"></i></button>
                </div>
                <div class="modal-product-details">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="mb-1 product-modal-name">Boscaiola Pasta</h6>
                            <span class="text-muted product-modal-ingredients">Pasta, Cheese, Tomatoes, Olives</span>
                        </div>
                        <div class="col-3 text-lg text-right">$<span class="product-modal-price"></span></div>
                    </div>
                </div>
                <div class="modal-body panel-details-container">
                    <!-- Panel Details / Size -->
                    <div class="panel-details panel-details-size">
                        <h5 class="panel-details-title">
                            <label class="custom-control custom-radio">
                                <input name="radio_title_size" type="radio" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                            </label>
                            <a href="#panel-details-sizes-list" data-toggle="collapse">Size</a>
                        </h5>
                        <div id="panel-details-sizes-list" class="collapse show">
                            <div class="panel-details-content">
                                <div class="product-modal-sizes">
                                    <div class="form-group">
                                        <label class="custom-control custom-radio">
                                            <input name="radio_size" type="radio" class="custom-control-input" checked>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Small - 100g ($9.99)</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="custom-control custom-radio">
                                            <input name="radio_size" type="radio" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Medium - 200g ($14.99)</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="custom-control custom-radio">
                                            <input name="radio_size" type="radio" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Large - 350g ($21.99)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Panel Details / Additions -->
                    <div class="panel-details panel-details-additions">
                        <h5 class="panel-details-title">
                            <label class="custom-control custom-radio">
                                <input name="radio_title_additions" type="radio" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                            </label>
                            <a href="#panel-details-additions-content" data-toggle="collapse">Additions</a>
                        </h5>
                        <div id="panel-details-additions-content" class="collapse">
                            <div class="panel-details-content">
                                <!-- Additions List -->
                                <div class="row product-modal-additions">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Tomato ($1.29)</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Ham ($1.29)</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Chicken ($1.29)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Cheese($1.29)</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Bacon ($1.29)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Panel Details / Other -->
                    <div class="panel-details panel-details-form">
                        <h5 class="panel-details-title">
                            <label class="custom-control custom-radio">
                                <input name="radio_title_other" type="radio" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                            </label>
                            <a href="#panel-details-other" data-toggle="collapse">Other</a>
                        </h5>
                        <div id="panel-details-other" class="collapse">
                            <form action="#">
                                <textarea cols="30" rows="4" class="form-control" placeholder="Put this any other informations..."></textarea>
                            </form>
                        </div>
                    </div>
                </div>
                <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg" data-action="add-to-cart"><span>Add to Cart</span></button>
                <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg" data-action="update-cart"><span>Update</span></button>
            </div>
        </div>
    </div>

    <!-- Cookies Bar -->
    <div id="cookies-bar" class="body-bar cookies-bar">
        <div class="body-bar-container container">
            <div class="body-bar-text">
                <h4 class="mb-2">Cookies & GDPR</h4>
                <p>This is a sample Cookies / GDPR information. You can use it easily on your site and even add link to <a href="#">Privacy Policy</a>.</p>
            </div>
            <div class="body-bar-action">
                <button class="btn btn-primary" data-accept="cookies"><span>Accept</span></button>
            </div>
        </div>
    </div>
  </div>

  <!-- Jquery JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Functions JS (potential delete) -->
	<script src="<?php echo Router::route("js");?>/functions.js"></script>
  <!-- Core JS -->
	<script type="module" src="<?php echo Router::route("js");?>/core.js"></script>
  <!-- Custom Scripts -->
  <?php if (isset($custom_js)):?>
    <?php if (is_array($custom_js)):?>
      <?php foreach ($custom_js as $js):?>
        <script type="module" src="<?php echo Router::route("js");?>/<?= $js?>.js"></script>
        <?php endforeach;?>
    <?php else: ?>
      <script type="module" src="<?php echo Router::route("js");?>/<?= $custom_js?>.js"></script>
    <?php endif;?>
  <?php endif;?>

	<script>

			// select image button
			if (document.getElementById("update-img-btn")) {
				let updateImgBtn 		= document.getElementById("update-img-btn");
				let updateImginput 	= document.getElementById("update-img-input");
				let previewImg 			= document.getElementById("img-preview");

				updateImgBtn.onclick = function () {
					updateImginput.click();
				}

				updateImginput.onchange = e => {
					let [file] = updateImginput.files;
					previewImg.src = URL.createObjectURL(file);
				}
			}

		$(document).ready(function(){

			// chosing catigory
			let cat = $("#category-selector");
			cat.on('change', function() {
				getCat(cat.val());
			});

			// increase and decrease order count
			$(".food-container").each(function(index) {

				$(this).find(".order-count-changer-add").click(function() {

					let input = $(this).siblings("#" + $(this).data("input"));

					if (+input.val() < 100) {
						input.attr('value', +input.val() + 1);
					}

				});

				$(this).find(".order-count-changer-drop").click(function() {
					let input = $(this).siblings("#" + $(this).data("input"));

					if (+input.val() > 1) {
						input.attr('value', +input.val() - 1);
					}

				});

				let parent = $(this);

				$(this).find(".submet-btn").click(function() {
					let orderCount = parseInt(parent.find(".order-count").val());
					let url = window.location.href.split("/");
					let foodId = null;

					if (url[4] == "cart") {
						foodId = $(this).data("food");
					}else {
						foodId = url[5]// depending on the url name space ['http:', '', 'localhost', 'food', 'food', 'needed id'];
					}

					if (!Number.isInteger(orderCount)) {
						orderCount = 1;
						console.error("To Me: handle this error later! pls");
					}else if (orderCount > 100 || orderCount < 1) {
						orderCount = 1;
						console.error("To Me: handle this error later! pls");
					}

					if ($(this).hasClass("edit")) {
						parent.find(".order-counter").text(orderCount);
						updateOrderCount(foodId, orderCount);
					}else {
						orderFood(foodId, orderCount);
					}

				});

				$(this).find(".delete-food-completly").click(function() {

					let foodId = $(this).data("food")

					deleteOrder(foodId);

				});

			});


			// clear cart
			let clearCartBtn = $("#clear-cart");
			clearCartBtn.click(function () {
				clearCart();
			});

			// confirm order
			let confirmBtn = $("#confirm-order");
			confirmBtn.click(function () {
				payCart();
			});

		});
	</script>
	<?php if (isset($_SESSION["admin"]) && !empty($_SESSION["admin"])):?>
		<script>

			// $(document).ready(function(){

			// });

		</script>
	<?php endif;?>

</body>
</html>
