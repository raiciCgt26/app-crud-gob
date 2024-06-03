<?php
session_start();
$title = "Creación de Respaldo";

include "header.php";

// Asegurarse que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

include "connect.php";
 	

$server=$servername;
$us=$username;
$clave=$password;
$db=$dbname;
  

$success = "Respaldo generado exitósamente. Puede encontrarlo en ";

$error = "Algo salió mal...";

$foldername = __DIR__ . "/backup";

//exportarTablas($server,$us,$clave,$db);
?>


<main id="main" class="main">
<div class="container mt-5">
    <h2 class="text-center">Creación de Respaldo.</h2>
    <a href="backups.php">Atrás</a>
    <?php if ($_SESSION["user_type"] == "admin") { ?>
        <div class="alert alert-success mt-4">
            <?php echo $success; echo $foldername;
        exportarTablas($server,$us,$clave,$db);
        audit_log(AuditAction::BackupMake, null, null, null);?>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger mt-4">
            <?php echo $error; ?>
        </div>
    <?php } ?>
</div>
</main>
<?php include "footer.php"; ?>