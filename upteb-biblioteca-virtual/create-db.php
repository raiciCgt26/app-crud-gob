<?php

$con = 0;

include "connect.php";

$con = mysqli_connect($servername, $username, $password);

$sql = "CREATE DATABASE " . $dbname;

if (mysqli_query($con, $sql))
{
    echo "Base de datos creada exitósamente<br>";
}
else
{
    echo "Error creando base de datos: " . mysqli_error($con) . "<br>";
}

// Crear nueva conexión a base de datos
$con = mysqli_connect($servername, $username, $password, $dbname);

// Crear tabla de usuarios
$sql = "CREATE TABLE users (
    user_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(45) NOT NULL,
    password VARCHAR(255),
    email VARCHAR(85),
    user_type VARCHAR(20) NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    cedula_id VARCHAR(20) NOT NULL,
    pnf VARCHAR(50),
    auto_register INT(6) UNSIGNED NOT NULL 
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla creada exitósamente<br>";
}
else
{
    echo "Error durante creación de tabla: " . mysqli_error($con) . "<br>";
}

// Encriptar contraseña
$password = password_hash("password", PASSWORD_BCRYPT);

// Preparar la inserción de datos.
$stmt = mysqli_prepare($con, "INSERT INTO users (username, password, email, user_type, contact_number, cedula_id, pnf, auto_register) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'sssssssi', $username, $password, $email, $user_type, $contact, $cedula_id, $pnf, $auto_register);

// Crear parametros de prueba.
$username = "admin";
$email = "admin@example.com";
$user_type = "admin";
$contact = "0412-5550134";
$cedula_id = "20615411";
$pnf = "Ninguno";
$auto_register = 0;

if (mysqli_stmt_execute($stmt))
{
    echo "Usuario de prueba insertado exitósamente<br>";
}
else
{
    echo "Error insertando usuario de prueba: " . mysqli_error($con) . "<br>";
}

// Crear parametros de prueba, esta vez para un usuario común.
$username = "Jesús Fereira";
$email = "testuser@example.com";
$user_type = "teacher";
$contact = "0412-5550148";
$cedula_id = "24605502";
$pnf = "Informática";
$auto_register = 0;

if (mysqli_stmt_execute($stmt))
{
    echo "Usuario de prueba insertado exitósamente<br>";
}
else
{
    echo "Error insertando usuario de prueba: " . mysqli_error($con) . "<br>";
}

// Crear tabla de libros y tesis (PUBLICACIONES).
$sql = "CREATE TABLE publications (
    pub_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(500) NOT NULL,
    description VARCHAR(5000),
    code VARCHAR(15),
    quantity INT(6) UNSIGNED NOT NULL,
    state INT(6),
    link VARCHAR(255),
    removed BOOLEAN NOT NULL DEFAULT 0
    )";
    
if (mysqli_query($con, $sql))
{
    echo "Tabla de publicaciones creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de publicaciones: " . mysqli_error($con) . "<br>";
}

// Agregar libro a la tabla
$stmt = mysqli_prepare($con, "INSERT INTO publications (name, description, code, quantity, state) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'sssii', $name, $description, $code, $quantity, $state);

// Crear parametros de prueba
$name = "El lenguaje de programación C";
$description = "Programación en C.";
$code = "9789688802052";
$quantity = 1;
$state = 1;

//$publish = "PRENTICE HALL HISPANOAMERICANA S.A";

if (mysqli_stmt_execute($stmt))
{
    echo "Libro de prueba insertado exitósamente<br>";
}
else
{
    echo "Error insertando libro de prueba: " . mysqli_error($con) . "<br>";
}

// Crear tabla de fuentes citadas (Autores, citas, tutores, editoriales).
$sql = "CREATE TABLE cited_sources (
    source_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    pub_id INT(6) UNSIGNED,
    role VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (pub_id) REFERENCES publications(pub_id)
    )";
    
if (mysqli_query($con, $sql))
{
    echo "Tabla de fuentes citadas creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de fuentes: " . mysqli_error($con) . "<br>";
}

// Agregar fuente a la tabla
$stmt = mysqli_prepare($con, "INSERT INTO cited_sources (role, name) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'ss', $role, $name);

// Crear parametros de prueba
$pub_id = 01;
$role = "Autor";
$name = "BRIAN W. KERNIGHAN"; //Autor

if (mysqli_stmt_execute($stmt))
{
    echo "Fuente de prueba insertado exitósamente<br>";
}
else
{
    echo "Error insertando fuente de prueba: " . mysqli_error($con) . "<br>";
}


// Crear tabla de cotas (Porque cada libro tiene múltiples cotas dependientes del ejemplar).
$sql = "CREATE TABLE pub_cota_data (
    pub_cd_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    pub_id INT(6) UNSIGNED,
    prefix_string VARCHAR(150),
    cota VARCHAR(25),
    FOREIGN KEY (pub_id) REFERENCES publications(pub_id)
    )";
    
if (mysqli_query($con, $sql))
{
    echo "Tabla de cotas creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de cotas: " . mysqli_error($con) . "<br>";
}

// Agregar fuente a la tabla
$stmt = mysqli_prepare($con, "INSERT INTO pub_cota_data (prefix_string, cota) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'ss', $prefix, $cota);

// Crear parametros de prueba
$pub_id = 01;
$prefix = "";
$cota = "01"; 

if (mysqli_stmt_execute($stmt))
{
    echo "Cota de prueba insertado exitósamente<br>";
}
else
{
    echo "Error insertando cota de prueba: " . mysqli_error($con) . "<br>";
}


// Crear tabla de etiquetas (con la cual interactúa usuario)
$sql = "CREATE TABLE tags (
    tag_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(50) NOT NULL,
    description VARCHAR(500),
    tag_category VARCHAR(255) NOT NULL DEFAULT 'PNF',
    removed BOOLEAN NOT NULL DEFAULT 0
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla de etiquetas creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de etiquetas: " . mysqli_error($con) . "<br>";
}

// Agregar una etiqueta a la tabla
$stmt = mysqli_prepare($con, "INSERT INTO tags (name, description, tag_category) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'sss', $name, $description, $tag_category);

// Crear parametros para etiqueta
$name = "Ninguno";
$description = "Esta etiqueta se utiliza para libros miscelaneos que son de uso general o no caben dentro del molde de los PNF existentes.";
$tag_category = "PNF";


if (mysqli_stmt_execute($stmt))
{
    echo "Cita Ninguna insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta
$name = "Informática";
$description = "El PNF en Informática tiene como fin promover un conjunto de estudios y actividades académicas conducentes a los títulos de Técnico o Técnica Superior Universitaria en Informática e Ingeniero o Ingeniera en Informática, así como el grado de Especialista en áreas afines, donde se asocia el conocimiento con la investigación en escenarios reales, utilizando como método el diseño, desarrollo y puesta en marcha de Proyectos Socio Tecnológicos.";
$tag_category = "PNF";


if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Informática insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta
$name = "Materiales Industriales";
$description = "El PNF en Materiales Industriales está dirigido a la formación de un profesional con conocimiento integral sobre los PNFles, capaz de diseñar, seleccionar, transformar, usar y aplicar los diferentes PNFles de ingeniería.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de M.I insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Higiene y Seguridad Laboral";
$description = "El PNF en Higiene y Seguridad Laboral, está dirigido a la formación de un profesional con una visión integral del ser humano, con sentido social y responsabilidad ambientalista, capacitado para el diseño, instalación, operación, evaluación, gerencia, investigación e innovación en el área de higiene y seguridad.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Higiene insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Electricidad";
$description = "El PNF en Electricidad está dirigido a la formación de un profesional con pensamiento crítico, científico humanista, con habilidades técnicas y científicas orientadas a la planificación, diseño, desarrollo, evaluación, construcción, innovación, instalación, operación, mantenimiento y supervisión en sistemas eléctricos.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Electricidad insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Geociencias";
$description = "El PNF en Geociencias es concebido en función de satisfacer la necesidad de formar profesionales en el área de Geociencias, con principios, visión integral, valores y pertinencia social.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Geociencias insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Mecánica";
$description = "El PNF en Mecánica está dirigido a la formación de un profesional para identificar, abordar y resolver problemas relacionados con el análisis, diseño, construcción, montaje puesta en marcha, operación, mantenimiento, desincorporación y desecho de equipos e instalaciones industriales.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Mecánica insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Química";
$description = "El PNF en Química tiene como objetivo promover en los actores del proceso educativo el talento para el análisis psicoquímico y la producción de sustancias o formulaciones químicas en diferentes escalas para lograr la transformación del aparato socioproductivo de la nación, fundamentado en valores éticos, biocéntricos, sociales y una clara identidad regional, nacional, latinoamericana y caribeña.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Química insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Orfebrería y Joyería";
$description = "El PNF en Orfebrería y Joyería forma a profesionales con experiencia específica en el proceso de producción de joyas que, adicionalmente, pueda desempeñar cargos de coordinación en el proceso de producción.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Joyería insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Sistemas de Calidad y Ambiente";
$description = "El PNF en Sistemas de Calidad y Ambiente se diseña para dar respuesta a la necesidad de transformación del modelo tecnológico nacional, orientándolo con principios éticos, políticos, ideológicos y revolucionarios, hacia la formación de un ser humano integral, sensibilizado a la problemática social de las distintas organizaciones.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Calidad insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Agroalimentación";
$description = "El PNF en Agroalimentación forma un profesional integral con una visión comprehensiva de la realidad agrícola del país, capaz de abordar sistémicamente el conjunto de la cadena agroalimentaria (producción, transformación, distribución y consumo), con un enfoque agroecológico.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Agroalimentación insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Ingenieria de Mantenimiento";
$description = "El PNF en Ingeniería de Mantenimiento es una gestión de tecnología y debe ser transversal a todo el proceso de producción de bienes y servicios, abarcando actividades desde la concepción del proyecto, ingeniería conceptual, diseño, ingeniería básica y de detalle, hasta la instalación, puesta en marcha, producción y sobre todo un amplio apoyo y seguimiento durante la fase de operación. ";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Mantenimiento insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}


// Crear parametros para etiqueta
$name = "Distribución y Logística";
$description = "El PNF en Distribución y Logística.";
$tag_category = "PNF";

if (mysqli_stmt_execute($stmt))
{
    echo "Cita de Logística insertado exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta
$name = "Casco Histórico";
$description = "La biblioteca ubicada en la sede del Casco Histórico.";
$tag_category = "Ubicación";

if (mysqli_stmt_execute($stmt))
{
    echo "Categoria de Ubicación insertada exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta
$name = "Germania";
$description = "La biblioteca ubicada en la sede de la Germania.";
$tag_category = "Ubicación";

if (mysqli_stmt_execute($stmt))
{
    echo "Categoria de Ubicación insertada exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta
$name = "Aldea";
$description = "La biblioteca ubicada en la sede de la Aldea. Aún no está activa.";
$tag_category = "Ubicación";

if (mysqli_stmt_execute($stmt))
{
    echo "Categoria de Ubicación insertada exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta DE TIPO DE DOCUMENTO
$name = "Libro";
$description = "Libros en la poseción por la institución.";
$tag_category = "Documento";

if (mysqli_stmt_execute($stmt))
{
    echo "Categoria de Ubicación insertada exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}

// Crear parametros para etiqueta DE TIPO DE DOCUMENTO
$name = "Tesis";
$description = "Tesis de proyectos sociales desarrollados en la institución.";
$tag_category = "Documento";

if (mysqli_stmt_execute($stmt))
{
    echo "Categoria de Ubicación insertada exitósamente<br>";
}
else
{
    echo "Error insertando cita: " . mysqli_error($con) . "<br>";
}





// Crear tabla de control de etiquetas
$sql = "CREATE TABLE pub_join_tags (
    pt_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pub_id INT(6) UNSIGNED NOT NULL,
    tag_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (pub_id) REFERENCES publications(pub_id),
    FOREIGN KEY (tag_id) REFERENCES tags(tag_id)
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla de control de etiquetas creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de control de etiquetas: " . mysqli_error($con) . "<br>";
}

// Agregar entrada
$stmt = mysqli_prepare($con, "INSERT INTO pub_join_tags (pub_id, tag_id) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'ii', $pub_id, $tag_id);

// Crear parametros
$pub_id = 01;
$tag_id = 02;


if (mysqli_stmt_execute($stmt))
{
    echo "Join_tags de prueba insertada exitósamente<br>";
}
else
{
    echo "Error insertando join_tags: " . mysqli_error($con) . "<br>";
}

// Crear parametros
$pub_id = 01;
$tag_id = 14;


if (mysqli_stmt_execute($stmt))
{
    echo "Join_tags de prueba insertada exitósamente<br>";
}
else
{
    echo "Error insertando join_tags: " . mysqli_error($con) . "<br>";
}

// Crear parametros
$pub_id = 01;
$tag_id = 17;


if (mysqli_stmt_execute($stmt))
{
    echo "Join_tags de prueba insertada exitósamente<br>";
}
else
{
    echo "Error insertando join_tags: " . mysqli_error($con) . "<br>";
}



// Crear la tabla de acciones complejas de libro (prestamos)
$sql = "CREATE TABLE pub_lending (
    book_act_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    focus_user_id INT(6) UNSIGNED NOT NULL,
    focus_pub_id INT(6) UNSIGNED NOT NULL,
    observations VARCHAR(1500),
    lend_type VARCHAR(25) NOT NULL, 
    lend_status VARCHAR(50) NOT NULL,
    start_date DATE,
    end_date DATE,
    quantity INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (focus_pub_id) REFERENCES publications(pub_id),
    FOREIGN KEY (focus_user_id) REFERENCES users(user_id)
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla de prestamo de libro creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de acciones de libro: " . mysqli_error($con) . "<br>";
}

// Crear tabla de control de cotas siendo prestadas (estamos haciendo esto para mantener Normalización de tercera forma lo más cercano posible.)
$sql = "CREATE TABLE pub_lent_cotas (
    plc_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pub_lend_id INT(6) UNSIGNED NOT NULL,
    cota_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (pub_lend_id) REFERENCES pub_lending(book_act_id),
    FOREIGN KEY (cota_id) REFERENCES pub_cota_data(pub_cd_id)
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla de control de cotas siendo prestadas creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de control de  cotas siendo prestadas: " . mysqli_error($con) . "<br>";
}


// Crear la tabla de movimientos
$sql = "CREATE TABLE audit_log (
    mov_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    user_id INT(6) UNSIGNED NOT NULL,
    action_id INT(6) UNSIGNED NOT NULL,
    target_pub_id INT(6) UNSIGNED,
    target_user_id INT(6) UNSIGNED,
    target_tag_id INT(6) UNSIGNED,
    capture_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
    date DATE AS (DATE(capture_dt)),
    time TIME AS (TIME(capture_dt)),
    FOREIGN KEY (target_pub_id) REFERENCES publications(pub_id),
    FOREIGN KEY (target_tag_id) REFERENCES tags(tag_id)
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla de movimientos creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de movimientos: " . mysqli_error($con) . "<br>";
}

// Agregar un registro a la tabla.
$stmt = mysqli_prepare($con, "INSERT INTO audit_log (user_id, action_id, target_pub_id, target_user_id, target_tag_id) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'iiiii', $user_id, $action_id, $target_pub_id, $target_user_id, $target_tag_id);

// Crear parametros para el registro
$user_id = 1;
$action_id = 5;
$target_pub_id = 1;
$target_user_id = 1;
$target_tag_id = 1;

mysqli_stmt_execute($stmt);

// Tabla de preguntas de seguridad
$sql = "CREATE TABLE security_answers (
    security_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    user_id INT(6) UNSIGNED NOT NULL,
    answer0 VARCHAR(255) NOT NULL,
    answer1 VARCHAR(255) NOT NULL,
    answer2 VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";

if (mysqli_query($con, $sql))
{
    echo "Tabla de preguntas de seguridad creada exitósamente<br>";
}
else
{
    echo "Error creando tabla de preguntas de seguridad: " . mysqli_error($con) . "<br>";
}

// Agregar preguntas de seguridad por defecto
$stmt = mysqli_prepare($con, "INSERT INTO security_answers (user_id, answer0, answer1, answer2) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'isss', $user_id, $answer0, $answer1, $answer2);

// Crear parametros de preguntas de seguridad
$user_id = 1;
$answer0 = "Clockwork Orange";
$answer1 = "Margarita";
$answer2 = "Hallaca";

mysqli_stmt_execute($stmt);

// Cerrar todo
mysqli_stmt_close($stmt);
mysqli_close($con);
?>