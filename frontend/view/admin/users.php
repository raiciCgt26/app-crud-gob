<?php
session_start(); // Inicia la sesión
include('C:\xampp\htdocs\backend\php\dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/index.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/users.css" />
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
            <span class="title-profile">Nivel Admin
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

  <!--profile card -->

  <main class="table-pos">
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
          <h1>Lista de Usuarios</h1>
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
                <th>Username<span class="icon-arrow">&UpArrow;</span></th>
                <th>Email<span class="icon-arrow">&UpArrow;</span></th>
                <th>Rol<span class="icon-arrow">&UpArrow;</span></th>
                <th>Phone<span class="icon-arrow">&UpArrow;</span></th>
                <th>Description<span class="icon-arrow">&UpArrow;</span></th>
                <th>Estado<span class="icon-arrow">&UpArrow;</span></th>
                <th>Acciones<span class="icon-arrow">&UpArrow;</span></th>
              </tr>
            </thead>
            <tbody>
              <?php
              include('C:\xampp\htdocs\backend\php\dbconnection.php');
              $fetch = mysqli_query($con, "select * from usuarios");
              $row = mysqli_num_rows($fetch);
              if ($row > 0) {
                while ($r = mysqli_fetch_array($fetch)) {
                  $rol = '';
                  switch ($r['role_id_fk']) {
                    case 1:
                      $rol = 'Admin';
                      break;
                    case 2:
                      $rol = 'Jefe';
                      break;
                    case 3:
                      $rol = 'Administrativo';
                      break;
                    default:
                      $rol = 'Sin Rol';
                      break;
                  }
              ?>
                  <tr data-id="<?php echo $r['id'] ?>">
                    <td><?php echo $r['username'] ?></td>
                    <td><?php echo $r['email'] ?></td>
                    <td><?php echo $rol ?></td>
                    <td><?php echo $r['phone'] ?></td>
                    <td><?php echo $r['description'] ?></td>
                    <td><?php echo $r['activo'] == 1 ? 'Activo' : 'Deshabilitado'; ?></td>
                    <td>
                      <div class="acciones-container">
                        <strong>
                          <!-- <a href="/backend/php/editar_users.php?id=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/pencil-fill.svg" alt="Editar"></a> -->

                          <?php if ($r['activo'] == 1) { ?>
                            <a href="/backend/php/editar_users.php?id=<?php echo $r['id'] ?>"><img src="/frontend/aseets/icons/pencil-fill.svg" alt="Editar"></a>
                          <?php } else { ?>
                            <span class="disabled"><img src="/frontend/aseets/icons/x.svg" alt=""></span>
                          <?php } ?>


                          <a class="ver-detalles" data-username="<?php echo $r['username']; ?>" data-email="<?php echo $r['email']; ?>" data-role="<?php echo $rol; ?>" data-phone="<?php echo $r['phone']; ?>" data-description="<?php echo $r['description']; ?>" data-estado="<?php echo $r['activo'] == 1 ? 'Activo' : 'Deshabilitado'; ?>">
                            <img src="/frontend/aseets/icons/envelope-paper.svg" alt="">
                          </a>


                          <a class="desabilitar-usuario" data-id="<?php echo $r['id'] ?>">
                            <img src="/frontend/aseets/icons/file-lock2.svg" alt="">
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

        </section>

        <div class="pagination">
          <div class="wrapper">
            <button class="btn startBtn" disabled><img src="/frontend/aseets/icons/bx-chevrons-left.svg" alt=""></button>
            <button class="btn stepBtn" disabled><img src="/frontend/aseets/icons/bx-chevron-left.svg" alt=""></button>
            <div class="nums"></div>
            <button class="btn stepBtn" id="next"><img src="/frontend/aseets/icons/bx-chevron-right.svg" alt=""></button>
            <button class="btn endBtn"><img src="/frontend/aseets/icons/bx-chevrons-right.svg" alt=""></button>
          </div>
        </div>
      </div>


    </div>


  </main>


  <!--profile card-->


  <footer>
    <!-- Modal para mostrar los detalles -->
    <div id="modalDetalles" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="detalles">Usuarios</h2>
        <div class="detallesCont" id="detallesContent"></div>
      </div>
    </div>

    <!-- Modal para confirmar la deshabilitación -->
    <div id="modalConfirmacion" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p class="text">¿Estás seguro de que deseas deshabilitar este usuario?</p>
        <div class="button-container">
          <button id="confirmarDeshabilitar" class="button-grd">Confirmar</button>
          <button class="close-btn button-can">Cancelar</button>
        </div>
      </div>
    </div>

    <!-- Modal de alerta de usuario deshabilitado -->
    <div id="modalUsuarioDeshabilitado" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Usuario deshabilitado con éxito</p>
      </div>
    </div>

    <!-- Botón para mostrar los detalles (debe repetirse para cada fila de la tabla) -->
    <!-- <a class="ver-detalles" data-username="Usuario1" data-email="usuario1@example.com" data-role="Admin" data-phone="123456789" data-description="Descripción del usuario 1">Ver detalles</a>

  <a class="ver-detalles" data-username="Usuario2" data-email="usuario2@example.com" data-role="Jefe" data-phone="987654321" data-description="Descripción del usuario 2">Ver detalles</a> -->
    <!-- scripts -->
    <script src="/frontend/aseets/js/index.js"></script>
    <script src="/frontend/aseets/js/users.js"></script>
    <script src="/frontend/aseets/js/disable_user.js"></script>
  </footer>

  </div>

</body>

</html>