<?php

session_start();

if (!$_SESSION['username']) {
  header("location: /frontend/view/login.php");
  exit();
}
