// Mostrar el modal de registro exitoso
function showModalSuccess() {
  var modal = document.getElementById("myModalSuccess");
  modal.style.display = "block";
}

// Mostrar el modal de registro fallido
function showModalError() {
  var modal = document.getElementById("myModalError");
  modal.style.display = "block";
}

// Mostrar el modal de informacion en uso
function showModalInfo() {
  var modal = document.getElementById("myModalInfo");
  modal.style.display = "block";
}

// Cerrar el modal cuando se haga clic en la 'x'
var closeButtons = document.getElementsByClassName("close");
for (var i = 0; i < closeButtons.length; i++) {
  closeButtons[i].onclick = function () {
    var modal = this.parentElement.parentElement;
    modal.style.display = "none";
  };
}
