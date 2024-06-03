<?php
/* Actualmente inutilizadas - Funciones de estado de libro.*/
abstract class BookState
{
    const BuenaCalidad = 1;
    const CalidadDecente = 2;
    const MalaCalidad = 3;
}

function book_state_get_name(int $book_state): string {
  switch ($book_state) {
    case BookState::BuenaCalidad:
      return "Buena Calidad";
    case BookState::CalidadDecente:
      return "Calidad Decente";
    case BookState::MalaCalidad:
      return "Mala Calidad";
    default:
      return "Buena Calidad";
  }
}


function book_state_get_index(string $book_state): int {
  switch ($book_state) {
    case "Buena Calidad":
      return BookState::BuenaCalidad;
    case "Calidad Decente":
      return BookState::CalidadDecente;
    case "Mala Calidad":
      return BookState::MalaCalidad;
    default:
      return "1";
  }
}

/* Fin de funciones inutilizadas */



abstract class AuditAction
{
    public const AccountRegister = 1;
    public const UserNew = 2;
    public const UserEdit = 3;
    public const UserDelete = 4;

    public const BookNew = 5;
    public const BookEdit = 6;
    public const BookDelete = 7;

    public const TagNew = 8;
    public const TagEdit = 9;
    public const TagDelete = 10;

    public const BackupMake = 11;

    public const ThesisNew = 12;
    public const ThesisEdit = 13;
    public const ThesisDelete = 14;

    public const PubLendRegister = 15;
    public const PubLendEdit = 16;
    public const PubLendDeliver = 17;
    public const PubLendDelete = 18;
}

function audit_action_get_name(int $audit_action): string {
  switch ($audit_action) {
    case AuditAction::AccountRegister:
      return "Registro de Cuenta";
    case AuditAction::UserNew:
      return "Nuevo Usuario";
    case AuditAction::UserEdit:
      return "Actualización de Datos";
    case AuditAction::UserDelete:
      return "Eliminación de Usuario";

    case AuditAction::BookNew:
      return "Nuevo Libro";
    case AuditAction::BookEdit:
      return "Modificación de Libro";
    case AuditAction::BookDelete:
      return "Eliminación de Libro";

    case AuditAction::TagNew:
      return "Nueva Categoría";
    case AuditAction::TagEdit:
      return "Modificación de Categoría";
    case AuditAction::TagDelete:
      return "Eliminación de Categoría";

    case AuditAction::BackupMake:
      return "Creación de Respaldo";

    case AuditAction::ThesisNew:
      return "Nueva Tesis";
    case AuditAction::ThesisEdit:
      return "Modificación de Tesis";
    case AuditAction::ThesisDelete:
      return "Eliminación de Tesis";

    case AuditAction::PubLendRegister:
      return "Prestamo de Publicación.";
    case AuditAction::PubLendEdit:
      return "Prestamo de Publicación Modificado.";
    case AuditAction::PubLendDeliver:
      return "Prestamo de Publicación Finalizada.";
    case AuditAction::PubLendDelete:
      return "Prestamo de Publicación Eliminada.";

    default:
      return "N/A";
  }


}


// Esta función basicamente maneja todo acerca de como funciona el registro de movimientos. Cada vez que hay una modificación de algún dato relevante la llamas y colocas los parametros. El audit action es el tipo de modificación, si modificas un libro pones su id, si no modificas algo pones null, etc. 
function audit_log(int $audit_action, ?int $target_pub_id, ?int $target_user_id, ?int $target_tag_id)
{
    global $con;
    $user_id = $_SESSION["user_id"];
    $stmt = mysqli_prepare($con, "INSERT INTO audit_log (action_id, user_id, target_pub_id, target_user_id, target_tag_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'iiiii', $audit_action, $user_id, $target_pub_id, $target_user_id, $target_tag_id);
    
    return mysqli_stmt_execute($stmt);

}

//Función de respaldo proporcionada por el profesor
function exportarTablas($host, $usuario, $pasword, $nombreDeBaseDeDatos)
{
    set_time_limit(3000);
    $tablasARespaldar = [];
    $mysqli = new mysqli($host, $usuario, $pasword, $nombreDeBaseDeDatos);
    $mysqli->select_db($nombreDeBaseDeDatos);
    $mysqli->query("SET NAMES 'utf8'");
    $tablas = $mysqli->query('SHOW TABLES');
    while ($fila = $tablas->fetch_row()) {
        $tablasARespaldar[] = $fila[0];
    }
    $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $nombreDeBaseDeDatos . "`\r\n--\r\n\r\n\r\n";
    foreach ($tablasARespaldar as $nombreDeLaTabla) {
        if (empty($nombreDeLaTabla)) {
            continue;
        }
        $datosQueContieneLaTabla = $mysqli->query('SELECT * FROM `' . $nombreDeLaTabla . '`');
        $cantidadDeCampos = $datosQueContieneLaTabla->field_count;
        $cantidadDeFilas = $mysqli->affected_rows;
        $esquemaDeTabla = $mysqli->query('SHOW CREATE TABLE ' . $nombreDeLaTabla);
        $filaDeTabla = $esquemaDeTabla->fetch_row();
        $contenido .= "\n\n" . $filaDeTabla[1] . ";\n\n";
        for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
            while ($fila = $datosQueContieneLaTabla->fetch_row()) {
                //La primera y cada 100 veces
                if ($contador % 100 == 0 || $contador == 0) {
                    $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                }
                $contenido .= "\n(";
                for ($j = 0; $j < $cantidadDeCampos; $j++) {
                    $fila[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
                    if (isset($fila[$j])) {
                        $contenido .= '"' . $fila[$j] . '"';
                    } else {
                        $contenido .= '""';
                    }
                    if ($j < ($cantidadDeCampos - 1)) {
                        $contenido .= ',';
                    }
                }
                $contenido .= ")";
                # Cada 100...
                if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                    $contenido .= ";";
                } else {
                    $contenido .= ",";
                }
                $contador = $contador + 1;
            }
        }
        $contenido .= "\n\n\n";
    }
    $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

    # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
    $carpeta = __DIR__ . "/backup";
    if (!file_exists($carpeta)) {
        mkdir($carpeta);
    }
    date_default_timezone_set('America/La_paz');
    # Calcular un ID único
    $id = date("h.i.s A");

    # También la fecha
    $fecha = date("d-m-Y");

    # Crear un archivo que tendrá un nombre como respaldo_2018-10-22_asd123.sql
    $nombreDelArchivo = sprintf('%s/Respaldo_%s_%s.sql', $carpeta, $fecha, $id);

    #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
    return file_put_contents($nombreDelArchivo, $contenido) !== false;
  
  
}

?>