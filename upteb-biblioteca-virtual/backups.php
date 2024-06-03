<?php

session_start();
$title = "Respaldos";
include "header.php";

// Asegurarse que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

include "connect.php";



$fileArray = array();

$backupPlace = __DIR__ . "/backup/";

$handle = opendir(__DIR__ . "/backup");

if ($handle) {
    while (($entry = readdir($handle)) !== FALSE) {
        $fileArray[] = $entry;
    }
}

closedir($handle);


arsort($fileArray);
$unlinker = count($fileArray);

$fileArray = \array_filter($fileArray, static function ($element) {
    return $element !== ".";
});

$fileArray = \array_filter($fileArray, static function ($element) {
    return $element !== "..";
});

$backupDL = "backup/"


?>

<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Lista de Respaldos</h2>
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="backups">
        <thead>
           <tr class="table-primary">
                <th scope="col">Respaldos</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach ($fileArray as $file_row)
{
$unlinker = $unlinker - 1;              
?>
            <tr class="table-light">
                <td><?php print $file_row; ?></td>
                <td>
                    <div class="d-flex justify-content-evenly">
                    <a href="<?php echo $backupDL . $file_row; ?>" class="btn btn-info" download><i class="ri-download-2-fill"></i></a>
                    <button type="button" name="<?php echo $unlinker ?>" class="btn btn-danger deleter" data-bs-toggle="modal" data-bs-target="#deleteModal" id="deleteButton" onclick=""><i class="bi bi-trash-fill"></i></button>
                    </div>
                </td>
            </tr>
<?php }  ?>
        </tbody>
    </table>
</div>
<div id="testID"></div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminación de Respaldo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar este respaldo permanentemente?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a class="btn btn-danger" id="eraseFile" href="?delete=2">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<?php

    if(isset($_GET['delete']))
    {

        unlink($backupPlace . $fileArray[($_GET['delete'])]); ?>
    <script>window.location = "backups.php";</script>
    <?php }

?>


</main>
<script>

function addModalToButton(button)
{
  var buttonName = button.getAttribute("name");
  button.onclick = function() { sendToModal(buttonName); }
}

var listOfButtons = document.getElementsByClassName("deleter");

for (let i = 0; i < listOfButtons.length; i++)
{
  addModalToButton(listOfButtons[i]);
}

function sendToModal(buttonName) {
var delLink = buttonName;
var delConfirm = document.getElementById("eraseFile");
 delConfirm.setAttribute('href', '?delete=' + delLink);
}

jQuery(document).ready(function($) {
    $("#backups").DataTable({
        paging: true,
        info: false,
        ordering: false,
        orderFixed: [ 0, 'desc' ],


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay respaldos así.",
        },

        buttons: [
            {
                text: "Generar Respaldo",
                className: "btn btn-success",
                action: function ( e, dt, button, config ) {
                    window.location = "respaldo.php";
                }
            },

            {
                extend: "copy",
                text: "Copiar",
                className: "btn btn-success",
            },

            {
                extend: "excel",
                text: "Excel",
                className: "btn btn-success",
            },       
            
            {
                extend: "pdf",
                text: "PDF",
                className: "btn btn-success",
            }, 

            {
                extend: "print",
                text: "Imprimir",
                className: "btn btn-success",
            }
        ]

    });
} );


$.extend($.fn.dataTable.defaults, {
  dom: 'fBrtip'
});
</script>

<?php include "footer.php"; ?>