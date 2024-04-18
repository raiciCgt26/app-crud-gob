
<?php
session_start();
require('/xampp/htdocs/backend/php/dbconnection.php');

if (session_destroy()) {
  // Cambiar el estado del usuario a "desconectado"
  $username = $_SESSION['username'];
  $status = "desconectado";

  $sql = "UPDATE `usuarios` SET `status`='$status' WHERE `username`='$username'";
  $result = mysqli_query($con, $sql);

  if ($result) {
    header("Location: /frontend/view/signup.php");
  } else {
    // Manejar el error de actualización
    echo "Error al actualizar el estado del usuario";
  }
}
?>
