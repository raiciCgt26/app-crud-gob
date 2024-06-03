<?php

session_start();
$title = "Registrar Prestamo de Publicación";

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
$ad_hoc = false; //Se pone como verdadero si el usuario no está en el sistema y lo auto-registra como un usuario de conveniencia.
$cota_array_length = [];


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


$sqlSelect3 = "SELECT tag_id FROM tags WHERE (name = 'Libro' OR name = 'Tesis') AND removed = 0";
$queryResult3 = mysqli_query($con, $sqlSelect3);

$docTypeArray = array();


while ($row = mysqli_fetch_array($queryResult3, MYSQLI_ASSOC)) {
  array_push($docTypeArray, $row);
}


//Y liberamos la memoría
mysqli_free_result($queryResult3);




// Que el formulario no esté vacío.
if (isset($_POST['register-pub-lending'])) {

  // Agarrar detalles del préstamo
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $lend_type = $_POST['lend_type'];
  $observations = $_POST['observations'];

  //Agarrar detalles de usuario (en caso de que sea ad-hoc estos se utilizarán para registrarlo).
  $lend_name = $_POST['lend_name'];
  $lend_user_type = $_POST['user_type'];
  $lender_phone = $_POST['lender_phone'];
  $lend_student_pnf = $_POST['lend_student_pnf'];
  $borrower_cedula = $_POST['lend_cedula'];
  

  //Agarrar detalles de la publicación (solo necesitamos el id y las cotas seleccionadas/la cantidad realmente).

  $pub_id = $_POST['pub_id'];

  $cota = $_POST['cotas_checked'];

//Fecha actual
$currentDate = date("Y-m-d"); 
// Convertir la fecha y fin de fecha en tiempoestampas de Unix.
$start_timestamp = strtotime($start_date);
$end_timestamp = strtotime($end_date);
$current_timestamp = strtotime($currentDate);

// Comparar para que la fecha de fin no sea antés que la fecha de inicio.
if ($end_timestamp < $start_timestamp) {
    $errors[] = "¡Fecha de retorno no puede ser anterior a la fecha de salida!";
}

// Marcar el préstamo como activo si la fecha de inicio es la actual, o como presolicitud si aún no ha ocurrido.
if ($start_timestamp >= $current_timestamp) {
    $lend_status = 1; // Activo
} else {
    $lend_status = 0; // Presolicitud
}

  if (isset($cota)) {
    //Y que tantas cotas.
    $cota_array_length = count($cota);
  }




  //Si no hay cotas, dejar que el usuario escriba el número de ejemplares. Si hay, calcula en base al número de cotas.
  if ($cota_array_length < 1) {
    $quantity = $_POST['quantity_check'];
    if (empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
      $errors[] = "Por favor seleccione los ejemplares a prestar.";
    }
  } else {
    $quantity = $cota_array_length;
  }

    //  Conseguir el id del usuario en base a la cédula. NO el nombre en caso de que el usuario deje el campo de usuario en vacío
    if (isset($borrower_cedula))
    {
    $user_query = "SELECT user_id FROM users WHERE cedula_id = " . $borrower_cedula;
    $user_result = mysqli_query($con, $user_query);

      if ($user_result) {
          if (mysqli_num_rows($user_result) == 0) {
              // No hay usuario con esta cédula, lo que significa que es hora de auto-registrar.
              $ad_hoc = true;
          } else {
              // Si hay, obtener el user_id.
              $user_data = mysqli_fetch_assoc($user_result);
              $user_id = $user_data['user_id'];
          }
          // Liberar el resultado
          mysqli_free_result($user_result);
      }
    }
    else
    {
      $errors[] = "Por favor introduzca una cédula válida.";
    }

  if (empty($borrower_cedula) || !is_numeric($borrower_cedula) || $borrower_cedula <= 0) {
      $errors[] = "Por favor introduzca una cédula válida.";
    }

  if (empty($lender_phone)) {
      $errors[] = "Por favor introduzca un número de telefono válido.";
    }

  // Si no hay errores...
  if (empty($errors)) {

    //Vamos a hacer las tres cosas en una transacción para que así sea más facil de procesar
    $con->begin_transaction();
    try {

      if ($ad_hoc == true)
      {
      // Si el usuario no está registrado, crear un usuario auto registrado para este propósito
      $add_user_sql = "INSERT INTO users (username, user_type, contact_number, pnf, cedula_id, auto_register) VALUES (?, ?, ?, ?, ?, ?)";
      $add_user_stmt = mysqli_prepare($con, $add_user_sql);
      $auto_register = 1;
      mysqli_stmt_bind_param($add_user_stmt, 'sssssi', $lend_name, $lend_user_type, $lender_phone, $lend_student_pnf, $borrower_cedula, $auto_register);
      mysqli_stmt_execute($add_user_stmt);
      $user_id = $add_user_stmt->insert_id;
      mysqli_stmt_close($add_user_stmt);
      }

      // Y ahora se hace la inserción del propio prestamo. Se pone el status de lend status como 1 porque es un ticket completo. 0 es para presolicitud y 2, 3 y 4 son estados de finalización.
      $pub_lend_sql = "INSERT INTO pub_lending (start_date, end_date, focus_user_id, focus_pub_id, observations, lend_type, lend_status, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $pub_lend_stmt = mysqli_prepare($con, $pub_lend_sql);
      mysqli_stmt_bind_param($pub_lend_stmt, 'ssiissii', $start_date, $end_date, $user_id, $pub_id, $observations, $lend_type, $lend_status, $quantity);
      mysqli_stmt_execute($pub_lend_stmt);
      $pub_lend_id = $pub_lend_stmt->insert_id;
      mysqli_stmt_close($pub_lend_stmt);

      // Finalmente se hace el join de las cotas seleccionadas a prestar...
      $pub_lend_cota_query = "INSERT INTO pub_lent_cotas (pub_lend_id, cota_id) VALUES ";
      $pub_cotas_checked = [];

      if (isset($cota))
      {
        foreach ($cota as $cota_row) {


          $pub_cotas_checked[] = "(" . $pub_lend_id . ", " . $cota_row . ")";
        }
      }

      $pub_lend_cota_query .= implode(", ", $pub_cotas_checked);

      if (count($pub_cotas_checked) > 0) {
        mysqli_query($con, $pub_lend_cota_query);
      }

      // Commit the transaction
      $con->commit();

     $success = "Préstamo registrado exitósamente!";
     audit_log(AuditAction::PubLendRegister, $pub_id, $user_id, null);
    } catch (Exception $e) {
        // Revertir la transacción si algo sale mal
        $con->rollback();
        $errors[] = "Algo salió mal: " . $e->getMessage(); // Log the specific error message
    }
  }
  //Cerrar conexión.
  mysqli_close($con);
}
?>
<script src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/search_script.js"></script> 
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
                <?php }  ?>
              </div>
            <?php } 
            ?>
<style>
    .custom-wider-card {
        width: 150%; /* Adjust the width as needed */
        margin: auto -25%;
    }


input[readonly], select[style*="pointer-events: none"] {
    background-color: #e9ecef; /* Grayed-out look */
    opacity: 1;
    pointer-events: none; /* Prevent interaction */
    cursor: not-allowed;
}
  input[readonly]:focus {
    outline: none; /* Remove the outline on focus */
  }
  input[readonly]::selection {
    background: transparent; /* Prevent text selection background color */
  }

</style>
<div class="card custom-wider-card">
  <div class="card-body">
    <div class="pt-4 pb-2">
      <h5 class="card-title text-center pb-0 fs-4">Registrar Préstamo de Libro</h5>
    </div>

    <form action="register-pub-lending.php" class="row g-3" method="post">

      <div class="col-md-6">
        <!-- Columna izquierda -->
        <div class="form-group">
          <label for="start_date">Fecha de Salida</label>
          <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Fecha de inicio del préstamo." required>
        </div>
      </div>

      <div class="col-md-6">
        <!-- Columna derecha -->
        <div class="form-group">
          <label for="end_date">Fecha de Retorno</label>
          <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Fecha tope del préstamo." required>
        </div>
      </div>

      <div class="col-md-6">
        <!-- Columna izquierda -->
        <div class="form-group">
          <label for="lend_name">Nombre del Prestatario</label>
          <input type="text" class="form-control" id="lend_name" name="lend_name" placeholder="Nombre del prestatario." autocomplete="off">
        </div>
               
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="user_system_check" checked>
                  <label class="form-check-label" for="user_system_check">¿Está el usuario dentro del sistema?</label>
                </div>
      </div>

      <div class="col-md-6">
        <!-- Columna derecha -->
        <div class="form-group">
          <label for="lend_cedula">Cédula del Prestatario</label>
          <input type="text" class="form-control" id="lend_cedula" name="lend_cedula" placeholder="Cédula del prestatario." readonly>
        </div>
      </div>

      <div class="col-md-6">
        <!-- Columna izquierda -->
        <div class="form-group" id="student_lender_pnf">
          <label for="lend_student_pnf">PNF del Prestatario</label>
                              <?php
                    echo "<select name='lend_student_pnf[]' id='lend_student_pnf' class='form-control' style='pointer-events: none;'>";
                    foreach ($tagArray as $row) { // Basicamente va a través del arreglo que hicimos con los contenidos de la tabla tags y pone sus nombres como el nombre de la opción y su id como valor.


                      echo "<option value=$row[name]>$row[name]</option>";
                    }
                    echo "</select>";

                    ?>
        </div>
      </div>

      <div class="col-md-6">
        <!-- Columna derecha -->
        <div class="form-group">
          <label for="lend_location">Sede del Préstamo</label>
          <input type="text" class="form-control" id="lend_location" name="lend_location" placeholder="Sede del préstamo." readonly>
        </div>
      </div>

     <div class="col-md-6">
        <!-- Columna izquierda -->
        <div class="form-group">
          <label for="community_type">Tipo de Comunidad</label>
          <select class="form-control" id="community_type_drop" name="user_type" style="pointer-events: none;">
            <option value="outsider">Comunidad Externa</option>
            <option value="student">Estudiante</option>
            <option value="teacher">Docente</option>
            <option value="admin">Bibliotecario</option>
          </select>
        </div>
     </div>

      <div class="col-md-6">
        <!-- Columna derecha -->
        <div class="form-group">
          <label for="lender_phone">Télefono de Contacto del Prestatario</label>
          <input type="text" class="form-control" id="lender_phone" name="lender_phone" placeholder="Número télefonico del prestatario." readonly>
        </div>
      </div>

    <div class="col-md-6">
        <div class="form-group">
          <label for="search_pub">Nombre de la Publicación</label>
          <input type="text" class="form-control" id="search_pub" name="search_pub" placeholder="Nombre de la publicación prestada." autocomplete="off">
        </div>
                <div class="form-group text-center">
                  <input type="radio" class="btn-check" name="doc_type" id="doc_type_both" value="" checked>
                  <label class="btn btn-outline-primary" for="doc_type_both">Ambos</label>

                  <input type="radio" class="btn-check" name="doc_type" id="doc_type_book" value="<?php echo $docTypeArray[0]['tag_id'] ?>">
                  <label class="btn btn-outline-primary" for="doc_type_book">Libro</label>
                  
                  <input type="radio" class="btn-check" name="doc_type" id="doc_type_thesis" value="<?php echo $docTypeArray[1]['tag_id'] ?>">
                  <label class="btn btn-outline-primary" for="doc_type_thesis">Tesis</label>
              </div>
      </div>



    <div class="col-md-6">
      <div class="form-group">
          <label for="author_names">Autor(es) de la Publicación</label>
          <input type="text" class="form-control" id="author_names" name="author_names" placeholder="Autor(es) de la publicación prestada." readonly>
        </div>
      </div>


        <!-- Centrado -->
        <div class="form-group" id="cota">
          <label for="cota" id="cota-quant-label">Cotas de la Publicación</label>
            <div id="cota_boxes"></div>
          <br>
        </div>


        <!-- Centrado -->
        <label for="lend_type">Tipo de Préstamo</label>
        <div class="form-group text-center">
            <div class="btn-group" role="group" aria-label="Tipo de Préstamo">
                <input type="radio" class="btn-check" name="lend_type" id="lend_type_in" value="Interno" checked>
                <label class="btn btn-outline-primary" for="lend_type_in">Interno</label>
                
                <input type="radio" class="btn-check" name="lend_type" id="lend_type_ex" value="Externo">
                <label class="btn btn-outline-primary" for="lend_type_ex">Externo</label>
            </div>
        </div>

        <!-- Centrado -->
        <div class="form-group">
          <label for="observations" id="observations">Observaciones (Opcional)</label>
          <textarea type="text" class="form-control" id="observations" name="observations" placeholder="Ingresar observaciones (opcional)." maxlength="1500"></textarea>
        </div>

          <input type="hidden"  id="pub_id_hidden" name="pub_id">

      <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-primary" name="register-pub-lending">Registrar</button>
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
var docMode = 0; //Si estamos en modo libro o tesis. 0 es modo todos. Libro es 1 y 2 es modo Tesis.
var userManual = 0; //Si es en modo 0, el administrador selecciona un usuario que está en el sistema. Si esta en modo 1, puede escribir en los demás campos y puede insertar información manual.

//Agarrar botones y valores a cambiar dependiendo del modo.
var userManualSwitch = document.getElementById("user_system_check");


var bothButton = document.getElementById("doc_type_both")
var bookButton = document.getElementById("doc_type_book");
var thesisButton = document.getElementById("doc_type_thesis");

var cedulaField = document.getElementById("lend_cedula");
var studentPNFDrop = document.getElementById("lend_student_pnf");
var communityTypeDrop = document.getElementById("community_type_drop");
var userPhoneField = document.getElementById("lender_phone");

var searchPubField = document.getElementById("search_pub"); 




//Cambio de restricciones dependiendo del botón.

  bothButton.addEventListener("click", function() {
    docMode = 0;
    console.log(bothButton.value);
    // Actualizar los campos
    updateFields();
  });



  bookButton.addEventListener("click", function() {
    docMode = 1;
    console.log(bookButton.value);
    // Actualizar los campos
    updateFields();
  });


  thesisButton.addEventListener("click", function() {
    console.log(thesisButton.value);
    docMode = 2;

    updateFields();
  });

// Add an event listener to listen for the switch state change
userManualSwitch.addEventListener('change', function() {
    // Check if the switch is checked (ON) or not (OFF)
    if (this.checked) {
        // Execute your function when the switch is ON
        console.log('Switch is ON');
        changeUserSearchMode();
    } else {
        // Execute your function when the switch is OFF
        console.log('Switch is OFF');
       changeUserSearchMode();
    }
});


  // Esta función actualiza los campos en base a curMode. Yo pensé que simplemente podría poner la condicional afuera, pero no, tiene que ser llamada por una función.
function updateFields() {
    switch (docMode) {
        default:
        case 0:
            searchPubField.setAttribute('placeholder', 'Nombre de la publicación prestada.');
            break;
        case 1:
            searchPubField.setAttribute('placeholder', 'Nombre del libro prestado.');
            break;
        case 2:
            searchPubField.setAttribute('placeholder', 'Nombre de la tesis prestada.');
            break;
    }
}

function changeUserSearchMode() {

  if (userManual == 0)
  {
    userManual = 1;
    cedulaField.value = "";
    studentPNFDrop.selectedIndex = 0;
    userPhoneField.value = "";



    cedulaField.readOnly = false;
    studentPNFDrop.style.pointerEvents = 'auto';
    communityTypeDrop.style.pointerEvents = 'auto';
    userPhoneField.readOnly = false;
  } else {
    userManual = 0;

    cedulaField.readOnly = true;
    studentPNFDrop.style.pointerEvents = 'none';
    communityTypeDrop.style.pointerEvents = 'none';
    userPhoneField.readOnly = true;

  }
}


</script>
<?php include "footer.php"; ?>