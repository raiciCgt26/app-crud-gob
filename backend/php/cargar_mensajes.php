<?php
session_start();

if (isset($_SESSION['username'])) {
  include('C:\xampp\htdocs\backend\php\dbconnection.php');

  $sender = $_SESSION['username'];

  // Verifica si se ha enviado el valor 'receiver' a través de POST o GET
  $receiver = isset($_POST['receiver']) ? mysqli_real_escape_string($con, $_POST['receiver']) : (isset($_GET['receiver']) ? mysqli_real_escape_string($con, $_GET['receiver']) : '');

  // Verifica si se ha proporcionado un valor de receptor válido
  if (!empty($receiver)) {
    $output = "";

    $sql = "SELECT * FROM `mensajes` WHERE (sender='$sender' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$sender') ORDER BY id";

    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) > 0) {
      while ($row = mysqli_fetch_assoc($query)) {
        if ($row['sender'] === $sender) {
          $output .= '<div class="chat outgoing">
  <div class="details">
    <p>' . $row['message'] . '</p>
  </div>
</div>';
        } else {
          // Verificar si la clave 'file' está definida en el array $row antes de acceder a ella
          // $file = isset($row['file']) ? $row['file'] : ''; // Asignar un valor predeterminado en caso de que 'file' no esté definido
          $output .= '<div class="chat incoming">
        <div class="details">
    <p>' . $row['message'] . '</p>
  </div>
</div>';
        }
      }
    } else {
      $output .= '<div class="text">No hay mensajes disponibles.</div>';
    }
    echo $output;
  } else {
    echo "Error: No se ha proporcionado un destinatario válido.";
  }
} else {
  echo "Error: No se ha iniciado sesión.";
  exit();
}
