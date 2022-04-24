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
      title.text(data.name);
      caption.append(title);
      
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
    console.log(...cards);
    $(this).append(...cards);

  });
}