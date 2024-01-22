<?php
include('C:\xampp\htdocs\backend\php\dbconnection.php');
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
    echo "<script>alert('actualizado correctamente')</script>";
    echo "<script type='text/javascript'> document.location.href = '/frontend/view/index.php'; </script>";
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
          <a id="inbox" href="/frontend/view/index.php">
            <ion-icon name="mail-unread-outline">
              <img class="ico-center" src="/frontend/aseets/icons/house.svg" />
            </ion-icon>
            <span>Pagina principal</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/users.html">
            <ion-icon name="star-outline">
              <img class="ico-center" src="/frontend/aseets/icons/person.svg" />
            </ion-icon>
            <span>Usuarios</span>
          </a>
        </li>

        <li>
          <a class="user" href="/frontend/view/chat.html">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/chat.svg" />
            </ion-icon>
            <span>Chat</span>
          </a>
        </li>

        <li>
          <a href="/frontend/view//setting.html">
            <ion-icon name="paper-plane-outline">
              <img class="ico-center" src="/frontend/aseets/icons/gear.svg" />
            </ion-icon>
            <span>Configuracion</span>
          </a>
        </li>

        <li>
          <a href="/frontend/view/login_signup.html">
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
  <!-- menu-navbar-header -->


  <main class=" table-pos ">

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
                    <option>...</option>
                    <option>...</option>
                    <option>...</option>
                  </select>
                </div>

                <div class="input-box">
                  <span class="details">Asignado a - Tecnico</span>
                  <select name="tecnico" value="<?php echo $row['tecnico'] ?>" class="input-extr">
                    <option selected>Seleccionar...</option>
                    <option>...</option>
                    <option>...</option>
                    <option>...</option>
                  </select>
                </div>

                <div class="input-box">
                  <span class="details">Categoria</span>
                  <select name="categoria" value="<?php echo $row['categoria'] ?>" class="input-extr">
                    <option selected>Seleccionar...</option>
                    <option>...</option>
                    <option>...</option>
                    <option>...</option>
                  </select>
                </div>

              </div>
            <?php } ?>

            <div class="button-container">
              <div class="button">
                <input class="button-grd" type="submit" value="Actualizar" />
              </div>
              <div class="button">
                <input class="button-can" type="submit" value="Cancelar" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <footer>
      <!-- scripts -->
      <script src="/frontend/aseets/js/index.js"></script>
    </footer>

    </div>
</body>

</html>