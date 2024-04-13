document.addEventListener("DOMContentLoaded", function () {
  const btnAdd = document.querySelector(".btn-add");
  const table = document.querySelector(".table");
  const modalForm = document.getElementById("modalForm");
  const btnCancel = document.querySelector(".close-btn");

  btnAdd.addEventListener("click", function () {
    table.style.display = "none";
    modalForm.style.display = "block";
  });

  btnCancel.addEventListener("click", function () {
    table.style.display = "block";
    modalForm.style.display = "none";
  });
});

// Función para limpiar el formulario
function limpiarFormulario() {
  document.getElementById("miFormulario").reset();
}
