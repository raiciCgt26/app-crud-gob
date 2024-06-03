<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.13.2/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" type="text/css" href="DataTables/Buttons-2.3.4/css/buttons.bootstrap5.min.css" />
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">


  <link rel="icon" type="image/x-icon" href="assets/favicon.ico">


  <script src="DataTables/jQuery-3.6.0/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="DataTables/DataTables-1.13.2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="DataTables/DataTables-1.13.2/js/dataTables.bootstrap5.min.js"></script>
  <script type="text/javascript" src="DataTables/Buttons-2.3.4/js/buttons.bootstrap5.min.js" />
  </script>
  <script type="text/javascript" src="DataTables/Buttons-2.3.4/js/dataTables.buttons.min.js" />
  </script>
  <script type="text/javascript" src="DataTables/Buttons-2.3.4/js/buttons.html5.min.js" />
  </script>
  <script type="text/javascript" src="DataTables/Buttons-2.3.4/js/buttons.print.min.js" />
  </script>
  <script type="text/javascript" src="DataTables/pdfmake-0.1.36/pdfmake.min.js" />
  </script>
  <script type="text/javascript" src="DataTables/pdfmake-0.1.36/vfs_fonts.js" />
  </script>
  <script type="text/javascript" src="DataTables/JSZip-2.5.0/jszip.min.js" />
  </script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="js/main.js"></script>


</head>

<body>
  <?php

  function get_role_name(string $user_role): string
  {
    switch ($user_role) {
      case "admin":
        return "Bibliotecario";
      case "teacher":
        return "Docente";
      case "student":
        return "Estudiante";
      case "outsider":
        return "Comunidad Externa";
      default:
        return "SIN ROL VÁLIDO.";
    }
  }


  if ($title != "Catalogo Bibliotecario de la Universidad Politécnica Territorial del Estado Bolívar") {
    if (isset($_SESSION['loggedin'])) {
      include "partials/headerbar.php";

      if ($_SESSION["user_type"] != "student") {
        include "partials/sidebar.php";
      }
  ?><div class="contents"><?php
                        }
                      }

                          ?>