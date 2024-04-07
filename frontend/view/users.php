<?php
include('C:\xampp\htdocs\backend\php\dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/users.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <title>S.I</title>
</head>

<body>
  <!-- navbar-->
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
  <!--navbar-->
  <!--profile card -->

  <section>
    <article>

      <div class="slide-container swiper">

        <div class="slide-content">
          <div class="card-wrapper  swiper-wrapper">

            <div class="card swiper-slide">

              <div class="image-content">

                <span class="overlay"></span>

                <div class="card-image">
                  <img src="/frontend/aseets/img/avatar-3.png" alt="" class="card-img">
                </div>

                <div class="card-content">
                  <?php
                  include('C:\xampp\htdocs\backend\php\dbconnection.php');
                  $fetch = mysqli_query($con, "select * from usuarios");
                  $row = mysqli_num_rows($fetch);
                  if ($row > 0) {
                    while ($r = mysqli_fetch_array($fetch)) {
                  ?>
                      <tr>
                        <h2 class="name"> <?php echo $r['username'] ?></h2>

                        <p class="description"> <?php echo $r['email'] ?></p>
                        <p class="description"> <?php echo $r['role_id_fk'] ?></p>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </div>
                <button class="button">Actualizar</button>
              </div>



            </div>
            <div class="card swiper-slide">
              <div class="image-content">
                <span class="overlay"></span>

                <div class="card-image">
                  <img src="/frontend/aseets/img/Casa Congeso de Angostura.JPG" alt="" class="card-img">
                </div>

                <div class="card-content">
                  <h2 class="name"> david dell</h2>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                </div>

                <button class="button">Actualizar</button>

              </div>
            </div>
            <div class="card swiper-slide">
              <div class="image-content">
                <span class="overlay"></span>

                <div class="card-image">
                  <img src="/frontend/aseets/img/avatar_2.png" alt="" class="card-img">
                </div>

                <div class="card-content">
                  <h2 class="name"> david dell</h2>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                </div>

                <button class="button">Actualizar</button>

              </div>
            </div>
            <div class="card swiper-slide">
              <div class="image-content">
                <span class="overlay"></span>

                <div class="card-image">
                  <img src="/frontend/aseets/img/avatar-png-image_1541962.jpg" alt="" class="card-img">
                </div>

                <div class="card-content">
                  <h2 class="name"> david dell</h2>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                </div>

                <button class="button">Actualizar</button>

              </div>
            </div>
            <div class="card swiper-slide">
              <div class="image-content">
                <span class="overlay"></span>

                <div class="card-image">
                  <img src="/frontend/aseets/img/avatar-4.jpg" alt="" class="card-img">
                </div>

                <div class="card-content">
                  <h2 class="name"> david dell</h2>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                </div>

                <button class="button">Actualizar</button>

              </div>
            </div>

            <div class="card swiper-slide">
              <div class="image-content">
                <span class="overlay"></span>

                <div class="card-image">
                  <img src="/frontend/aseets/img/logo-round.jpg" alt="" class="card-img">
                </div>

                <div class="card-content">
                  <h2 class="name"> david dell</h2>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                  <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>

                </div>

                <button class="button">Actualizar</button>

              </div>
            </div>


          </div>
        </div>
        <div>
        </div>

        <div class="wrapper">
          <button class="btn arrow startBtn" disabled>
            <img src="/frontend/aseets/icons/bx-chevrons-left.svg" alt="">
          </button>

          <button class="btn arrow stepBtn" disabled>
            <img src="/frontend/aseets/icons/bx-chevron-left.svg" alt="">
          </button>

          <div class="nums">
            <a href="#" class="num active">1</a>
            <a href="#" class="num">2</a>
            <a href="#" class="num">3</a>
            <a href="#" class="num">4</a>
            <a href="#" class="num">5</a>
          </div>

          <button class="btn arrow stepBtn" id="next">
            <img src="/frontend/aseets/icons/bx-chevron-right.svg" alt="">
          </button>
          <button class="btn arrow endBtn">
            <img src="/frontend/aseets/icons/bx-chevrons-right.svg" alt="">
          </button>
        </div>


      </div>

    </article>
  </section>


  <!--profile card-->

</body>

<footer>
  <!-- scripts -->
  <script src="/frontend/aseets/js/index.js"></script>
  <script src="/frontend/aseets/js/users.js"></script>

</footer>

</div>


</html>