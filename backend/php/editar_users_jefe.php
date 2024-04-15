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
  $id = $_GET['id'];
  $username = $_POST['username'];
  $email = $_POST['email'];

  $phone = $_POST['phone'];
  $description = $_POST['description'];

  $query = mysqli_query($con, "UPDATE usuarios SET username='$username', email='$email', phone='$phone', description='$description' WHERE ID='$id'");

  if ($query) {
    echo "<script>window.onload = function() { mostrarModalActualizacionExitosa(); }</script>";
  } else {
    echo "<script>alert('Hubo un error, solicitud denegada')</script>";
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
          <a class="user" href="/frontend/view/jefe/chat.php">
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
            <span class="title-profile">Level 2
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

  <!-- Tu código HTML para el menú, la barra lateral y otros elementos -->

  <main class="table-pos">

    <div class="modal-box">

      <div class="formulario">

        <div class="container">
          <div class="title">Actualizar usuario</div>
          <div class="content">
            <form method="POST">

              <?php
              include('C:\xampp\htdocs\backend\php\dbconnection.php');
              $id = $_GET['id'];
              $query = mysqli_query($con, "SELECT * FROM usuarios WHERE ID = '$id'");
              while ($row = mysqli_fetch_array($query)) {
              ?>

                <div class="user-details">
                  <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" name="username" value="<?php echo $row['username'] ?>" placeholder="Enter username" required />
                  </div>

                  <div class="input-box">
                    <span class="details">Email</span>
                    <input type="email" name="email" value="<?php echo $row['email'] ?>" placeholder="Enter email" required />
                  </div>

                  <div class="input-box">
                    <span class="details">Phone</span>
                    <input type="text" name="phone" value="<?php echo $row['phone'] ?>" placeholder="Enter phone number" required />
                  </div>

                  <div class="input-box">
                    <span class="details">Description</span>
                    <input type="text" name="description" value="<?php echo $row['description'] ?>" placeholder="Enter description" required />
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
        <p>¡Actualización exitosa! Regrese a la pagina principal</p>
      </div>
    </div>

    <div id="modalError" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Hubo un error, solicitud denegada</p>
      </div>
    </div>
  </footer>

  <!-- scripts -->
  <script src="/frontend/aseets/js/modalUpd.js"></script>
</body>

</html>