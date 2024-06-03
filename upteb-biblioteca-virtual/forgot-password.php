<?php

session_start();
$title = "Contraseña Olvidada";
include "header.php";

if (isset($_POST["check-answer"]))
{
    include "connect.php";
        
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $security_answer0 = mysqli_real_escape_string($con, $_POST["security-answer0"]);
    $security_answer1 = mysqli_real_escape_string($con, $_POST["security-answer1"]);
    $security_answer2 = mysqli_real_escape_string($con, $_POST["security-answer2"]);
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) == 1)
    {
        // Verificar respuestas con la tabla y asegurarse que sean correctas
        $row = mysqli_fetch_assoc($result);
        $user_id = $row["user_id"];
        
        $sql = "SELECT * FROM security_answers WHERE user_id = '$user_id'";
        $result = mysqli_query($con, $sql);
        
        $row = mysqli_fetch_assoc($result);
        $security_answer0_db = $row["answer0"];
        $security_answer1_db = $row["answer1"];
        $security_answer2_db = $row["answer2"];
        
        if ($security_answer0 != $security_answer0_db || $security_answer1 != $security_answer1_db || $security_answer2 != $security_answer2_db)
        {
            $error = "Respuestas Equivocadas";
        }
        else
        {
            $row = mysqli_fetch_assoc($result);
            $new_password = uniqid();
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
            
            $sql = "UPDATE users SET password = '$password_hash' WHERE user_id = '$user_id'";
            
            if (mysqli_query($con, $sql))
            {
                $message = "Tu nueva contraseña es: " . $new_password . "\n\nPuede cambiarla en lo que accese sesión.";
            }
            else
            {
                $error = "Error actualizando contraseña. Intente otra vez.";
            }
        }
    }
    else
    {
        $error = "Email o respuesta de seguridad equivocada.";
    }
    
    mysqli_close($con);
}
?>
<style>
  main {
    position: relative;
    z-index: 1; /* Ensure main content is above the background */
  }

  main::before {
    content: "";
    background-image: url('assets/biblioteca_background_stock.jpg');
    background-size: cover;
    background-position: center;
    filter: blur(5px);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Ensure it stays behind the main content */
  }
</style>
<main>
<div class="container mt-5">

        <div class="card">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">¿Olvidó su contraseña?</h5>
                  </div>

    <form action="forgot-password.php" method="post">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresar correo electrónico." required>
        </div>
        <div class="form-group">
            <label for="security-answer">Pregunta de Seguridad - ¿Cuál es su libro favorito?</label>
            <input type="text" class="form-control" id="security-answer0" name="security-answer0" placeholder="Ingresar respuesta." required>
        </div>
        <div class="form-group">
            <label for="security-answer">Pregunta de Seguridad - ¿Cuál es el nombre de su madre?</label>
            <input type="text" class="form-control" id="security-answer1" name="security-answer1" placeholder="Ingresar respuesta." required>
        </div>
        <div class="form-group">
            <label for="security-answer">Pregunta de Seguridad - ¿Cuál es su animal favorito?</label>
            <input type="text" class="form-control" id="security-answer2" name="security-answer2" placeholder="Ingresar respuesta." required>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="check-answer">Verificar</button>
        </div>
    </form>
    <a href="main.php">Atrás</a>
    <?php if (isset($message)) { ?>
    <div class="alert alert-success mt-4" role="alert">
        <?php echo $message; ?>
    </div>
    <?php } ?>
    <?php if (isset($error)) { ?>
    <div class="alert alert-danger mt-4" role="alert">
        <?php echo $error; ?>
    </div>
    <?php } ?>
</div>
</div>
</div>
</main>
<?php include "footer.php"; ?>