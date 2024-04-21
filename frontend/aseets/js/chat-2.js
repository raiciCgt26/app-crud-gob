// Función para cargar los mensajes del chat automáticamente
const cargarMensajesAutomaticamente = () => {
  setInterval(() => {
    cargarMensajes();
  }, 5000); // Consultar cada 5 segundos
};

// Función para cargar los mensajes del chat del usuario actual
const cargarMensajes = () => {
  fetch(`/backend/php/cargar_mensajes.php?receiver=${chatUser}`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("chat-box").innerHTML = data;
    })
    .catch((error) => console.error("Error al cargar mensajes:", error));
};

// Función para enviar un mensaje
const enviarMensaje = async (mensaje) => {
  try {
    const response = await fetch("/backend/php/enviar_mensaje.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `receiver=${chatUser}&message=${mensaje}`,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    cargarMensajes();
  } catch (error) {
    console.error("Error al enviar mensaje:", error);
  }
};

// Event listener para enviar un mensaje cuando se envía el formulario
document.getElementById("chat-form").addEventListener("submit", (e) => {
  e.preventDefault();
  const mensaje = document.getElementById("mensaje").value.trim();
  if (mensaje !== "") {
    enviarMensaje(mensaje);
    document.getElementById("mensaje").value = "";
  }
});

// Cargar mensajes al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  cargarMensajes();
  cargarMensajesAutomaticamente();
});
