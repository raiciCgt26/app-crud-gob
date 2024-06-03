<?php

session_start();
$title = "Cubículo";

// Verificar sesión.
if (!isset($_SESSION['loggedin']))
{
    header("Location: index.php");
    exit;
}

include "header.php";
include "connect.php";
?>
<main id="main" class="main">
<div class="container mt-5">
    <h1 class="text-center pagetitle">Bienvenido, <?php echo $_SESSION["user_name"]?>.</h1>
</div>