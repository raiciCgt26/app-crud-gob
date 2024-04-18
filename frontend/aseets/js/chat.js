const searchBar = document.querySelector(".users .search input"),
  searchBtn = document.querySelector(".users .search button"),
  usersList = document.querySelectorAll(".users-list"); // Cambiado de usersList a users-list

searchBtn.onclick = () => {
  searchBar.classList.toggle("active");
  searchBar.focus();
};

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const searchButton = document.getElementById("searchButton");
  const usersList = document.querySelector(".users-list");

  searchButton.addEventListener("click", function () {
    const searchTerm = searchInput.value.toLowerCase();

    // Ocultar todos los usuarios
    usersList.querySelectorAll("a").forEach(function (user) {
      user.style.display = "none";
    });

    // Mostrar solo los usuarios que coincidan con el término de búsqueda
    usersList.querySelectorAll("a").forEach(function (user) {
      const username = user
        .querySelector(".tittle-chat")
        .textContent.toLowerCase();
      if (username.includes(searchTerm)) {
        user.style.display = "block";
      }
    });
  });
});
