<?php

session_start();
$title = "Lista de Sedes";

// Verificar sesión.
if (!isset($_SESSION['loggedin'])) 
{
    header("Location: index.php");
    exit;
}

if ($_SESSION["user_type"] == "student")
{
  header("Location: cubicle.php");
  exit;
}

include "header.php";
include "connect.php";

// Agarrar los tags
$query = "SELECT * FROM tags WHERE removed = 0 AND tag_category = 'Ubicación'";
$result = mysqli_query($con, $query);
?>
<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Lista de Sedes Bibliotecarias de la UPTEB</h2>
<br>
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="tags">
        <thead>
           <tr class="table-primary">
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Número de Libros</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tag = mysqli_fetch_assoc($result)) {
                // Conseguir la cantidad de libros que utilizan esta etiqueta
                $query = "SELECT COUNT(*) FROM pub_join_tags WHERE tag_id = " . $tag["tag_id"];
                $num_books = mysqli_query($con, $query);
                $num_books = mysqli_fetch_assoc($num_books);
                $num_books = $num_books["COUNT(*)"];

                ?>
            <tr class="table-light">
                <td><?php echo $tag["name"]; ?></td>
                <?php if ($tag["description"] == "") { ?>
                    <td><i>N/A</i></td>
                <?php } else { ?>
                    <td><?php echo $tag["description"]; ?></td>
                <?php } ?>
                <td><?php echo $num_books; ?></td>
                <td>
                    <div class="d-flex justify-content-evenly">
                    <a href="edit-tag.php?id=<?php echo $tag["tag_id"]; ?>" class="btn btn-success"><i class="ri-ball-pen-fill"></i></a>
                    <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-pubid="<?php echo $tag['tag_id']; ?>"><i class="bi bi-trash-fill"></i></button>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal de Eliminación -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminación de Libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar esta etiqueta permanentemente?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="#" id="deleteLink" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>


</main>
<script>
var myModal = document.getElementById('deleteModal')
var myInput = document.getElementById('deleteButton')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})

//Y esta es la función que le permite al modal borrar una publicación diferente dependiendo del botón de eliminación.
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const pubId = this.getAttribute('data-pubid');
            const deleteLink = document.getElementById('deleteLink');
            deleteLink.href = `remove-tag.php?id=${pubId}`;
        });
    });
});

jQuery(document).ready(function($) {
    $("#tags").DataTable({
        paging: false,
        info: false,
        ordering: false,


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay categorías así.",
        },

        buttons: [
            {
                text: "<b>Agregar Sede</b>",
                className: "btn btn-primary",
                action: function ( e, dt, button, config ) {
                    window.location = "add-tag.php";
                }
            },

            {
                extend: "copy",
                text: "<i class='ri ri-file-copy-2-line'></i>",
                className: "btn btn-primary",
            },

            {
                extend: "excel",
                text: "<i class='ri ri-file-excel-2-line'></i>",
                className: "btn btn-primary",
            },       
            
            {
                extend: "pdf",
                className: "btn btn-primary",
                text: "<i class='bi bi-file-earmark-pdf'></i>",
            }, 

            {
                extend: "print",
                text: "<i class='bi bi-printer'></i>",
                title: 'UPTEB - Listado de Sedes Bibliotecarias',
                messageTop: ' <div class="d-flex justify-content-center py-4"><img src="assets/upt_banner.png" alt="Banner de la Universidad" style="max-height:100%; max-width: 100%;"></div>',
               className: "btn btn-primary",
               customize: function (win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '14px');
                    $(win.document.body).find('h1').css('text-align','center');
                },
            }
        ]

    });
} );

$.extend($.fn.dataTable.defaults, {
  dom: 'fBrtip'
});
</script>

<?php include "footer.php"; ?>