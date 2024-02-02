<?php
$nameError = "";
$emailError = "";
$passwordError = "";

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validaciones para el nombre de usuario
  if (empty($username)) {
    $nameError = "Su nombre de usuario es obligatorio";
  } else {
    $username = trim($username);
    $username = htmlspecialchars($username);
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
      $nameError = "El nombre de usuario debe contener solo letras, números y guiones bajos.";
    }
  }

  // Validaciones para el correo electrónico
  if (empty($email)) {
    $emailError = "Su correo electrónico es obligatorio";
  } else {
    $email = trim($email);
    $email = htmlspecialchars($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Por favor, ingrese una dirección de correo electrónico válida";
    }
  }

  // Validaciones para la contraseña
  if (empty($password)) {
    $passwordError = "Su contraseña es obligatoria";
  } else {
    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-z]+#", $password) || !preg_match("#[A-Z]+#", $password)) {
      $passwordError = "Su contraseña debe tener al menos 8 caracteres, incluyendo al menos un número, una letra minúscula y una letra mayúscula.";
    }
  }

  // Si todas las validaciones pasan, proceder con la inserción en la base de datos
  if (empty($nameError) && empty($emailError) && empty($passwordError)) {
    require('/xampp/htdocs/backend/php/dbconnection.php');

    // Verificar si el nombre de usuario o correo ya existen
    $checkUserEmailQuery = "SELECT * FROM `usuarios` WHERE `username`='$username' OR `email`='$email'";
    $checkUserEmailResult = mysqli_query($con, $checkUserEmailQuery);

    if (mysqli_num_rows($checkUserEmailResult) > 0) {
      echo "
                <script>
                    function showAlert() {
                        alert('El nombre de usuario o correo electrónico ya están en uso. Por favor, elija otro.');
                    }
                    showAlert();
                </script>";
    } else {
      // Insertar en la base de datos
      $username = mysqli_real_escape_string($con, $username);
      $email = mysqli_real_escape_string($con, $email);
      $password = mysqli_real_escape_string($con, $password);

      $sql = "INSERT INTO `usuarios` (`username`, `email`,`password`) VALUES ('$username', '$email', '$password')";
      $result = mysqli_query($con, $sql);

      if ($result) {
        echo "
                <script>
                    function showAlert() {
                        alert('Registro exitoso ahora puedes iniciar sesión.');
                    }
                    showAlert();
                </script>";
      } else {
        echo "<script>alert('Error en el registro');</script>";
      }
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

  <title>Login and sign up</title>
</head>

<body>

  <div class="container">
    <div id="register" class="container-form register">
      <div class="information">
        <div class="info-childs">
          <img class="icono" src="../aseets/img/logo-round.jpg" alt="" />
          <h2>Bienvenido al Sistema de incidencias</h2>
          <p>Para ingresar inicie sesión con su correo y contraseña</p>
          <a href="/frontend/view/login.php">
            <input class="btn-login" type="button" value="Iniciar sesión" />
          </a>
        </div>
      </div>
      <div class="form-information">
        <div class="form-information-childs">
          <h2>Crear una cuenta</h2>
          <div class="icons">
            <form class="form" action="" method="POST">
              <p>
                <label for="name">
                  <img src="../aseets/icons/bx-user.svg" />
                  <input type="text" placeholder="Escribe tu Usuario" name="username" />
                </label>
                <span class="form-error">
                  <?php echo $nameError ?>
                </span>
              </p>
              <p>
                <label for="email">
                  <img src="../aseets/icons/bx-envelope.svg" />
                  <input type="email" placeholder="Email" name="email" id="email" />
                </label>
                <span class="form-error">
                  <?php echo $emailError ?>
                </span>
              </p>
              <p>
                <label for="pwd">
                  <img src="../aseets/icons/bx-lock-alt.svg" />
                  <input type="password" placeholder="Escribe tu contraseña" name="password" id="password-reg" />
                </label>
                <span class="form-error">
                  <?php echo $passwordError ?>
                </span>
              </p>
              <input class="btn-login" name="submit" type="submit" value="Registrarse" />
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="../aseets/js/login-signup.js"></script>
  </div>
</body>

</html>