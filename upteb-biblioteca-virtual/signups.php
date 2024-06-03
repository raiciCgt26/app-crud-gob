<?php

session_start();
$title = "Registro de Usuario";

// Verificar que el usuario este logueado.
if (isset($_SESSION['loggedin']))
{
    header("Location: main.php");
    exit;
}

include "header.php";

$errors = [];

// Asegurarse que el formulario este completo
if (isset($_POST["add_user"]))
{
    include "connect.php";

    // Conseguir datos de formulario.
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $security_answer0 = mysqli_real_escape_string($con, $_POST["security-answer0"]);
    $security_answer1 = mysqli_real_escape_string($con, $_POST["security-answer1"]);
    $security_answer2 = mysqli_real_escape_string($con, $_POST["security-answer2"]);
    $user_type = "student";
    $contact_number = mysqli_real_escape_string($con, $_POST["contact-number"]);
    $cedula = mysqli_real_escape_string($con, $_POST["cedula"]);
    $pnf = "Ninguno";

    // Asegurarse que el usuario entré datos correctos.
    if (empty($email))
    {
        $errors[] = "Email requerido.";
    }
    if (empty($username) || (is_numeric($username))) 
    {
        $errors[] = "Nombre válido requerido.";
    }
    if (empty($cedula) || !is_numeric($cedula) || $cedula <= 0)
    {
        $errors[] = "Número de cédula válido requerido.";
    }
    if (empty($password))
    {
        $errors[] = "Contraseña requerida.";
    }
    if (empty($security_answer0))
    {
        $errors[] = "Respuesta de seguridad requerida.";
    }
    if (empty($security_answer1))
    {
        $errors[] = "Respuesta de seguridad requerida.";
    }
    if (empty($security_answer2))
    {
        $errors[] = "Respuesta de seguridad requerida.";
    }
    if (empty($contact_number))
    {
        $errors[] = "Número de telefono de contacto requerido.";
    }

    // Verificar que no haya otro usuario con el mismo nombre o email.
    $query = "SELECT * FROM users WHERE (username = '$username' OR email = '$email')";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0)
    {
        $errors[] = "Nombre de usuario ya ocupado.";
    }
    
    // Si no hay errores...
    if (empty($errors))
    {
        // Encriptar contraseña
        $password = password_hash($password, PASSWORD_BCRYPT);
       //Vamos a hacer las dos cosas en una transacción para que así sea más facil de procesar
        $con->begin_transaction();
        try
        {
            // Primera inserción: Insertar a la tabla de libros
            $sql = "INSERT INTO users (email, username, cedula_id, password, user_type, pnf, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssss', $email, $username, $cedula, $password, $user_type, $pnf, $contact_number);
            mysqli_stmt_execute($stmt);
            $user_insert_id = $stmt->insert_id;
            mysqli_stmt_close($stmt);

            // Agregar respuestas de seguridad también
            $sql2 = "INSERT INTO security_answers (user_id, answer0, answer1, answer2) VALUES (?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($con, $sql2);
            mysqli_stmt_bind_param($stmt2, 'isss', $user_insert_id, $security_answer0, $security_answer1, $security_answer2);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);

            // Commit the transaction
            $con->commit();
                $success = "Usuario registrado exitosamente!";

            echo '<script>setTimeout(function () { window.location.href = "cubicle.php";}, 500);</script>';
        }catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $con->rollback();
            $errors[] = "Algo salió mal...";
        }
        
    }
   
    mysqli_close($con);
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
<main id="main" class="main">
<div class="container mt-5">
   <section class="section register min-vh-100 d-flex flex-column justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-xl-6 d-flex flex-column justify-content-center">
    <?php if (isset($success)) { ?>
        <div class="alert alert-success mt-4">
            <?php echo $success; ?>
        </div>
    <?php } ?>
    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger mt-4">
            <?php foreach ($errors as $error) { ?>
                <div><?php echo $error; ?></div>
            <?php } ?>
        </div>
    <?php } ?>
            <div class="card">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registro de Usuario</h5>
                  </div>


    <form action="signups.php" method="post">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresar correo electrónico." required>
        </div>

        <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="username">Nombre y Apellido</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingresar nombre y apellido." required>
                </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="password">Número de Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingresar número de cédula." required>
            </div>
            </div>
        </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresar contraseña." required>
                <ul id="passwordRequirements" class="list-unstyled mt-2">
                    <li id="lengthRequirement" class="text-danger">Debe tener más de 6 caracteres.</li>
                    <li id="numberRequirement" class="text-danger">Debe tener al menos un número.</li>
                </ul>
            </div>

        <div class="form-group">
            <label for="security-answer">Respuesta a Pregunta de Seguridad - ¿Cuál es su libro favorito?</label>
            <input type="text" class="form-control" id="security-answer0" name="security-answer0" placeholder="Entrar tu respuesta" required>
        </div>
        <div class="form-group">
            <label for="security-answer">Respuesta a Pregunta de Seguridad - ¿Cuál es el nombre de su madre?</label>
            <input type="text" class="form-control" id="security-answer1" name="security-answer1" placeholder="Entrar tu respuesta" required>
        </div>
        <div class="form-group">
            <label for="security-answer">Respuesta a Pregunta de Seguridad - ¿Cuál es su animal favorito?</label>
            <input type="text" class="form-control" id="security-answer2" name="security-answer2" placeholder="Entrar tu respuesta" required>
        </div>
        <div class="form-group">
            <label for="contact-number">Teléfono de Contacto</label>
            <input type="text" class="form-control" id="contact-number" name="contact-number" placeholder="Entrar teléfono número de contacto">
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="add_user">Registrar Cuenta</button>
        </div>
    </form>
        </div>
    <a href="public_website.php" style="padding-left: 8px;">Atrás</a>

</div>

            </div>
          </div>
        </div>

      </section>

</main>
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordRequirements = document.getElementById('passwordRequirements');
            const lengthRequirement = document.getElementById('lengthRequirement');
            const numberRequirement = document.getElementById('numberRequirement');
            const form = document.getElementById('signupForm');

            function validatePassword() {
                const password = passwordInput.value;
                let isValid = true;

                // Check length requirement
                if (password.length > 6) {
                    lengthRequirement.classList.remove('text-danger');
                    lengthRequirement.classList.add('text-success');
                } else {
                    lengthRequirement.classList.remove('text-success');
                    lengthRequirement.classList.add('text-danger');
                    isValid = false;
                }

                // Check number requirement
                if (/\d/.test(password)) {
                    numberRequirement.classList.remove('text-danger');
                    numberRequirement.classList.add('text-success');
                } else {
                    numberRequirement.classList.remove('text-success');
                    numberRequirement.classList.add('text-danger');
                    isValid = false;
                }

                return isValid;
            }

            passwordInput.addEventListener('input', validatePassword);

            form.addEventListener('submit', function(event) {
                if (!validatePassword()) {
                    event.preventDefault();
                }
            });
        });
    </script>
<?php include "footer.php"; ?>