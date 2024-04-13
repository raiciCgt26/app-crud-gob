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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/index.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/estadist.css">
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

  <main>
    <!-- main -->
    <div class="estadisticas-container">

      <div class="estadisticas estadisticas-incidencias">
        <h2 class="stat-title">Estadísticas de Incidencias por Estado</h2>
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
        <h2 class="stat-title">Estadísticas de Usuarios por Nivel</h2>
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
    </ <!-- main -->
  </main>

  <footer>

  </footer>



  <script src="/frontend/aseets/js/index.js"></script>
  <script src="/frontend/aseets/js/estadist.js"></script>
</body>

</html>