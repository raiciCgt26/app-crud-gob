<?php
$passwordError = "";
$passwordConfirmError = "";
$tokenError = "";


$token = isset($_POST["token"]) ? $_POST["token"] : "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($token)) {
    $tokenError = "Token no encontrado. Por favor, envíe un nuevo email de recuperación.";
  } else {
    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "../../../backend/php/dbconnection.php";

    $sql = "SELECT * FROM usuarios
            WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user !== null && isset($user["reset_token_expires_at"])) {
      if (strtotime($user["reset_token_expires_at"]) <= time()) {
        $tokenError = "El token ha expirado. Por favor, envíe un nuevo email de recuperación.";
      }
    } else {
      $tokenError = "Token no encontrado. Por favor, envíe un nuevo email de recuperación.";
    }
  }

  if (strlen($_POST["password"]) < 8) {
    $passwordError = "La contraseña debe tener al menos 8 caracteres";
  }

  if (!preg_match("/[a-z]/i", $_POST["password"])) {
    $passwordError = "La contraseña debe contener al menos una letra";
  }

  if (!preg_match("/[0-9]/", $_POST["password"])) {
    $passwordError = "La contraseña debe contener al menos un número";
  }

  if ($_POST["password"] !== $_POST["password_confirm"]) {
    $passwordConfirmError = "Las contraseñas deben coincidir";
  }

  if ($tokenError === "" && $passwordError === "" && $passwordConfirmError === "") {
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios
            SET password = ?,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("ss", $password_hash, $user["id"]);

    $stmt->execute();
    //// cambie echo x $confirm
    $confirmRest = "Recuperación completa, ingrese con su nueva contraseña.";
  } elseif ($tokenError === "") {
    $tokenError = "Por favor verifique que todos los datos sean correctos";
  }
}
