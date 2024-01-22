<?php
$con = mysqli_connect("localhost", "root", "", "app");

if (mysqli_connect_errno()) {
  echo "conexion fallida" . mysqli_connect_errno();
}
