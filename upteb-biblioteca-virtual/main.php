<?php

session_start();
$title = "Lista de Libros";

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

//Agarrar todos los tags y su id...
$sqlSelect = "SELECT tag_id, name FROM tags WHERE tag_category = 'PNF' AND removed = 0";
$queryResult= mysqli_query($con, $sqlSelect);

//Establecer un arreglo vacío
$tagArray = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult, MYSQLI_ASSOC)) 
{
    array_push($tagArray,$row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult);

//Lo hacemos otra vez pero para las sedes
$sqlSelect2 = "SELECT tag_id, name FROM tags WHERE tag_category = 'Ubicación' AND removed = 0";
$queryResult2 = mysqli_query($con, $sqlSelect2);

//Establecer un arreglo vacío
$tagArray2 = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult2, MYSQLI_ASSOC)) 
{
    array_push($tagArray2,$row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult2);


//Y una vez más pero para el typo de documento.
$sqlSelect3 = "SELECT tag_id FROM tags WHERE name = 'Libro' AND removed = 0";
$queryResult3= mysqli_query($con, $sqlSelect3);

$docType = implode(mysqli_fetch_assoc($queryResult3));

//Y liberamos la memoría
mysqli_free_result($queryResult3);

// Mostrar todos los libros de la tabla "publications" Y SOLO LOS LIBROS a través de un "JOIN" de MySQL que compara el tag id de pub_join_tags con el arreglo que acabamos de llenar, el $docTypeArray (porque pub_join_tags SOLO guarda ids).
$query = "SELECT * FROM publications INNER JOIN pub_join_tags ON publications.pub_id=pub_join_tags.pub_id WHERE publications.removed=0 AND pub_join_tags.tag_id=" . $docType;
$result = mysqli_query($con, $query);


//Inicializamos un arreglo vacío para mostrar las descripciones en modales.
$descArray = array();

        //Ponemos todas las cotas que estan siendo préstadas para hacer comparaciones con cada libro que esté tomado.
            $cota_ids_result = mysqli_query($con, "SELECT cota_id FROM pub_lent_cotas");
            $cota_ids = mysqli_fetch_all($cota_ids_result, MYSQLI_ASSOC);
            $cota_ids = array_column($cota_ids, 'cota_id');

?>

<main id="main" class="main">
<div class="container mt-5">
 
    <h1 class="text-center pagetitle">Lista de Libros</h1>
<br>
<div class="col-md-12">

<?php
            echo "<select name='tags' id='tags_filter' class='dropdown'>";
            echo " <option value=''>Todos los PNF</option>";
            foreach ($tagArray as $row){ // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.
            

           echo "<option value=$row[name]>$row[name]</option>"; 

            
            }
            echo "</select>";

            echo "<select name='location_tags' id='tags_filter_2' class='dropdown'>";
            echo " <option value=''>Todas las Sedes</option>";
            foreach ($tagArray2 as $row){ // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.
            

           echo "<option value=$row[name]>$row[name]</option>"; 

            
            }
            echo "</select>";

            ?>
</div>
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="publications">
        <thead>
            <tr class="table-primary">
                <th scope="col">Nombre</th>
                <th scope="col">Autor(es)</th>
                <th scope="col">Ejemplares</th>
                <th scope="col">PNF</th>
                <th scope="col">Sede</th>
                 <th scope="col">Cota(s)</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($book = mysqli_fetch_assoc($result)) 
            {     

                //  Conseguir todas las etiquetas donde el book_id encaja y convertirlo en array.
                $query = "SELECT * FROM pub_join_tags WHERE pub_id = " . $book["pub_id"];
                $tag_ids = mysqli_query($con, $query);
                $tag_ids = mysqli_fetch_all($tag_ids, MYSQLI_ASSOC);
                $tag_ids = array_column($tag_ids, "tag_id");

                // Conseguir todas las etiquetas desde su propia tabla en donde el tag id esté incluido en el array anterior y convertir los nombres en un string.
                if (count($tag_ids) > 0)
                {
                    $query = "SELECT * FROM tags WHERE tag_id IN (" . implode(", ", $tag_ids) . ")";
                    $tags = mysqli_query($con, $query);
                    $tags = mysqli_fetch_all($tags, MYSQLI_ASSOC);
                    $tags = array_column($tags, "name", "tag_category");
                }
                else
                {
                    $tags = "<i>Ninguna</i>";
                }


               //  Conseguir los autores del libro.
                $query2 = "SELECT * FROM cited_sources WHERE pub_id = " . $book["pub_id"];
                $cited_sources = mysqli_query($con, $query2);
                $cited_sources = mysqli_fetch_all($cited_sources, MYSQLI_ASSOC);

                if (count($cited_sources) > 0)
                {
                $cited_sources = array_column($cited_sources, "name");
                $cited_sources_string = implode(", ", $cited_sources);
                }
                else
                {

                    $cited_sources_string = "<i>Ningunos</i>";
                }
                    array_push($descArray,$book["description"]);

            // Recuperar data de cota
            $query3 = "SELECT * FROM pub_cota_data WHERE pub_id = " . $book["pub_id"];
            $cota_result = mysqli_query($con, $query3);
            $cota = mysqli_fetch_all($cota_result, MYSQLI_ASSOC);

                    $pub_date_query = "SELECT date FROM audit_log WHERE action_id = 5 AND target_pub_id = " . $book["pub_id"];
                    $pub_date_result = mysqli_query($con, $pub_date_query);
                    if ($pub_date_result) {
                        $book_date = mysqli_fetch_assoc($pub_date_result); 
                    } else {
                        $book_date = "N/A"; 
                    }

                // Si la publicación está siendo prestada, indicar cuantos y que cotas están siendo prestadas.
                $pub_lend_query = "SELECT book_act_id, quantity FROM pub_lending WHERE focus_pub_id = " . $book["pub_id"];
                $pub_lend_result = mysqli_query($con, $pub_lend_query);

                if (mysqli_num_rows($pub_lend_result) > 0)
                {
                $pub_lend_result = mysqli_fetch_all($pub_lend_result, MYSQLI_ASSOC);
                $isLent = true; //Esta variable dicta si muestra la cantidad siendo restada.
                $comparison_count = ($book["quantity"]) - ($pub_lend_result[0]["quantity"]);
                }
                else
                {
                $isLent = false;
                }

                // Crear la variable de nombre con enlace si $book["link"] existe y no está vacío
                if (!empty($book["link"])) {
                    $bookName = '<a href="' . htmlspecialchars($book["link"]) . '" target="_blank">' . htmlspecialchars($book["name"]) . '</a>';
                } else {
                    $bookName = htmlspecialchars($book["name"]);
                }
            ?>
            <tr class="table-light">
                <td><?php echo $bookName; ?><a href="#" data-bs-toggle="modal" data-bs-target="#abstractModal" onclick="displayDesc(this)" data-desc="<?php echo htmlspecialchars($book["description"]); ?>" data-date="<?php echo htmlspecialchars($book_date["date"]); ?>" class="ri ri-add-circle-line"></a></td>
                <td><?php echo $cited_sources_string;?></td>
                <td><?php if ($isLent) { echo $comparison_count; echo "/"; } echo $book["quantity"]; ?></td>
                <td><?php echo $tags["PNF"]; ?></td>
                <td><?php echo $tags["Ubicación"]; ?></td>
                <td>
                    <?php if (count($cota) > 0) { ?>
                        <ul class="cota-list">
                            <?php foreach ($cota as $cota_item) { ?>
                                <li>
                                    <?php
                                    $content = !empty($cota_item["prefix_string"]) ? $cota_item["prefix_string"] . " " . $cota_item["cota"] : $cota_item["cota"];
                                    if (in_array($cota_item["pub_cd_id"], $cota_ids)) {
                                        echo "<s>{$content}</s>"; // Wrap in <s> tag for strikethrough
                                    } else {
                                        echo $content;
                                    }
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <i>SIN COTA</i>
                    <?php } ?>
                </td>
                <td>
                    <div class="d-flex justify-content-evenly">
                        <a href="edit-book.php?id=<?php echo $book["pub_id"]; ?>" class="btn btn-success"><i class="ri-ball-pen-fill"></i></a>
                        <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-pubid="<?php echo $book['pub_id']; ?>"><i class="bi bi-trash-fill"></i></button>
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
        <h5 class="modal-title" id="staticBackdropLabel">Detalles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="desc-modal">
        <h6 id="modalDateTitle"></h6>
        <p id="modalDate"></p>
        <h6 id="modalDescTitle"></h6>
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
        <h5 class="modal-title" id="staticBackdropLabel">Eliminación de Libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar este libro permanentemente?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="#" id="deleteLink" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>


</main>
<style>
    .cota-list {
        list-style-type: none; /* Remove default bullet points */
        padding-left: 0; /* Remove default left padding */
    }
</style>
<script>
//Este bloque basicamente se encarga de asegurar que el modal funcione de la manera correcta. Así lo recomienda la guía de Bootstrap 5 debido a un cambio en html con autofocus.
var myModal = document.getElementById('deleteModal')
var myInput = document.getElementById('deleteButton')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})

//Esta es la función que muestra el modal con los detalles extra.
function displayDesc(anchor) {
    var desc = anchor.getAttribute("data-desc");
    var date = anchor.getAttribute("data-date");

    // Update the modal content with the retrieved data
    document.getElementById("modalDateTitle").textContent = "Fecha de Registro:";
    document.getElementById("modalDate").textContent = date;
    document.getElementById("modalDescTitle").textContent = "Descripción:";
    document.getElementById("modalDesc").textContent = desc;
}

//Y esta es la función que le permite al modal borrar una publicación diferente dependiendo del botón de eliminación.
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const pubId = this.getAttribute('data-pubid');
            const deleteLink = document.getElementById('deleteLink');
            deleteLink.href = `remove-book.php?id=${pubId}`;
        });
    });
});

//Este bloque basicamente activa datatables, lo vas a ver en todas las tablas de esta aplicación. 

jQuery(document).ready(function($) {
    $("#publications").DataTable({
        paging: true,
        info: false,
        ordering: false,


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay libros así.",
        },

        buttons: [
            {
                text: "<b>Agregar Libro</b>",
                className: "btn btn-primary",
                action: function ( e, dt, button, config ) {
                    window.location = "add-book.php";
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
                title: 'UPTEB - Listado de Libros',
                messageTop: ' <div class="d-flex justify-content-center py-4"><img src="assets/upt_banner.png" alt="Banner de la Universidad" style="max-height:100%; max-width: 100%;"></div>',
               className: "btn btn-primary",
               customize: function (win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '14px');
                    $(win.document.body).find('h1').css('text-align','center');
                },
            }
        ]

    });

 //Todo lo que está aqui abajo se encarga del filtrador por categoria - Primero la de PNF. Primero seleccionamos la tabla.
      var table = $('#publications').DataTable();

      //Luego la pegamos como parte de datatables.
      $("#publications_filter.dataTables_filter").append($("#tags_filter"));

      $("#publications_filter.dataTables_filter").append($("#tags_filter_2"));

      
      //Este bloque basicamente va uno por uno por cada columna y luego para en la que tenga el mismo nombre que queremos filtrar. En este caso "PNF". Así basicamente la selecciona.
      var categoryIndex = 0;
      var categoryIndex2 = 0;

      $("#publications th").each(function (i) {
        if ($($(this)).html() == "PNF") {
          categoryIndex = i; return false;
        }
      });

      $("#publications th").each(function (i) {
        if ($($(this)).html() == "Sede") {
          categoryIndex2 = i; return false;
        }
      });
      


      //Este bloque utiliza las mismas funciones del API de datatables para asegurarse que el valor seleccionado en el menú dropdown sea utilizado para filtrar.
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = $('#tags_filter').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );


      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem2 = $('#tags_filter_2').val()
          var category2 = data[categoryIndex2];
          if (selectedItem2 === "" || category2.includes(selectedItem2)) {
            return true;
          }
          return false;
        }
      );


      //Esta parte redibuja la tabla cada vez que seleccionas una opción para que no tenga que refrescar la página.
      $("#tags_filter").change(function (e) {
        table.draw();
      });

      $("#tags_filter_2").change(function (e) {
        table.draw();
      });


      table.draw();
    });


$.extend($.fn.dataTable.defaults, {
  dom: 'fBrtip'
});

</script>



<?php include "footer.php"; ?>