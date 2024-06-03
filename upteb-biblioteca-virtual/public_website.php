<?php

session_start();
$title = "Catalogo Bibliotecario de la Universidad Politécnica Territorial del Estado Bolívar";

// Verificar sesión.
if (!isset($_SESSION['loggedin'])) {
  $isLogged = false;
} else {
  $isLogged = true;
}



// Convertir variable de sesión en variable de javascript.
echo '<script type="text/javascript">';
echo 'var isLogged = ' . ($isLogged ? 'true' : 'false') . ';';
echo '</script>';

include "header.php";
include "connect.php";
include "datetimecheck.php";

$sqlDoctype = "SELECT tag_id FROM tags WHERE (name = 'Libro' OR name = 'Tesis') AND removed = 0";
$queryResultDoctype = mysqli_query($con, $sqlDoctype);

$docTypeArray = array();


while ($row = mysqli_fetch_array($queryResultDoctype, MYSQLI_ASSOC)) {
  array_push($docTypeArray, $row);
}

//Y liberamos la memoría
mysqli_free_result($queryResultDoctype);

//Agarrar todos los tags y su id...
$sqlSelect = "SELECT tag_id, name FROM tags WHERE tag_category = 'PNF' AND removed = 0";
$queryResult = mysqli_query($con, $sqlSelect);

//Establecer un arreglo vacío
$tagArray = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult, MYSQLI_ASSOC)) {
  array_push($tagArray, $row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult);

//Lo hacemos otra vez pero para las sedes
$sqlSelect2 = "SELECT tag_id, name FROM tags WHERE tag_category = 'Ubicación' AND removed = 0";
$queryResult2 = mysqli_query($con, $sqlSelect2);

//Establecer un arreglo vacío
$tagArray2 = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult2, MYSQLI_ASSOC)) {
  array_push($tagArray2, $row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult2);


// Fecha actual.
$currentDate = date('Y-m-d');

// Fecha en una semana.
$oneWeekMaxDate = date('Y-m-d', strtotime('+1 week'));
?>

<style>
  .btn-lg {
    font-size: 1.5rem;

  }

  .label-text {
    font-size: 1.5rem;
    /* Adjust the font size for the label text */
    margin-top: 5px;
    /* Add margin for spacing between the icon and label text */
  }

  .button-gap {
    margin-right: 1.75rem;
    /* Adjust the margin as needed */
  }

  main {
    margin-left: 20rem;
    margin-right: 20rem;
  }

  /* Cosas de tabla */
  .card-row {
    border-radius: 15px;
    margin-bottom: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    overflow: hidden;
  }

  .card-row td {
    border-top: none !important;
    padding: 15px;
  }

  .image-container {
    position: relative;
    display: flex;
    align-items: center;
  }

  .image-container img {
    position: relative;
    z-index: 2;
    max-width: 100%;
  }

  .image-container .circle {
    position: absolute;
    background-color: lightblue;
    border-radius: 50%;
    z-index: 1;
    width: var(--circle-size, 150px);
    height: var(--circle-size, 150px);
  }
</style>

</head>

<header id="header" class="header white-menu navbar-dark">
  <div class="header-wrapper">
    <div class="banneruptb">

      <img src="assets/logo.png" class="logo-uni" alt="UPTBOLIVAR" />

      <div class="centere-title">
        <span class="tittl-1">Bliblioteca UPTBOLIVAR</span>
      </div>

    </div>
  </div>



  <!-- Por aquí estaría el menu de navegación como en la página oficial.-->
</header>



<main>
  <div class="container mt-5">
    <div class="row">
      <div class="centered-title">
        <span class="tittle-1">Biblioteca Virtual "Mimina Rodríguez"</span>
      </div>

      <div class="col-md-4 image-container">
        <img src="assets/royalty_free_unsplash_books_STUDIOMEDIA.png" alt="Libros">
      </div>
      <div class="col-md-8 justi-texto">
        <p>
          <b>¡Bienvenido a la Biblioteca Virtual "Mimina Rodríguez" de la Universidad Politécnica Territorial del Estado Bolívar!</b> Nuestra plataforma digital te ofrece la comodidad de navegar por un extenso catálogo de libros y tesis de proyectos. Ya sea que estés investigando para una tarea o buscando lectura recreativa, nuestra colección está diseñada para satisfacer todas tus necesidades académicas. Además, nuestro sistema de reservas en línea te permite hacer reservas fácilmente para préstamos en persona. <a href="signups.php">Regístrate ahora</a> y empieza a explorar la riqueza de conocimientos disponible en la Biblioteca Virtual Mimina Rodríguez.
        </p>
      </div>
    </div>
  </div>



  <div class="d-flex justify-content-center">

    <div class="form-group text-center button-gap">
      <input type="radio" class="btn-check" name="doc_type" id="doc_type_book" value="<?php echo $docTypeArray[0]['tag_id'] ?>" checked>
      <label class="btn btn-outline-danger btn-lg" for="doc_type_book">
        <i class="bi bi-book"></i>
      </label>
      <p class="label-text">Libros</p>
    </div>

    <div class="form-group text-center">

      <input type="radio" class="btn-check" name="doc_type" id="doc_type_thesis" value="<?php echo $docTypeArray[1]['tag_id'] ?>">
      <label class="btn btn-outline-danger btn-lg button-gap" for="doc_type_thesis">
        <i class="ri ri-booklet-line"></i>
      </label>
      <p class="label-text">Tesis</p>
    </div>
  </div>


  <div class="contenedor">
    <div class="form-group">
      <div class="centered-title">
        <label for="search_pub" class="tittl-1">Nombre de la Publicación</label>
      </div>
      <div class="margen"> <input type="text" class="form-control" id="search_pub" name="search_pub" placeholder="Nombre de la publicación prestada." autocomplete="off"> </div>

    </div>

    <div class="col-md-12">

      <?php
      echo "<select name='tags' id='tags_filter' class='dropdown form-select'>";
      echo " <option value=''>Todos los PNF</option>";
      foreach ($tagArray as $row) { // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.


        echo "<option value=$row[name]>$row[name]</option>";
      }
      echo "</select>";

      echo "<select name='location_tags' id='tags_filter_2' class='dropdown form-select mt-2'>";
      echo " <option value=''>Todas las Sedes</option>";
      foreach ($tagArray2 as $row) { // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.


        echo "<option value=$row[name]>$row[name]</option>";
      }
      echo "</select>";

      ?>
    </div>

  </div>

  <div class="contenedor">
    <table class="table table-hover mt-4" id="publications_public">
      <thead>
      </thead>
      <tbody id="publications_body">

        <tr class="table-light">
          <td id="PNF_column"></td>
          <td id="pub_name_column"></td>
          <td id="author_column"></td>
          <td id="quantity_column"></td>
          <td id="location_column"></td>
          <td id="buttons_column">
            <div class="d-flex justify-content-evenly">
              <button type="button" class="btn btn-info"><i class="bi bi-file-plus"></i></button>
              <button type="button" class="btn btn-success"><i class="bi bi-calendar-check"></i></button>
          </td>
  </div>
  </tr>

  </tbody>
  </table>
  </div>

  <!-- Modal de Reserva -->
  <div class="modal fade" id="reserveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Reservar Publicación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <h6 id="modalPubNameTitle"><b>Nombre de la Publicación</b>:</h6>
              <p id="modalPubName"></p>
            </div>
            <div class="col-md-6">
              <h6 id="modalLocationTitle"><b>Sede de la Publicación</b>:</h6>
              <p id="modalLocation"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="start_date"><b>Fecha de Recepción</b></label>
              <input type="date" class="form-control" id="start_date" name="start_date" min="<?php echo $currentDate; ?>" max="<?php echo $oneWeekMaxDate; ?>">
              <small class="form-text text-muted">¡Solo puedes reservar una publicación hasta una semana de adelanto!</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <label for="observations" id="observations">Petición de Prestamo</label>
              <textarea type="text" class="form-control" id="observations" name="observations" placeholder="Haga su caso de por qué está pidiendo el libro, el tiempo a esperar, y/o una descripción visual a la hora de recibirlo." maxlength="1500"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="#" id="reserveButton" class="btn btn-success">Reservar</a>
        </div>
      </div>
    </div>
  </div>
</main>


<script>

</script>

<!-- <div class="containered">
  <div class="carousel-wrapper">
    <div class="card">
      <a href="#">
        <img src="imagen1.jp" alt="Imagen 1">
      </a>
    </div>
    <div class="card">
      <a href="#">
        <img src="imagen2.jpg" alt="Imagen 2">
      </a>
    </div>
    <div class="card">
      <a href="#">
        <img src="imagen3.jpg" alt="Imagen 3">
      </a>
    </div>
    <div class="card">
      <a href="#">
        <img src="imagen4.jpg" alt="Imagen 4">
      </a>
    </div>
  </div>
</div> -->


<link rel="stylesheet" href="css/public_website.css">
<script type="text/javascript" src="js/search_script_public.js"></script>

<footer>
  <div class="container-fluid text-end">
    <div class="row" style="background-color: #164e68;color:#ffffff;">
      <div class="col-sm-12 col-12">
        <b>Ciudad Bolívar - Venezuela,
          <script type="text/javascript">
            var meses = new Array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
            var fecha = new Date();
            document.write(fecha.getDate() + " de " + meses[fecha.getMonth()] + " " + fecha.getFullYear());
          </script>
        </b>

      </div>

    </div>
  </div>
</footer>