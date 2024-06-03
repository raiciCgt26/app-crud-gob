    <?php
    //Incluir la conexión a la base de datos.
    include "../connect.php";
    //Sacar el valor de la página web mediante el script de ajax. En este caso, el pub_id.
    if (isset($_POST['search_cotas'])) {
    
    // Inicializar el arreglo y asignar el valor a una variable.

        $cota_array = array();

       $pub_ids = $_POST['search_cotas'];



    // Asegurarse que solo haya un pub_id
    if (count($pub_ids) == 1) {
        // Extraer este un elemento.
        $pub_id = reset($pub_ids); 

        // En caso de que la cota YA esté en prestamo, no mostrarla aquí. MODIFICARLA PARA QUE VERIFIQUE PUB_LENDING ESTÉ ACTIVO.
         $Query = "SELECT pub_cota_data.* 
              FROM pub_cota_data 
              LEFT JOIN pub_lent_cotas ON pub_cota_data.pub_cd_id = pub_lent_cotas.cota_id 
              WHERE pub_cota_data.pub_id = $pub_id AND pub_lent_cotas.cota_id IS NULL";


           $cota_result = mysqli_query($con, $Query);
            
           if ($cota_result) {
         //Este while loop basicamente llena el array de arriba con los resultados
                while ($row = mysqli_fetch_array($cota_result, MYSQLI_ASSOC)) 
                {
                    array_push($cota_array,$row);
                }
                
                echo json_encode($cota_array, JSON_PRETTY_PRINT);
           } else {
               echo "Query execution failed: " . mysqli_error($con);
           }

    } else {
           echo "Buscando cotas...";
       }
}
    ?>
