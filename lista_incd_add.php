<?php
include('php/link.php');

if (isset($_POST['titulo'])) {
  $titulo = $_POST['titulo'];
  $estado = $_POST['estado'];
  $modificacion = $_POST['modificacion'];
  $prioridad = $_POST['prioridad'];
  $Solicitante = $_POST['Solicitante'];
  $AsigTecnico = $_POST['AsigTecnico'];
  $AsigGrupo = $_POST['AsigGrupo'];
  $Categoria = $_POST['Categoria'];
  $query = "INSERT into incidencias(titulo,estado,modificacion,prioridad,Solicitante,AsigTecnico,AsigGrupo,Categoria) VALUES ('$titulo','$estado','$modificacion','$prioridad','$Solicitante','$AsigTecnico','$AsigGrupo','$Categoria')";
  $result = mysqli_query($LINK, $query);

  if (!$result) {
    die('Query Error fatal.');
  }
  echo 'Incidencia agregada correctamente';
}
