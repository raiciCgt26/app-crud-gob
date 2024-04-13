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
  $titulo = $_POST['titulo'];
  $estado = $_POST['estado'];
  $fecha = $_POST['fecha'];
  $prioridad = $_POST['prioridad'];
  $solicitante = $_POST['solicitante'];
  $tecnico = $_POST['tecnico'];
  $grupo = $_POST['grupo'];
  $categoria = $_POST['categoria'];

  $query = mysqli_query($con, "update incidencias set titulo='$titulo', estado='$estado', fecha='$fecha', prioridad='$prioridad', solicitante='$solicitante', tecnico='$tecnico', grupo='$grupo', categoria='$categoria' where ID='$id' ");

  if ($query) {
    echo "<script>window.onload = function() { mostrarModalActualizacionExitosa(); }</script>";
    // echo "<script>setTimeout(() => { document.location.href = '/frontend/view/pers_adm/level_pers_admi.php'; }, 2000)</script>";
  } else {
    echo "<script>alert('hubo un error , solicitud denegada')</script>";
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
              $query = mysqli_query($con, "select * from incidencias where ID = '$id' ");
              while ($row = mysqli_fetch_array($query)) {
              ?>

                <div class="user-details">
                  <div class="input-box">
                    <span class="details">Titulo</span>
                    <input type="text" name="titulo" value="<?php echo $row['titulo'] ?>" placeholder="Escribe el titulo " required />
                  </div>

                  <div class="input-box">
                    <span class="details">Estado</span>
                    <select name="estado" value="<?php echo $row['estado'] ?>" class="input-extr">
                      <option>Sin resolver</option>
                      <option>En Curso</option>
                      <option>Resuelto</option>
                    </select>
                  </div>

                  <div class="input-box">
                    <span class="details">Fecha de modificacion</span>
                    <input type="date" name="fecha" value="<?php echo $row['fecha'] ?>" required />
                  </div>

                  <div class="input-box">
                    <span class="details">Prioridad</span>
                    <select name="prioridad" value="<?php echo $row['prioridad'] ?>" class="input-extr">
                      <option selected>Urgente</option>
                      <option>Media</option>
                      <option>Baja</option>
                    </select>


                  </div>
                  <div class="input-box">
                    <span class="details">Solicitante</span>
                    <input name="solicitante" value="<?php echo $row['solicitante'] ?>" type="text" placeholder="Escriba el nombre del solicitante" required />
                  </div>


                  <div class="input-box">
                    <span class="details">Asignado a - Grupo Tecnico</span>
                    <select name="grupo" value="<?php echo $row['grupo'] ?>" class="input-extr">
                      <option selected>Seleccionar...</option>
                      <option>Carolina Vixleris</option>
                      <option>Jose Arenas</option>
                      <option>Juan Lopez</option>
                    </select>
                  </div>

                  <div class="input-box">
                    <span class="details">Asignado a - Tecnico</span>
                    <select name="tecnico" value="<?php echo $row['tecnico'] ?>" class="input-extr">
                      <option selected>Seleccionar...</option>
                      <option>Carolina Vixleris</option>
                      <option>Jose Arenas</option>
                      <option>Juan Lopez</option>
                    </select>
                  </div>

                  <div class="input-box">
                    <span class="details">Categoria</span>
                    <select name="categoria" value="<?php echo $row['categoria'] ?>" class="input-extr">
                      <option selected>Seleccionar...</option>
                      <option>01 Direccion de informatica y sistemas > division de desarrollo de sistemas</option>
                      <option>01 Direccion de informatica y sistemas > division de soporte tecnico</option>
                      <option>01 Direccion de informatica y sistemas > division de problemas de internet</option>
                    </select>
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