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
$backup_file = 'D:\Descargas\copia_de_seguridad.sql';

// Abrir el archivo de respaldo
$file_content = file_get_contents($backup_file);

// Separar las consultas por punto y coma
$queries = explode(';', $file_content);

// Ejecutar cada consulta

foreach ($queries as $query) {


  if (trim($query) != '') {


    // Comprobar si la tabla ya existe antes de crearla


    $table_name = get_table_name($query);


    if (!table_exists($table_name, $con)) {


      if (!mysqli_query($con, $query)) {




        die('Error restoring database: ' . mysqli_error($con));
      }
    }
  }
}



// Mostrar mensaje de éxito después de que la página haya cargado completamente
echo "<script>
    window.onload = function() {
        var modalRestauracion = document.getElementById('modalRestauracion');
        if (modalRestauracion) {
            modalRestauracion.style.display = 'block';
        }
    };
</script>";


// Cerrar la conexión
mysqli_close($con);


// Función para obtener el nombre de la tabla de una consulta CREATE TABLE
function get_table_name($query)
{
  preg_match('/CREATE TABLE `(.*)`/', $query, $matches);
  return isset($matches[1]) ? $matches[1] : '';
}

// Función para comprobar si una tabla existe en la base de datos
function table_exists($table_name, $con)
{
  $result = mysqli_query($con, "SHOW TABLES LIKE '$table_name'");
  return mysqli_num_rows($result) > 0;
}
