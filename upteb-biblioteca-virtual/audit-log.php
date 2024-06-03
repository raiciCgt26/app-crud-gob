<?php

session_start();
$title = "Registro de Movimientos";
include "header.php";

// Asegurarse que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

include "connect.php";

// Conseguir todos los usuarios de la base de datos.
$query = "SELECT * FROM audit_log";
$result = mysqli_query($con, $query);
?>

<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Movimientos</h2>
    
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="audit">
        <thead>
           <tr class="table-primary">
                <th scope="col">Fecha y Hora</th>
                <th scope="col">Usuario</th>
                <th scope="col">Acción</th>
                <th scope="col">Libro Afectado</th>
                <th scope="col">Usuario Afectado</th>
                <th scope="col">Etiqueta Afectada</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                // Conseguir el nombre de usuario desde user_id
                $user_query = "SELECT username FROM users WHERE user_id = " . $row["user_id"];
                $user_result = mysqli_query($con, $user_query);
                $user_row = mysqli_fetch_assoc($user_result);
                $user_name = $user_row["username"];

                // Conseguir el nombre del libro afectado desde su id.
                if (is_null($row["target_pub_id"]))
                    $target_book_name = "N/A";
                else
                {
                    $target_book_query = "SELECT name FROM publications WHERE pub_id = " . $row["target_pub_id"];
                    $target_book_result = mysqli_query($con, $target_book_query);
                    $target_book_row = mysqli_fetch_assoc($target_book_result);

                    // Verificar si el libro ha sido eliminado
                    $target_book_query = "SELECT * FROM publications WHERE pub_id = " . $row["target_pub_id"] . " AND removed = 1";
                    $target_book_result = mysqli_query($con, $target_book_query);
                    $target_book_deleted = mysqli_num_rows($target_book_result) > 0;

                    if (is_null($target_book_row))
                        $target_book_name = "Deleted Book #" . $row["target_pub_id"];
                    else
                        $target_book_name = $target_book_row["name"];
                }

                // Lo mismo pero con el usuario afectado.
                if (is_null($row["target_user_id"]))
                    $target_user_name = "N/A";
                else
                {
                    $target_user_query = "SELECT username FROM users WHERE user_id = " . $row["target_user_id"];
                    $target_user_result = mysqli_query($con, $target_user_query);
                    $target_user_row = mysqli_fetch_assoc($target_user_result);

                    if (is_null($target_user_row))
                        $target_user_name = "Deleted User #" . $row["target_user_id"];
                    else
                        $target_user_name = $target_user_row["username"];
                }

                // Y la etiqueta afectada.
                if (is_null($row["target_tag_id"]))
                    $target_tag_name = "N/A";
                else
                {
                    $target_tag_query = "SELECT name FROM tags WHERE tag_id = " . $row["target_tag_id"];
                    $target_tag_result = mysqli_query($con, $target_tag_query);
                    $target_tag_row = mysqli_fetch_assoc($target_tag_result);
                    
                    // Verificar si esta fue eliminada.
                    $target_tag_query = "SELECT * FROM tags WHERE tag_id = " . $row["target_tag_id"] . " AND removed = 1";
                    $target_tag_result = mysqli_query($con, $target_tag_query);
                    $target_tag_deleted = mysqli_num_rows($target_tag_result) > 0;

                    if (is_null($target_tag_row))
                        $target_tag_name = "Deleted Tag #" . $row["target_tag_id"];
                    else
                        $target_tag_name = $target_tag_row["name"];
                }
                ?>
            <tr class="table-light">
                <th scope="row"><?php echo $row["date"]; echo " "; echo $row["time"];?></th>
                <td><a href="edit-user.php?id=<?php echo $row["user_id"]; ?>"><?php echo $user_name; ?></a></td>
                <td><?php echo audit_action_get_name($row["action_id"]); ?></td>
                <?php
                if ($target_book_deleted)
                {
                    ?>
                    <td><i><?php echo $target_book_name?></i></td>
                    <?php
                }
                else
                {
                    ?>
                    <td><a href="edit-book.php?id=<?php echo $row["target_pub_id"]; ?>"><?php echo $target_book_name; ?></a></td>
                    <?php
                }
                ?>
                <?php
                if (is_null($row["target_user_id"]) || is_null($target_user_row))
                {
                    ?>
                    <td><i><?php echo $target_user_name?></i></td>
                    <?php
                }
                else
                {
                    ?>
                    <td><a href="edit-user.php?id=<?php echo $row["target_user_id"]; ?>"><?php echo $target_user_name; ?></a></td>
                    <?php
                }
                ?>
                <?php
                if ($target_tag_deleted)
                {
                    ?>
                    <td><i><?php echo $target_tag_name?></i></td>
                    <?php
                }
                else
                {
                    ?>
                    <td><a href="edit-tag.php?id=<?php echo $row["target_tag_id"]; ?>"><?php echo $target_tag_name; ?></a></td>
                    <?php
                }
                ?>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>
<script>
jQuery(document).ready(function($) {
    $("#audit").DataTable({
        paging: true,
        info: false,
        ordering: true,
        orderFixed: [ 0, 'desc' ],


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay movimientos así.",
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
                title: 'UPTEB - Movimientos de Biblioteca',
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