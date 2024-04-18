// Función para cargar los mensajes del chat
const cargarMensajes = () => {
  fetch(`/backend/php/cargar_mensajes.php?receiver=<?php echo $chatUser; ?>`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("chat-box").innerHTML = data;
    })
    .catch((error) => console.error("Error al cargar mensajes:", error));
};

// Funcion enviar
document.getElementById("chat-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const mensaje = document.getElementById("mensaje");
  console.log(mensaje);
  try {
    const response = await fetch("/backend/php/enviar_mensaje.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `receiver=<?php echo $chatUser; ?>&message=${mensaje}`,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    document.getElementById("mensaje").value = "";
    cargarMensajes();
  } catch (error) {
    console.error("Error al enviar mensaje:", error);
  }
});
// Cargar los mensajes al cargar la página
document.addEventListener("DOMContentLoaded", cargarMensajes);

// console.log("Mensaje a enviar:", mensaje);
// console.log("Receptor del mensaje:", chatUser);
