<?php

session_start();
$title = "Agregar Libro";

// Asegurarse que el usuario esté en sesión.
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
$isThesis = false; //Utilizado para cambiar la función de audit log.

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

$cota = array(); //Esta es mi idea para evitar el crash cuando se entra en modo ejemplares.
$prefix_string = array();
//Luego viene el resto del código

// Que el formulario no esté vacío.
if (isset($_POST['add_book'])) {

  // Agarrar detalles del libro.
  $name = $_POST['name'];
  $description = $_POST['description'];

  $tag_ids = $_POST['tags'];

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

    if (isset($_POST['link_field'])) {
      $link = $_POST['link_field'];
    } else {
      $link = "";
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

  
// Este bloque chequea si $cota es un array y tiene más de un elemento.
if (is_array($cota) && count($cota) > 0) {
    foreach ($cota as $cotaEntry) {
        // Valida que el código de cada uno sea un número mayor a cero.
        if (empty($cotaEntry) || !is_numeric($cotaEntry) || $cotaEntry <= 0) {
            $errors[] = "Número de cota correcto requerido.";
            // Seguir.
            continue;
        }

        // Comparar cada elemento del arreglo $cota con las cotas existentes y crear error si ya existe.
        $check_code_sql = "SELECT * FROM pub_cota_data WHERE cota = '$cotaEntry'";
        $result = mysqli_query($con, $check_code_sql);

        if (!$result) {
            $errors[] = "Error query de cota $cotaEntry: " . mysqli_error($con);
        } elseif (mysqli_num_rows($result) > 0) {
            $errors[] = "Cota $cotaEntry ya existe.";
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



  // Si no hay errores...
  if (empty($errors)) {


    //Vamos a hacer las tres cosas en una transacción para que así sea más facil de procesar
    $con->begin_transaction();
    try {
      // Primera inserción: Insertar a la tabla de libros
      $sql = "INSERT INTO publications (name, description, code, quantity, state, link) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, 'sssiis', $name, $description, $code, $quantity, $state, $link);
      mysqli_stmt_execute($stmt);
      $pub_insert_id = $stmt->insert_id;
      mysqli_stmt_close($stmt);

      // Segunda Inserción: Insertar a la tabla de fuentes citadas las fuentes citadas, sacando primeramente el id del libro.
      $cite_sql = "INSERT INTO cited_sources (pub_id, role, name) VALUES (?, ?, ?)";
      $source_stmt = mysqli_prepare($con, $cite_sql);
      mysqli_stmt_bind_param($source_stmt, 'iss', $pub_attach_name, $source_role, $source_name);
      $pub_attach_name = $pub_insert_id;

      // Utilizando la longitud de arreglo, ir a través de ambos arreglos a la vez para insertar sus valores al mismo tiempo y en el mismo index.
      for ($i = 0; $i < $s_array_length; $i++) {
        $source_role = $cited_source_types[$i];
        $source_name = $cited_source_names[$i];
        mysqli_stmt_execute($source_stmt);
      }
      mysqli_stmt_close($source_stmt);

      //Tercera inserción: Insertar a la tabla de cotas las cotas del libro, utilizando la id del libro.
      $cota_sql = "INSERT INTO pub_cota_data (pub_id, prefix_string, cota) VALUES (?, ?, ?)";
      $cota_stmt = mysqli_prepare($con, $cota_sql);
      mysqli_stmt_bind_param($cota_stmt, 'iss', $pub_cota_join_id, $cota_prefix, $cota_code);
      $pub_cota_join_id = $pub_insert_id;

      // Utilizando la longitud de arreglo, ir a través de ambos arreglos a la vez para insertar sus valores al mismo tiempo y en el mismo index.
      for ($i = 0; $i < $cota_array_length; $i++) {
        $cota_prefix = $prefix_string[$i];
        $cota_code = $cota[$i];
        mysqli_stmt_execute($cota_stmt);
      }
      mysqli_stmt_close($cota_stmt);

      // Cuarta inserción: Agregar las etiquetas al libro
      $query = "INSERT INTO pub_join_tags (pub_id, tag_id) VALUES ";
      $tag_values = [];
      $pub_id = $pub_insert_id;

      foreach ($tag_ids as $tag_id) {


        $tag_values[] = "(" . $pub_id . ", " . $tag_id . ")";


            if ($tag_id == $docTypeArray[1]['tag_id'])
            {
                $isThesis = true;
            }
      }

      $query .= implode(", ", $tag_values);

      if (count($tag_values) > 0) {
        mysqli_query($con, $query);
      }


      // Commit the transaction
      $con->commit();

      
      if ($isThesis == false)
        {
            $success = "Libro agregado exitósamente!";
        audit_log(AuditAction::BookNew, $pub_insert_id, null, null);
        }
        else
        {
                  $success = "Tesis agregada exitósamente!";
        audit_log(AuditAction::ThesisNew, $pub_insert_id, null, null);
        }
    } catch (Exception $e) {
      // Revertir la transacción si algo sale mal
      $con->rollback();
      $errors[] = "Algo salió mal...";
    }
  }
  //Cerrar conexión.
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
            <?php }
            ?>
            <div class="card">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Agregar Publicación</h5>
                </div>

                <form action="add-book.php" class="row g-3" method="post">
                  <div class="form-group">
                    <label for="doc_type">Tipo de Publicación</label>
                    <div class="container text-center">
                      <div class="btn-group" role="group">
                        <?php

                        // Variable para que el primer botón este activo por defecto.
                        $firstButton = true;

                        // Va a través del arreglo de docType con los tags de categorización de publicación
                        foreach ($docTypeArray as $row) {
                          // Un ternario que es basicamente como un if else pero comprimido en una sola línea (if $checked = firstButton = true { checked} else "")
                          $checked = $firstButton ? "checked" : "";

                          // Los propios botones
                          echo '<input type="radio" class="btn-check" name="tags[]" id="docTypeButton' . $row["tag_id"] . '" value="' . $row["tag_id"] . '" autocomplete="off" ' . $checked . '>';
                          echo '<label class="btn btn-outline-primary" for="docTypeButton' . $row["tag_id"] . '">' . $row["name"] . '</label>';

                          // Actualizar la variable de primer botón.
                          $firstButton = false;
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar nombre del libro." required autocomplete="off">
                  </div>
                        <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="link_check">
                        <label class="form-check-label" for="user_system_check">¿Quieres asociar esta publicación con un enlace externo?</label>
                        </div>

                        <div id="link_show_div">
                        </div>
                  <div id="source-alert"></div>
                  <!-- Fuentes Citadas -->
                  <div class="form-group" id="source-field">
                    <div class="container row align-items-center source-container">
                      <!-- El dropdown -->
                      <div class="col-auto" id="source-drop-col">
                        <label for="cited_sources">Tipo de Fuente</label>
                        <select class="form-control dropdown" id="cited_source_type" name="cited_source_type[]">
                          <option value="Autor">Autor</option>
                          <option value="Editorial">Editorial</option>
                          <option value="Tutor">Tutor</option>
                        </select>
                      </div>
                      <!-- El nombre -->
                      <div class="col" id="source-field-col">
                        <label for="cited_sources">Nombre de Fuente</label>
                        <input type="text" class="form-control" id="cited_sources" name="cited_source_name[]" placeholder="Ingresar nombre de fuente." required autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="controls d-flex justify-content-evenly">
                    <button type="button" class="btn btn-success add" onclick="add()"><i class="bi bi-person-plus-fill"></i></button>
                    <button type="button" class="btn btn-danger remove" onclick="remove()"><i class="bi bi-person-x-fill"></i></button>
                  </div>
                  <div class="form-group">
                    <label for="description" id="desc-label">Descripción</label>
                    <textarea type="text" class="form-control" id="description" name="description" placeholder="Ingresar descripción del libro (opcional)." maxlength='5000'></textarea>
                  </div>

                  <!-- Botones de radio que te permiten alternar entre cota y sin cota. SOLO DISPONIBLE EN MODO LIBRO.-->
                  <div class="form-group" id="cota-quant-radio">
                    <label for="cota-radio-button">¿Este libro posee cotas?</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="inlineRadio" id="cota-radio-button" onclick="showCota()" checked autocomplete="off">
                      <label class="form-check-label" for="cota-radio-button">Cotas</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="inlineRadio" id="quantity-radio-button" onclick="hideCota()" autocomplete="off">
                      <label class="form-check-label" for="quantity-radio-button">Sin Cota</label>
                    </div>
                  </div>

                  <!-- EJEMPLARES -->
                  <div class="form-group" id="quantity-segment">

                  </div>

                  <!-- Campo de cotas -->
                  <div id="cota-segment">
                    <div class="form-group" id="multicota">
                      <div class="container row align-items-center cota-container">
                        <!-- El prefijo -->
                        <div class="col-auto" id="cota-left-col">
                          <label for="cited_sources">Prefijo de Cota (Opcional)</label>
                          <input type="text" class="form-control" id="cota_prefix" name="prefix_string[]" placeholder="Sin prefijo." maxlength='100'>
                        </div>
                        <!-- La cota -->
                        <div class="col" id="cota-right-col">
                          <label for="cited_sources">Número de Cota</label>
                          <input type="text" class="form-control" id="cota" name="cota[]" placeholder="Ingresar número de cota." maxlength='13' required>
                        </div>
                      </div>
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


                      echo "<option value=$row[tag_id]>$row[name]</option>";
                    }
                    echo "</select>";

                    ?>
                  </div>
                  <div class="form-group">
                    <label for="sede">Sede</label>
                    <?php
                    echo "<select name='tags[]' id='sede' class='form-control'>";
                    foreach ($tagArray2 as $row) { // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.


                      echo "<option value=$row[tag_id]>$row[name]</option>";
                    }
                    echo "</select>";

                    ?>
                  </div>
                  <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary" name="add_book" id="submit-button">Agregar Libro</button>
                  </div>
                </form>
              </div>
              <a href="main.php" style="padding-left: 8px;">Atrás</a>

            </div>

          </div>
        </div>
      </div>

    </section>

</main>
<script>
  var curMode = 0; //Que modo esta. Modo 0 es libro, modo 1 es tesis.
  var minCount = 1; //la cantidad mínima de fuentes citadas. Debe ser 1 en modo libro y 2 en modo tesis.

  var weCotaOrNot = 0; //Esta variable dicta si es una publicación con cota o no. En caso de que sea 0, o por defecto, no hay un campo de cantidad y la cantidad se determina dinámicamente por la cantidad de cotas. En caso de que sea donación, se activa el campo de ejemplares automaticamente.

  var linkSwitch = 0; //Esta variable determina si mostrar el campo de enlace o no.

  //Botones de cambio de modo. 
  var bookButton = document.getElementById('docTypeButton17');
  var thesisButton = document.getElementById('docTypeButton18');

  var pubLinkSwitcher = document.getElementById("link_check");

  //Campos que cambian cuando cambias de modo.
  var nameField = document.getElementById("name");
  var linkField = document.getElementById("link_show_div");

  var descLabel = document.getElementById("desc-label");
  var descField = document.getElementById("description");
  var submitButton = document.getElementById("submit-button");
  var sourceAlert = document.getElementById("source-alert");

  //Esta sección es basicamente para crear la duplicación de campos de autor. Primero agarramos el id de los campos.
  var sourceFieldCol = document.getElementById('source-field-col');
  var sourceDropCol = document.getElementById('source-drop-col');

  //Divisor entre cota y ejemplares.
  var cotaQuantRadio = document.getElementById("cota-quant-radio");
  var quantDiv = document.getElementById("quantity-segment");
  var cotaDiv = document.getElementById("cota-segment");

  //Esta sección es para la duplicación de campos de cota
  var cotaLeftCol = document.getElementById('cota-left-col');
  var cotaRightCol = document.getElementById('cota-right-col');




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

  pubLinkSwitcher.addEventListener('change', function() {
    // Check if the switch is checked (ON) or not (OFF)
    if (this.checked) {
        // Execute your function when the switch is ON
        console.log('Switch is ON');
        linkSwitch = 1;
        toggleLink();
    } else {
        // Execute your function when the switch is OFF
        console.log('Switch is OFF');
        linkSwitch = 0;
       toggleLink();
    }
});

  function toggleLink() {
    if (linkSwitch > 0)
    {
      linkField.innerHTML = '<div class="form-group"><label for="name">Enlace</label><input type="text" class="form-control" id="linkField" name="link_field" placeholder="Copia y pega un enlace externo de descarga en este campo." required autocomplete="off"></div>';
    }
    else
    {
      linkField.innerHTML = "";
    }
  }

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

  // Esta función actualiza los campos en base a curMode. Yo pensé que simplemente podría poner la condicional afuera, pero no, tiene que ser llamada por una función.
  function updateFields() {
    if (curMode == 0) {
      minCount = 1;
      nameField.setAttribute('placeholder', 'Ingresar nombre del libro.');
      descLabel.innerHTML = "Descripción";
      descField.setAttribute('placeholder', 'Ingresar descripción del libro (opcional).');
      submitButton.textContent = "Agregar Libro.";

        sourceAlert.classList.remove('alert', 'alert-info', 'mt-4');
        sourceAlert.textContent = '';


      cotaQuantRadio.innerHTML = '<label for="cota-radio-button">¿Este libro posee cotas?</label><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadio" id="cota-radio-button" onclick="showCota()" checked autocomplete="off"><label class="form-check-label" for="cota-radio-button">Cotas</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadio" id="quantity-radio-button" onclick="hideCota()" autocomplete="off"><label class="form-check-label" for="quantity-radio-button">Sin Cota</label></div>';
    } else {
      minCount = 2;
      nameField.setAttribute('placeholder', 'Ingresar nombre del proyecto.');
      descLabel.innerHTML = "Resumen";
      descField.setAttribute('placeholder', 'Ingresar resumen de la tesis (opcional).');
      submitButton.textContent = "Agregar Tesis.";

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


    // Pegar las opciones al dropdown
    options.forEach(function(option) {
      var optionElement = document.createElement("option");
      optionElement.value = option.value;
      optionElement.textContent = option.name;
      newDrop.appendChild(optionElement);
    });

    if (curMode == 1)
    {
        newDrop.selectedIndex = 2;
    }
    newDropCol.appendChild(newDropLabel); //Se pega el label a la columna.
    newDropCol.appendChild(newDrop); //Se pega la fila a la columna.
    container.appendChild(newDropCol); //Y se pega la columna al contenedor.

    // Columna de campo de texto
    var newFieldCol = document.createElement('div');
    newFieldCol.classList.add('col', 'source-field-col');
    newFieldCol.id = 'source-field-col'; // ID de cada campo
    var newLabel = document.createElement('label');
    newLabel.setAttribute('for', 'cited_sources');
    newLabel.textContent = 'Nombre de Fuente';
    var newField = document.createElement('input');
    newField.setAttribute('type', 'text');
    newField.setAttribute('class', 'form-control');
    newField.setAttribute('name', 'cited_source_name[]');
    newField.setAttribute('placeholder', 'Ingresar nombre de fuente.');
    newField.setAttribute('placeholder', 'Ingresar nombre de fuente.');
    newField.required = true;
    newFieldCol.appendChild(newLabel); //Se pega el label a la columna.
    newFieldCol.appendChild(document.createElement('br')); // Agregar un line break para crear un espacio.
    newFieldCol.appendChild(newField); //Pegamos el campo a la columna.
    container.appendChild(newFieldCol); //Y la columna al contenedor.

    // Y luego se pega el contenedor al id de source-field.
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
    newCotaField.required = true;
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