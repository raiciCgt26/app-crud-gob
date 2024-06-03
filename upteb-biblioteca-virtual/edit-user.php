<?php

session_start();
$title = "Editar Usuario";
include "header.php";

$errors = [];

include "connect.php";

$user_id = $_GET['id'];

// Verificar que el usuario sea administrador si esta modificando un id que no sea suyo.

if ($_SESSION["user_id"] !== $user_id)
{
    if ($_SESSION["user_type"] !== "admin")
    {
        header("Location: index.php");
        exit;
    }
}

//Agarrar todos los tags y su id...
$sqlSelect = "SELECT tag_id, name FROM tags WHERE tag_category = 'PNF' AND removed = 0";
$queryResult = mysqli_query($con, $sqlSelect);

//Establecer un arreglo vacío
$tagArray = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($tag_row = mysqli_fetch_array($queryResult, MYSQLI_ASSOC)) {
  array_push($tagArray, $tag_row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult);

// Sacar detalles de usuario de la base de datos.
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);

// Asegurarse que el usuario exista
if (mysqli_num_rows($result) == 0)
{
    header("Location: users.php");
    exit;
}

$user_row = mysqli_fetch_assoc($result);

// Get the security answers
$sql = "SELECT * FROM security_answers WHERE security_id = '$user_id'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0)
{
    $row2 = mysqli_fetch_assoc($result);
    $security_answer0 = $row2['answer0'];
    $security_answer1 = $row2['answer1'];
    $security_answer2 = $row2['answer2'];
}
else
{
    $security_answer0 = "";
    $security_answer1 = "";
    $security_answer2 = "";
}


if (isset($_POST['edit_user']))
{
    // Agarrar detalles nuevos de usuario.
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user-type'];
    $security_answer0 = $_POST['security-answer0'];
    $security_answer1 = $_POST['security-answer1'];
    $security_answer2 = $_POST['security-answer2'];
    $contact_number = $_POST['contact-number'];

    // Que la información sea válida.
    if (empty($email))
    {
        $errors[] = "Email requerido.";
    }
    if (empty($username))
    {
        $errors[] = "Nombre de usuario requerido.";
    }
    if (empty($user_type))
    {
        $errors[] = "Tipo de usuario requerido.";
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
        $errors[] = "Teléfono número de contacto requerido.";
    }

    // Verificar que no haya otro usuario con el mismo usuario o email
    $sql = "SELECT * FROM users WHERE (username = '$username' OR email = '$email') AND user_id != '$user_id'";
    if (mysqli_num_rows(mysqli_query($con, $sql)) > 0)
    {
        $errors[] = "Ya existe un usuario con el mismo nombre de usuario o correo electrónico.";
    }

    // Si no hay errores...
    if (empty($errors))
    {
        // Preparar la actualización de base de datos.
        if (empty($password))
        {
            $sql = "UPDATE users SET email = '$email', username = '$username', user_type = '$user_type', contact_number = '$contact_number' WHERE user_id = '$user_id'";
        }
        else
        {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET email = '$email', username = '$username', password = '$password', user_type = '$user_type', contact_number = '$contact_number' WHERE user_id = '$user_id'";
        }

        // Ejecutar y crear mensaje.
        if (mysqli_query($con, $sql))
        {
            // Remove the existing security answers
            $sql = "DELETE FROM security_answers WHERE user_id = '$user_id'";
            if (!mysqli_query($con, $sql))
            {
                $errors[] = "Algo salió mal...";
            }
            else
            {
                // Add the new security answers
                $sql = "INSERT INTO security_answers (user_id, answer0, answer1, answer2) VALUES ('$user_id', '$security_answer0', '$security_answer1', '$security_answer2')";
                if (!mysqli_query($con, $sql))
                {
                    $errors[] = "Algo salió mal...";
                }
                else
                {
                    $success = "Usuario actualizado exitósamente.";
                    audit_log(AuditAction::UserEdit, null, $user_id, null);
                }
            }
        }
        else
        {
            $errors[] = "Algo salió mal...";
        }

        // Re-agarrar detalles de la base de datos de usuario.
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

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
                    <h5 class="card-title text-center pb-0 fs-4">Editando Usuario</h5>
                  </div>

    <form action="edit-user.php?id=<?php echo $user_id; ?>" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Entrar correo electrónico" value="<?php echo $user_row['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Entrar nombre de usuario" value="<?php echo $user_row['username']; ?>" required>
        </div>
        <?php if ($_SESSION["user_id"] == $user_id) { ?>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Cambiar contraseña.">
                <ul id="passwordRequirements" class="list-unstyled mt-2" style="display: none;">
                    <li id="lengthRequirement" class="text-danger">Debe tener más de 6 caracteres.</li>
                    <li id="numberRequirement" class="text-danger">Debe tener al menos un número.</li>
                </ul>
        </div>
        <div class="form-group">
            <label for="security-answer">Respuesta a Pregunta de Seguridad - ¿Cuál es su libro favorito?</label>
            <input type="text" class="form-control" id="security-answer0" name="security-answer0" placeholder="Entrar respuesta" value="<?php echo $security_answer0; ?>" required>
        </div>
        <div class="form-group">
            <label for="security-answer">Respuesta a Pregunta de Seguridad - ¿Cuál es el nombre de su madre?</label>
            <input type="text" class="form-control" id="security-answer1" name="security-answer1" placeholder="Entrar respuesta" value="<?php echo $security_answer1; ?>" required>
        </div>
        <div class="form-group">
            <label for="security-answer">Respuesta a Pregunta de Seguridad - ¿Cuál es su animal favorito?</label>
            <input type="text" class="form-control" id="security-answer2" name="security-answer2" placeholder="Entrar respuesta" value="<?php echo $security_answer2; ?>" required>
        </div>
   <?php } if (($_SESSION["user_type"] == "admin") && ($_SESSION["user_id"] != $user_id)) { ?>
        <div class="form-group">
          <label for="community_type">Tipo de Comunidad</label>
          <select class="form-control" id="community_type_drop" name="user-type">
            <option value="outsider" <?php if ($user_row["user_type"] == "outsider") echo "selected"; ?>>Comunidad Externa</option>
            <option value="student" <?php if ($user_row["user_type"] == "student") echo "selected"; ?>>Estudiante</option>
            <option value="teacher" <?php if ($user_row["user_type"] == "teacher") echo "selected"; ?>>Docente</option>
            <option value="admin" <?php if ($user_row["user_type"] == "admin") echo "selected"; ?>>Bibliotecario</option>
          </select>
        </div>

            <div class="form-group" id="pnf_drop_div" style="display: none;">
                <label for="pnf_drop">PNF del Prestatario</label>
                <?php
                echo "<select name='pnf_drop[]' id='pnf_drop' class='form-control'>";
                foreach ($tagArray as $row) {
                    echo "<option value='{$row['name']}'>{$row['name']}</option>";
                }
                echo "</select>";
                ?>
            </div>

    <?php } ?>
        <div class="form-group">
            <label for="contact-number">Teléfono Número de Contacto</label>
            <input type="text" class="form-control" id="contact-number" name="contact-number" placeholder="Entrar número de contacto" value="<?php echo $user_row["contact_number"]; ?>" required>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="edit_user">Editar Usuario</button>
        </div>
    </form>
    <a    <?php if ($_SESSION["user_type"] == "admin") { ?>href="users.php"<?php } else { ?> href="main.php"  <?php } ?> style="padding-left: 8px;">Atrás</a>
</div>

</div>

            </div>
          </div>
        </div>

      </section>
</main>
<script>
document.addEventListener("DOMContentLoaded", function() {

    if (document.getElementById("community_type_drop")) {
        togglePNFDropdown();
    }

          var passwordInput = document.getElementById('password');
        var requirementsList = document.getElementById('passwordRequirements');
        var lengthRequirement = document.getElementById('lengthRequirement');
        var numberRequirement = document.getElementById('numberRequirement');
        var submitButton = document.querySelector('button[name="edit_user"]');

        function validatePassword() {
            var password = passwordInput.value;
            var lengthValid = password.length > 6;
            var numberValid = /\d/.test(password);

            if (password.length > 0) {
                requirementsList.style.display = 'block';
                lengthRequirement.classList.toggle('text-success', lengthValid);
                lengthRequirement.classList.toggle('text-danger', !lengthValid);
                numberRequirement.classList.toggle('text-success', numberValid);
                numberRequirement.classList.toggle('text-danger', !numberValid);
                submitButton.disabled = !lengthValid || !numberValid;
            } else {
                requirementsList.style.display = 'none';
                submitButton.disabled = false; // Allow form submission if no password is entered
            }
        }

        passwordInput.addEventListener('input', validatePassword);
});


function togglePNFDropdown() {
  var userType = document.getElementById("community_type_drop");
    if (!userType) {
        return; // Salir si el dropdown no existe, para que no se dañe el script.
    }
    var pnfDropdown = document.getElementById("pnf_drop_dive");
    var lendStudentPnf = document.getElementById("pnf_drop");

    if (userType.value === "student" || userType.value === "teacher") {
        pnfDropdown.style.display = "block";
    } else {
        pnfDropdown.style.display = "none";
        lendStudentPnf.selectedIndex = 0; // Reset to the first option
    }
}
</script>
<?php include "footer.php"; ?>