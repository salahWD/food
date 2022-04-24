	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="js/parallax.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="js/functions.js"></script>
	<script>
		$(document).ready(function(){
			
			// chosing catigory
			let cat = $("#category-selector");
			cat.on('change', function() {
				getCat(cat.val());
			});

			let updateImgBtn 		= $("#update-img-btn");
			let updateImginput 	= $("#update-img-input");

			updateImgBtn.click(function () {
				updateImginput.click();
			});

		});
	</script>
</body>
</html>