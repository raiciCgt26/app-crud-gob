<?php

session_start();
$title = "Login";

// Redireccioner a main.php si ya esta logueado.
if (isset($_SESSION['loggedin']))
{
    header("Location: main.php");

}


include "header.php";

// Asegurarse que el formulario no este vacio.
if (isset($_POST["login"]))
{
    include "connect.php";
}
?>
<style>
  main {
    position: relative;
    z-index: 1; /* Ensure main content is above the background */
  }

  main::before {
    content: "";
    background-image: url('assets/biblioteca_background_stock.jpg');
    background-size: cover;
    background-position: center;
    filter: blur(5px);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Ensure it stays behind the main content */
  }
</style>


<main>
<div class="container mt-5">

   <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

    <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/upt_logo_transparent.png" alt="Logotipo de la Universidad" style="max-height:250%; max-width: 250%;">
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                    <p class="text-center small">Entre su nombre y usuario para entrar sesión</p>
                  </div>


    <form action="authenticate.php" method="post" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="username" class="form-label">Correo Electrónico</label>
                      <div class="input-group has-validation">
                        <input type="text" id="user_email" name="user_email" class="form-control" placeholder="Ingresar correo electrónico." required>
                        <div class="invalid-feedback">Por favor ingresar correo electrónico.</div>
                      </div>
                    </div>

        <div class="col-12">
            <label for="password" class="form-label">Contraseña</label>
                      <input type="password" name="password" class="form-control" id="password" placeholder="Ingresar contraseña." required>
                      <div class="invalid-feedback">Por favor ingresar contraseña!</div>
        </div>
                   <div class="col-12">
                      <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                    </div>
    </form>
    <div class="text-center mt-4 col-12">
        <a href="forgot-password.php" class="small mb-0">Olvidé mi contraseña.</a>
        <br>
    <div class="text-center mt-4 col-12">
        <a href="signups.php" class="small mb-0">Crear cuenta.</a>
    </div>
    </div>
                    </div>
              </div>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger mt-4">
            <?php echo $error; ?>
        </div>
    <?php } ?>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
              </div>

            </div>
          </div>
        </div>

</section>

    </div>
  </main><!-- End #main -->
<?php include "footer.php"; ?>