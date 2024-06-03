<?php
include('C:\xampp\htdocs\backend\php\dbconnection.php');
include("/xampp/htdocs/backend/php/antentication.php");

// Verifica si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Obtén los datos del formulario
  $titulo = $_POST['titulo'];
  $estado = $_POST['estado'];
  $fecha = $_POST['fecha'];
  $prioridad = $_POST['prioridad'];
  $solicitante = $_POST['solicitante'];
  $tecnico = $_POST['tecnico'];
  $grupo = $_POST['grupo'];
  $categoria = $_POST['categoria'];

  // // Verifica si ya existe un registro con los mismos valores
  // $existing_record_query = mysqli_query($con, "SELECT * FROM incidencias WHERE titulo='$titulo' AND estado='$estado' AND fecha='$fecha' AND prioridad='$prioridad' AND solicitante='$solicitante' AND tecnico='$tecnico' AND grupo='$grupo' AND categoria='$categoria'");
  // $existing_record_count = mysqli_num_rows($existing_record_query);

  // // Si ya existe un registro con los mismos valores, muestra un mensaje de alerta
  // if ($existing_record_count > 0) {
  //   echo "<script>window.onload = function() { mostrarModalConfirmacion(); }</script>";
  // } else {
  // Inserta el nuevo registro en la base de datos
  $query = mysqli_query($con, "INSERT INTO incidencias (titulo, estado, fecha, prioridad, solicitante, tecnico, grupo, categoria) VALUES ('$titulo','$estado','$fecha','$prioridad','$solicitante','$tecnico','$grupo', '$categoria')");

  // Verifica si la consulta se realizó con éxito
  if ($query) {
    // Si se inserta el registro correctamente, muestra un mensaje de éxito
    echo "<script>window.onload = function() { mostrarModalRegistroExitoso(); }</script>";
  } else {
    // Si hay un error al insertar el registro, muestra un mensaje de error
    echo "<script>window.onload = function() { mostrarModalRegistroFallido(); }</script>";
  }
}
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/index.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/modalAdd.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/modaConf.css" />
  <title>S.I</title>
</head>

<body>

  <!-- menu-navbar-header -->

  <div class="menu">
    <ion-icon name="menu-outline"> <img src="/frontend/aseets/icons/list.svg" alt=""></ion-icon>
    <ion-icon name="close-outline"> <img src="/frontend/aseets/icons/x.svg" alt=""></ion-icon>
  </div>
  <div class="barra-lateral">
    <div>

      <div class="nombre-pagina">
        <ion-icon id="cloud" name="cloud-outline">
          <img id="log-gob" class="img-log" src="/frontend/aseets/img/logo-round.jpg" />
        </ion-icon>
        <span class="nombre">Sistema de Incidencias</span>
      </div>

    </div>

    <nav class="navegacion">
      <ul>
        <li>
          <a id="inbox" href="/frontend/view/jefe/index.php">
            <ion-icon name="mail-unread-outline">
              <img class="ico-center" src="/frontend/aseets/icons/house.svg" />
            </ion-icon>
            <span>Pagina principal</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/jefe/level_jefe.php">
            <ion-icon name="mail-unread-outline">
              <img class="icono-inc" src="/frontend/aseets/icons/envelope-paper.svg" />
            </ion-icon>
            <span>Incidencias</span>
          </a>
        </li>


        <li>
          <a class="user" href="/frontend/view/jefe/users.php">
            <ion-icon name="star-outline">
              <img class="ico-center" src="/frontend/aseets/icons/person.svg" />
            </ion-icon>
            <span>Usuarios</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/jefe/users.php">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/chat.svg" />
            </ion-icon>
            <span>Chat</span>
          </a>
        </li>

        <li>
          <a href="/frontend/view/jefe/setting.php">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/gear.svg" />
            </ion-icon>
            <span>Configuracion</span>
          </a>
        </li>


        <li>
          <a href="/frontend/view/logout.php">
            <ion-icon name="document-text-outline">
              <img class="icons-menu ico-center" src="/frontend/aseets/icons/file-lock2.svg" />
            </ion-icon>
            <span>Cerrar sesion</span>
          </a>
        </li>
      </ul>
    </nav>

    <div>
      <div class="linea"></div>



      <div class="info-usuario">
        <div class="nombre-email">
          <span class="nombre">
            <span class="title-profile">Bienvenid@ <?php echo $_SESSION['username'] ?> </span>
            <!-- <span class="title-profile">Nivel Jefe
            </span> -->
          </span>
        </div>
      </div>




      <div class="modo-oscuro">
        <div class="info">
          <img class="ico ico-center" src="/frontend/aseets/icons/bx-moon.svg" />
          <span class="dark-text">Modo oscuro</span>
        </div>

        <div class="switch">
          <div class="base">
            <div class="circulo">

            </div>
          </div>
        </div>

      </div>




    </div>

  </div>
  <!-- menu-navbar-header -->

  <main class="table-pos">

    <button class="btn-add-2 show-modal-2">Generar reporte</button>

    <div id="reportModal" class="modal-1">
      <div class="modal-content-1">
        <span class="close-1">&times;</span>
        <div class="report post">
          <div class="report-filters">
            <h2>Generar Reporte</h2>
            <form id="reportForm" method="POST" action="/backend/php/generar_reporte.php">
              <div class="filter-group">
                <label for="startDate">Fecha de inicio:</label>
                <input type="date" id="startDate" name="startDate" required>
              </div>
              <div class="filter-group">
                <label for="endDate">Fecha de fin:</label>
                <input type="date" id="endDate" name="endDate" required>
              </div>
              <div class="filter-group">
                <label for="category">Categoría:</label>
                <select id="category" name="category">
                  <option value="">Seleccionar...</option>
                  <?php
                  $fetch_categoria = mysqli_query($con, "SELECT DISTINCT `data-categoria` FROM datos_pers");
                  while ($r_categoria = mysqli_fetch_array($fetch_categoria)) {
                    echo "<option>" . $r_categoria['data-categoria'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="filter-group">
                <label for="status">Estado:</label>
                <select id="status" name="status">
                  <option value="">Seleccionar...</option>
                  <option value="Sin resolver">Sin resolver</option>
                  <option value="En Curso">En Curso</option>
                  <option value="Resuelto">Resuelto</option>
                </select>
              </div>
              <button type="submit" class="button-generate-report">Generar Reporte</button>
            </form>
          </div>
        </div>


      </div>
    </div>



    <div id="tableAndFormContainer">
      <!-- Contenido de la tabla -->
      <div class="table table-2" id="tab_inc">

        <section class="table__header">
          <div class="export__file">
            <label for="export-file" class="export__file-btn" title="Exportar archivo"></label>
            <input type="checkbox" id="export-file">
            <div class="export__file-options">
              <label>Exportar &nbsp; &#10140;</label>

              <label for="export-file" id="toPDF" onclick="window.print()">PDF <img src="/frontend/aseets/icons/file-earmark-pdf.svg" alt=""></label>

              <label for="export-file" id="toJSON">JSON <img src="/frontend/aseets/icons/filetype-json.svg" alt=""></label>

              <label for="export-file" id="toCSV">CSV <img class="ico-csv" src="/frontend/aseets/icons/filetype-csv.svg" alt=""></label>

              <label for="export-file" id="toEXCEL">EXCEL <img src="/frontend/aseets/icons/file-earmark-excel.svg" alt=""></label>

            </div>
          </div>
          <h1>Lista de Incidencias</h1>



          <div class="input-group">
            <input type="search" placeholder="Buscar...">
            <img src="/frontend/aseets/icons/bx-search-alt-2.svg" alt="">
          </div>


        </section>

        <div class="linea2"></div>
        <hr>

        <section class="table__body">
          <table>
            <thead>
              <tr>
                <th>Id <span class="icon-arrow">&UpArrow;</span></th>
                <th>Titulo<span class="icon-arrow">&UpArrow;</span></th>
                <th>Estado<span class="icon-arrow">&UpArrow;</span></th>
                <th>Modificacion <span class="icon-arrow">&UpArrow;</span></th>
                <th> Prioridad <span class="icon-arrow">&UpArrow;</span></th>
                <th>Solicitante <span class="icon-arrow">&UpArrow;</span></th>
                <th>Tecnico<span class="icon-arrow">&UpArrow;</span></th>
                <th>Grupo Tecnico <span class="icon-arrow">&UpArrow;</span></th>
                <th>Categoria<span class="icon-arrow">&UpArrow;</span></th>
                <th>Acciones<span class="icon-arrow">&UpArrow;</span></th>
              </tr>
            </thead>

            <tbody>
              <?php
              include('C:\xampp\htdocs\backend\php\dbconnection.php');
              $fetch = mysqli_query($con, "select * from incidencias");
              $row = mysqli_num_rows($fetch);
              if ($row > 0) {
                while ($r = mysqli_fetch_array($fetch)) {
              ?>

                  <tr>
                    <td><?php echo $r['id'] ?></td>
                    <td> <?php echo $r['titulo'] ?></td>
                    <td> <?php echo $r['estado'] ?></td>
                    <td><?php echo date("d-m-Y", strtotime($r['fecha'])); ?></td>
                    <td> <?php echo $r['prioridad'] ?></td>
                    <td> <?php echo $r['solicitante'] ?></td>
                    <td> <?php echo $r['tecnico'] ?></td>
                    <td> <?php echo $r['grupo'] ?></td>
                    <td><?php echo $r['categoria'] ?></td>
                    <td>
                      <div class="acciones-container">
                        <strong>
                          <!-- botones de borrar y editar -->
                          <!-- <a href="/backend/php/borrar.php?delete=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/x.svg" alt="Borrar"></a> -->

                          <a href="/backend/php/editar_jefe.php?id=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/pencil-fill.svg" alt="Editar"></a>

                          <a class="ver-detalles" data-titulo="<?php echo $r['titulo']; ?>" data-estado="<?php echo $r['estado']; ?>" data-fecha="<?php echo $r['fecha']; ?>" data-prioridad="<?php echo $r['prioridad']; ?>" data-solicitante="<?php echo $r['solicitante']; ?>" data-tecnico="<?php echo $r['tecnico']; ?>" data-grupo="<?php echo $r['grupo']; ?>" data-categoria="<?php echo $r['categoria']; ?>">
                            <img src="/frontend/aseets/icons/envelope-paper.svg" alt="">
                          </a>
                        </strong>
                      </div>
                    </td>
                  </tr>
              <?php
                }
              }

              ?>



            </tbody>

          </table>


          <div class="pagination">
            <div class="wrapper">
              <button class="btn startBtn" disabled>
                <img src="/frontend/aseets/icons/bx-chevrons-left.svg" alt="">
              </button>

              <button class="btn stepBtn" disabled>
                <img src="/frontend/aseets/icons/bx-chevron-left.svg" alt="">
              </button>

              <div class="nums"></div> <!-- Aquí se generarán los números de página -->

              <button class="btn stepBtn" id="next">
                <img src="/frontend/aseets/icons/bx-chevron-right.svg" alt="">
              </button>
              <button class="btn endBtn">
                <img src="/frontend/aseets/icons/bx-chevrons-right.svg" alt="">
              </button>
            </div>
          </div>




        </section>

      </div>


      <button class="btn-add show-modal">Agregar Incidencia</button>

      <div id="modalForm" class="modal-box formulario ">
        <!-- Contenido del formulario -->
        <div class="container">
          <div class="title">Agregar incidencia</div>

          <div class="content">
            <form method="POST" id="miFormulario">

              <div class="user-details">

                <div class="input-box">
                  <span class="details">Titulo</span>
                  <input type="text" name="titulo" placeholder="Escribe el titulo" class="input-extr" />
                </div>

                <div class="input-box">
                  <span class="details">Estado</span>
                  <select name="estado" class="input-extr">
                    <option>Sin resolver</option>
                    <option>En Curso</option>
                    <option>Resuelto</option>
                  </select>
                </div>

                <div class="input-box">
                  <span class="details">Fecha de modificacion</span>
                  <input type="date" name="fecha" class="input-extr" />
                </div>

                <div class="input-box">
                  <span class="details">Prioridad</span>
                  <select name="prioridad" class="input-extr">
                    <option selected>Urgente</option>
                    <option>Media</option>
                    <option>Baja</option>
                  </select>


                </div>
                <div class="input-box">
                  <span class="details">Solicitante</span>
                  <input name="solicitante" type="text" placeholder="Escriba el nombre del solicitante" class="input-extr" />
                </div>


                <div class="input-box">
                  <span class="details">Asignado a - Grupo Tecnico</span>
                  <select name="grupo" class="input-extr">
                    <?php
                    $fetch_grupo = mysqli_query($con, "SELECT DISTINCT `data-grupo` FROM datos_pers");
                    while ($r_grupo = mysqli_fetch_array($fetch_grupo)) {
                      echo "<option>" . $r_grupo['data-grupo'] . "</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="input-box">
                  <span class="details">Asignado a - Tecnico</span>
                  <select name="tecnico" class="input-extr">
                    <option selected>Seleccionar...</option>
                    <?php
                    $fetch_tecnico = mysqli_query($con, "SELECT DISTINCT `data-tecnico` FROM datos_pers");
                    while ($r_tecnico = mysqli_fetch_array($fetch_tecnico)) {
                      echo "<option>" . $r_tecnico['data-tecnico'] . "</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="input-box">
                  <span class="details">Categoria</span>
                  <select name="categoria" class="input-extr">
                    <option selected>Seleccionar...</option>
                    <?php
                    $fetch_categoria = mysqli_query($con, "SELECT DISTINCT `data-categoria` FROM datos_pers");
                    while ($r_categoria = mysqli_fetch_array($fetch_categoria)) {
                      echo "<option>" . $r_categoria['data-categoria'] . "</option>";
                    }
                    ?>
                  </select>
                </div>



              </div>


              <div class="button-container">
                <div class="button">
                  <input class="button-grd" type="submit" value="Guardar" />
                </div>
                <div class="button">
                  <button class="button-can close-btn" type="button" onclick="limpiarFormulario()">Cancelar</button>
                </div>




              </div>



            </form>
          </div>
        </div>

      </div>



    </div>
  </main>




  <!-- main -->
  <footer>
    <!-- Modales -->
    <div id="modalRegistroExitoso" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p class="text-1">El registro se ha agregado correctamente.</p>
      </div>
    </div>

    <div id=" modalRegistroFallido" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p class="text-1">Hubo un error al agregar el registro. Por favor, inténtalo de nuevo.</p>
      </div>
    </div>

    <!-- <div id="modalConfirmacion" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p class="text">El registro ya existe. ¿Deseas guardarlo de todas formas?</p>
        <div class="button-container">
          <button id="guardarRegistro" class="button-grd" type="submit">Guardar</button>
          <button id="cancelarRegistro" class="button-can">Cancelar</button>
        </div>
      </div>
    </div> -->


    <div id="modalDetalles" class="modal">
      <div class="modal-content">

        <span class="close">&times;</span>
        <h2 class="detalles">Detalles de la incidencia</h2>
        <div class="detallesCont" id="detallesContent"></div>
        <!-- <div> <img class="log" src="/frontend/aseets/img/logo-round.jpg" alt=""></div> -->
      </div>
    </div>
  </footer>

  <!-- scripts -->
  <script src="/frontend/aseets/js/index.js"></script>
  <script src="/frontend/aseets/js/modalAdd.js"></script>
  <script src="../../aseets/js/modalConf.js"></script>
  <script src="../../aseets/js/details-2.js"></script>
  <script src="/frontend/aseets/js/filtr.js"></script>
</body>

</html>