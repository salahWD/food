	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="<?php echo Router::get_path("js");?>/parallax.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="<?php echo Router::get_path("js");?>/functions.js"></script>
	<script>
		
		$(document).ready(function(){
			
			// chosing catigory
			let cat = $("#category-selector");
			cat.on('change', function() {
				getCat(cat.val());
			});

			// select image button
			let updateImgBtn 		= $("#update-img-btn");
			let updateImginput 	= $("#update-img-input");

			updateImgBtn.click(function () {
				updateImginput.click();
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
	<?php if (isset($_SESSION["user"]) && !empty($_SESSION["user"])):?>
		<script>

			$(document).ready(function(){

				

			});

		</script>
	<?php endif;?>
</body>
</html>