<?php
session_start();

if (session_destroy()) {

  header("Location: /frontend/view/signup.php");
}
