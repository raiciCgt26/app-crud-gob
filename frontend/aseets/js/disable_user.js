document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".desabilitar-usuario").forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      var userId = this.getAttribute("data-id");

      document.getElementById("modalConfirmacion").style.display = "block";

      document
        .getElementById("confirmarDeshabilitar")
        .addEventListener("click", function () {
          fetch("/backend/php/disable.php?id=" + userId)
            .then(function (response) {
              return response.json();
            })
            .then(function (data) {
              if (data.success) {
                document.getElementById("modalConfirmacion").style.display =
                  "none";
                document.getElementById(
                  "modalUsuarioDeshabilitado"
                ).style.display = "block";

                // Cambiar el estilo de la fila y desactivar los botones
                var row = document.querySelector(
                  "tr[data-id='" + userId + "']"
                );
                row.style.backgroundColor = "#f2f2f2";
                row
                  .querySelectorAll(".acciones-container a")
                  .forEach(function (btn) {
                    btn.style.pointerEvents = "none";
                    btn.style.opacity = "0.5";
                  });
              } else {
                alert("Error al deshabilitar usuario");
              }
            })
            .catch(function (error) {
              console.error("Error al deshabilitar usuario:", error);
              alert("Error al deshabilitar usuario");
            });
        });
    });
  });

  document.querySelectorAll(".close, .close-btn").forEach(function (closeBtn) {
    closeBtn.addEventListener("click", function () {
      document.querySelectorAll(".modal").forEach(function (modal) {
        modal.style.display = "none";
      });
    });
  });
});
