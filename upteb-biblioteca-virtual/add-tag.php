<?php

session_start();
$title = "Agregar Categoría";

// Verificar sesión.
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

$errors = [];

// Asegurarse que el formulario este completo
if (isset($_POST["add_tag"]))
{
    include "connect.php";

    // Conseguir datos de formulario.
    $tag_name = mysqli_real_escape_string($con, $_POST["name"]);
    $tag_description = mysqli_real_escape_string($con, $_POST["description"]);
    $tag_category = $_POST["tag_category"];


    // Asegurarse que el usuario entró datos correctos.
    if (empty($tag_name))
    {
        $errors[] = "Nombre de etiqueta requerido.";
    }

    // Asegurarse que el usuario entró datos correctos.
    if (empty($tag_category))
    {
        $errors[] = "Tipo de etiqueta requerido.";
    }


    // Asegurarse que no hayan etiquetas repetidas.
    $query = "SELECT * FROM tags WHERE removed = 0 AND name='$tag_name'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0)
    {
        $errors[] = "Nombre de etiqueta ya ocupado.";
    }
    
    // Si no hay errores...
    if (empty($errors))
    {
      // Y a la base de datos te vas
        $query = "INSERT INTO tags (name, tag_category, description) VALUES ('$tag_name', '$tag_category', '$tag_description')";
        $result = mysqli_query($con, $query);
        $tag_id = $con->insert_id;
        if ($result)
        {
            $success = "Categoría agregada exitosamente!";
            audit_log(AuditAction::TagNew, null, null, $tag_id);
        }
        else
        {
            $errors[] = "Algo salió mal...";
        }
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
                    <h5 class="card-title text-center pb-0 fs-4">Agregando Categoría</h5>
                  </div>

    <form action="add-tag.php" method="post">
        <label for="tag_category">Tipo de Etiqueta</label><br>
        <div class="form-group text-center">
            <div class="btn-group" role="group" aria-label="Tipo de Etiqueta">
                <input type="radio" class="btn-check" name="tag_category" id="tag_category_pnf" value="PNF" checked>
                <label class="btn btn-outline-primary" for="tag_category_pnf">PNF</label>
                
                <input type="radio" class="btn-check" name="tag_category" id="tag_category_sede" value="Ubicación">
                <label class="btn btn-outline-primary" for="tag_category_sede">Sede</label>
            </div>
        </div>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Entrar nombre" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea type="text" class="form-control" id="description" name="description" placeholder="Entrar descripción"></textarea>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="add_tag">Agregar Categoría</button>
        </div>
    </form>
        </div>
    <a href="tags.php" style="padding-left: 8px;">Atrás</a>
</div>

            </div>
          </div>
        </div>

      </section>
</main>
<?php include "footer.php"; ?>