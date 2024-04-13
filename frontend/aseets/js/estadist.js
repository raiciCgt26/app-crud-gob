// Espera a que la página se cargue completamente
document.addEventListener("DOMContentLoaded", function () {
  // Selecciona todas las estadísticas
  var cards = document.querySelectorAll(".card");

  // Agrega la clase 'visible' a cada estadística después de un breve retraso
  cards.forEach(function (card, index) {
    setTimeout(function () {
      card.classList.add("visible");
    }, index * 100); // Incrementa el retraso para cada estadística
  });
});

// Selecciona todos los elementos con la clase "stat-title"
const titles = document.querySelectorAll(".stat-title");

// Función para animar la aparición gradual de los títulos
function animateTitles() {
  titles.forEach((title, index) => {
    // Espera 300 milisegundos antes de animar cada título
    setTimeout(() => {
      title.style.opacity = 1; // Cambia la opacidad a 1 (visible)
    }, index * 300); // Multiplica el índice por 300 para un retraso progresivo
  });
}

// Llama a la función para iniciar la animación al cargar la página
window.addEventListener("load", animateTitles);
