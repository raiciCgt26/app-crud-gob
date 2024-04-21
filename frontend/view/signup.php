<?php
include("/xampp/htdocs/backend/php/dbconnection.php");
$nameError = "";
$emailError = "";
$passwordError = "";
$rolError = "";
$phoneError = "";
$descriptionError = "";
$fileError = "";

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $description = $_POST['description'];
  $file = $_FILES['file']['name'];
  $tempname = $_FILES['file']['tmp_name'];
  $folder = '/frontend/aseets/image';


  if (isset($_POST['role_id_fk']) && $_POST['role_id_fk'] !== '') {
    $rol = $_POST['role_id_fk'];
  } else {
    $rolError = "Por favor, seleccione un rol válido";
  }

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

  // Validaciones para el número de teléfono
  if (empty($phone)) {
    $phoneError = "Su número de teléfono es obligatorio, no olvide el guion 0414-1234567";
  } else {
    $phone = trim($phone);
    if (!preg_match("/^(0414|0424|0416|0426|0412)[-\/]\d{7}$/", $phone)) {
      $phoneError = "El número de teléfono debe tener el formato correcto (por ejemplo, 0414-1234567 o 0424/0416/0426/0412/)";
    }
  }

  // Validaciones para la institución
  if (empty($description)) {
    $descriptionError = "El nombre de la institución es obligatorio";
  }

  $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
  // Verificar si el archivo se subió correctamente antes de intentar obtener su tipo de imagen
  if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES['file']['tmp_name'])) {
    $fileError = "Error al subir el archivo.";
  } else {
    // Verificar si el archivo es una imagen
    $tipoImagen = exif_imagetype($_FILES['file']['tmp_name']);
    if ($tipoImagen === false || !in_array(image_type_to_extension($tipoImagen, false), $extensionesPermitidas)) {
      $fileError = "Por favor selecciona un archivo de imagen válido (jpg, jpeg, png, gif).";
    }
  }

  // Mover la imagen al directorio de destino
  if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $folder . '/' . $file);
  }

  // Hashear la contraseña
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


  // Si todas las validaciones pasan, proceder con la inserción en la base de datos
  if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($rolError) && empty($phoneError) && empty($descriptionError) && empty($fileError)) {
    require('/xampp/htdocs/backend/php/dbconnection.php');

    // Verificar si el nombre de usuario o correo ya existen
    $checkUserEmailQuery = "SELECT * FROM `usuarios` WHERE `username`='$username' OR `email`='$email'";
    $checkUserEmailResult = mysqli_query($con, $checkUserEmailQuery);

    if (mysqli_num_rows($checkUserEmailResult) > 0) {
      echo "<script>document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('myModalInfo').style.display = 'block';
  });</script>";
    } else {

      // Insertar en la base de datos
      $username = mysqli_real_escape_string($con, $username);
      $email = mysqli_real_escape_string($con, $email);
      $rol = mysqli_real_escape_string($con, $rol);
      $phone = mysqli_real_escape_string($con, $phone);
      $description = mysqli_real_escape_string($con, $description);
      $file = mysqli_real_escape_string($con, $file);
      // Cambiar el estado del usuario a "desconectado"
      $status = "desconectado";

      $sql = "INSERT INTO `usuarios` (`username`, `email`,`password`,`role_id_fk`, `phone`, `description`, `file`, `status`) VALUES ('$username', '$email', '$hashedPassword', '$rol', '$phone', '$description','$file', '$status')";
      $result = mysqli_query($con, $sql);

      if ($result) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('myModalSuccess').style.display = 'block';
  });</script>";
      } else {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('myModalError').style.display = 'block';
  });</script>";
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
  <link rel="shortcut icon" href="/frontend/aseets/img/logo-gob2.png" />
  <link rel="stylesheet" href="/frontend/aseets/css/login-signup.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/try-error.css" />

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
          <h2 class="sign">Crear una cuenta</h2>
          <div class="icons">
            <form class="form" action="" method="POST" enctype="multipart/form-data">
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
                <label class="field input" for="pwd">
                  <img src="../aseets/icons/bx-lock-alt.svg" />
                  <input type="password" placeholder="Escribe tu contraseña" name="password" id="password-reg" />
                  <img class="eye" src="/frontend/aseets/icons/eye.svg" alt="">
                </label>
                <span class="form-error">
                  <?php echo $passwordError ?>
                </span>
              </p>

              <p>
                <label for="rol">
                  <img src="../aseets/icons/bx-search-alt-2.svg" />
                  <select name="role_id_fk" id="rol">
                    <option selected disabled>-----Seleccionar rol-----</option>
                    <?php
                    $rolesfetchQuery = "SELECT * FROM `roles` WHERE roles != 'Admin';";
                    $resul = mysqli_query($con, $rolesfetchQuery);
                    $adminQuery = "SELECT * FROM `usuarios` WHERE `role_id_fk` = 1 LIMIT 1"; // Selecciona el rol 'Admin'
                    $adminResult = mysqli_query($con, $adminQuery);
                    $adminExists = mysqli_num_rows($adminResult) > 0;

                    while ($row = mysqli_fetch_assoc($resul)) {
                    ?>
                      <option value="<?php echo $row['id'] ?>">
                        <?php echo $row['roles'] ?>
                      </option>
                    <?php
                    }

                    if (!$adminExists) {
                    ?>
                      <option value="1">Admin</option> <!-- Si no existe el rol 'Admin' en la tabla usuarios, se añade como opción -->
                    <?php
                    }
                    ?>
                  </select>
                </label>



                <span class=" form-error">
                  <?php echo $rolError ?>
                </span>

              </p>


              <p>
                <label for="phone">
                  <img src="../aseets/icons/pen.svg" />
                  <input type="text" placeholder="Escribe tu numero de telefono" name="phone" />
                </label>
                <span class="form-error">
                  <?php echo $phoneError  ?>
                </span>
              </p>

              <p>
                <label for="description">
                  <img src="../aseets/icons/bx-home.svg" />
                  <input type="text" placeholder="Escriba su institucion" name="description" />
                </label>
                <span class="form-error">
                  <?php echo $descriptionError ?>
                </span>
              </p>

              <p>
                <label for="file">
                  <input type="file" name="file" />
                </label>
                <span class="form-error">
                  <?php echo $fileError ?>
                </span>
              </p>


              <input class="btn-login log" name="submit" type="submit" value="Registrarse" />
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- Modal para registro exitosp-->
  <div id="myModalSuccess" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p class="text-2">Registro exitoso ahora puedes iniciar sesión.</p>
    </div>
  </div>

  <!-- Modal para registro fallido-->
  <div id="myModalError" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p class="text-2">Error en el registro. Intente nuevamente.</p>
    </div>
  </div>

  <!-- Modal para informacion-->
  <div id="myModalInfo" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p class="text-2">El nombre de usuario o correo electrónico ya están en uso.</p>
    </div>
  </div>


  <script src="../aseets/js/login-signup.js"></script>
  <script src="/frontend/aseets/js/try-error.js"></script>
</body>

</html>