<?php
session_start(); // Inicia la sesión
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

  <div class="center">
    <div class="container wrapper">
      <section class="chat-area">
        <header>
          <a href="" class="back-icon"> <img src="/frontend/aseets/icons/bx-chevron-left.svg" alt=""></a>
          <img src="/frontend/aseets/img/avatar-.png" alt="">
          <div class="details">
            <span class="tittle-chat">Chat</span>
            <p>En linea</p>
          </div>
        </header>
        <div class="chat-box">
          <div class="div chat outgoing">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat incoming">
            <img src="/frontend/aseets/img/avatar_2.png" alt="">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat outgoing">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat incoming">
            <img src="/frontend/aseets/img/avatar_2.png" alt="">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat outgoing">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat incoming">
            <img src="/frontend/aseets/img/avatar_2.png" alt="">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat outgoing">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>
          <div class="div chat incoming">
            <img src="/frontend/aseets/img/avatar_2.png" alt="">
            <div class="details">
              <p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus aliquam, quam nesciunt esse voluptatem deserunt voluptates iure dolorum illo vitae amet voluptas dicta debitis ut. Dolore quos totam at veritatis.</p>
            </div>
          </div>

        </div>
        <form action="#" class="typing-area">
          <input type="text" placeholder="Escriba su mensaje....">
          <button><img src="/frontend/aseets/icons/send-fill.svg" alt=""></button>
        </form>
      </section>
    </div>
  </div>


  <footer>
    <!-- scripts -->
    <script src="/frontend/aseets/js/index.js"></script>
    <script src="/frontend/aseets/js/chat.js"></script>
  </footer>

</body>

</html>