<?php

session_start();
$title = "Editar Libro";

// Que el usuario esté en sesión
if (!isset($_SESSION['loggedin'])) {
  header("Location: index.php");
  exit;
}

if ($_SESSION["user_type"] == "student") {
  header("Location: cubicle.php");
  exit;
}


include "header.php";

include "connect.php";

$errors = [];

//Agarrar todos los tags y su id...
$sqlSelect = "SELECT tag_id, name FROM tags WHERE tag_category = 'PNF' AND removed = 0";
$queryResult = mysqli_query($con, $sqlSelect);

//Establecer un arreglo vacío
$tagArray = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult, MYSQLI_ASSOC)) {
  array_push($tagArray, $row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult);

//Lo hacemos otra vez pero para las sedes
$sqlSelect2 = "SELECT tag_id, name FROM tags WHERE tag_category = 'Ubicación' AND removed = 0";
$queryResult2 = mysqli_query($con, $sqlSelect2);

//Establecer un arreglo vacío
$tagArray2 = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult2, MYSQLI_ASSOC)) {
  array_push($tagArray2, $row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult2);

//Y una vez más pero para el typo de documento.
$sqlSelect3 = "SELECT tag_id, name FROM tags WHERE tag_category = 'Documento' AND removed = 0";
$queryResult3 = mysqli_query($con, $sqlSelect3);

//Establecer un arreglo vacío
$docTypeArray = array();

//Este while loop basicamente llena el array de arriba con los resultados de $sqlSelect, o sea, con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($queryResult3, MYSQLI_ASSOC)) {
  array_push($docTypeArray, $row);
}

//Y liberamos la memoría
mysqli_free_result($queryResult3);

$isThesis = false; //Voy a utilizar esto para chequear si es tesis o no y de esa manera correr updateFields() y cambiar el curMode inmediatamente.
$hasCota = true; //Voy a utilizar esto para verificar si tiene cotas, que debería por defecto. Y si no, automaticamente cambiar a modo sin cotas.
$quantNumber = 0; //Pasale la cantidad original de este libro al número para pasarlo a javascript y hacer que se cambie a modo cantidad inmediatamente, guardando el número.
// Variable para que el primer botón este activo por defecto.
$firstButton = true;

$isSubmittedAsThesis = false; //Esto chequea si la versión final al ser ingresada es tesis o no.

//Luego viene el resto del código

$pub_id = $_GET['id'];

// Agarrar detalles de libro de la base de datos.
$sql = "SELECT * FROM publications WHERE pub_id = '$pub_id' AND removed = 0";
$result = mysqli_query($con, $sql);

// Asegurarse que el libro exista.
if (mysqli_num_rows($result) == 0) {
  header("Location: index.php");
  exit;
}

$edit_row = mysqli_fetch_assoc($result);


$quantNumber = $edit_row["quantity"];

// Agarrar detalles de libro de la base de datos.
$sqlSources = "SELECT * FROM cited_sources WHERE pub_id = '$pub_id'";
$resultSources = mysqli_query($con, $sqlSources);
$resultSources = mysqli_fetch_all($resultSources, MYSQLI_ASSOC);

// Agarrar detalles de libro de la base de datos.
$sqlCota = "SELECT * FROM pub_cota_data WHERE pub_id = '$pub_id'";
$resultCotas = mysqli_query($con, $sqlCota);
$resultCotas = mysqli_fetch_all($resultCotas, MYSQLI_ASSOC);


if (empty($resultCotas)) {
  $hasCota = false;
}



// Conseguir las etiquetas existentes en el libro actual
$query = "SELECT * FROM pub_join_tags WHERE pub_id = " . $pub_id;
$tag_ids = mysqli_query($con, $query);
$tag_ids = mysqli_fetch_all($tag_ids, MYSQLI_ASSOC);
$tag_ids = array_column($tag_ids, "tag_id");

// Y de allí extrapolar las etiquetas desde su propia tabla.
if (count($tag_ids) > 0) {
  $query = "SELECT * FROM tags WHERE tag_id IN (" . implode(", ", $tag_ids) . ")";
  $tags = mysqli_query($con, $query);
  $tags = mysqli_fetch_all($tags, MYSQLI_ASSOC);
  $tags = array_column($tags, "name", "tag_category");
}

if (isset($_POST['edit_book'])) {
  // Agarrar los detalles modificados.

  $name = $_POST['name'];
  $description = $_POST['description'];

  $tag_ids = $_POST['tags'];
  $tags_new = $tag_ids;

  if (empty($cota)) {
    //Aqui simplemente agarramos el arreglo entero
    $cota = $_POST['cota'];
    //Y los prefixes.    
    if (isset($_POST['prefix_string'])) {
      $prefix_string = $_POST['prefix_string'];
    } else {
      $prefix_string = "";
    }
  }

  if (isset($_POST['cited_source_type'])) {
    $cited_source_types = $_POST['cited_source_type'];
  } else {
    $cited_source_types = "";
  }

  if (isset($_POST['cited_source_name'])) {
    $cited_source_names = $_POST['cited_source_name'];
  } else {
    $cited_source_names = "";
  }


  // Determinar que tantas fuentes el usuario ha agregado
  if (is_countable($cited_source_types)) {
    $s_array_length = count($cited_source_types);
  }
  if (isset($cota)) {
    //Y que tantas cotas.
    $cota_array_length = count($cota);
  } else {
    $cota_array_length = 0;
  }

  //Este loop va por cada elemento del arreglo cota y verifica que sea un número positivo y que no esté vacío.
  if ($cota_array_length > 0) {
    foreach ($_POST['cota'] as $cotaEntry) {

      if (empty($cotaEntry) || !is_numeric($cotaEntry) || $cotaEntry <= 0) {
        $errors[] = "Número de cota correcto requerido.";
        // Terminar el loop si hay un error.
        break;
      }
    }
  }

  if (isset($prefix_string)) {
    if (is_countable($prefix_string))
    {
        if ((count($prefix_string)) > ($cota_array_length)) 
        {
          $errors[] = "No agregue prefijos sin cota.";
        }
    }
  }
  // Asegurarse que la información sea válida.
  if (empty($name)) {
    $errors[] = "Nombre requerido.";
  }

  //Si no hay cotas, dejar que el usuario escriba el número de ejemplares. Si hay, calcula en base al número de cotas.
  if ($cota_array_length < 1) {
    $quantity = $_POST['quantity'];
    if (empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
      $errors[] = "Cantidad debe ser un número positivo.";
    }
  } else {
    $quantity = $cota_array_length;
  }


  // Que no hayan cotas repetidos.
    $check_code_sql = "SELECT pub_id FROM publications INNER JOIN pub_cota_data ON publications.pub_id=pub_cota_data.pub_id WHERE publications.removed=0";

    $result = mysqli_query($con, $check_code_sql);
    if (mysqli_num_rows($result) > 0)
    {
        $errors[] = "Cota ya existe.";
    }


  // Si no hay errores...
  if (empty($errors)) {

    //Vamos a hacer todo en una transacción para que así sea más facil de procesar
    $con->begin_transaction();
    try {
      // Primera modificación: Actualizar la publicación directamente
      $sql = "UPDATE publications SET name= ?, description= ?, quantity= ? WHERE pub_id=?";
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, 'sssi', $name, $description, $quantity, $pub_id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      //Segundo paso: Eliminar todas las fuentes citadas del libro.
      $querySourceDel = "DELETE FROM cited_sources WHERE pub_id = " . $pub_id;
      mysqli_query($con, $querySourceDel);

      //Tercer paso: Reinsertar las nuevas fuentes citadas
      $cite_sql = "INSERT INTO cited_sources (pub_id, role, name) VALUES (?, ?, ?)";
      $source_stmt = mysqli_prepare($con, $cite_sql);
      mysqli_stmt_bind_param($source_stmt, 'iss', $pub_attach_name, $source_role, $source_name);
      $pub_attach_name = $pub_id;

      // Utilizando la longitud de arreglo, ir a través de ambos arreglos a la vez para insertar sus valores al mismo tiempo y en el mismo index.
      for ($i = 0; $i < $s_array_length; $i++) {
        $source_role = $cited_source_types[$i];
        $source_name = $cited_source_names[$i];
        mysqli_stmt_execute($source_stmt);
      }
      mysqli_stmt_close($source_stmt);

      //Cuarto paso: Eliminar todas las cotas del libro.
      $queryCotaDel = "DELETE FROM pub_cota_data WHERE pub_id = " . $pub_id;
      mysqli_query($con, $queryCotaDel);

      //Quinto paso: Insertar a la tabla de cotas las cotas del libro, utilizando la id del libro.
      $cota_sql = "INSERT INTO pub_cota_data (pub_id, prefix_string, cota) VALUES (?, ?, ?)";
      $cota_stmt = mysqli_prepare($con, $cota_sql);
      mysqli_stmt_bind_param($cota_stmt, 'iss', $pub_cota_join_id, $cota_prefix, $cota_code);
      $pub_cota_join_id = $pub_id;

      // Utilizando la longitud de arreglo, ir a través de ambos arreglos a la vez para insertar sus valores al mismo tiempo y en el mismo index.
      for ($i = 0; $i < $cota_array_length; $i++) {
        $cota_prefix = $prefix_string[$i];
        $cota_code = $cota[$i];
        mysqli_stmt_execute($cota_stmt);
      }
      mysqli_stmt_close($cota_stmt);


      // Penultimo paso: Eliminar todas las etiquetas del libro
      $queryTagDel = "DELETE FROM pub_join_tags WHERE pub_id = " . $pub_id;
      mysqli_query($con, $queryTagDel);

      // Ultima modificación: Agregar las nuevas etiquetas al libro
      $query = "INSERT INTO pub_join_tags (pub_id, tag_id) VALUES ";
      $tag_values = [];

      foreach ($tag_ids as $tag_id) {
        $tag_values[] = "(" . $pub_id . ", " . $tag_id . ")";

            if ($tag_id == $docTypeArray[1]['tag_id'])
            {
                $isSubmittedAsThesis = true;
            }
      }

      $query .= implode(", ", $tag_values);

      if (count($tag_values) > 0) {
        mysqli_query($con, $query);
      }

      //Si tiene una categoría, actualizar el dropdown menu para que lo muestra apropiadamente (esto utiliza el nombre SOLO porque el sistema no permite dos categorías con el mismo nombre.)
      if (count($tags_new) > 0) {
        $query_name = "SELECT * FROM tags WHERE tag_id IN (" . implode(", ", $tags_new) . ")";
        $tags = mysqli_query($con, $query_name);
            if ($tags !== false && mysqli_num_rows($tags) > 1)
            {
                $tags = mysqli_fetch_all($tags, MYSQLI_ASSOC);
                $tags = array_column($tags, "name", "tag_category");
            }
      } else //Si no tiene categoría, dejalo en blanco y haz que el dropdown menu muestre ninguna.
      {
        $tags = "";
      }

      // Commit the transaction
      $con->commit();

      if ($isThesis == false)
        {
        $success = "Libro actualizado exitósamente.";
        audit_log(AuditAction::BookEdit, $pub_id, null, null);
        }
        else
        {
        $success = "Tesis actualizada exitósamente.";
        audit_log(AuditAction::ThesisEdit, $pub_id, null, null);
        }
    } catch (Exception $e) {
      // Revertir la transacción si algo sale mal
      $con->rollback();
      $errors[] = "Algo salió mal...";
    }
    // Re-agarrar detalles de libro de la base de datos.
    $sql = "SELECT * FROM publications WHERE pub_id = '$pub_id'";
    $result = mysqli_query($con, $sql);
    $edit_row = mysqli_fetch_assoc($result);
  }
  mysqli_close($con);
}
?>
<main id="main" class="main">
  <div class="container mt-5">
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
    <?php } 
    ?>
    <section class="section register min-vh-100 d-flex flex-column justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-xl-6 d-flex flex-column justify-content-center">
            <div class="card">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Editando Libro</h5>
                </div>
                <div class="form-group">
                  <label for="doc_type">Tipo de Publicación</label>
                  <div class="container text-center">
                    <div class="btn-group" role="group">
                      <?php

                        if (isset($tags["Documento"])) {
                            if ($tags["Documento"] == "Tesis") {
                                $isThesis = true;
                            } else {
                                $isThesis = false;
                            }
                        } else {
                            $isThesis = false;
                        }

                      // Va a través del arreglo de docType con los tags de categorización de publicación
                      foreach ($docTypeArray as $row) {

                      if (isset($tags["Documento"]))
                        { if ($tags["Documento"] == $row["name"]) {
                            $firstButton = true;
                          } else {
                            $firstButton = false;
                          }
                        } else
                        {
                            $firstButton = false;
                        }

                        // Un ternario que es basicamente como un if else pero comprimido en una sola línea (if $firstButton = true { checked} else "")
                        $checked = $firstButton ? "checked" : "";

                        // Los propios botones
                        echo '<input type="radio" class="btn-check" name="tags[]" id="docTypeButton' . $row["tag_id"] . '" value="' . $row["tag_id"] . '" autocomplete="off" ' . $checked . '>';
                        echo '<label class="btn btn-outline-primary" for="docTypeButton' . $row["tag_id"] . '">' . $row["name"] . '</label>';
                      }
                      ?>
                    </div>
                  </div>
                </div>

                <form action="edit-book.php?id=<?php echo $pub_id; ?>" method="post">
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Entrar nombre del libro" value="<?php echo $edit_row['name']; ?>" required autocomplete="off"> 
                  </div>
                    <div id="source-alert"></div>
                  <!-- Fuentes Citadas. Este bloque entero se dedica a generar la cantidad de fuentes y sus tipos exactos que tenía la publicación.-->
                  <div class="form-group" id="source-field">
                    <?php
                    foreach ($resultSources as $doc_row) {
                      // Hacer un contenedor por cada fuente (DEBERÍA COPIAR ESTO EN AGREGAR PUBLICACIÓN PARA QUE SE VEA MEJOR.)
                      echo '<div class="container row align-items-center source-container" id="source-container">';

                      // Columna de fila dropdown
                      echo '<div class="col-auto source-drop-col" id="source-drop-col">';
                      echo '<label for="cited_sources">Tipo de Fuente</label>';
                      echo '<select class="form-control dropdown" id="cited_source_type" name="cited_source_type[]">';

                      // Hacer las opciones del dropdown menu
                      $source_types = ["Autor", "Editorial", "Tutor"];
                      foreach ($source_types as $type) {
                        $selected = ($type == $doc_row['role']) ? 'selected' : '';
                        echo '<option value="' . $type . '" ' . $selected . '>' . $type . '</option>';
                      }

                      echo '</select>';
                      echo '</div>'; // Cerrar la columna de fila dropdown

                      // Columna de campo de texto
                      echo '<div class="col source-field-col" id="source-field-col">';
                      echo '<label for="cited_sources">Nombre de Fuente</label>';
                      echo '<input type="text" class="form-control" id="cited_sources" name="cited_source_name[]" placeholder="Ingresar nombre de fuente." value="' . $doc_row['name'] . '" autocomplete="off">';
                      echo '</div>'; // Cerrar la columna de campo de texto

                      // Y ahora cerrar el contenedor.
                      echo '</div>';
                    }
                    ?>
                  </div>
                  <br>
                  <div class="controls d-flex justify-content-evenly">
                    <button type="button" class="btn btn-success add" onclick="add()"><i class="bi bi-person-plus-fill"></i></button>
                    <button type="button" class="btn btn-danger remove" onclick="remove()"><i class="bi bi-person-x-fill"></i></button>
                  </div>

                  <div class="form-group">
                    <label for="description" id="desc-label">Descripción</label>
                    <textarea type="text" class="form-control" id="description" name="description" placeholder="Ingresar descripción del libro (opcional)." maxlength='5000'><?php echo $edit_row['description']; ?></textarea>
                  </div>
                  <br>
                  <!-- Botones de radio que te permiten alternar entre cota y sin cota. SOLO DISPONIBLE EN MODO LIBRO.-->
                  <div class="form-group" id="cota-quant-radio">
                    <label for="cota-radio-button">¿Este libro posee cotas?</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="inlineRadio" id="cota-radio-button" onclick="showCota()" <?php echo $hasCota ? 'checked' : ''; ?> autocomplete="off">
                      <label class="form-check-label" for="cota-radio-button">Cotas</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="inlineRadio" id="quantity-radio-button" onclick="hideCota()" <?php echo !$hasCota ? 'checked' : ''; ?> autocomplete="off">
                      <label class="form-check-label" for="quantity-radio-button">Sin Cota</label>
                    </div>
                  </div>
                  <br>
                  <!-- EJEMPLARES -->
                  <div class="form-group" id="quantity-segment">

                  </div>

                  <!-- Campo de cotas -->
                  <div id="cota-segment">
                    <div class="form-group" id="multicota">
                      <?php
                      foreach ($resultCotas as $cota_row) {
                        echo '<div class="container row align-items-center cota-container">';

                        // Campo de prefijos
                        echo '<div class="col-auto" id="cota-left-col">';
                        echo '<label for="cited_sources">Prefijo de Cota (Opcional)</label>';
                        echo '<input type="text" class="form-control" id="cota_prefix" name="prefix_string[]" placeholder="Sin prefijo." maxlength="100" value="' . $cota_row['prefix_string'] . '">';
                        echo '</div>';

                        // Campo de cotas
                        echo '<div class="col" id="cota-right-col">';
                        echo '<label for="cited_sources">Número de Cota</label>';
                        echo '<input type="text" class="form-control" id="cota" name="cota[]" placeholder="Ingresar número de cota." maxlength="13" value="' . $cota_row['cota'] . '">';
                        echo '</div>';

                        echo '</div>'; // Cerrar contenedor.
                      }
                      ?>
                    </div>
                    <br>
                    <div class="controls d-flex justify-content-evenly">
                      <button type="button" class="btn btn-success add" onclick="add2()"><i class="ri ri-add-fill"></i></button>
                      <button type="button" class="btn btn-danger remove" onclick="remove2()"><i class="ri ri-delete-back-2-fill"></i></button>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="tags">PNF</label>
                    <?php
                    echo "<select name='tags[]' id='tags' class='form-control'>";
                    foreach ($tagArray as $row) { // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.


                      if ($tags["PNF"] == $row["name"]) {
                        echo "<option value=$row[tag_id] selected='selected'>$row[name]</option>";
                      } else {
                        echo "<option value=$row[tag_id]>$row[name]</option>";
                      }
                    }
                    echo "</select>";

                    ?>
                  </div>
                  <div class="form-group">
                    <label for="sede">Sede</label>
                    <?php
                    echo "<select name='tags[]' id='sede' class='form-control'>";
                    foreach ($tagArray2 as $row) { // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.


                      if ($tags["Ubicación"] == $row["name"]) {
                        echo "<option value=$row[tag_id] selected='selected'>$row[name]</option>";
                      } else {
                        echo "<option value=$row[tag_id]>$row[name]</option>";
                      }
                    }
                    echo "</select>";

                    ?>
                  </div>


                  <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary" name="edit_book" class="submit-button">Editar Libro</button>
                  </div>
                </form>
              </div>
              <a href="main.php" style="padding-left: 8px;">Atrás</a>
            </div>

          </div>
    </section>
  </div>
  </div>
  </div>

  </section>
</main>
<script>
  var curMode = 0; //Que modo esta. Modo 0 es libro, modo 1 es tesis.
  var minCount = 1; //la cantidad mínima de fuentes citadas. Debe ser 1 en modo libro y 2 en modo tesis.
  var weCotaOrNot = 0; //Esta variable dicta si es una publicación con cota o no. En caso de que sea 0, o por defecto, no hay un campo de cantidad y la cantidad se determina dinámicamente por la cantidad de cotas. En caso de que sea donación, se activa el campo de ejemplares automaticamente.

  <?php
  echo 'var quantNumber = ' . $quantNumber . ';'; // Pasar la variable quantNumber de PHP a javascript.
  ?>



  // echo $quantNumber;

  //Botones de cambio de modo. 
  var bookButton = document.getElementById('docTypeButton17');
  var thesisButton = document.getElementById('docTypeButton18');

  //Campos que cambian cuando cambias de modo.
  var nameField = document.getElementById("name");

  var descLabel = document.getElementById("desc-label");
  var descField = document.getElementById("description");

var submitButton = document.getElementById("submit-button");
  var sourceAlert = document.getElementById("source-alert");
  //Campos de fuentes citadas.
  var sourceFieldCol = document.getElementById('source-field-col');
  var sourceDropCol = document.getElementById('source-drop-col');

  //Divisor entre cota y ejemplares.
  var cotaQuantRadio = document.getElementById("cota-quant-radio");
  var quantDiv = document.getElementById("quantity-segment");
  var cotaDiv = document.getElementById("cota-segment");


  //Cambio de restricciones dependiendo del botón.
  bookButton.addEventListener("click", function() {
    curMode = 0;
    console.log(curMode);
    // Actualizar los campos
    updateFields();
  });


  thesisButton.addEventListener("click", function() {

    curMode = 1;

    console.log(curMode);

    var containers = document.querySelectorAll('.source-container');
    if (containers.length < 2) {
      add();
    }

    updateFields();
  });

  function showCota() {
    weCotaOrNot = 1;
    quantDiv.innerHTML = '';
    cotaDiv.innerHTML = '<div class="form-group" id="multicota"><div class="container row align-items-center cota-container"><div class="col-auto" id="cota-left-col"><label for="cited_sources">Prefijo de Cota (Opcional)</label><input type="text" class="form-control" id="cota_prefix" name="prefix_string[]" placeholder="Sin prefijo." maxlength="100"></div><div class="col" id="cota-right-col"><label for="cited_sources">Número de Cota</label><input type="text" class="form-control" id="cota" name="cota[]" placeholder="Ingresar número de cota." maxlength="13"></div></div></div><br><div class="controls d-flex justify-content-evenly"><button type="button" class="btn btn-success add" onclick="add2()"><i class="ri ri-add-fill"></i></button><button type="button" class="btn btn-danger remove" onclick="remove2()"><i class="ri ri-delete-back-2-fill"></i></button></div>';

  }

  function hideCota() {
    weCotaOrNot = 0;
    quantDiv.innerHTML = '<label for="quantity">Ejemplares</label> <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Ingresar cantidad de ejemplares." required>';
    cotaDiv.innerHTML = '';

  }
  //Esta variante SOLO se utiliza cuando hasCota es falso, o sea, cuando no hay cotas, para que cuando se cargue la página inmediatemente cambie a modo ejemplares y te muestre el número de ejemplares, pero no lo haga cuando cambies de modo.
  function hideCotaDX() {
    weCotaOrNot = 0;
    quantDiv.innerHTML = '<label for="quantity">Ejemplares</label> <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Ingresar cantidad de ejemplares." value="' + quantNumber + '" required>';
    cotaDiv.innerHTML = '';
  }

  <?php
  echo 'var isThesis = ' . ($isThesis ? 'true' : 'false') . ';'; // Convert PHP boolean to JavaScript boolean
  echo 'if (isThesis) {';
  echo '  curMode = 1;';
  echo '  updateFields();';
  echo '}';
  ?>

  <?php
  echo 'var hasCota = ' . ($hasCota ? 'true' : 'false') . ';'; // Convert PHP boolean to JavaScript boolean
  echo 'if (!hasCota) {';
  echo '  hideCotaDX();';
  echo '}';
  ?>


  // Esta función actualiza los campos en base a curMode. Yo pensé que simplemente podría poner la condicional afuera, pero no, tiene que ser llamada por una función.
  function updateFields() {
    if (curMode == 0) {
      minCount = 1;
      nameField.setAttribute('placeholder', 'Ingresar nombre del libro.');
      descLabel.innerHTML = "Descripción";
      descField.setAttribute('placeholder', 'Ingresar descripción del libro (opcional).');
        submitButton.textContent = "Editar Libro.";

        sourceAlert.classList.remove('alert', 'alert-info', 'mt-4');
        sourceAlert.textContent = '';

      cotaQuantRadio.innerHTML = '<label for="cota-radio-button">¿Este libro posee cotas?</label><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadio" id="cota-radio-button" onclick="showCota()" checked autocomplete="off"><label class="form-check-label" for="cota-radio-button">Cotas</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadio" id="quantity-radio-button" onclick="hideCota()" autocomplete="off"><label class="form-check-label" for="quantity-radio-button">Sin Cota</label></div>';

    } else {
      minCount = 2;
      nameField.setAttribute('placeholder', 'Ingresar nombre del proyecto.');
      descLabel.innerHTML = "Resumen";
      descField.setAttribute('placeholder', 'Ingresar resumen de la tesis (opcional).');
      submitButton.textContent = "Editar Tesis.";

        sourceAlert.classList.add('alert', 'alert-info', 'mt-4');
        sourceAlert.textContent = '¡Cada tesis debe tener al menos un tutor!';

      cotaQuantRadio.innerHTML = "";
      showCota();
    }
  }




  // Ponemos las opciones del menú dropdown en un arreglo para que podamos crearlo
  var options = [{
      value: "Autor",
      name: "Autor"
    },
    {
      value: "Editorial",
      name: "Editorial"
    },
    {
      value: "Tutor",
      name: "Tutor"
    }
  ];



  // El botón de agregar, crea un nuevo elemento de select y un nuevo elemento de campo de texto y pega los valores del dropdown menu que pusimos arriba en el dropdown menu.
  function add() {
    // Crear un nuevo contenedor para el grupo de campos
    var container = document.createElement('div');
    container.classList.add('container', 'row', 'align-items-center', "source-container");
    container.id = 'source-container';

    // Columna de fila dropdown
    var newDropCol = document.createElement('div');
    newDropCol.classList.add('col-auto', 'source-drop-col');
    newDropCol.id = 'source-drop-col'; // This will be unique for each added field
    var newDropLabel = document.createElement('label');
    newDropLabel.setAttribute('for', 'cited_source_type');
    newDropLabel.textContent = 'Tipo de Fuente';
    var newDrop = document.createElement('select');
    newDrop.setAttribute('class', 'form-control dropdown');
    newDrop.setAttribute('name', 'cited_source_type[]');

    // Append options to the dropdown
    options.forEach(function(option) {
      var optionElement = document.createElement("option");
      optionElement.value = option.value;
      optionElement.textContent = option.name;
      newDrop.appendChild(optionElement);
    });

    newDropCol.appendChild(newDropLabel);
    newDropCol.appendChild(newDrop);
    container.appendChild(newDropCol);

    // Columna de campo de texto
    var newFieldCol = document.createElement('div');
    newFieldCol.classList.add('col', 'source-field-col');
    newFieldCol.id = 'source-field-col'; // This will be unique for each added field
    var newLabel = document.createElement('label');
    newLabel.setAttribute('for', 'cited_sources');
    newLabel.textContent = 'Nombre de Fuente';
    var newField = document.createElement('input');
    newField.setAttribute('type', 'text');
    newField.setAttribute('class', 'form-control');
    newField.setAttribute('name', 'cited_source_name[]');
    newField.setAttribute('placeholder', 'Ingresar nombre de fuente.');
    newFieldCol.appendChild(newLabel);
    newFieldCol.appendChild(document.createElement('br')); // Add a line break for spacing
    newFieldCol.appendChild(newField);
    container.appendChild(newFieldCol);

    // Append the new container to the parent div
    document.getElementById('source-field').appendChild(container);
  }

  function remove() {
    var containers = document.querySelectorAll('.source-container');
    if (containers.length > minCount) {
      var lastContainer = containers[containers.length - 1];
      lastContainer.parentNode.removeChild(lastContainer);
    }
  }

  //El boton de agregar cotas
  function add2() {
    // Crear un nuevo contenedor para el grupo de campos
    var container = document.createElement('div');
    container.classList.add('container', 'row', 'align-items-center', "cota-container");
    container.id = 'cota-container';

    // Columna de fila dropdown
    var newCotaPrefix = document.createElement('div');
    newCotaPrefix.classList.add('col-auto');
    newCotaPrefix.id = 'cota-left-col'; // This will be unique for each added field
    var newPrefixLabel = document.createElement('label');
    newPrefixLabel.setAttribute('for', 'cota_prefix');
    newPrefixLabel.textContent = 'Prefijo de Cota (Opcional)';
    var newPrefixField = document.createElement('input');
    newPrefixField.setAttribute('type', 'text');
    newPrefixField.setAttribute('class', 'form-control');
    newPrefixField.setAttribute('name', 'prefix_string[]');
    newPrefixField.setAttribute('placeholder', 'Sin prefijo.');
    newPrefixField.setAttribute('maxlength', '100');
    newPrefixField.id = "cota_prefix";

    newCotaPrefix.appendChild(newPrefixLabel); //Se pega el label a la columna.
    newCotaPrefix.appendChild(newPrefixField); //Se pega la fila a la columna.
    container.appendChild(newCotaPrefix); //Y se pega la columna al contenedor.

    // Columna de campo de texto
    var newCotaFieldCol = document.createElement('div');
    newCotaFieldCol.classList.add('col');
    newCotaFieldCol.id = 'cota-right-col'; // ID de cada campo
    var newFieldLabel = document.createElement('label');
    newFieldLabel.setAttribute('for', 'cota');
    newFieldLabel.textContent = 'Número de Cota';
    var newCotaField = document.createElement('input');
    newCotaField.setAttribute('type', 'text');
    newCotaField.setAttribute('class', 'form-control');
    newCotaField.setAttribute('name', 'cota[]');
    newCotaField.setAttribute('placeholder', 'Ingresar número de cota.');
    newCotaField.setAttribute('maxlength', '13');
    newCotaField.id = "cota";
    newCotaField.setAttribute('autocomplete', 'off');

    newCotaFieldCol.appendChild(newFieldLabel); //Se pega el label a la columna.
    newCotaFieldCol.appendChild(document.createElement('br')); // Agregar un line break para crear un espacio.
    newCotaFieldCol.appendChild(newCotaField); //Pegamos el campo a la columna.
    container.appendChild(newCotaFieldCol); //Y la columna al contenedor.

    // Y luego se pega el contenedor al id de multicota.
    document.getElementById('multicota').appendChild(container);
  }


  //El boton de eliminar cotas
  function remove2() {
    var containers = document.querySelectorAll('.cota-container');
    if (containers.length > 1) {
      var lastContainer = containers[containers.length - 1];
      lastContainer.parentNode.removeChild(lastContainer);
    }

  }
</script>
<?php include "footer.php"; ?>