<?php

session_start();
$title = "Lista de Usuarios";
include "header.php";

// Asegurarse que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

include "connect.php";

// Conseguir todos los usuarios de la base de datos.
$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);
?>
<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Lista de Usuarios</h2>
<br>
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="users">
        <thead>
            <tr class="table-primary">
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo de Usuario</th>
                <th scope="col">Teléfono Número de Contacto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr class="table-light">
                <th scope="row"><?php echo $row["user_id"]; if ($row["auto_register"] > 0) { echo " (Autoregistro)";} ?></th>
                <td><?php if (isset($row["email"])) {  echo $row["email"]; } else { echo "<i>SIN CORREO.</i>"; }?></td>
                <td><?php echo $row["username"]; ?></td>
                <td><?php echo get_role_name($row["user_type"]); ?></td>
                <td><?php echo $row["contact_number"]; ?></td>
                <td>
                    <div class="d-flex justify-content-evenly">
                    <a href="edit-user.php?id=<?php echo $row["user_id"]; ?>" class="btn btn-success"><i class="ri-ball-pen-fill"></i></a>
                    <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userid="<?php echo $row['user_id']; ?>"><i class="bi bi-trash-fill"></i></button>
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
        <h5 class="modal-title" id="staticBackdropLabel">Eliminación de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar este usuario permanentemente?
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
            const pubId = this.getAttribute('data-userid');
            const deleteLink = document.getElementById('deleteLink');
            deleteLink.href = `remove-user.php?id=${pubId}`;
        });
    });
});

jQuery(document).ready(function($) {
    $("#users").DataTable({
        paging: false,
        info: false,
        ordering: false,


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay usuarios así.",
        },

        buttons: [
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
                title: 'UPTEB - Listado de Usuarios',
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