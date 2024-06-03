<?php

session_start();
$title = "Eliminar usuario.";
include "header.php";

// Asegurar que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

include "connect.php";

$user_id = $_GET['id'];

// Sacar detalles de la base de datos.
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);

// Asegurarse que exista.
if (mysqli_num_rows($result) == 0)
{
    header("Location: users.php");
    exit;
}

// Sacar nombre de usuario y si es autoregistrado o no de usuario.
$user = mysqli_fetch_assoc($result);
$username = $user["username"];
$adhoc = $user["auto_register"];

// Asegurarse que no somos el usuario que vamos a borrar.
if ($_SESSION["user_name"] == $username) {
    $error = "¡No puedes borrarte a ti mismo!";
} else {

    //Vamos a hacer las tres cosas en una transacción para que así sea más facil de procesar
    $con->begin_transaction();
    try
    {
        // Obtener los book_act_id de los tickets a eliminar.
        $sql_select = "SELECT book_act_id FROM pub_lending WHERE focus_user_id = '$user_id'";
        $result = mysqli_query($con, $sql_select);

        // Verificar si se encontraron tickets.
        if (mysqli_num_rows($result) > 0) {
            $bookActIds = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $bookActIds[] = $row['book_act_id'];
            }

            // Eliminar registros de pub_lent_cotas basado en los book_act_id.
            $bookActIdsStr = implode(',', $bookActIds);
            $sql_delete_cotas = "DELETE FROM pub_lent_cotas WHERE pub_lend_id IN ($bookActIdsStr)";
            mysqli_query($con, $sql_delete_cotas);
        }

        // Eliminar todos los tickets de préstamo donde se encuentra el usuario.
        $sql_delete_lending = "DELETE FROM pub_lending WHERE focus_user_id = '$user_id'";
        mysqli_query($con, $sql_delete_lending);

        if ($adhoc < 1)
        {
        //Eliminar las preguntas de seguridad si no es usuario autoregistrado.
        $sql2 = "DELETE FROM security_answers WHERE user_id = '$user_id'";
        mysqli_query($con, $sql2);
        }


    // Eliminar el propio usuario.
    $sql3 = "DELETE FROM users WHERE user_id = '$user_id'";
    mysqli_query($con, $sql3);

    $con->commit();

    $success = "Usuario eliminado exitósamente.";
    audit_log(AuditAction::UserDelete, null, $user_id, null);

    } catch (Exception $e) {
                // Revertir la transacción si algo sale mal.
                $con->rollback();
                $errors[] = "Algo salió mal...";
    }

}

mysqli_close($con);


?>
<main id="main" class="main">
<div class="container mt-5">
    <h2 class="text-center">Eliminar usuario.</h2>
    <a href="users.php">Atrás</a>
    <?php if (isset($success)) { ?>
        <div class="alert alert-success mt-4">
            <?php echo $success; ?>
        </div>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger mt-4">
            <?php echo $error; ?>
        </div>
    <?php } ?>
</div>
</main>
<?php include "footer.php"; ?>