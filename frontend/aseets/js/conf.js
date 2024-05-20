document.addEventListener("DOMContentLoaded", function () {
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
});
// navbar------------------

// Mostrar el modal de restauración
function mostrarModalRestauracion() {
  var modalRestauracion = document.getElementById("modalRestauracion");
  modalRestauracion.style.display = "block";
}

// Mostrar el modal de copia de seguridad
function mostrarModalCopiaSeguridad() {
  var modalCopiaSeguridad = document.getElementById("modalCopiaSeguridad");
  modalCopiaSeguridad.style.display = "block";
}

// Obtener los elementos de los modales
var modalRestauracion = document.getElementById("modalRestauracion");
var modalCopiaSeguridad = document.getElementById("modalCopiaSeguridad");

// Obtener el elemento span para cerrar los modales
var closeRestauracion = document.querySelector("#modalRestauracion .close");
var closeCopiaSeguridad = document.querySelector("#modalCopiaSeguridad .close");

// Ocultar todos los modales
function ocultarModales() {
  modalRestauracion.style.display = "none";
  modalCopiaSeguridad.style.display = "none";
}

// Cerrar los modales cuando se hace clic en el botón de cerrar (span)
closeRestauracion.addEventListener("click", function () {
  ocultarModales();
});

closeCopiaSeguridad.addEventListener("click", function () {
  ocultarModales();
});

// Cerrar los modales cuando se hace clic fuera de ellos
window.addEventListener("click", function (event) {
  if (
    event.target == modalRestauracion ||
    event.target == modalCopiaSeguridad
  ) {
    ocultarModales();
  }
  // Cerrar todos los modales si se hace clic fuera de ellos
  document.querySelectorAll(".modal").forEach(function (modal) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });
});

//////
const accordionContent = document.querySelectorAll(".accordion-content");

accordionContent.forEach((item, index) => {
  let header = item.querySelector("header");
  header.addEventListener("click", () => {
    item.classList.toggle("open");

    let description = item.querySelector(".description");
    if (item.classList.contains("open")) {
      description.style.height = `${description.scrollHeight}px`; //scrollHeight property returns the height of an element including padding , but excluding borders, scrollbar or margin
      item.querySelector("i").classList.replace("fa-plus", "fa-minus");
    } else {
      description.style.height = "0px";
      item.querySelector("i").classList.replace("fa-minus", "fa-plus");
    }
    removeOpen(index); //calling the funtion and also passing the index number of the clicked header
  });
});

function removeOpen(index1) {
  accordionContent.forEach((item2, index2) => {
    if (index1 != index2) {
      item2.classList.remove("open");

      let des = item2.querySelector(".description");
      des.style.height = "0px";
      item2.querySelector("i").classList.replace("fa-minus", "fa-plus");
    }
  });
}

// eliminar respaldo
document.addEventListener("DOMContentLoaded", function () {
  var deleteBackupButton = document.getElementById("deleteBackupButton");
  if (deleteBackupButton) {
    deleteBackupButton.addEventListener("click", function () {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "/backend/php/eliminar-resp.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
        if (xhr.status == 200) {
          alert(xhr.responseText);
        } else {
          alert("Hubo un error al eliminar el respaldo");
        }
      };
      xhr.send(); // Envía la solicitud sin parámetros adicionales
    });
  } else {
    console.error("Element with id 'deleteBackupButton' not found.");
  }
});

// Función para mostrar el modal de eliminación exitosa
function mostrarModalDeleteCopiaSeguridad() {
  var modal = document.getElementById("modaldeleteCopiaSeguridad");
  modal.style.display = "block";
}

// Función para mostrar el modal de error al eliminar
function mostrarModalErrorEliminar() {
  var modal = document.getElementById("modalErrorEliminar");
  modal.style.display = "block";
}

// Función para mostrar el modal de respaldo no existente
function mostrarModalRespaldoNoExiste() {
  var modal = document.getElementById("modalRespaldoNoExiste");
  modal.style.display = "block";
}

// Cerrar el modal al hacer clic en la "x"
document.querySelectorAll(".close").forEach(function (closeBtn) {
  closeBtn.addEventListener("click", function () {
    modals.forEach(function (modal) {
      modal.style.display = "none";
    });
  });
});

// // Asignar el evento de clic fuera del modal para cerrarlo
// window.onclick = function (event) {
//   modals.forEach(function (modal) {
//     if (event.target == modal) {
//       modal.style.display = "none";
//     }
//   });
// };
