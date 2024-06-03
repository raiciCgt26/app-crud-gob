<?php

session_start();
$title = "Dashboard";

// Verificar sesión.
if (!isset($_SESSION['loggedin']))
{
    header("Location: index.php");
    exit;
}

if ($_SESSION["user_type"] == "student")
{
  header("Location: cubicle.php");
}

include "header.php";
include "connect.php";
include "datetimecheck.php";

$sqlDoctype = "SELECT tag_id FROM tags WHERE (name = 'Libro' OR name = 'Tesis') AND removed = 0";
$queryResultDoctype = mysqli_query($con, $sqlDoctype);

$docTypeArray = array();


while ($row = mysqli_fetch_array($queryResultDoctype, MYSQLI_ASSOC)) {
  array_push($docTypeArray, $row);
}

$query = "SELECT COUNT(*) FROM publications INNER JOIN pub_join_tags ON publications.pub_id=pub_join_tags.pub_id WHERE publications.removed=0 AND pub_join_tags.tag_id=" . $docTypeArray[0]['tag_id'];
                $num_books = mysqli_query($con, $query);
                $num_books = mysqli_fetch_assoc($num_books);
                $num_books = $num_books["COUNT(*)"];

$queryEssays = "SELECT COUNT(*) FROM publications INNER JOIN pub_join_tags ON publications.pub_id=pub_join_tags.pub_id WHERE publications.removed=0 AND pub_join_tags.tag_id=" . $docTypeArray[1]['tag_id'];
                $num_thesis = mysqli_query($con, $queryEssays);
                $num_thesis = mysqli_fetch_assoc($num_thesis);
                $num_thesis = $num_thesis["COUNT(*)"];


$queryT = "SELECT COUNT(*) FROM tags WHERE tag_category = 'PNF' AND removed = 0";
  if (!is_null($queryT))
  {
    $num_tags = mysqli_query($con, $queryT);
    $num_tags = mysqli_fetch_assoc($num_tags);
    $num_tags = $num_tags["COUNT(*)"];
  }
$query = "SELECT COUNT(*) FROM users";
                $num_users = mysqli_query($con, $query);
                $num_users = mysqli_fetch_assoc($num_users);
                $num_users = $num_users["COUNT(*)"];

//CÓDIGO DE PIECHART

$p_query = "SELECT tag_id, name FROM tags WHERE tag_category = 'PNF' AND removed = 0";
$p_result = mysqli_query($con, $p_query);


//Establecemos dos arreglo vacíos, uno para los números de libros, otro para el número de tesis y el primero para las propias categorías
$tagArray = array();
$bt_Array = array();
$tt_Array = array();

//Este while loop basicamente llena el array de arriba con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($p_result, MYSQLI_ASSOC)) 
{
    array_push($tagArray, $row);
}

//Luego este rellena el segundo array con el número de libros de cada tag, iterando uno por uno por cada miembro del primer array.
foreach ($tagArray as $bt_row)
{
                // Conseguir la cantidad de libros que utilizan esta etiqueta
                $query = "SELECT COUNT(*) FROM pub_join_tags WHERE tag_id = " . $bt_row["tag_id"];
                $num_bt = mysqli_query($con, $query);
                $num_bt = mysqli_fetch_assoc($num_bt);
                array_push($bt_Array,$num_bt);
              }

//Y liberamos la memoría
mysqli_free_result($p_result);

//Luego convertimos el arreglo de categorías en un string conteniendo los nombres y con tildes entre cada miembro. Para el primer y ultimo tilde tenemos que hacerlo manualmente con echo, como puedes ver en el código del propio chart. 
    $ptagNames = array_column($tagArray, "name");
    $ptagNames = implode("', '", $ptagNames);

// Y hacemos lo mismo sin los tildes para los números de libros. 
    $ptagCounts = array_column($bt_Array, "COUNT(*)");
    $ptagCounts = implode(", ", $ptagCounts);


//CÓDIGO DE CHART DE MOVIMIENTOS

//Primermo sacamos la fecha de las 10 entradas más recientes sin repeticiones. Esta es la manera más simple que lo pude hacer.
$au_query = "SELECT date FROM audit_log WHERE mov_id IN (SELECT MAX(mov_id) FROM audit_log GROUP BY mov_id) GROUP BY date ORDER BY date ASC LIMIT 10"; 
$au_result = mysqli_query($con, $au_query);


//Establecemos dos arreglo vacíos, uno para las fechas y otra para las acciones por fecha
$auditArray = array();
$apdArray = array();

//Este while loop basicamente llena el array de arriba con los tag_id y nombres de cada etiqueta una por una.
while ($row = mysqli_fetch_array($au_result, MYSQLI_ASSOC)) 
{
    array_push($auditArray, $row);
}

//Luego este rellena el segundo array con el número de acciones en cada fecha
foreach ($auditArray as $apd_row)
{
                $query = "SELECT COUNT(*) FROM audit_log WHERE DATE(date) = '" . $apd_row["date"] . "'";
                $num_apd = mysqli_query($con, $query);
                $num_apd = mysqli_fetch_assoc($num_apd);
                array_push($apdArray,$num_apd);
              }



//Y liberamos la memoría
mysqli_free_result($au_result);

//El string de las fechas...
    $dateNames = array_column($auditArray, "date");
    $dateNames = implode("', '", $dateNames);

// Y el de los números. 
    $dateCounts = array_column($apdArray, "COUNT(*)");
    $dateCounts = implode(", ", $dateCounts);
?>
<style>
    .custom-taller-card {
        height: 150%; /* Adjust the width as needed */
        /*margin: auto -25%;*/
    }
</style>
<main id="main" class="main">

  <div class="container">
            <div class="col-lg-4 col-xl-6 d-flex flex-column justify-content-center">
       <?php if (!empty($lend_alert)) { ?>
                <div class="alert alert-danger mt-4">
                  <?php echo $lend_alert; ?>
                </div>
              <?php } ?>
        </div>
  </div>

<div class="container mt-5">
    <h1 class="text-center pagetitle">Bienvenido, <?php echo $_SESSION["user_name"]?>.</h1>
</div>
<br>
 <section class="section dashboard">
      <div class="row">

        <!-- Columnas izquierdas -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Carta de Libros -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Publicaciones <span>| Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-bookshelf"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $num_books; ?> 
                      <?php if (($num_books) == 1) { echo "libro."; } else { echo "libros."; } ?></h6>
                      <br>
                      <h6><?php echo $num_thesis; ?> 
                      <?php if (($num_thesis) == 1) { echo "tesis."; } else { echo "tesis."; } ?></h6>                      
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- Fin de Carta de Libros -->

            <!-- Carta de Categorías -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Programas Nacionales de Formación <span>| Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-bookmark-check"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $num_tags; ?> 
                      <?php echo "PNF"; ?></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- Fin de Carta de Categorías -->

            <!-- Carta de Usuarios -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Usuarios <span>| Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                     <h6><?php echo $num_users; ?> 
                      <?php if (($num_users) == 1) { echo "usuario."; } else { echo "usuarios."; } ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- Fin de Carta de Usuarios -->
            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Movimientos</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Movimientos',
                          data: [<?php echo ($dateCounts); ?>],
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'date',
                          categories: [<?php echo "'"; echo ($dateNames); echo "'"; ?>]
                        },
                        tooltip: {
                          x: {
                            format: 'yy/MM/dd'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
 

            </div>
            </div>
<div class="col-lg-4">
      <!-- Website Traffic -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Libros por PNF</h5>

              <div id="trafficChart" style="min-height: 350px;" class="echart"></div>

              <script>

                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      orient: 'horizontal',
                      top: '1%',
                      left: 'center',
                      type: 'scroll'
                    },

                      dataset: {
                        source: {
                          'name': [<?php echo "'"; echo ($ptagNames); echo "'";?>],
                          'value': [<?php echo ($ptagCounts); ?>],
                        }
                    },
                    series: [{
                      name: 'Libros categorizados bajo',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: true,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                        
                  }]
                    });
                });
              </script>
            </div>
          </div><!-- End Website Traffic -->
</div>
</div>
</main>
<?php include "footer.php"; ?>