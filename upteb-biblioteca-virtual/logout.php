<?php

$title = "Redireccionando....";
include "header.php";
session_start();

unset($_SESSION['username']);
session_destroy();

echo '<br><br><div class="container"><h3 class="text-center">Sesión cerrada.</h3></div>';
echo '<script>setTimeout(function () { window.location.href = "index.php";}, 2000);</script>';

//include "footer.php";
?>