<?php

session_start();
$title = "Eliminar Categoría";

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

include "header.php";
include "connect.php";

$tag_id = $_GET['id'];

// Sacar etiquetas de la base de datos... 
$sql = "SELECT * FROM tags WHERE tag_id = '$tag_id'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 0)
{
    header("Location: tags.php");
    exit;
}

// Delete the tag from the book_tags table first.
$sql = "DELETE FROM pub_join_tags WHERE tag_id = '$tag_id'";
if (mysqli_query($con, $sql))
{
    // Eliminar la etiqueta
    $sql = "UPDATE tags SET removed = 1 WHERE tag_id = '$tag_id'";
    if (mysqli_query($con, $sql))
    {
        $success = "Categoría eliminado exitósamente.";
        audit_log(AuditAction::TagDelete, null, null, $tag_id);
    }
    else
    {
        $error = "Algo salió mal...";
    }
}
else
{
    $error = "Algo salió mal...";
}
mysqli_close($con);

?>
<main id="main" class="main">
<div class="container mt-5">
    <h2 class="text-center">Eliminar Etiqueta.</h2>
    <a href="tags.php">Atrás</a>
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