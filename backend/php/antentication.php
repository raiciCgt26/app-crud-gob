<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!$_SESSION['username']) {
  header("location: /frontend/view/login.php");
  exit();
}
