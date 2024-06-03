<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_local_upteb_biblioteca";

// Crear conexión.
if (!isset($con))
{
    $con = mysqli_connect($servername, $username, $password, $dbname);

    if (!$con)
    {
        die("Conexión Fallida: " . mysqli_connect_error());
    }
    include "functions.php";
}

?>