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

  // Verifica si ya existe un registro con los mismos valores
  $existing_record_query = mysqli_query($con, "SELECT * FROM incidencias WHERE titulo='$titulo' AND estado='$estado' AND fecha='$fecha' AND prioridad='$prioridad' AND solicitante='$solicitante' AND tecnico='$tecnico' AND grupo='$grupo' AND categoria='$categoria'");
  $existing_record_count = mysqli_num_rows($existing_record_query);

  // Si ya existe un registro con los mismos valores, muestra un mensaje de alerta
  if ($existing_record_count > 0) {
    echo "<script>alert('El registro ya existe.')</script>";
  } else {
    // Inserta el nuevo registro en la base de datos
    $query = mysqli_query($con, "INSERT INTO incidencias (titulo, estado, fecha, prioridad, solicitante, tecnico, grupo, categoria) VALUES ('$titulo','$estado','$fecha','$prioridad','$solicitante','$tecnico','$grupo', '$categoria')");

    // Verifica si la consulta se realizó con éxito
    if ($query) {
      // Si se inserta el registro correctamente, muestra un mensaje de éxito y redirige a otra página
      echo "<script>alert('Registro agregado correctamente.')</script>";
      echo "<script>window.location.href = '/frontend/view/index.php';</script>";
      exit;
    } else {
      // Si hay un error al insertar el registro, muestra un mensaje de error
      echo "<script>alert('Hubo un error, solicitud denegada.')</script>";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/index.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
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
          <a id="inbox" href="./index.php">
            <ion-icon name="mail-unread-outline">
              <img class="ico-center" src="/frontend/aseets/icons/house.svg" />
            </ion-icon>
            <span>Pagina principal</span>
          </a>
        </li>

        <li>
          <a class="user" href="./users.php">
            <ion-icon name="star-outline">
              <img class="ico-center" src="/frontend/aseets/icons/person.svg" />
            </ion-icon>
            <span>Usuarios</span>
          </a>
        </li>

        <li>
          <a class="user" href="./chat.php">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/chat.svg" />
            </ion-icon>
            <span>Chat</span>
          </a>
        </li>

        <li>
          <a href="./setting.php">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/gear.svg" />
            </ion-icon>
            <span>Configuracion</span>
          </a>
        </li>


        <li>
          <a href="./logout.php">
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
          </span>
        </div>
      </div>




      <div class="modo-oscuro">
        <div class="info">
          <img class="ico ico-center" src="/frontend/aseets/icons/bx-moon.svg" />
          </ion-icon> <span class="dark-text">Modo oscuro</span> </ion-icon>
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


  <main class=" table-pos ">

    <div class="formulario">

      <div class="container">
        <div class="title">Agregar incidencia</div>
        <!-- <hr> -->
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
                  <option>Carolina Vixleris</option>
                  <option>Jose Arenas</option>
                  <option>Juan Lopez</option>
                </select>
              </div>

              <div class="input-box">
                <span class="details">Asignado a - Tecnico</span>
                <select name="tecnico" class="input-extr">
                  <option selected>Seleccionar...</option>
                  <option>Carolina Vixleris</option>
                  <option>Jose Arenas</option>
                  <option>Juan Lopez</option>
                </select>
              </div>

              <div class="input-box">
                <span class="details">Categoria</span>
                <select name="categoria" class="input-extr">
                  <option selected>Seleccionar...</option>
                  <option>01 Direccion de informatica y sistemas > division de desarrollo de sistemas</option>
                  <option>01 Direccion de informatica y sistemas > division de soporte tecnico</option>
                  <option>01 Direccion de informatica y sistemas > division de problemas de internet</option>
                </select>
              </div>

            </div>

            <div class="button-container">
              <div class="button">
                <input class="button-grd" type="submit" value="Guardar" />
              </div>
              <div class="button">
                <button class="button-can" type="button" onclick="limpiarFormulario()">Cancelar</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>




    <div class=" table">
      <section class="table__header" id="incident_table">
        <h1>Lista de Incidencias</h1>

        <div class="input-group">
          <input type="search" placeholder="Buscar...">
          <img src="/frontend/aseets/icons/bx-search-alt-2.svg" alt="">
        </div>

        <div class="export__file">
          <label for="export-file" class="export__file-btn" title="Export File">

          </label>
          <input type="checkbox" id="export-file">
          <div class="export__file-options">
            <label>Exportar &nbsp; &#10140;</label>
            <label for="export-file" id="toPDF">PDF <img src="/frontend/aseets/icons/file-earmark-pdf.svg" alt=""></label>
            <label for="export-file" id="toJSON">JSON <img src="/frontend/aseets/icons/filetype-json.svg" alt=""></label>
            <label for="export-file" id="toCSV">CSV <img class="ico-csv" src="/frontend/aseets/icons/filetype-csv.svg" alt=""></label>
            <label for="export-file" id="toEXCEL">EXCEL <img src="/frontend/aseets/icons/file-earmark-excel.svg" alt=""></label>
          </div>
        </div>
      </section>
      <div class="linea2"></div>

      <section class="table__body">
        <table>
          <thead>
            <tr>
              <!-- <th>Id <span class="icon-arrow">&UpArrow;</span></th> -->
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
            <tr>
              <?php
              include('C:\xampp\htdocs\backend\php\dbconnection.php');
              $fetch = mysqli_query($con, "select * from incidencias");
              $row = mysqli_num_rows($fetch);
              if ($row > 0) {
                while ($r = mysqli_fetch_array($fetch)) {
              ?>
            <tr>
              <!-- <td> <?php echo $r['id'] ?></td> -->
              <td> <?php echo $r['titulo'] ?></td>
              <td> <?php echo $r['estado'] ?></td>
              <td> <?php echo $r['fecha'] ?></td>
              <td> <?php echo $r['prioridad'] ?></td>
              <td> <?php echo $r['solicitante'] ?></td>
              <td> <?php echo $r['tecnico'] ?></td>
              <td> <?php echo $r['grupo'] ?></td>
              <td><?php echo $r['categoria'] ?></td>
              <td>
                <div class="acciones-container">
                  <strong>
                    <!-- botones de borrar y editar -->
                    <a href="/backend/php/borrar.php?delete=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/x.svg" alt="Borrar"></a>

                    <a href="/backend/php/editar.php?id=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/pencil-fill.svg" alt="Editar"></a>
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
        <div>
          <div class="wrapper">
            <button class="btn startBtn" disabled>
              <i class="fas fa-angles-left"></i>
            </button>
            <button class="btn stepBtn" disabled>
              <i class="fas fa-angle-left"></i>
            </button>

            <div class="nums">
              <a href="#" class="num active">1</a>
              <a href="#" class="num">2</a>
              <a href="#" class="num">3</a>
              <a href="#" class="num">4</a>
              <a href="#" class="num">5</a>
            </div>

            <button class="btn stepBtn" id="next">
              <i class="fas fa-angle-right"></i>
            </button>
            <button class="btn endBtn">
              <i class="fas fa-angles-right"></i>
            </button>
          </div>
        </div>


      </section>

  </main>
  </div>
  </div>
  </div>
  <!-- main -->

  <footer>
    <!-- scripts -->
    <script src="/frontend/aseets/js/index.js"></script>
  </footer>

  </div>


</body>

</html>