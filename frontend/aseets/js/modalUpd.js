const cloud = document.getElementById("log-gob");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const palanca = document.querySelector(".switch");
const circulo = document.querySelector(".circulo");
const menu = document.querySelector(".menu");
const main = document.querySelector("main");

menu.addEventListener("click", () => {
  barraLateral.classList.toggle("max-barra-lateral");
  if (barraLateral.classList.contains("max-barra-lateral")) {
    menu.children[0].style.display = "none";
    menu.children[1].style.display = "block";
  } else {
    menu.children[0].style.display = "block";
    menu.children[1].style.display = "none";
  }
  if (window.innerWidth <= 320) {
    barraLateral.classList.add("mini-barra-lateral");
    main.classList.add("min-main");
    spans.forEach((span) => {
      span.classList.add("oculto");
    });
  }
});

palanca.addEventListener("click", () => {
  let body = document.body;
  body.classList.toggle("dark-mode");
  // body.classList.toggle("");
  circulo.classList.toggle("prendido");
});

cloud.addEventListener("click", () => {
  barraLateral.classList.toggle("mini-barra-lateral");
  main.classList.toggle("min-main");
  spans.forEach((span) => {
    span.classList.toggle("oculto");
  });
});
// navbar------------------
function mostrarModalActualizacionExitosa() {
  var modal = document.getElementById("modalActualizacionExitosa");
  modal.style.display = "block";
}

var closeBtn = document.querySelector("#modalActualizacionExitosa .close");
closeBtn.addEventListener("click", function () {
  var modal = document.getElementById("modalActualizacionExitosa");
  modal.style.display = "none";
});

window.addEventListener("click", function (event) {
  var modal = document.getElementById("modalActualizacionExitosa");
  if (event.target == modal) {
    modal.style.display = "none";
  }
});

// document.querySelector(".button-can").addEventListener("click", function () {
//   window.location.href = "/frontend/view/admin/level_admin.php";
// });

document.querySelector(".button-can").addEventListener("click", function () {
  if (nivel_usuario == 1) {
    window.location.href = "/frontend/view/admin/level_admin.php";
  } else if (nivel_usuario == 2) {
    window.location.href = "/frontend/view/jefe/level_jefe.php";
  } else if (nivel_usuario == 3) {
    window.location.href = "/frontend/view/pers_adm/level_pers_admi.php";
  }
});
