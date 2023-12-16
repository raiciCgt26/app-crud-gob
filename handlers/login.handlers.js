import { extractFromElement } from "../helpers/dataForm.js";

import { loginController } from "../controllers/login.controller.js";

// Insertar toda la logica que se necesita para los *Estilos*

const form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const data = extractFromElement(".formulario");

  loginController.create(data.title);
  loginController.getAllIncidents();
});
