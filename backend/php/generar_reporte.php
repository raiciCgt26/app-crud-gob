<?php
require_once('/xampp/htdocs/frontend/aseets/tcpdf/tcpdf.php');

// Conectar a la base de datos
$host = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'app';

$con = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_errno()) {
  echo "Conexión fallida: " . mysqli_connect_errno();


  exit();
}

// Recuperar los valores de los filtros
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$category = $_POST['category'] ?? '';
$status = $_POST['status'] ?? '';

// Consulta SQL para obtener los datos
$sql = "SELECT * FROM incidencias WHERE 1=1";
if (!empty($startDate)) {
  $startDate = mysqli_real_escape_string($con, $startDate);
  $sql .= " AND fecha >= '$startDate'";
}
if (!empty($endDate)) {
  $endDate = mysqli_real_escape_string($con, $endDate);
  $sql .= " AND fecha <= '$endDate'";
}
if (!empty($category)) {
  $category = mysqli_real_escape_string($con, $category);
  $sql .= " AND categoria='$category'";
}
if (!empty($status)) {
  $status = mysqli_real_escape_string($con, $status);
  $sql .= " AND estado='$status'";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
  // Crear un nuevo objeto TCPDF


  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // Establecer información del documento
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Author');
  $pdf->SetTitle('Reporte');
  $pdf->SetSubject('Reporte de incidencias');
  $pdf->SetKeywords('TCPDF, PDF, ejemplo, reporte, incidencias');

  // Establecer márgenes


  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // Establecer auto-rotación y auto-escala de páginas
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');




  // Establecer estilo de fuente


  $pdf->SetFont('helvetica', '', 6);

  // Agregar una página
  $pdf->AddPage();


  // Encabezado de la tabla
  $pdf->SetFillColor(150, 150, 150);
  $pdf->MultiCell(6, 10, 'ID', 1, 'C', 1, 0);
  $pdf->MultiCell(20, 10, 'Titulo', 1, 'C', 1, 0);
  $pdf->MultiCell(14, 10, 'Estado', 1, 'C', 1, 0);
  $pdf->MultiCell(14, 10, 'Fecha', 1, 'C', 1, 0);
  $pdf->MultiCell(14, 10, 'Prioridad', 1, 'C', 1, 0);
  $pdf->MultiCell(16, 10, 'Solicitante', 1, 'C', 1, 0);
  $pdf->MultiCell(18, 10, 'Tecnico', 1, 'C', 1, 0);
  $pdf->MultiCell(18, 10, 'Grupo', 1, 'C', 1, 0);
  $pdf->MultiCell(60, 10, 'Categoria', 1, 'C', 1, 1);

  // Datos de la tabla


  while ($row = $result->fetch_assoc()) {
    $pdf->MultiCell(6, 10, $row['id'], 1, 'C', 0, 0);
    $pdf->MultiCell(20, 10, $row['titulo'], 1, 'C', 0, 0);
    $pdf->MultiCell(14, 10, $row['estado'], 1, 'C', 0, 0);
    $pdf->MultiCell(14, 10, $row['fecha'], 1, 'C', 0, 0);
    $pdf->MultiCell(14, 10, $row['prioridad'], 1, 'C', 0, 0);
    $pdf->MultiCell(16, 10, $row['solicitante'], 1, 'C', 0, 0);
    $pdf->MultiCell(18, 10, $row['tecnico'], 1, 'C', 0, 0);
    $pdf->MultiCell(18, 10, $row['grupo'], 1, 'C', 0, 0);



    // Ajustar la celda de categoría para manejar el desbordamiento
    $pdf->MultiCell(60, 10, $row['categoria'], 1, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
  }



  // Salida del PDF
  $pdf->Output('reporte.pdf', 'D');
} else {
  echo "No se encontraron registros.";
}

$con->close();
