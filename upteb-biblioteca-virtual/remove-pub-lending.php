<?php

session_start();
$title = "Eliminar préstamo.";
include "header.php";

// Asegurar que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

include "connect.php";

$ba_id = $_GET['id'];

// Sacar detalles de la base de datos.
$sql = "SELECT * FROM pub_lending WHERE book_act_id = '$ba_id'";
$result = mysqli_query($con, $sql);

// Asegurarse que exista.
if (mysqli_num_rows($result) == 0)
{
    header("Location: pub-lending-tickets.php");
    exit;
}

// Sacar nombre de usuario y si es autoregistrado o no de usuario.
$pl_data = mysqli_fetch_assoc($result);
$user_id = $pl_data["focus_user_id"];
$pub_id = $pl_data["focus_pub_id"];



    //Vamos a hacer las dos cosas en una transacción por conveniencia
    $con->begin_transaction();
    try
    {
        // Eliminar todos los tickets de préstamo donde se encuentra el usuario.
        $sql_delete_cota = "DELETE FROM pub_lent_cotas WHERE pub_lend_id = '$ba_id'";
        if (!mysqli_query($con, $sql_delete_cota)) {
            throw new Exception("Error al eliminar cotas: " . mysqli_error($con));
        }

        // Eliminar todos los tickets de préstamo donde se encuentra el usuario.
        $sql_delete_lending = "DELETE FROM pub_lending WHERE focus_user_id = '$ba_id'";
        if (!mysqli_query($con, $sql_delete_lending)) {
            throw new Exception("Error al eliminar préstamo: " . mysqli_error($con));
        }

        // Commit the transaction
        $con->commit();

        $success = "Ticket de préstamo eliminado exitósamente.";
        audit_log(AuditAction::PubLendDelete, $pub_id, $user_id, null);

    } catch (Exception $e) {
        // Revertir la transacción si algo sale mal.
        $con->rollback();
        $error = "Algo salió mal: " . $e->getMessage();
    }



mysqli_close($con);


?>
<main id="main" class="main">
<div class="container mt-5">
    <h2 class="text-center">Eliminar usuario.</h2>
    <a href="pub-lending-tickets.php">Atrás</a>
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