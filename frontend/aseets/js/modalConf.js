// Mostrar modal de confirmación
function mostrarModalConfirmacion() {
  document.getElementById("modalConfirmacion").style.display = "block";
}

// Mostrar modal de registro exitoso
function mostrarModalRegistroExitoso() {
  document.getElementById("modalRegistroExitoso").style.display = "block";
}

// Mostrar modal de registro fallido
function mostrarModalRegistroFallido() {
  document.getElementById("modalRegistroFallido").style.display = "block";
}

// Cerrar todos los modales
function cerrarModales() {
  var modals = document.getElementsByClassName("modal");
  for (var i = 0; i < modals.length; i++) {
    modals[i].style.display = "none";
  }
}

// Evento para cerrar los modales al hacer clic en la 'X'
var closeButtons = document.getElementsByClassName("close");
for (var i = 0; i < closeButtons.length; i++) {
  closeButtons[i].addEventListener("click", cerrarModales);
}

//
//
//
///
//
//
//
// Evento para mostrar el modal de confirmación al intentar agregar un registro existente
document
  .getElementById("guardarRegistro")
  .addEventListener("click", function () {
    cerrarModales();
    // Aquí puedes llamar a la función que guarda el registro a pesar de que ya exista
  });
document
  .getElementById("cancelarRegistro")
  .addEventListener("click", cerrarModales);

// Obtener referencia al botón de guardar del modal de confirmación
const guardarRegistroBtn = document.getElementById("guardarRegistro");

// Agregar evento click al botón de guardar
guardarRegistroBtn.addEventListener("click", function () {
  // Aquí iría tu código para guardar el registro
  // Una vez guardado, cierra el modal
  cerrarModalConfirmacion();
});
///
///
//
//
//
//
//
//
// Obtener referencia al botón de cancelar del modal de confirmación
const cancelarRegistroBtn = document.getElementById("cancelarRegistro");

// Agregar evento click al botón de cancelar
cancelarRegistroBtn.addEventListener("click", function () {
  // Simplemente cierra el modal
  cerrarModalConfirmacion();
});

// Función para cerrar el modal de confirmación
function cerrarModalConfirmacion() {
  const modalConfirmacion = document.getElementById("modalConfirmacion");
  modalConfirmacion.style.display = "none";
}
