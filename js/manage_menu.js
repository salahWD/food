async function postData(url = '', data = {}) {
  const response = await fetch(url, {
    method: 'POST',
    body: data
  });
  return response.json();
}


function deleteMenuBtn(btn, target) {

  let deletBtn = document.querySelector(btn);
  let targetEl = document.querySelector(target);

  deletBtn.addEventListener("click", function () {

    this.classList.add("active");

    let handler = function () {

      let form = new FormData();
      form.set("menu_id", window.location.href.split("/").slice(-1)[0]);
      let url = window.location.href.split("/").slice(0, -1).join("/").concat("/delete");
      postData(url, form)
      .then((result) => {
        if (result.success) {
          window.location.href = window.location.href;
        }else {
          console.log("not accepted");
        }
      })
      .catch((error) => {
        console.error(error);
      });

    }

    this.addEventListener("click", handler, false);// assign the func in the saved memory position

    setTimeout(() => {
      this.classList.remove("active");
      this.removeEventListener("click", handler, false);// pass the same memory position to remove
    }, 1500);

  });

}

deleteMenuBtn(`#MenuDelete`);
