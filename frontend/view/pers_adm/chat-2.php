<?php
session_start();
include('C:\xampp\htdocs\backend\php\dbconnection.php');
include("/xampp/htdocs/backend/php/antentication.php");
// Verificar que se haya iniciado sesión
if (!isset($_SESSION['username'])) {
  echo "Error: No se ha iniciado sesión.";
  exit();
}

// Obtener el nombre de usuario del usuario que inició sesión
$username = $_SESSION['username'];

// Obtener los datos del usuario que inició sesión
$sql = "SELECT * FROM `usuarios` WHERE username = '$username'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$nombreUsuario = $row['username'];
$imagenUsuario = '/frontend/aseets/image/' . $row['file'];

// Verificar que se haya especificado el destinatario del chat
if (!isset($_GET['username'])) {
  echo "Error: No se ha especificado el destinatario del chat.";
  exit();
}
$chatUser = $_GET['username'];

// // Asignar el valor de $chatUser a una variable JavaScript
echo "<script>var chatUser = " . json_encode($chatUser) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/chat.css" />
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
          <a id="inbox" href="/frontend/view/pers_adm/index.php">
            <ion-icon name="mail-unread-outline">
              <img class="ico-center" src="/frontend/aseets/icons/house.svg" />
            </ion-icon>
            <span>Pagina principal</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/pers_adm/level_pers_admi.php">
            <ion-icon name="mail-unread-outline">
              <img class="icono-inc" src="/frontend/aseets/icons/envelope-paper.svg" />
            </ion-icon>
            <span>Incidencias</span>
          </a>
        </li>


        <li>
          <a class="user" href="/frontend/view/pers_adm/users.php">
            <ion-icon name="star-outline">
              <img class="ico-center" src="/frontend/aseets/icons/person.svg" />
            </ion-icon>
            <span>Usuarios</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/pers_adm/chat.php">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/chat.svg" />
            </ion-icon>
            <span>Chat</span>
          </a>
        </li>

        <li>
          <a href="/frontend/view/pers_adm/setting.php">
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
            <span class="title-profile">Level 3
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


  <div class="center">
    <div class="container wrapper">
      <section class="chat-area">

        <header>

          <a href="/frontend/view/pers_adm/chat.php" class="back-icon"> <img src="/frontend/aseets/icons/bx-chevron-left.svg" alt=""></a>
          <img src="<?php echo $imagenUsuario; ?>" alt="">
          <div class="details">
            <span class="tittle-chat"><?php echo $nombreUsuario; ?></span>
            <p>En linea</p>
          </div>
        </header>

        <div class="chat-box" id="chat-box" data-username="nombre_destinatario">

        </div>

        <form id="chat-form" class="typing-area">
          <input class="text" type="text" id="mensaje" placeholder="Escriba su mensaje....">
          <input class="btn" type="submit" id="enviarMensaje">
          <!-- <img src="/frontend/aseets/icons/send-fill.svg" alt=""> -->
        </form>
      </section>
    </div>
  </div>


  <footer>
    <!-- scripts -->
    <!-- <script src="/frontend/aseets/js/index.js"></script> -->
    <script src="/frontend/aseets/js/chat-2.js"></script>
    <script src="/frontend/aseets/js/index.js"></script>



  </footer>

</body>

</html>