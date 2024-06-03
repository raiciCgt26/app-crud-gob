<?php

session_start();
$title = "Préstamos";

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
include "datetimecheck.php";

// Agarrar los tags
$query = "SELECT * FROM pub_lending";
$result = mysqli_query($con, $query);
?>
<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Lista de Préstamos</h2>
<br>
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="tickets">
        <thead>
           <tr class="table-primary">
                <th scope="col">Estado</th>
                <th scope="col">Tipo</th>
                <th scope="col">Fecha de Salida</th>
                <th scope="col">Fecha de Retorno</th>
                <th scope="col">Publicación</th>
                <th scope="col">Prestatario</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ticket = mysqli_fetch_assoc($result)) {
			    $query_pubs = "SELECT * FROM publications WHERE pub_id = " . $ticket["focus_pub_id"];
			    $pub_data = mysqli_query($con, $query_pubs);
			    $pub_data = mysqli_fetch_all($pub_data, MYSQLI_ASSOC);

                $query_pub_tag = "SELECT * FROM tags INNER JOIN pub_join_tags ON tags.tag_id=pub_join_tags.tag_id WHERE tags.removed=0 AND pub_join_tags.pub_id=" . $pub_data[0]["pub_id"];
                $pub_tag_data = mysqli_query($con, $query_pub_tag);
                $pub_tag_data = mysqli_fetch_all($pub_tag_data, MYSQLI_ASSOC);
                $pub_tag_data = array_column($pub_tag_data, "name","tag_category");

			    $query_users = "SELECT * FROM users WHERE user_id = " . $ticket["focus_user_id"];
			    $user_data = mysqli_query($con, $query_users);
			    $user_data = mysqli_fetch_all($user_data, MYSQLI_ASSOC);




                //  Conseguir todas las cotas en base a pub_lent_cotas
                $cota_id_query = "SELECT * FROM pub_lent_cotas WHERE pub_lend_id = " . $ticket["book_act_id"];
                $cota_ids = mysqli_query($con, $cota_id_query);
                $cota_ids = mysqli_fetch_all($cota_ids, MYSQLI_ASSOC);
                $cota_ids = array_column($cota_ids, "cota_id");

                // Conseguir todas las etiquetas desde su propia tabla en donde el tag id esté incluido en el array anterior y convertir los nombres en un string.
                if (count($cota_ids) > 0)
                {
                    $real_cota_query = "SELECT * FROM pub_cota_data WHERE pub_cd_id IN (" . implode(", ", $cota_ids) . ")";
                    $cotas = mysqli_query($con, $real_cota_query);
                    $cotas = mysqli_fetch_all($cotas, MYSQLI_ASSOC);
                    $cotas = array_column($cotas, "cota");
                    $cota_string = implode(", ", $cotas);
                }
                else
                {
                    $cota_string = "Publicación sin Cota.";
                }
                
                switch ($ticket["lend_status"]) {
                    case 0:
                        $tick_string = "Presolicitud";
                        $row_class = "table-light";
                        break;
                    case 1:
                        $tick_string = "<b>Préstamo Activo</b>";
                        $row_class = "table-light";
                        break;
                    case 2:
                        $tick_string = "Finalizado";
                        $row_class = "table-light";
                        break;
                    case 3:
                        $tick_string = "<b>Préstamo Expirado</b>";
                        $row_class = "table-danger";
                        break;
                    default:
                        $tick_string = "Presolicitud"; // Default case
                        $row_class = "table-light";
                        break;
                }

			?>
			    <tr class="<?php echo $row_class; ?>">
			        <td><?php echo $tick_string ?></td>
			        <td><?php echo $ticket["lend_type"]; ?></td>
			        <td><?php echo $ticket["start_date"]; ?></td>
			        <td><?php echo $ticket["end_date"]; ?></td>
			        <td><?php echo $pub_data[0]["name"]; ?></td>
			        <td><?php echo $user_data[0]["username"]; ?></td>
			        <td>
			            <div class="d-flex justify-content-evenly">
			                <button href="#" data-bs-toggle="modal" data-bs-target="#abstractModal" onclick="displayDesc(this)"  data-start-date="<?php echo htmlspecialchars($ticket["start_date"]); ?>" data-end-date="<?php echo htmlspecialchars($ticket["end_date"]); ?>" data-lend-name="<?php echo htmlspecialchars($user_data[0]["username"]); ?>" data-lend-cedula="<?php echo htmlspecialchars($user_data[0]["cedula_id"]); ?>" data-lend-pnf="<?php echo htmlspecialchars($user_data[0]["pnf"]); ?>" data-lend-role="<?php echo htmlspecialchars(get_role_name($user_data[0]["user_type"])); ?>" data-lend-location="<?php echo htmlspecialchars($pub_tag_data["Ubicación"]); ?>" data-lend-phone="<?php echo htmlspecialchars($user_data[0]["contact_number"]); ?>" data-lend-pub="<?php echo htmlspecialchars($pub_data[0]["name"]); ?>" data-lend-type="<?php echo htmlspecialchars($ticket["lend_type"]); ?>" data-desc="<?php echo htmlspecialchars($ticket["observations"]); ?>" data-cotas="<?php echo htmlspecialchars($cota_string); ?>" class="btn btn-info bi bi-file-plus-fill"></button>
                            <a href="edit-pub-lending.php?id=<?php echo $ticket["book_act_id"]; ?>" class="btn btn-success"><i class="ri-ball-pen-fill"></i></a>
			                <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-pubid="<?php echo $ticket['book_act_id']; ?>"><i class="bi bi-trash-fill"></i></button>
			            </div>
			        </td>
			    </tr>
			<?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal de Detalles Extra -->
<div class="modal fade" id="abstractModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Ticket de Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="desc-modal">
        <!-- Fecha de salida y de retorno -->
        <div class="row">
          <div class="col-md-6">
            <h6 id="modalStartDateTitle"><b>Fecha de Salida</b>:</h6>
            <p id="modalStartDate"></p>
          </div>
          <div class="col-md-6">
            <h6 id="modalEndDateTitle"><b>Fecha de Retorno</b>:</h6>
            <p id="modalEndDate"></p>
          </div>
        </div>
        <!-- Nombre y cédula de prestatario -->
        <div class="row">
          <div class="col-md-6">
            <h6 id="modalLendNameTitle"><b>Nombre del Prestatario</b>:</h6>
            <p id="modalLendName"></p>
          </div>
          <div class="col-md-6">
            <h6 id="modalLendCedulaTitle"><b>Cédula del Prestatario</b>:</h6>
            <p id="modalLendCedula"></p>
          </div>
        </div>
        <!-- PNF del prestatario y sede del préstamo -->
        <div class="row">
          <div class="col-md-6">
            <h6 id="modalLendPNFTitle"><b>PNF del Prestatario</b>:</h6>
            <p id="modalLendPNF"></p>
          </div>
          <div class="col-md-6">
            <h6 id="modalLendLocationTitle"><b>Sede del Prestamo</b>:</h6>
            <p id="modalLendLocation"></p>
          </div>
        </div>
        <!-- Tipo de Comunidad del prestatario y Número de teléfono del prestatario -->
        <div class="row">
          <div class="col-md-6">
            <h6 id="modalLendRoleTitle"><b>Rol del Prestatario</b>:</h6>
            <p id="modalLendRole"></p>
          </div>
          <div class="col-md-6">
            <h6 id="modalLendPhoneTitle"><b>Número de Telf. del Prestatario</b>:</h6>
            <p id="modalLendPhone"></p>
          </div>
        </div>
        <!-- Nombre de la Publicación y Cotas de la Publicación -->
        <div class="row">
          <div class="col-md-6">
            <h6 id="modalLendPubTitle"><b>Nombre de la Publicación</b>:</h6>
            <p id="modalLendPub"></p>
          </div>
          <div class="col-md-6">
            <h6 id="modalCotaTitle"><b>Cotas Prestadas</b>:</h6>
            <p id="modalCotas"></p>
          </div>
        </div>
        <!-- Tipo de Préstamo -->
        <div class="row">
          <div class="col-md-12 text-center">
            <h6 id="modalLendTypeTitle"><b>Tipo de Préstamo</b>:</h6>
            <p id="modalLendType"></p>
          </div>
        </div>
        <!-- Observaciones -->
            <h6 id="modalDescTitle"><b>Observaciones</b>:</h6>
            <p id="modalDesc"></p>
      </div>
    </div>
  </div>
</div>


<!-- Modal de Eliminación -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminación de Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar este préstamo permanentemente?
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

//Esta es la función que muestra el modal con los detalles extra.
function displayDesc(anchor) {
    var startDate = anchor.getAttribute("data-start-date");
    var endDate = anchor.getAttribute("data-end-date");

    var lendName = anchor.getAttribute("data-lend-name");
    var lendCedula = anchor.getAttribute("data-lend-cedula");

    var lendPNF = anchor.getAttribute("data-lend-pnf");
    var lendLocation = anchor.getAttribute("data-lend-location");

    var lendRole = anchor.getAttribute("data-lend-role");
    var lendPhone = anchor.getAttribute("data-lend-phone");

    var lendPub = anchor.getAttribute("data-lend-pub");
    var cotas = anchor.getAttribute("data-cotas");



    var lendType = anchor.getAttribute("data-lend-type");



    var desc = anchor.getAttribute("data-desc");


    // Update the modal content with the retrieved data
    document.getElementById("modalStartDate").textContent = startDate;
    document.getElementById("modalEndDate").textContent = endDate;
    document.getElementById("modalLendName").textContent = lendName;
    document.getElementById("modalLendCedula").textContent = lendCedula;
    document.getElementById("modalLendPNF").textContent = lendPNF;
    document.getElementById("modalLendLocation").textContent = lendLocation;
    document.getElementById("modalLendRole").textContent = lendRole;
    document.getElementById("modalLendPhone").textContent = lendPhone;
    document.getElementById("modalLendPub").textContent = lendPub;
    document.getElementById("modalLendType").textContent = lendType;

    document.getElementById("modalCotas").textContent = cotas;
    document.getElementById("modalDesc").textContent = desc;
}

//Y esta es la función que le permite al modal borrar una publicación diferente dependiendo del botón de eliminación.
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const pubId = this.getAttribute('data-pubid');
            const deleteLink = document.getElementById('deleteLink');
            deleteLink.href = `remove-pub-lending.php?id=${pubId}`;
        });
    });
});

jQuery(document).ready(function($) {
    $("#tickets").DataTable({
        paging: false,
        info: false,
        ordering: false,


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay préstamos así.",
        },

        buttons: [
            {
                text: "<b>Registrar Préstamo</b>",
                className: "btn btn-primary",
                action: function ( e, dt, button, config ) {
                    window.location = "register-pub-lending.php";
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
                title: 'UPTEB - Listado de PNFs',
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