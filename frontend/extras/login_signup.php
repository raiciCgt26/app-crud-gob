<?php
$nameError = "";
$password = "";
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) {
    $nameError = "Su nombre de usuario es obligatorio";
  } else {
    $username = trim($username);
    $username = htmlspecialchars($username);
    if (!preg_match("/^[a-zA-Z ]$/", $username)) {
      $nameError = "el nombre debe contener solo caracteres y espacios en blanco";
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
          <p>Para ingresar inicie sesion con su correo y contraseña</p>
          <input class="btn-login" id="sign-in" type="button" value="iniciar sesion" />
        </div>
      </div>
      <div class="form-information">
        <div class="form-information-childs">
          <h2>Crear una cuenta</h2>
          <div class="icons">


            <form class="form" action="" method="post">

              <label for=name>
                <img src="../aseets/icons/bx-user.svg" />
                <input type="text" placeholder="Escribe tu Usuario" name="username" />
              </label>

              <label for=email>
                <img src="../aseets/icons/bx-envelope.svg" />
                <input type="email" placeholder="Email" name="email" id="email" />
              </label>

              <label for=pwd>
                <img src="../aseets/icons/bx-lock-alt.svg" />
                <input type="password" placeholder="Escribe tu contraseña" name="pwd" id="password-reg" />

              </label>
              <input class="btn-login" type="submit" value="Registrarse" />

            </form>

            <?php

            ?>


          </div>
        </div>
      </div>
    </div>

    <div id="login" class="container-form login hide">
      <div class="information">
        <div class="info-childs">
          <img class="icono" src="../aseets/img/logo-round.jpg" alt="" />
          <h2>Bienvenido de nuevo al Sistema de incidencias</h2>
          <p>Si no tienes una cuenta puedes registrarte</p>
          <input class="btn-login" id="sign-up" type="button" value="Registrarse" />
        </div>
      </div>
      <div class="form-information">
        <div class="form-information-childs">
          <h2>Iniciar sesion</h2>
          <div class="icons">

            <form id="loginFom" class="form" action="" method="post">

              <label for=name>
                <img src="../aseets/icons/bx-user.svg" />
                <input type="text" placeholder="Usuario" name="username" id="login" />
              </label>
              <span class="form-error">
                <?php echo $nameError ?>
              </span>

              <label for=password>
                <img src="../aseets/icons/bx-lock-alt.svg" />
                <input type="password" placeholder="Escribe tu contraseña" name="password" id="password-log" />
              </label>

              <input class="btn-login" type="submit" name="submit" value="Iniciar sesion" />
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="../aseets/js/login-signup.js"></script>

</body>

</html>