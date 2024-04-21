<?php
session_start(); // Inicia la sesión

include('C:\xampp\htdocs\backend\php\dbconnection.php');

$query_user = mysqli_query($con, "SELECT role_id_fk FROM usuarios WHERE username = '$_SESSION[username]'");

// Verifica si la consulta se realizó con éxito
if ($query_user) {
  // Obtiene el resultado de la consulta
  $user_data = mysqli_fetch_assoc($query_user);
  // Guarda el nivel de usuario en una variable JavaScript 
  echo "<script>var nivel_usuario = " . $user_data['role_id_fk'] . ";</script>";
} else {
  // Si hay un error, muestra un mensaje de error
  echo "<script>alert('Error al obtener el nivel de usuario');</script>";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tecnico = $_POST['data-tecnico'];
    $grupo = $_POST['data-grupo'];
    $categoria = $_POST['data-categoria'];
    $query = mysqli_query($con, "UPDATE datos_pers SET `data-tecnico`='$tecnico', `data-grupo`='$grupo', `data-categoria`='$categoria' WHERE ID='$id'");

    if ($query) {
      echo "<script>window.onload = function() { mostrarModalActualizacionExitosa(); }</script>";
      // echo "<script>setTimeout(() => { document.location.href = '/frontend/view/admin/level_admin.php'; }, 2000)</script>";
    } else {
      echo "<script>alert('Hubo un error, solicitud denegada')</script>";
    }
  } else {
    echo "<script>alert('No se recibió el parámetro ID')</script>";
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
  <link rel="stylesheet" href="/frontend/aseets/css/modalAdd.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/modalUpd.css" />
  <title>Actualizar</title>
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


  <main class=" table-pos ">

    <div class="modal-box">

      <div class="formulario">

        <div class="container">
          <div class="title">Actualizar incidencia</div>
          <div class="content">
            <form method="POST">

              <?php
              include('C:\xampp\htdocs\backend\php\dbconnection.php');
              $id = $_GET['id'];
              $query = mysqli_query($con, "select * from datos_pers where ID = '$id' ");
              while ($row = mysqli_fetch_array($query)) {
              ?>

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



              <?php } ?>


              <div class="button-container">
                <div class="button">
                  <input class="button-grd" type="submit" value="Actualizar" />
                </div>
                <div class="button">
                  <button class="button-can close-btn" type="button" value="Cancelar">Cancelar</button>
                </div>
              </div>

          </div>
          </form>
        </div>
      </div>
    </div>

    </div>

  </main>

  <footer>
    <!-- Modales -->
    <div id="modalActualizacionExitosa" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>¡Actualización exitosa!</p>
      </div>
    </div>

    <div id="modalError" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Hubo un error, solicitud denegada</p>
      </div>
    </div>
  </footer>

  </div>

  <!-- scripts -->
  <!-- <script src="/frontend/aseets/js/index.js"></script> -->
  <!-- <script src="/frontend/aseets/js/modalAdd.js"></script> -->
  <script src="/frontend/aseets/js/modalUpd.js"></script>
</body>

</html>