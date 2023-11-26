$(document).ready(function () {
  console.log("jquery funciona");

  $("#ind-result").hide();

  $("#search").keyup(function (e) {
    if ($("#search").val()) {
      let search = $("#search").val();
      $.ajax({
        url: "list_incd_search.php",
        type: "POST",
        data: { search },
        success: function (resp) {
          let incd = JSON.parse(resp);
          let template = "";
          incd.forEach((incd) => {
            template += `<li>
               ${incd.Titulo}
            </li>`;
          });
          $("#container").html(template);
          $("#ind-result").show();
        },
      });
    }
  });

  $("#lista-incd").submit(function (e) {
    const postData = {
      titulo: $("#titulo").val(),
      estado: $("#estado").val(),
      modificacion: $("#modificacion").val(),
      prioridad: $("#prioridad").val(),
      Solicitante: $("#Solicitante").val(),
      AsigTecnico: $("#AsigTecnico").val(),
      AsigGrupo: $("#AsigGrupo").val(),
      Categoria: $("#Categoria").val(),
    };
    $.post("lista_incd_add.php", postData, function (resp) {
      console.log(resp);
    });
    // console.log(postData);
    e.preventDefault();
  });
});
