// // Obtener el modal
// var modal = document.getElementById("reportModal");

// // Obtener el botón que abre el modal
// var btn = document.querySelector(".show-modal-2");

// // Obtener el <span> que cierra el modal
// var span = document.querySelector(".close");

// // Función para abrir el modal
// btn.addEventListener("click", function () {
//   modal.style.display = "block";
// });

// // Función para cerrar el modal al hacer clic en <span> (x)
// span.span.addEventListener("click", function () {
//   modal.style.display = "none";
// });

// // Función para cerrar el modal al hacer clic fuera de él
// window.addEventListener("click", function (event) {
//   if (event.target === modal) {
//     modal.style.display = "none";
//   }
// });

// Obtener el modal
var modal = document.getElementById("reportModal");

// Obtener el botón que abre el modal
var btn = document.querySelector(".show-modal-2");

// Obtener el <span> que cierra el modal
var span = document.getElementsByClassName("close-1")[0];

// Obtener la tabla
var table = document.getElementById("tab_inc");

// Cuando el usuario hace clic en el botón, abre el modal y oculta la tabla
btn.onclick = function () {
  modal.style.display = "block";
  table.classList.add("hide-table");
};

// Cuando el usuario hace clic en <span> (x), cierra el modal y muestra la tabla
span.onclick = function () {
  modal.m;
  style.display = "none";
  table.classList.remove("hide-table");
};

// Cuando el usuario hace clic en cualquier lugar fuera del modal, cierra el modal y muestra la tabla
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
    table.classList.remove("hide-table");
  }
};
