<?php
include('C:\xampp\htdocs\backend\php\dbconnection.php');
include("/xampp/htdocs/backend/php/antentication.php");

// Consulta SQL para obtener el número de incidencias por estado
$query = "SELECT estado, COUNT(*) AS cantidad FROM incidencias GROUP BY estado";
$result = mysqli_query($con, $query);

// Crear un array asociativo para almacenar los resultados
$incidencias_por_estado = array();

while ($row = mysqli_fetch_assoc($result)) {
  $estado = $row['estado'];
  $cantidad = $row['cantidad'];
  $incidencias_por_estado[$estado] = $cantidad;
}
// Verifica si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['data-tecnico']) && isset($_POST['data-grupo']) && isset($_POST['data-categoria'])) {
  // Obtén los datos del formulario
  $tecnico = mysqli_real_escape_string($con, $_POST['data-tecnico']);
  $grupo = mysqli_real_escape_string($con, $_POST['data-grupo']);
  $categoria = mysqli_real_escape_string($con, $_POST['data-categoria']);

  // Inserta el nuevo registro en la base de datos
  $query = mysqli_query($con, "INSERT INTO datos_pers (`data-tecnico`, `data-grupo`, `data-categoria`) VALUES ('$tecnico','$grupo', '$categoria')");

  // Verifica si la consulta se realizó con éxito
  if ($query) {
    // Si se inserta el registro correctamente, muestra un mensaje de éxito
    echo "<script>window.onload = function() { mostrarModalRegistroExitoso(); }</script>";
  } else {
    // Si hay un error al insertar el registro, muestra un mensaje de error
    echo "<script>window.onload = function() { mostrarModalRegistroFallido(); }</script>";
  }
}
// else {
//   echo "No se han recibido los datos esperados.";
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
  <link rel="stylesheet" href="/frontend/aseets/css/estadist.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/note.css" />
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
          <a id="inbox" href="/frontend/view/admin/index.php">
            <ion-icon name="mail-unread-outline">
              <img class="ico-center" src="/frontend/aseets/icons/house.svg" />
            </ion-icon>
            <span>Pagina principal</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/admin/level_admin.php">
            <ion-icon name="mail-unread-outline">
              <img class="icono-inc" src="/frontend/aseets/icons/envelope-paper.svg" />
            </ion-icon>
            <span>Incidencias</span>
          </a>
        </li>


        <li>
          <a class="user" href="/frontend/view/admin/users.php">
            <ion-icon name="star-outline">
              <img class="ico-center" src="/frontend/aseets/icons/person.svg" />
            </ion-icon>
            <span>Usuarios</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/admin/chat.php">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/chat.svg" />
            </ion-icon>
            <span>Chat</span>
          </a>
        </li>

        <li>
          <a href="/frontend/view/admin/setting.php">
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
            <span class="title-profile">Level 1
            </span>
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

  <main>
    <!-- main -->



    <div class="estadisticas-container">

      <div class="center-note">
        <div class="note">
          <div class="task-input">
            <img src="/frontend/aseets/icons/bars-icon.svg" alt="icon">
            <input type="text" placeholder="Agrega una nota">
          </div>
          <div class="controls">
            <div class="filters">
              <span class="active" id="all">Todas</span>
              <span id="pending">Pendientes</span>
              <span id="completed">Completadas</span>
            </div>
            <button class="clear-btn">Limpiar</button>
          </div>
          <ul class="task-box">

          </ul>
        </div>
      </div>

      <section class="center-table ">

        <div id="tableAndFormContainer">
          <!-- Contenido de la tabla -->
          <div class="table" id="tab_inc">

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
              <h1>Datos del Personal</h1>

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
                    <th>Tecnico<span class="icon-arrow">&UpArrow;</span></th>
                    <th>Grupo Tecnico <span class="icon-arrow">&UpArrow;</span></th>
                    <th>Categoria<span class="icon-arrow">&UpArrow;</span></th>
                    <th>Acciones<span class="icon-arrow">&UpArrow;</span></th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  include('C:\xampp\htdocs\backend\php\dbconnection.php');
                  $fetch = mysqli_query($con, "select * from datos_pers");
                  $row = mysqli_num_rows($fetch);
                  if ($row > 0) {
                    while ($r = mysqli_fetch_array($fetch)) {
                  ?>
                      <tr>
                        <td> <?php echo $r['data-tecnico'] ?></td>
                        <td> <?php echo $r['data-grupo'] ?></td>
                        <td> <?php echo $r['data-categoria'] ?></td>
                        <td>
                          <div class="acciones-container">
                            <strong>
                              <!-- botones de borrar y editar -->
                              <a href="/backend/php/borrar.php?delete=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/x.svg" alt="Borrar"></a>

                              <a href="/backend/php/editar_admin_data.php?id=<?php echo $r['id']; ?>"><img src="/frontend/aseets/icons/pencil-fill.svg" alt="Editar"></a>

                              <a class="ver-detalles" data-tecnico="<?php echo htmlspecialchars($r['data-tecnico'] ?? ''); ?>" data-grupo="<?php echo htmlspecialchars($r['data-grupo'] ?? ''); ?>" data-categoria="<?php echo htmlspecialchars($r['data-categoria'] ?? ''); ?>">
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

          <button class="btn-add show-modal">Agregar</button>

          <div id="modalForm" class="modal-box formulario ">
            <!-- Contenido del formulario -->
            <div class="container">
              <div class="title">Agregar incidencia</div>

              <div class="content">
                <form method="POST" id="miFormulario">

                  <div class="user-details">

                    <div class="input-box">
                      <span class="details">Asignado a - Grupo Tecnico</span>
                      <input type="text" name="data-grupo" class="input-extr" placeholder="Escriba su grupo">
                    </div>

                    <div class="input-box">
                      <span class="details">Asignado a - Tecnico</span>
                      <input type="text" name="data-tecnico" class="input-extr" placeholder="Escriba el nombre del tecnico">
                    </div>

                    <div class="input-box">
                      <span class="details">Categoria</span>
                      <input type="text" name="data-categoria" class="input-extr" placeholder="Escriba su categoria">
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


      </section>



      <div class="estadisticas estadisticas-incidencias">
        <h2 class="stat-title">Incidencias por Estado</h2>
        <div class="card">
          <div class="circle">
            <div class="bar">

              <div class="box">
                <span>
                  <?php echo isset($incidencias_por_estado['Resuelto']) ? $incidencias_por_estado['Resuelto'] : 0; ?>
                </span>
              </div>

            </div>
          </div>

          <div class="text">Resueltas</div>

        </div>



        <div class="card">
          <div class="circle">
            <div class="bar">

              <div class="box">
                <span>
                  <?php echo isset($incidencias_por_estado['En Curso']) ? $incidencias_por_estado['En Curso'] : 0; ?>
                </span>
              </div>

            </div>
          </div>

          <div class="text">En Curso</div>

        </div>

        <div class="card">
          <div class="circle">
            <div class="bar">

              <div class="box">
                <span>
                  <?php echo isset($incidencias_por_estado['Sin resolver']) ? $incidencias_por_estado['Sin resolver'] : 0; ?>
                </span>
              </div>

            </div>
          </div>

          <div class="text"> Sin Resolver</div>

        </div>

      </div>


      <?php
      include('C:\xampp\htdocs\backend\php\dbconnection.php');

      // Consulta SQL para obtener el número de usuarios por nivel de usuario
      $query = "SELECT role_id_fk, COUNT(*) AS cantidad FROM usuarios GROUP BY role_id_fk";
      $result = mysqli_query($con, $query);

      // Crear un array asociativo para almacenar los resultados
      $usuarios_por_nivel = array();

      while ($row = mysqli_fetch_assoc($result)) {
        $nivel = $row['role_id_fk'];
        $cantidad = $row['cantidad'];
        $nivel_texto = '';

        // Asignar texto según el nivel de usuario
        switch ($nivel) {
          case 1:
            $nivel_texto = 'Admin';
            break;
          case 2:
            $nivel_texto = 'Jefe';
            break;
          case 3:
            $nivel_texto = 'Administrativo';
            break;
        }

        $usuarios_por_nivel[$nivel_texto] = $cantidad;
      }
      ?>



      <div class="estadisticas estadisticas-usuarios">
        <h2 class="stat-title">Usuarios por Nivel</h2>
        <div class="card">
          <div class="circle">
            <div class="bar">

              <div class="box">
                <span>
                  <?php echo isset($usuarios_por_nivel['Admin']) ? $usuarios_por_nivel['Admin'] : 0; ?>
                </span>
              </div>

            </div>
          </div>

          <div class="text"> Admin</div>

        </div>



        <div class="card">
          <div class="circle">
            <div class="bar">

              <div class="box">
                <span>
                  <?php echo isset($usuarios_por_nivel['Jefe']) ? $usuarios_por_nivel['Jefe'] : 0; ?>
                </span>
              </div>

            </div>
          </div>

          <div class="text">Jefe</div>

        </div>

        <div class="card">
          <div class="circle">
            <div class="bar">

              <div class="box">
                <span>
                  <?php echo isset($usuarios_por_nivel['Administrativo']) ? $usuarios_por_nivel['Administrativo'] : 0; ?>
                </span>
              </div>

            </div>
          </div>

          <div class="text">Administrativo</div>

        </div>

      </div>


    </div>
    <!-- main -->
  </main>

  <footer>
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


    <div id="modalDetalles" class="modal">
      <div class="modal-content">

        <span class="close">&times;</span>
        <h2 class="detalles">Detalles del personal</h2>
        <div class="detallesCont" id="detallesContent"></div>

      </div>
    </div>
  </footer>
  <script src="/frontend/aseets/js/index.js"></script>
  <script src="/frontend/aseets/js/estadist.js"></script>
  <script src="/frontend/aseets/js/modalAdd.js"></script>
  <script src="/frontend/aseets/js/modalConf.js"></script>
  <script src="/frontend/aseets/js/note.js"></script>
  <script src="/frontend/aseets/js/datos_pers.js"></script>
</body>

</html>