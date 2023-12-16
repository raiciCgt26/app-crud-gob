<?php
require('./link.php');

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Buscar el usuario en la base de datos
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
  // Verificar contraseña
  if (password_verify($password, $user['password'])) {
    // La contraseña es correcta, puedes iniciar sesión aquí
    session_start();
    $_SESSION['user_id'] = $user['id'];
    echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
  } else {
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
}
