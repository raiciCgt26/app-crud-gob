<?php

session_start();
$title = "Lista de Tesis";

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
$sqlSelect3 = "SELECT tag_id FROM tags WHERE name = 'Tesis' AND removed = 0";
$queryResult3= mysqli_query($con, $sqlSelect3);

$docType = implode(mysqli_fetch_assoc($queryResult3));

//Y liberamos la memoría
mysqli_free_result($queryResult3);

// Mostrar todos los libros de la tabla "publications" Y SOLO LOS LIBROS a través de un "JOIN" de MySQL que compara el tag id de pub_join_tags con el arreglo que acabamos de llenar, el $docTypeArray (porque pub_join_tags SOLO guarda ids).
$query = "SELECT * FROM publications INNER JOIN pub_join_tags ON publications.pub_id=pub_join_tags.pub_id WHERE publications.removed=0 AND pub_join_tags.tag_id=" . $docType;
$result = mysqli_query($con, $query);

//Montando un arreglo vacío para organizar las fuentes sin utilizar array_column, que remueve duplicados.
$indexed_sources = array();

        //Ponemos todas las cotas que estan siendo préstadas para hacer comparaciones con cada libro que esté tomado.
            $cota_ids_result = mysqli_query($con, "SELECT cota_id FROM pub_lent_cotas");
            $cota_ids = mysqli_fetch_all($cota_ids_result, MYSQLI_ASSOC);
            $cota_ids = array_column($cota_ids, 'cota_id');

?>
<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Lista de Tesis</h2>
<br>
<div class="col-md-12">

<?php
            echo "<select name='tags' id='tags_filter'>";
            echo " <option value=''>Todos los PNF</option>";
            foreach ($tagArray as $row){ // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.
            

           echo "<option value=$row[name]>$row[name]</option>"; 

            
            }
            echo "</select>";

            echo "<select name='location_tags' id='tags_filter_2'>";
            echo " <option value=''>Todas las Sedes</option>";
            foreach ($tagArray2 as $row){ // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.
            

           echo "<option value=$row[name]>$row[name]</option>"; 

            
            }
            echo "</select>";

            ?>
</div>
</div>
    <table class="table table-hover mt-4 rounded rounded-2 overflow-hidden" id="thesis">
        <thead>
           <tr class="table-primary">
                <th scope="col">Sede</th>
                <th scope="col">PNF</th>
               <th scope="col">Nombre</th>
                <th scope="col">Autor(es)</th>
                <th scope="col">Tutor</th>
                <th scope="col">Cota</th>
                <th scope="col">Disponibilidad</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
           <?php while ($thesis = mysqli_fetch_assoc($result)) 
            {     
                //  Conseguir todas las etiquetas donde el book_id encaja y convertirlo en array.
                $query = "SELECT * FROM pub_join_tags WHERE pub_id = " . $thesis["pub_id"];
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

                $indexed_sources = [];
               //  Conseguir las fuentes del libro, autores y tutores.
                $query2 = "SELECT * FROM cited_sources WHERE pub_id = " . $thesis["pub_id"];
                $cited_sources = mysqli_query($con, $query2);
                $cited_sources = mysqli_fetch_all($cited_sources, MYSQLI_ASSOC);

                    // Crear un for loop que va por todos las fuentes del libro
                    foreach ($cited_sources as $source) {
                        // Asegurarse que la llave existe.
                        if (!isset($indexed_sources[$source["role"]])) {
                            // Sino, crear un arreglo vacío
                            $indexed_sources[$source["role"]] = [];
                        }
                        // Empujar el elemento al arreglo por rol.
                        $indexed_sources[$source["role"]][] = $source;
                    }

                // Luego implotar y organizar por nombre los autores...
                $autor_names = implode(", ", array_column($indexed_sources["Autor"], "name"));

                // ... y lo mismo con los tutores.
                $tutor_names = implode(", ", array_column($indexed_sources["Tutor"], "name"));


                //  Conseguir las cotas de la tesis.
                $query3 = "SELECT * FROM pub_cota_data WHERE pub_id = " . $thesis["pub_id"];
                $cota = mysqli_query($con, $query3);
                $cota = mysqli_fetch_all($cota, MYSQLI_ASSOC);

                if (count($cota) > 0) //Hacemos la cota un string porque una tesis solo puede tener una.
                {
                    if (in_array($cota[0]["pub_cd_id"], $cota_ids)) //Si está dentro de la lista de préstamos ponemos un strikethrough a través de la cota.
                    {
                        $isLent = true;
                    }
                    else
                    {
                        $isLent = false;
                    }
                $cota = array_column($cota, "cota");
                $cota_string = implode(", ", $cota);
                }
                else
                {

                    $cota_string = "<i>SIN COTA</i>";
                }


                    $pub_date_query = "SELECT date FROM audit_log WHERE action_id = 12 AND target_pub_id = " . $thesis["pub_id"];
                    $pub_date_result = mysqli_query($con, $pub_date_query);
                    if ($pub_date_result) {
                        $thesis_date = mysqli_fetch_assoc($pub_date_result); //Tienes que implode de manera medio rara pero funciona.
                    } else {
                        $thesis_date = "N/A"; 
                    }

                    if ($isLent == true)
                    {
                        $available_string = "Disponible.";
                    }
                    else
                    {
                        $available_string = "En Préstamo.";
                    }

                    // Crear la variable de nombre con enlace si $book["link"] existe y no está vacío
                    if (!empty($thesis["link"])) {
                        $thesisName = '<a href="' . htmlspecialchars($thesis["link"]) . '" target="_blank">' . htmlspecialchars($thesis["name"]) . '</a>';
                    } else {
                        $thesisName = htmlspecialchars($thesis["name"]);
                    }

                ?>
            <tr class="table-light">
                <td><?php echo $tags["Ubicación"]; ?></td>
                <td><?php echo $tags["PNF"]; ?></td>
                <td><?php echo $thesisName;?><a href="#" data-bs-toggle="modal" data-bs-target="#abstractModal" onclick="displayDesc(this)" data-desc="<?php echo htmlspecialchars($thesis["description"]); ?>" data-date="<?php echo htmlspecialchars($thesis_date["date"]); ?>" class="ri ri-add-circle-line"></a></td>
                <td><?php echo $autor_names; ?></td>
                <td><?php echo $tutor_names; ?></td>
                <td><?php echo $cota_string ?></td>
                <td><?php echo $available_string; ?></td>
                <td>
                    <div class="d-flex justify-content-evenly">
                    <a href="edit-book.php?id=<?php echo $thesis["pub_id"]; ?>" class="btn btn-success"><i class="ri-ball-pen-fill"></i></a>
                    <button type="button" class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-pubid="<?php echo $thesis['pub_id']; ?>"><i class="bi bi-trash-fill"></i></button>
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
        <h5 class="modal-title" id="staticBackdropLabel">Eliminación de Tesis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro que quieres eliminar esta tesis permanentemente?
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
    var desc = anchor.getAttribute("data-desc");
    var date = anchor.getAttribute("data-date");

    // Update the modal content with the retrieved data
    document.getElementById("modalDateTitle").textContent = "Fecha de Registro:";
    document.getElementById("modalDate").textContent = date;
    document.getElementById("modalDescTitle").textContent = "Resumen:";
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

jQuery(document).ready(function($) {
    $("#thesis").DataTable({
        paging: false,
        info: false,
        ordering: false,


        language: {
        "emptyTable":     "No hay datos.",
        "search":         "Buscar:",
        "zeroRecords":    "No hay tesis así.",
        },

        buttons: [
            {
                text: "<b>Agregar Tesis</b>",
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
                title: 'UPTEB - Listado de Tesis',
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
      var table = $('#thesis').DataTable();

      //Luego la pegamos como parte de datatables.
      $("#thesis_filter.dataTables_filter").append($("#tags_filter"));

      $("#thesis_filter.dataTables_filter").append($("#tags_filter_2"));

      
      //Este bloque basicamente va uno por uno por cada columna y luego para en la que tenga el mismo nombre que queremos filtrar. En este caso "PNF". Así basicamente la selecciona.
      var categoryIndex = 0;
      var categoryIndex2 = 0;

      $("#thesis th").each(function (i) {
        if ($($(this)).html() == "PNF") {
          categoryIndex = i; return false;
        }
      });

      $("#thesis th").each(function (i) {
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