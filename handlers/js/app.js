$(document).ready(function () {
  console.log("jquery funciona");

  $("#search").keyup(function (e) {
    let search = $("#search").val();
    $.ajax({
      url: "nav_search.php",
      type: "POST",
      data: { search },
      success: function (resp) {
        console.log(resp);
      },
    });
  });
});
