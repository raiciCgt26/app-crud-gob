document.addEventListener("DOMContentLoaded", function () {
  const startBtn = document.querySelector(".startBtn");
  const stepBtns = document.querySelectorAll(".stepBtn");
  const nums = document.querySelectorAll(".num");
  const slider = document.querySelector(".card-wrapper");
  const cards = document.querySelectorAll(".card");
  const endBtn = document.querySelector(".endBtn");
  const totalSlides = cards.length;
  let currentSlide = 0;

  // Función para mostrar el slide actual
  function showSlide(index) {
    cards.forEach((card) => {
      card.style.display = "none";
    });
    cards[index].style.display = "block";
    currentSlide = index;
    updateButtons();
  }

  // Función para actualizar el estado de los botones de navegación
  function updateButtons() {
    if (currentSlide === 0) {
      startBtn.disabled = true;
      stepBtns[0].disabled = true;
    } else {
      startBtn.disabled = false;
      stepBtns[0].disabled = false;
    }

    if (currentSlide === totalSlides - 1) {
      stepBtns[1].disabled = true;
      endBtn.disabled = true;
    } else {
      stepBtns[1].disabled = false;
      endBtn.disabled = false;
    }

    nums.forEach((num, index) => {
      if (index === currentSlide) {
        num.classList.add("active");
      } else {
        num.classList.remove("active");
      }
    });
  }

  // Evento para el botón de inicio
  startBtn.addEventListener("click", function () {
    showSlide(0);
  });

  // Evento para el botón de retroceso
  stepBtns[0].addEventListener("click", function () {
    if (currentSlide > 0) {
      showSlide(currentSlide - 1);
    }
  });

  // Evento para el botón de avance
  stepBtns[1].addEventListener("click", function () {
    if (currentSlide < totalSlides - 1) {
      showSlide(currentSlide + 1);
    }
  });

  // Evento para los números de paginación
  nums.forEach((num, index) => {
    num.addEventListener("click", function () {
      showSlide(index);
    });
  });

  // Evento para el botón de final
  endBtn.addEventListener("click", function () {
    showSlide(totalSlides - 1);
  });

  // Mostrar el primer slide al cargar la página
  showSlide(0);
});
