// Obtener referencia al modal y al contenido de los detalles
const modalDetalles = document.getElementById("modalDetalles");
const detallesContent = document.getElementById("detallesContent");

// Agregar evento click a los botones "Ver detalles"
document.querySelectorAll(".ver-detalles").forEach((button) => {
  button.addEventListener("click", () => {
    // Obtener los detalles del usuario a través del atributo data-*
    const username = button.getAttribute("data-username");
    const email = button.getAttribute("data-email");
    const role = button.getAttribute("data-role");
    const phone = button.getAttribute("data-phone");
    const description = button.getAttribute("data-description");
    const estado = button.getAttribute("data-estado");

    // Mostrar los detalles del usuario en el modal
    detallesContent.innerHTML = `
      <p><strong>Username:</strong> ${username}</p>
      <p><strong>Email:</strong> ${email}</p>
      <p><strong>Rol:</strong> ${role}</p>
      <p><strong>Phone:</strong> ${phone}</p>
      <p><strong>Description:</strong> ${description}</p>
      <p><strong>Estado:</strong> ${estado}</p>
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
