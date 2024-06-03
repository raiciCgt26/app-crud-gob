    <?php
//Esta versión se utiliza cuando se edita una publicación para mostrar todas sus cotas incluyendo con un check las que ya están en uso.

    //Incluir la conexión a la base de datos.
    include "../connect.php";
    //Sacar el valor de la página web mediante el script de ajax. En este caso, el pub_id.
    if (isset($_POST['search_cotas'])) {
    
    // Inicializar el arreglo y asignar el valor a una variable.

        $cota_array = array();

       $pub_ids = $_POST['search_cotas'];

        $lent_cotas = array();
        $lent_query = "SELECT cota_id FROM pub_lent_cotas";
        $lent_result = mysqli_query($con, $lent_query);

            if ($lent_result) {
                while ($lent_row = mysqli_fetch_array($lent_result, MYSQLI_ASSOC)) {
                    $lent_cotas[] = $lent_row['cota_id'];
                }
            } else {
                echo "Error buscando cotas prestadas: " . mysqli_error($con);
                exit;
            }
        


    // Asegurarse que solo haya un pub_id
    if (count($pub_ids) == 1) {
        // Extraer este un elemento.
        $pub_id = reset($pub_ids); 

        //Agarrar todas las cotas sin restricción.
         $Query = "SELECT * FROM pub_cota_data WHERE pub_id = $pub_id";


           $cota_result = mysqli_query($con, $Query);
            
           if ($cota_result) {
         //Este while loop basicamente llena el array de arriba con los resultados
                while ($row = mysqli_fetch_array($cota_result, MYSQLI_ASSOC)) 
                {
                    // Chequear si la cota esta en el arreglo de cotas en prestamos y si lo es, marcar checked como verdadero o falso.
                    $checked = in_array($row['pub_cd_id'], $lent_cotas);
                    // Agregar una columna al arreglo que mantenga los datos si el checked es verdadero o falso.
                    $row['checked'] = $checked;
                    // Empujar hacía el arreglo.
                    array_push($cota_array, $row);
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
