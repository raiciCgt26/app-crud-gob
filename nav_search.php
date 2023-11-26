<?php

include('php/link.php');

$search = $_POST['search'];

if (!empty($search)) {
  $query = "SELECT * FROM incidencias WHERE Titulo LIKE '$search%'";
  $result = mysqli_query($LINK, $query);
  if (!$result) {
    die('Query Error' . mysqli_error($LINK));
  }
  $json = array();
  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id' => $row['id'],
      'Titulo' => $row['Titulo'],
      'Estado' => $row['Estado'],
      'Ultima fecha de modificación' => $row['Ultima fecha de modificación'],
      'Prioridad' => $row['Prioridad'],
      'Solicitante' => $row['Solicitante'],
      'Asignado a - técnico' => $row['Asignado a - técnico'],
      'Asignado a - grupo técnico' => $row['Asignado a - grupo técnico'],
      'Categoría' => $row['Categoría']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}
