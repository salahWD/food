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
      link.attr("href", `http://food.test/food/${data.id}`);
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
    url: `http://food.test/api/category/${$id}`,
    context: $("#gallery-page"),
    type: "GET",
  }).done(function(res) {

    if (isJsonString(res)) {

      let foods = JSON.parse(res);

      if (foods.length > 0) {

        // remove the old foods
        $(this).children().remove();

        // create a new foods
        let cards = createFoodsCards(foods);

        // append the new foods
        $(this).append(...cards);

      }
    }

  });
}

function orderFood(food_id, orderCount) {

  $.ajax({
    url: `http://food.test/data/cart`,
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
    url: `http://food.test/data/cart/update`,
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
      price.data("number", res.total_price);
      price.text(res.total_price);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });
}

function deleteOrder(foodId) {

  $.ajax({
    url: `http://food.test/data/cart/deleteorder`,
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
    url: `http://food.test/data/cart/confirm`,
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
    url: `http://food.test/data/cart/delete`,
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

function deleteFood(id) {

  $.ajax({
    url: `http://food.test/manage/food/delete_food`,
    type: "POST",
    data: {
      "food_id": id,
    }
  }).done(function(res) {
    res = JSON.parse(res);
    if (res) {
      console.log(`food [${id}] deleted`);
    }else {
      console.error("You Should Handle This Error And Show It");
    }
  });

}

// function deleteCategory(id, elm) {

//   $.ajax({
//     url: `http://food.test/manage/category/delete_category`,
//     type: "POST",
//     data: {
//       "id": id,
//     },
//     beforeSend : function (xhr) {
//       console.log(xhr);
//       let trig = confirm("you are going to lose all food inside this category");
//       if (!trig) {
//         xhr.abort();
//       }
//     },
//   }).done(function(res) {
//     res = JSON.parse(res);
//     if (res) {
//       let parent = elm.parents("[class*=\"col\"]");
//       parent.css("opacity", "0");
//       setTimeout(() => {
//         parent.remove();
//       }, 700);
//     }else {
//       console.error("You Should Handle This Error And Show It");
//     }
//   });

// }

function updateFood(id) {
  form = new FormData();
  form.set("id", id);
  form.set("name", $("#foodname").val());
  form.set("price", $("#price").val());
  form.set("description", $("#description").val());
  form.set("image", $("#update-img-input")[0].files[0]);
  const checkKeys = ["id", "name", "price", "description", "image"];
  checkKeys.forEach(prop => {
    if (!form.hasOwnProperty(prop)) {
      return false;
    }else {
      if (prop != "image" && form.get(prop) == null) {
        return false;
      }
    }
  });
  $.ajax({
    url: `http://food.test/manage/food/update_food`,
    type: "POST",
    data: form,
    processData: false,
    contentType: false
  }).done(function(res) {
    res = JSON.parse(res);
    if (res.success === true) {
      location.href = "http://food.test/manage/food";
    }else {
      console.log(res);
      console.error(res.error);
    }
  });


}

function updateCategory(id) {
  form = new FormData();
  form.set("id", id);
  form.set("name", $("#foodname").val());
  form.set("description", $("#description").val());
  form.set("image", $("#update-img-input")[0].files[0]);
  const checkKeys = ["id", "name", "description", "image"];
  checkKeys.forEach(prop => {
    if (!form.hasOwnProperty(prop)) {
      return false;
    }else {
      if (prop != "image" && form.get(prop) == null) {
        return false;
      }
    }
  });
  $.ajax({
    url: `http://food.test/manage/category/update_category`,
    type: "POST",
    data: form,
    processData: false,
    contentType: false
  }).done(function(res) {
    res = JSON.parse(res);
    if (res.success === true) {
      location.href = "http://food.test/manage/category";
    }else {
      console.log(res);
      console.error(res.error);
    }
  });


}

function updateRestaurants() {
  form = new FormData();
  form.set("phone", $("#phone").val());
  form.set("whatsapp", $("#whats").val());
  form.set("msg", $("#whats-msg").val());
  form.set("address", $("#address").val());
  form.set("currency", $("#currency").val());
  form.set("image", $("#update-img-input")[0].files[0]);
  const checkKeys = ["phone", "whatsapp", "msg", "address", "currency", "image"];
  checkKeys.forEach(prop => {
    if (!form.hasOwnProperty(prop)) {
      return false;
    }else {
      if (prop != "image" && form.get(prop) == null) {
        return false;
      }
    }
  });
  $.ajax({
    url: `http://food.test/manage/Restaurants/update`,
    type: "POST",
    data: form,
    processData: false,
    contentType: false
  }).done(function(res) {
    res = JSON.parse(res);
    if (res.success === true) {
      location.href = "http://food.test/manage/Restaurants";
    }else {
      console.log(res);
      console.error(res.error);
    }
  });


}
