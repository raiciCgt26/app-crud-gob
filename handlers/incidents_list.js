import { extractFromElement } from '../helpers/dataForm.js';

import { incidentController } from '../controllers/incident.controller.js';

// Insertar toda la logica que se necesita para los *Estilos*

const form = document.querySelector('form');

form.addEventListener('submit', e => {
    e.preventDefault();
    const data = extractFromElement('.formulario');

    incidentController.create(data.title);
    incidentController.getAllIncidents();
})