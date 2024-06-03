<?php

session_start();
$title = "Eliminar Libro";
include "header.php";

// Asegurarse que la sesión este activa.
if (!isset($_SESSION['loggedin']))
{
    header("Location: index.php");
    exit;
}

if ($_SESSION["user_type"] == "student")
{
  header("Location: cubicle.php");
  exit;
}

include "connect.php";

$pub_id = $_GET['id'];

// Sacar publicaciones de la base de datos... (Esto es basicamente lo mismo que en edit y en agregar, me estoy repetiendo mucho.)
$sql = "SELECT * FROM publications WHERE pub_id = '$pub_id'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0)
{
    header("Location: index.php");
    exit;
}

//Vamos a hacer las tres cosas en una transacción para que así sea más facil de procesar
$con->begin_transaction();
try
{
// Eliminar etiquetas de la publicación
$sql = "DELETE FROM pub_join_tags WHERE pub_id = '$pub_id'";
mysqli_query($con, $sql);

//Eliminar las fuentes de la publicación
$sql2 = "DELETE FROM cited_sources WHERE pub_id = '$pub_id'";
mysqli_query($con, $sql2);
//Eliminar las cotas de la publicación.
$sql3 = "DELETE FROM pub_cota_data WHERE pub_id = '$pub_id'";
mysqli_query($con, $sql3);

// Eliminar la propia publicación
$sql4 = "UPDATE publications SET removed = 1 WHERE pub_id = '$pub_id'";
mysqli_query($con, $sql4);

$con->commit();

$success = "Libro eliminado exitósamente.";
audit_log(AuditAction::BookDelete, $pub_id, null, null);

} catch (Exception $e) {
            // Revertir la transacción si algo sale mal.
            $con->rollback();
            $errors[] = "Algo salió mal...";
}
mysqli_close($con);


?>
<main id="main" class="main">
<div class="container mt-5">
    <h2 class="text-center">Eliminar Libro.</h2>
    <a href="main.php">Atrás</a>
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