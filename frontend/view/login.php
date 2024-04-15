<?php
session_start();
require('/xampp/htdocs/backend/php/dbconnection.php');

$nameError = "";
$passwordError = "";

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) {
    $nameError = "Su nombre de usuario es obligatorio";
  } else {
    $username = trim($username);
    $username = htmlspecialchars($username);
    if (!preg_match("/^[a-zA-Z0-9_ ]+$/", $username)) {
      $nameError = "El nombre de usuario debe contener solo letras, números, espacios y guiones bajos.";
    }
  }

  if (empty($password)) {
    $passwordError = "Su contraseña es obligatoria";
  } else {
    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match("#[A-Z]+#", $password)) {
      $passwordError = "Su contraseña debe tener al menos 8 caracteres, incluyendo al menos un número, una letra minúscula y una letra mayúscula.";
    }
  }

  if (empty($nameError) && empty($passwordError)) {
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM `usuarios` WHERE username ='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
      // Verificar si el usuario está activo
      if ($row['activo'] == 1) {
        // Obtener el nivel del usuario
        $userLevel = $row['role_id_fk'];
        // Redirigir según el nivel del usuario
        switch ($userLevel) {
          case 1:
            // Usuario de nivel 1 (admin)
            header("Location: /frontend/view/admin/level_admin.php");
            break;
          case 2:
            // Usuario de nivel 2 (jefe)
            header("Location: /frontend/view/jefe/level_jefe.php");
            break;
          case 3:
            // Usuario de nivel 3 (administrativo)
            header("Location: /frontend/view/pers_adm/level_pers_admi.php");
            break;
        }
        // Establecer la sesión
        $_SESSION['username'] = $username;
      } else {
        // Mostrar el modal de usuario desactivado
        echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modalUsuarioDesactivado').style.display = 'block';
          });
        </script>
        ";
      }
    } else {
      // Mostrar alerta de usuario o contraseña incorrecta
      echo "
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          alert('Usuario o contraseña incorrecta');
        });
      </script>
      ";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../aseets/img/logo-gob2.png" />
  <link rel="stylesheet" href="../aseets/css/login-signup.css" />
  <link rel="stylesheet" href="../aseets/css/try-error.css" />
  <title>Login and sign up</title>
</head>

<body>
  <div class="container">

    <div id="login" class="container-form login">
      <div class="information">
        <div class="info-childs">
          <img class="icono" src="../aseets/img/logo-round.jpg" alt="" />
          <h2>Bienvenido de nuevo al Sistema de incidencias</h2>
          <p>Si no tienes una cuenta puedes registrarte</p>

          <a href="/frontend/view/signup.php">
            <input class="btn-login" type="button" value="Registrarse" />
          </a>


          <br>
          <br>
          <div>
            <a class="form-good" href="/frontend/view/recover_password.php">¿Has olvidado tu contraseña? </a>
          </div>


        </div>
      </div>
      <div class="form-information">
        <div class="form-information-childs">
          <h2>Iniciar sesion</h2>
          <div class="icons">

            <form id="loginFom" class="form" action="" method="post">


              <p>
                <label for="name">
                  <img src="../aseets/icons/bx-user.svg" />
                  <input type="text" placeholder="Usuario" name="username" id="login" />
                </label>
                <span class="form-error">
                  <?php echo $nameError ?>
                </span>
              </p>

              <p>
                <label for="password">
                  <img src="../aseets/icons/bx-lock-alt.svg" />
                  <input type="password" placeholder="Escribe tu contraseña" name="password" id="password-log" />
                </label>
                <span class="form-error">
                  <?php echo $passwordError ?>
                </span>
              </p>

              <input onclick='showAlert()' class="btn-login" type="submit" name="submit" value="Iniciar sesion" />

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de usuario desactivado -->
  <div id="modalUsuarioDesactivado" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Usuario desactivado</p>
    </div>
  </div>

  <script src="../aseets/js/login-signup.js"></script>
  <script src="../aseets/js/try-error.js"></script>

</body>

</html>