<?php

session_start();
$title = "Agregar Usuario";

// Verificar que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
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
    $user_type = mysqli_real_escape_string($con, $_POST["user-type"]);
    $contact_number = mysqli_real_escape_string($con, $_POST["contact-number"]);

    // Asegurarse que el usuario entré datos correctos.
    if (empty($email))
    {
        $errors[] = "Email requerido.";
    }
    if (empty($username))
    {
        $errors[] = "Nombre de usuario requerido.";
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
    if (empty($user_type))
    {
        $errors[] = "Tipo de usuario requerido.";
    }
    if (empty($contact_number))
    {
        $errors[] = "Teléfono número de contacto requerido.";
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

        // Y a la base de datos te vas
        $query = "INSERT INTO users (email, username, password, user_type, contact_number) VALUES ('$email', '$username', '$password', '$user_type', '$contact_number')";
        $result = mysqli_query($con, $query);

        if ($result)
        {
            // Agregar respuestas de seguridad también
            $user_id = $con->insert_id;
            $query = "INSERT INTO security_answers (user_id, answer0, answer1, answer2) VALUES ($user_id, '$security_answer0', '$security_answer1', '$security_answer2')";

            if (!mysqli_query($con, $query))
            {
                $errors[] = "Algo salió mal...";
            }
            else
            {
                $success = "Usuario agregado exitosamente!";
                audit_log(AuditAction::UserNew, null, $con->insert_id, null);
            }
        }
        else
        {
            $errors[] = "Algo salió mal...";
        }
    }

    mysqli_close($con);
}
?>
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
                    <h5 class="card-title text-center pb-0 fs-4">Agregar Usuario</h5>
                  </div>


    <form action="add-user.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Entrar correo electrónico" required>
        </div>
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Entrar nombre de usuario" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Entrar contraseña" required>
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
            <label for="user-type">Tipo de Usuario</label>
            <select class="form-control" id="user-type" name="user-type" required>
                <option value="regular">Ayudante</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <div class="form-group">
            <label for="contact-number">Teléfono de Contacto</label>
            <input type="text" class="form-control" id="contact-number" name="contact-number" placeholder="Entrar teléfono número de contacto">
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="add_user">Agregar Usuario</button>
        </div>
    </form>
        </div>
    <a href="users.php" style="padding-left: 8px;">Atrás</a>
</div>

            </div>
          </div>
        </div>

      </section>

</main>
<?php include "footer.php"; ?>