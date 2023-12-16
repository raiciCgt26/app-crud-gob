<?php
require('./link.php');

// Obtener datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash del password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Consulta para insertar el usuario en la base de datos
$query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

if (mysqli_query($conn, $query)) {
  echo json_encode(["success" => true, "message" => "Usuario registrado exitosamente"]);
} else {
  echo json_encode(["success" => false, "message" => "Error al registrar el usuario"]);
}
