<?php
include('C:\xampp\htdocs\backend\php\dbconnection.php');

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $sql = mysqli_query($con, "SELECT * FROM datos_pers WHERE id='$id'");
  if (mysqli_num_rows($sql) > 0) {
    // El registro existe, procede con la eliminación...
    $deleteSql = mysqli_query($con, "DELETE FROM datos_pers WHERE id='$id'");
    if ($deleteSql) {
      echo "<script>alert('eliminado correctamente')</script>";
      echo "<script type='text/javascript'> document.location.href = '/frontend/view/admin/level_admin.php'; </script>";
    } else {
      echo "<script>alert('hubo un error al eliminar')</script>";
    }
  } else {
    echo "<script>alert('El registro no existe')</script>";
  }
}
