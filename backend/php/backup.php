<?php
// Conexión a la base de datos
$host = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'app';
$con = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

// Verificar la conexión
if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Nombre del archivo de respaldo
$backup_file = 'copia_de_seguridad.sql';

// Crear archivo de respaldo
$file_handler = fopen($backup_file, 'w');

// Obtener lista de tablas
$tables = array();
$result = mysqli_query($con, 'SHOW TABLES');
while ($row = mysqli_fetch_row($result)) {
  $tables[] = $row[0];
}

// Recorrer las tablas y generar el respaldo
foreach ($tables as $table) {
  // Agregar estructura de la tabla al respaldo
  $result = mysqli_query($con, 'SHOW CREATE TABLE ' . $table);
  $row = mysqli_fetch_row($result);
  fwrite($file_handler, "\n\n" . $row[1] . ";\n\n");

  // Agregar datos de la tabla al respaldo
  $result = mysqli_query($con, 'SELECT * FROM ' . $table);
  while ($row = mysqli_fetch_row($result)) {
    $line = '';
    foreach ($row as $value) {
      if (isset($value)) {
        $line .= "'" . mysqli_real_escape_string($con, $value) . "',";
      } else {
        $line .= "'',";
      }
    }
    fwrite($file_handler, "INSERT INTO $table VALUES(" . rtrim($line, ',') . ");\n");
  }
}

// Cerrar archivo de respaldo
fclose($file_handler);

// Mostrar mensaje de éxito

echo "<script>window.onload = function() { mostrarModalCopiaSeguridad(); }</script>";

// Descargar el archivo de respaldo
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="copia_de_seguridad.sql"');
readfile($backup_file);
exit;

// Cerrar la conexión
mysqli_close($con);
