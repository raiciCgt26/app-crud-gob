/**
 * Pasarle el selector de css para que extraiga la informacion del formulario
 * ADVERTENCIA: Te va a dar error si lo que estas seleccionando no es un formulario
 * @param {*} selector
 * @returns
 */
// La función extractFromElement
// Uso de la función para extraer datos del formulario

export const extractFromElement = (selector) => {
  const object = {};
  const element = document.querySelector(selector);
  const formData = new FormData(element);

  for (const entri of formData.entries()) {
    object[entri[0]] = entri[1];
  }

  return object;
};
