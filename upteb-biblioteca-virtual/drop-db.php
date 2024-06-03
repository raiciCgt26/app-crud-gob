<?php

// Drop it
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_local_upteb_biblioteca";

$con = mysqli_connect($servername, $username, $password);

$sql = "DROP DATABASE " . $dbname;

if (mysqli_query($con, $sql))
{
    echo "Base de datos eliminada exitósamente<br>";
}
else
{
    echo "Error eliminando base de datos: " . mysqli_error($con) . "<br>";
}

?>