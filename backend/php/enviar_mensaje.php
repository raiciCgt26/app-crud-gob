<?php
session_start();
include("/xampp/htdocs/backend/php/dbconnection.php");
include("/xampp/htdocs/backend/php/antentication.php");

// Verificar que se haya iniciado sesión
if (!isset($_SESSION['username'])) {
  echo "Error: No se ha iniciado sesión.";
  exit();
}

// Obtener el nombre de usuario del usuario que inició sesión
$username = $_SESSION['username'];
echo "Nombre de usuario: " . $username . "<br>";

// Obtener los datos del usuario que inició sesión
$sql = "SELECT * FROM `usuarios` WHERE username = '$username'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$nombreUsuario = $row['username'];
$imagenUsuario = '/frontend/aseets/image/' . $row['file'];
echo "Nombre de usuario obtenido de la base de datos: " . $nombreUsuario . "<br>";

// Verificar que se haya especificado el destinatario del chat
if (!isset($_POST['receiver']) || !isset($_POST['message'])) {
  echo "Error: Datos insuficientes.";
  exit();
}

$receiver = mysqli_real_escape_string($con, $_POST['receiver']);
$message = mysqli_real_escape_string($con, $_POST['message']);

// Insertar el mensaje en la base de datos
$sql = "INSERT INTO `mensajes` (`sender`, `receiver`, `message`) VALUES ('$username', '$receiver', '$message')";
$result = mysqli_query($con, $sql);

if ($result) {
  echo "Mensaje enviado correctamente.";
} else {
  echo "Error al enviar el mensaje: " . mysqli_error($con);
}
