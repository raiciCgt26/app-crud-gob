// Obtener referencia al modal y al contenido de los detalles
const modalDetalles = document.getElementById("modalDetalles");
const detallesContent = document.getElementById("detallesContent");

// Agregar evento click a los botones "Ver detalles"
document.querySelectorAll(".ver-detalles").forEach((button) => {
  button.addEventListener("click", () => {
    // Obtener los detalles de la incidencia a través del atributo data-*
    const titulo = button.getAttribute("data-titulo");
    const estado = button.getAttribute("data-estado");
    const fecha = button.getAttribute("data-fecha");
    const prioridad = button.getAttribute("data-prioridad");
    const solicitante = button.getAttribute("data-solicitante");
    const tecnico = button.getAttribute("data-tecnico");
    const grupo = button.getAttribute("data-grupo");
    const categoria = button.getAttribute("data-categoria");

    // Mostrar los deta0lles de la incidencia en el modal
    detallesContent.innerHTML = `
      <p><strong>${titulo}</strong></p>
      <p><strong>Estado:</strong> ${estado}</p>
      <p><strong>Fecha de modificación:</strong> ${fecha}</p>
      <p><strong>Prioridad:</strong> ${prioridad}</p>
      <p><strong>Solicitante:</strong> ${solicitante}</p>
      <p><strong>Técnico:</strong> ${tecnico}</p>
      <p><strong>Grupo Técnico:</strong> ${grupo}</p>
      <p><strong>Categoría:</strong> ${categoria}</p>
    `;

    // Mostrar el modal
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
