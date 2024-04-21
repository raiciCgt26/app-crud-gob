document.addEventListener("DOMContentLoaded", function () {
  const modalDetalles = document.getElementById("modalDetalles");
  const detallesContent = document.getElementById("detallesContent");

  if (!modalDetalles || !detallesContent) {
    console.error(
      "No se encontraron los elementos modalDetalles o detallesContent"
    );
    return;
  }

  document.querySelectorAll(".ver-detalles").forEach((button) => {
    button.addEventListener("click", () => {
      const tecnico = button.getAttribute("data-tecnico");
      const grupo = button.getAttribute("data-grupo");
      const categoria = button.getAttribute("data-categoria");

      detallesContent.innerHTML = `
        <p><strong>Asignado a - Grupo Tecnico:</strong> ${grupo}</p>
        <p><strong>Asignado a - Tecnico:</strong> ${tecnico}</p>
        <p><strong>Categoria:</strong> ${categoria}</p>
      `;

      modalDetalles.style.display = "block";
    });
  });

  // Agregar evento click al botón de cerrar del modal
  document
    .querySelector("#modalDetalles .close")
    .addEventListener("click", () => {
      modalDetalles.style.display = "none";
    });

  // Cerrar el modal si se hace clic fuera de él
  window.addEventListener("click", (event) => {
    if (event.target === modalDetalles) {
      modalDetalles.style.display = "none";
    }
  });
});
