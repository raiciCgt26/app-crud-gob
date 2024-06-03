<?php

session_start();
$title = "Editar Categoría";
include "header.php";

// Verificar que el usuario sea administrador.
if (!isset($_SESSION['loggedin']) || $_SESSION["user_type"] !== "admin")
{
    header("Location: index.php");
    exit;
}

$errors = [];

include "connect.php";

$tag_id = $_GET['id'];

// Sacar detalles de etiqueta de la base de datos.
$sql = "SELECT * FROM tags WHERE tag_id = '$tag_id' AND removed = 0";
$result = mysqli_query($con, $sql);

// Asegurarse que la etiqueta exista
if (mysqli_num_rows($result) == 0)
{
    header("Location: tags.php");
    exit;
}

$row = mysqli_fetch_assoc($result);

if (isset($_POST['edit_tag']))
{
    // Agarrar detalles nuevos de etiqueta.
    $tag_name = $_POST['name'];
    $tag_description = $_POST['description'];

    // Que la información sea válida.
    if (empty($tag_name))
    {
        $errors[] = "Nombre de categoría requerido.";
    }

    // Asegurarse que no hayan etiquetas repetidas
    $sql = "SELECT * FROM tags WHERE name = '$tag_name' AND tag_id != '$tag_id'";

    if (mysqli_num_rows(mysqli_query($con, $sql)) > 0)
    {
        $errors[] = "Ya existe una categoría con el mismo nombre.";
    }
    
    // Si no hay errores...
    if (empty($errors))
    {
        // Preparar la actualización de base de datos.
        $sql = "UPDATE tags SET name = '$tag_name', description = '$tag_description' WHERE tag_id = '$tag_id'";

        // Ejecutar y crear mensaje.
        if (mysqli_query($con, $sql))
        {
            $success = "Categoría actualizada exitósamente.";
            audit_log(AuditAction::TagEdit, null, null, $tag_id);
        }
        else
        {
            $errors[] = "Algo salió mal...";
        }

        // Re-agarrar detalles de la base de datos de etiqueta.
        $sql = "SELECT * FROM tags WHERE tag_id = '$tag_id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

    }

    mysqli_close($con);
}
?>
<main id="main" class="main">
<div class="container mt-5">
   <section class="section register min-vh-100 d-flex flex-column justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-xl-6 d-flex flex-column justify-content-center">
    <?php if (isset($success)) { ?>
        <div class="alert alert-success mt-4">
            <?php echo $success; ?>
        </div>
    <?php } ?>
    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger mt-4">
            <?php foreach ($errors as $error) { ?>
                <div><?php echo $error; ?></div>
            <?php } ?>
        </div>
    <?php } ?>
           <div class="card">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Editando Categoría</h5>
                  </div>
    <form action="edit-tag.php?id=<?php echo $tag_id; ?>" method="post">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Entrar nombre" value="<?php echo $row['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea type="text" class="form-control" id="description" name="description" placeholder="Entrar descripción"><?php echo $row['description']; ?></textarea>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="edit_tag">Editar Categoría</button>
        </div>
    </form>
    <a href="tags.php" style="padding-left: 8px;">Atrás</a>
</div>
</div>
            </div>
          </div>
        </div>
      </section>
</main>
<?php include "footer.php"; ?>