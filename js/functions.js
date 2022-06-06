function createFoodsCards(res) {

  cards = [];
  if (res.length > 0 && Array.isArray(res)) {
    
    $.each(res, function( index, data ) {
      
      let card = $("<article>");
      card.addClass("col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item");
    
      let figure = $("<figure>");
      let img = $("<img>");
      img.attr({ src : data.image, alt : "food image" });
      img.addClass("img-fluid tm-gallery-img");
      figure.append(img);
      
      let caption = $("<figcaption>");
      
      let title = $("<h4>");
      title.addClass("tm-gallery-title");
      caption.append(title);

      let link = $("<a>");
      link.attr("href", `http://localhost/food/food/${data.id}`);
      link.text(data.name);
      title.append(link);
      
      let description = $("<p>");
      description.addClass("tm-gallery-description");
      description.text(data.description);
      caption.append(description);
      
      let price = $("<p>");
      price.addClass("tm-gallery-price");
      price.text(data.price);
      caption.append(price);
      
      figure.append(caption);
      card.append(figure);

      cards.push(card);
    });

    
  }

  return cards;

}

function getCat($id) {
  $.ajax({
    url: `http://localhost/food/data/category/${$id}`,
    context: $("#gallery-page"),
    type: "GET",
  }).done(function(res) {
    // remove the old foods
    $(this).children().remove();

    // create a new foods
    let cards = createFoodsCards(JSON.parse(res));
    
    // append the new foods
    $(this).append(...cards);

  });
}

function orderFood(food_id, orderCount) {

  $.ajax({
    url: `http://localhost/food/data/cart`,
    type: "POST",
    data: {
      "id": food_id,
      "count": parseInt(orderCount),
    },
  }).done(function(res) {
    if (res) {
      let notef = $("#notification");
      let number = parseInt(notef.data("number")) + parseInt(orderCount);
      notef.data("number", number);
      notef.text(number);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });
}

function updateOrderCount(food_id, newOrderCount) {

  $.ajax({
    url: `http://localhost/food/data/cart/update`,
    type: "POST",
    data: {
      "id": food_id,
      "new_count": parseInt(newOrderCount),
    },
  }).done(function(res) {
    if (res) {
      res = JSON.parse(res);
      let notef = $("#notification");
      let number = "Y";
      notef.data("number", number);
      notef.text(number);
      let price = $("#total-price");
      console.log(res.total_price);
      price.data("number", res.total_price);
      price.text(res.total_price);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });
}

function deleteOrder(foodId) {

  $.ajax({
    url: `http://localhost/food/data/cart/deleteorder`,
    type: "POST",
    data: {
      "id": foodId,
    }
  }).done(function(res) {
    if (res) {
      let price = $("#total-price");
      price.data("number", res.total_price);
      price.text(res.total_price);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });
}

function payCart() {

  $.ajax({
    url: `http://localhost/food/data/cart/confirm`,
    type: "POST",
    data: {
      "confirm": true,
    }
  }).done(function(res) {
    if (res) {
      res = JSON.parse(res);
      let notef = $("#notification");
      notef.data("number", 0);
      notef.text(0);
      console.log(res.msg);
      console.log(`https://wa.me/${res.whatsapp}`);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });
}

function clearCart() {

  $.ajax({
    url: `http://localhost/food/data/cart/delete`,
    type: "POST",
  }).done(function(res) {
    if (res) {
      let notef = $("#notification");
      notef.data("number", 0);
      notef.text(0);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });
}