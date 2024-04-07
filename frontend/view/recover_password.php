<?php
$email = "";
$confirm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $mysqli = new mysqli("localhost", "root", "", "app");

    $sql = "UPDATE usuarios
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();
    if ($mysqli->affected_rows) {
      require __DIR__ . "/reset_link.php";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/login-signup.css" />
  <title>Recuperacion de contraseña</title>
</head>

<body>

  <main>
    <div class="container">

      <div id="login" class="container-form login">
        <div class="information">
          <div class="info-childs">
            <img class="icono" src="../aseets/img/logo-round.jpg" alt="" />
            <h2>Bienvenido de nuevo a la recuperacion de contraseña en tres pasos</h2>
            <p>Paso 1:Escribe tu email</p>
            <p>Paso 2: Presiona el boton "Enviar mensaje" </p>
            <p>Paso 3: Revisa tu email, y accede al link que se indica</p>


            <a href="/frontend/view/login.php">
              <input class="btn-login" type="submit" name="submit" value="Volver a Iniciar sesion" />
            </a>

          </div>
        </div>
        <div class="form-information">
          <div class="form-information-childs">
            <h2>Iniciar sesion</h2>
            <div class="icons">

              <form id="loginFom" class="form" action="" method="post">


                <p>
                  <label for="enviar_email">
                    <img src="../aseets/icons/bx-envelope.svg" />
                    <input type="text" placeholder="Escribe tu email" name="email" id="login" />
                  </label>
                </p>
                <input class="btn-login" type="submit" name="submit" value="Enviar mensaje al email" />
                <p>
                  <span class="form-good">
                    <?php echo $confirm ?>
                  </span>
                </p>

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