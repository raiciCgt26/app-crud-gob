<?php
session_start(); // Inicia la sesión
include('C:\xampp\htdocs\backend\php\dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
  $id = intval($_GET['id']); // Convertir el ID a un entero

  if ($id > 0) {
    // Ejecuta una consulta para deshabilitar al usuario
    $query = mysqli_query($con, "UPDATE usuarios SET activo = 0 WHERE id = '$id'");

    if ($query) {
      // Si la consulta se ejecuta con éxito, muestra un mensaje de éxito
      echo json_encode(['success' => true]);
    } else {
      // Si hay un error, muestra un mensaje de error
      echo json_encode(['success' => false, 'message' => 'Error al deshabilitar el usuario']);
    }
  } else {
    // Si el ID no es un entero válido, muestra un mensaje de error
    echo json_encode(['success' => false, 'message' => 'ID de usuario no válido']);
  }
}
