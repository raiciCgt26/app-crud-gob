<?php
include('/xampp/htdocs/backend/php/dbconnection.php');
include('/xampp/htdocs/frontend/view/reset_password.php');

$confirmToken = "";     //// die
$confirmRest = "";


$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM usuarios
        WHERE reset_token_hash = ?";

$stmt = mysqli_prepare($con, $sql);

mysqli_stmt_bind_param($stmt, "s", $token_hash);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

//
if ($user === null) {
  $confirmRest = "Recuperación completa, ingrese con su nueva contraseña.";
} elseif (strtotime($user["reset_token_expires_at"]) <= time()) {
  $confirmToken = "El código ha expirado, inténtelo de nuevo";
}
// 
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/login-signup.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
  <title>Recuperacion de contraseña</title>
</head>

<body>

  <main>
    <div class="container">

      <div id="login" class="container-form login">
        <div class="information">
          <div class="info-childs">
            <img class="icono" src="../aseets/img/logo-round.jpg" alt="" />
            <h2>Bienvenido de nuevamente a la recuperacion de contraseña</h2>
            <p>Escribe tu contraseña</p>
            <p>Presiona el boton "Guardar contraseña" </p>
            <p>Ingresa al sistema con tu nueva contraseña</p>


            <a href="/frontend/view/login.php">
              <input class="btn-login" type="submit" name="submit" value="Volver a Iniciar sesion" />
            </a>

          </div>
        </div>
        <div class="form-information">
          <div class="form-information-childs">
            <h2>Restablecer contraseña</h2>
            <div class="icons">

              <form id="loginFom" class="form" action="" method="post">

                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <p>
                  <label for="pwd">
                    <img src="../aseets/icons/bx-lock-alt.svg" />
                    <input type="password" placeholder="Escribe tu nueva contraseña" name="password" id="password-reg" />
                  </label>
                  <span class="form-error">
                    <?php echo $passwordError ?>
                  </span>
                </p>

                <p>
                  <label for="pwd">
                    <img src="../aseets/icons/bx-lock-alt.svg" />
                    <input type="password" placeholder="Confirma tu contraseña" name="password_confirm" id="password_confirm" />
                  </label>
                  <span class="form-error">
                    <?php echo $passwordConfirmError ?>
                  </span>
                </p>

                <p>
                  <span class="form-error">
                    <?php echo $tokenError ?>
                  </span>
                </p>

                <p>
                  <span class="form-error">
                    <?php echo $confirmToken ?>
                  </span>
                </p>

                <p>
                  <span class="form-good">
                    <?php echo $confirmRest ?>
                  </span>
                </p>

                <input class="btn-login" type="submit" name="submit" value="Guardar nueva contraseña" />
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

  <footer>
    <!-- scripts -->
    <script src="/frontend/aseets/js/login-signup.js"></script>
  </footer>
</body>

</html>