<?php
session_start();
include "connect.php";

if ($stmt = $con->prepare("SELECT user_id, user_type, username, password FROM users WHERE email = ? AND auto_register < 1")) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['user_email']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

   // Asegurarse que el usuario existá y la contraseña sea correcta.
    if ($stmt->num_rows > 0)
    {
        $stmt->bind_result($user_id, $user_type, $username, $password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password))
        {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION["user_name"] = $username;
            $_SESSION["user_type"] = $user_type;
            $_SESSION["user_id"] = $user_id;
            header("Location: dashboard.php");
        }
        else
        {
            $error = "Nombre o contraseña incorrecta";
            header("Location: index.php");
        }
    }
    else
    {
        $error = "Nombre o contraseña incorrecta.";
        header("Location: index.php");
    }

    $stmt->close();

    //mysqli_close($con);

 
}

?>