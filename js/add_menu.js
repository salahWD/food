/* ========= Constants ========= */
const ImageMaxSize = 4 * 1024 * 1024;// maximum image size

/* ========= Functions ========= */
async function postData(url = '', data = {}) {
  const response = await fetch(url, {
    method: 'POST',
    body: data
  });
  return response.json();
}

function checkInput(info, placeholder) {
  if (typeof info == "string") {
    if (info.length > 1) {
      return {success: true, info: info};
    }else {
      return {success: false, info: placeholder};
    }
  }
  return {success: false};
}

function checkInputNumber(info, placeholder) {
  info = Number(info);
  if (Number.isInteger(info)) {
    if (info > -1) {
      return {success: true, info: info};
    }else {
      return {success: false, info: placeholder};
    }
  }
  return {success: false, info: placeholder};
}

function editImageBtn(btn, input, viewerEl, maxSize = null) {
  document.querySelector(btn).addEventListener("click", function () {
    let inputEl = document.querySelector(input);
    inputEl.addEventListener("input", () => {
      if (inputEl.files.length > 0) {
        if (maxSize != null) {
          if (inputEl.files[0].size < maxSize && ["image/png", "image/jpeg"].includes(inputEl.files[0].type)) {
            this.classList.add("btn-success");
            this.classList.remove("btn-danger");
            let imageUrl = URL.createObjectURL(inputEl.files[0]);
            document.querySelector(viewerEl).style.backgroundImage = `url(${imageUrl})`;
          }else {
            this.classList.remove("btn-success");
            this.classList.add("btn-danger");
          }
        }else {
          let imageUrl = URL.createObjectURL(inputEl.files[0]);
          document.querySelector(viewerEl).style.backgroundImage = `url(${imageUrl})`;
        }
      }
    });
    inputEl.click();
  });
}

let handler;// save a position in memory for deleting event listeners after saving them in this variable

function deletableElement(deletBtn, target, selectors = false) {// selectors => [false = DOM element True = selectors] by default its selectors

  if (!selectors) {
    deletBtn = document.querySelector(deletBtn);
    target = document.querySelector(target);
  }

  deletBtn.addEventListener("click", function () {


    this.classList.add("active");
    target.style.height = target.offsetHeight + 'px';

    handler = function () {// fill the saved position in memory with function
      target.classList.add("fade-out", "deleted");
    }

    this.addEventListener("click", handler, false);// assign the func in the saved memory position

    setTimeout(() => {
      this.classList.remove("active");
      this.removeEventListener("click", handler, false);// pass the same memory position to remove
    }, 1500);

  });

}

function create(info) {
  let el = document.createElement(info.type);
  Object.keys(info.attributes).forEach((key, val) => {
    if (key == "content") {
      el.innerHTML = info.attributes[key];
    }else {
      el.setAttribute(key, info.attributes[key]);
    }
  });
  return el;
}

function createFoodElement(foodData) {
  let foodEl = create({
    type: "div",
    attributes: {
      class: "menu-item menu-list-item food-item",
      id: foodData.id,
    }
  });
  let foodContent = create({
    type: "div",
    attributes: {
      class: "row align-items-center",
    }
  });
  let nameSection = create({
    type: "div",
    attributes: {
      class: "col-sm-6 mb-2 mb-sm-0",
    }
  });
  let foodName = create({
    type: "h6",
    attributes: {
      class: "mb-0 food-name",
      content: foodData.name,
      contenteditable: "true",
      autocomplete : 'off',
      spellcheck: 'false',
      autocorrect: 'off'
    }
  });
  let foodDesc = create({
    type: "span",
    attributes: {
      class: "text-muted text-sm food-desc",
      content: foodData.description,
      contenteditable: "true",
      autocomplete : 'off',
      spellcheck: 'false',
      autocorrect: 'off'
    }
  });
  let priceSection = create({
    type: "div",
    attributes: {
      class: "col-sm-6 text-sm-right",
    }
  });
  let price = create({
    type: "span",
    attributes: {
      class: "text-md mr-4 food-price",
      content: `<span class="text-muted">from</span>$<input class="food-price" type="number" value="${foodData.price}" min="1"></input>`
    }
  });
  let orderBtn = create({
    type: "buton",
    attributes: {
      class: "btn btn-outline-danger btn-sm",
      content: '<i class=" fa-solid fa-x"></i>'
    }
  });

  nameSection.appendChild(foodName);
  nameSection.appendChild(foodDesc);
  foodContent.appendChild(nameSection);
  priceSection.appendChild(price);
  priceSection.appendChild(orderBtn);
  foodContent.appendChild(priceSection);
  foodEl.appendChild(foodContent);

  deletableElement(orderBtn, foodEl, true);

  return foodEl;
}

function createCategoryElement(catData) {
  let catEl = create({
    type: "div",
    attributes: {
      class: "menu-category created",
      id: `cat-${catData.id}`,
    }
  });
  let deleteBtn = create({
    type: "button",
    attributes: {
      class: "btn btn-danger delete-cat",
      content: `<span class="confairm-msg">Delete Category</span><i class="fa-solid fa-trash"></i>`,
    }
  });
  let imageBtn = create({
    type: "button",
    attributes: {
      class: "btn btn-success image-btn",
      content: `<span class="error-msg">unacceptable file</span><i class="fa fa-sm fa-image"></i>`,
    }
  });
  let imageInput = create({
    type: "input",
    attributes: {
      type: "file",
      class: "hide imageInput",
      name: "image"
    }
  });
  let titleContainer = create({
    type: "div",
    attributes: {
      class: "menu-category-title"
    }
  });
  let bgEl = create({
    type: "div",
    attributes: {
      class: "bg-image",
      style: `background-image: url(${catData.image});`
    }
  });
  let bgImage = create({
    type: "img",
    attributes: {
      class: "bg-image",
      src: catData.image,
    }
  });
  let titleEl = create({
    type: "h2",
    attributes: {
      class: "title",
      content: catData.name,
      contenteditable: "true",
      autocomplete : 'off',
      spellcheck: 'false',
      autocorrect: 'off'
    }
  });
  let addFoodBtn = create({
    type: "button",
    attributes: {
      class: "btn btn-info add-food",
      content: "Add Food <i class=\"ml-3 fa fa-plus\"></i>",
    }
  });
  let catMenu = create({
    type: "div",
    attributes: {
      id: `cat${catData.id}menu`,
      class: "menu-category-content collapse show",
    }
  });

  catEl.appendChild(deleteBtn);
  catEl.appendChild(imageBtn);
  catEl.appendChild(imageInput);
  bgEl.appendChild(bgImage);
  titleContainer.appendChild(bgEl);
  titleContainer.appendChild(titleEl);
  catEl.appendChild(titleContainer);
  catMenu.appendChild(addFoodBtn);
  catEl.appendChild(catMenu);
  addFoodBtn.addEventListener("click", function () {
    catMenu.appendChild(createFoodElement({
      id: `food-${catEl.querySelectorAll(".food-item").length + 1}`,
      name: "new Food",
      // image: "http://localhost/food/img/categories/default.jpg",
      description: "lorem Ipsum Some Words For Testing",
      price: 10,
    }));
  });

  return catEl;
}

function scrl(el, margin = 70) {
  let top = el.getBoundingClientRect().top + window.scrollY - margin;
  window.scroll({
    top: top,
    behavior: 'smooth'
  });
}

/* ========= Initialisation ========= */
editImageBtn("#MenuimageBtn", "#MenuimageInput", "#menuImage", ImageMaxSize);// 4 * 1024 * 1024

let categorieEls = document.querySelectorAll(".menu-category[id^=\"cat-\"]");

categorieEls.forEach(cat => {
  editImageBtn(`#${cat.id} .image-btn`, `#${cat.id} .imageInput`, `#${cat.id} .bg-image`, ImageMaxSize);// 4 * 1024 * 1024
  deletableElement(`#${cat.id} .delete-cat`, `#${cat.id}`);
  let addFoodBtn = cat.querySelector(".add-food");
  addFoodBtn.addEventListener("click", function () {
    cat.querySelector(".menu-category-content").appendChild(createFoodElement({
      id: `food-${cat.querySelectorAll(".food-item").length + 1}`,
      name: "new Food",
      // image: "http://localhost/food/img/categories/default.jpg",
      description: "lorem Ipsum Some Words For Testing",
      price: 10,
    }));
  });
  cat.querySelectorAll(".menu-category-content .menu-item").forEach(el => {

    deletableElement(el.querySelector(".delete-btn"), el, true);
  });
});

/* ========= Add Category Section ========= */
const addCategoryBtn = document.getElementById("addCategory");
const catsContainer = document.getElementById("categoriesContainer");
let CatId = document.querySelectorAll('.menu-category[id^="cat-"]').length + 1 ?? 1;

addCategoryBtn.addEventListener("click", function () {

  let CatObj = {
    id: CatId,
    name: "New Category",
    image: "http://localhost/food/img/categories/default.jpg"
  };

  catsContainer.appendChild(createCategoryElement(CatObj));
  CatId++;

  editImageBtn(`#cat-${CatObj.id} .image-btn`, `#cat-${CatObj.id} .imageInput`, `#cat-${CatObj.id} .bg-image`, ImageMaxSize);// 4 * 1024 * 1024
  deletableElement(`#cat-${CatObj.id} .delete-cat`, `#cat-${CatObj.id}`);

});

/* ========= Submit Btn ========= */
const submitBtn = document.getElementById("submitBtn");
submitBtn.addEventListener("click", function () {

  const editableTitle = document.getElementById("editableTitle");
  const editableDesc = document.getElementById("editableDesc");
  const imageFile = document.getElementById("MenuimageInput");
  let form = new FormData();
  let errors = [];
  let titleCheckResult = checkInput(editableTitle.innerText, "Untiteled");
  let descCheckResult = checkInput(editableDesc.innerText, "Description of food");
  let categories = document.querySelectorAll(`.menu-category:not(.deleted)`);

  /* ==== Menu Check ==== */
  if (titleCheckResult.success) {
    editableTitle.classList.remove("wrong");
  }else {
    editableTitle.classList.add("wrong");
    editableTitle.innerText = titleCheckResult.info;
    errors.push("title");
  }

  if (descCheckResult.success) {
    editableDesc.classList.remove("wrong");
  }else {
    errors.push("desc");
    editableDesc.classList.add("wrong");
    editableDesc.innerText = descCheckResult.info;
  }

  if (imageFile.files[0]) {
    let menuImageBtn = document.getElementById("MenuimageBtn");
    if (imageFile.files[0].size < ImageMaxSize) {// 4 * 1024 * 1024
      if (imageFile.files[0].type == "image/jpeg" || imageFile.files[0].type == "image/png") {
        menuImageBtn.classList.remove("btn-danger");
        menuImageBtn.classList.add("btn-success");
      }else {
        menuImageBtn.classList.remove("btn-success");
        menuImageBtn.classList.add("btn-danger");
        errors.push("menuImage");
      }
    }else {
      menuImageBtn.classList.remove("btn-success");
      menuImageBtn.classList.add("btn-danger");
      errors.push("menuImage");
    }
  }

  /* ==== Categories Checks ====  */
  let catsInfo = {};

  if (categories.length > 0) {

    categories.forEach(cat => {

      let catNameEl = cat.querySelector(".title");
      let catId     = Number(cat.dataset.id) ?? null;
      let catName   = checkInput(catNameEl.innerText, "New Category");
      let catImage  = cat.querySelector(".imageInput");
      let foods = cat.querySelectorAll(".food-item:not(.deleted)");
      let index;

      if (catName.success) {
        cat.classList.remove("wrong");
        catNameEl.classList.remove("text-danger");
        index = errors.indexOf(cat.id);
        if (index > -1) {
          errors.splice(index, 1);
        }

      }else {
        errors.push(cat.id);
        cat.classList.add("wrong");
        catNameEl.innerText = catName.info;
        catNameEl.classList.add("text-danger");
        scrl(cat);
      }

      if (catImage.files[0]) {
        if (catImage.files[0].size < ImageMaxSize) {// 4 * 1024 * 1024
          if (catImage.files[0].type == "image/jpeg" || catImage.files[0].type == "image/png") {
            cat.classList.remove("wrong");
            form.set(cat.id, catImage.files[0]);
          }else {
            cat.classList.add("wrong");
            errors.push(cat.id);
          }
        }else {
          cat.classList.add("wrong");
          errors.push(cat.id);
        }
      }

      let foodsInfo = [];

      if (foods.length > 0) {

        foods.forEach(food => {
          let foodId    = Number(food.dataset.id) ?? null;
          let foodName  = food.querySelector(".food-name");
          let foodDesc  = food.querySelector(".food-desc");
          let foodPrice = food.querySelector("input.food-price");

          let nameCheck = checkInput(foodName.innerText, "New Food");
          let descCheck = checkInput(foodDesc.innerText, "lorem Ipsum Some Words For Testing");
          let priceCheck = checkInputNumber(foodPrice.value, 10);

          if (nameCheck.success) {
            foodName.classList.remove("text-danger");
          }else {
            foodName.classList.add("text-danger");
            errors.push(food.id);
            scrl(food, 180);
            setTimeout(function() {
              foodName.focus();
            }, 0);
          }

          if (descCheck.success) {
            foodDesc.classList.remove("text-danger");
          }else {
            foodDesc.classList.add("text-danger");
            errors.push(food.id);
            scrl(food, 180);
            setTimeout(function() {
              foodDesc.focus();
            }, 0);
          }

          if (priceCheck.success) {
            foodPrice.classList.remove("text-danger", "border-danger");
          }else {
            foodPrice.classList.add("text-danger", "border-danger");
            errors.push(food.id);
            scrl(food, 180);
            foodPrice.focus();
          }

          if (!errors.includes(food.id)) {

            foodsInfo.push({
              id: foodId > 0 ? foodId : null,
              name: nameCheck.info,
              desc: descCheck.info,
              price: priceCheck.info,
            });

          }

        });

      }

      if (!errors.includes(cat.id)) {

        catsInfo[cat.id] = {
          id: catId > 0 ? catId : null,
          name: catName.info,
          foods: foodsInfo,
        };

      }

    });

  }

  /* ==== Sending Stage ====  */
  let deletedCats = [];
  let deletedCatsEl = document.querySelectorAll(".menu-category.deleted");
  if (deletedCatsEl.length > 0) {
    deletedCatsEl.forEach(el => {
      if (Number(el.dataset.id) > 0) {
        deletedCats.push(el.dataset.id);
      }
    });
    form.set("deleted-categories", JSON.stringify(deletedCats));
  }
  let deletedFoods = [];
  let deletedFoodsEl = document.querySelectorAll(".menu-category:not(.deleted) .food-item.deleted");
  if (deletedFoodsEl.length > 0) {
    deletedFoodsEl.forEach(el => {
      if (Number(el.dataset.id) > 0) {
        deletedFoods.push(el.dataset.id);
      }
    });
    form.set("deleted-foods", JSON.stringify(deletedFoods));
  }

  /* ==== Sending Stage ====  */
  if (errors.length == 0) {

    this.classList.add("btn-success");
    this.classList.remove("btn-danger");

    form.set("menu_id", null);

    let url = window.location.href.split("/");
    let menuId = Number(url[url.length - 1]);

    if (Number.isInteger(menuId) && menuId > -1) {
      form.set("menu_id", menuId);
    }

    form.set("name", editableTitle.innerText);
    form.set("desc", editableDesc.innerText);
    form.set('image', imageFile.files[0] ?? null);
    form.set('categories', JSON.stringify(catsInfo));

    postData(window.location.href.split("/").slice(0, -1).join("/").concat(`/${this.dataset.action}`), form)// this => submitBtn
      .then((result) => {
        console.log(result);
        if (result.success) {
          console.log("All Done");
          if (this.dataset.action == "edit") {
            window.location.href = window.location.href;
          }else {
            window.location.href = window.location.href.split("/").slice(0, -2).join("/");
          }
        }else {
          console.log("not accepted");
        }
      })
      .catch((error) => {
        console.error(error);
      });


  }else {

    this.classList.remove("btn-success");
    this.classList.add("btn-danger");

    console.error(errors);

  }

});
