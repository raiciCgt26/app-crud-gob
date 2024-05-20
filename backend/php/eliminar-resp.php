

<?php
// Ruta del archivo de respaldo
$backup_file = 'copia_de_seguridad.sql';

// Verificar si el archivo existe antes de intentar eliminarlo
if (file_exists($backup_file)) {
  // Intentar eliminar el archivo
  if (unlink($backup_file)) {
    // Archivo eliminado con éxito, mostrar modal de eliminación exitosa
    echo "<script>window.onload = function() {
      mostrarModalDeleteCopiaSeguridad();
    };</script>";
  } else {
    // Error al intentar eliminar el archivo, mostrar modal de error al eliminar
    echo "<script>window.onload = function() {
      mostrarModalErrorEliminar();
    };</script>";
  }
} else {
  // El archivo de respaldo no existe, mostrar modal de respaldo no existente
  echo "<script>window.onload = function() {
    mostrarModalRespaldoNoExiste();
  };</script>";
}
?>