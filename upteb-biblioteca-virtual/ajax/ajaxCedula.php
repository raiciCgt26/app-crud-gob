    <?php
    //Including Database configuration file.
    include "../connect.php";
    //Getting value of "search_ced" variable from "search_script.js", which occurs after a succesful query of users.
    if (isset($_POST['search_ced'])) {
    //Se asigna el valor a esta variable.
       $user_ids = $_POST['search_ced'];

       $user_details_array = array();

    // Check if there's only one user_id in the array
    if (count($user_ids) == 1) {
        // Extract the single user_id from the array
        $user_id = reset($user_ids); // Asegurarse que sea el primero.


           $userDetailsExtractQuery = "SELECT * FROM users WHERE user_id = $user_id";
           $user_details_result = mysqli_query($con, $userDetailsExtractQuery);

           if ($user_details_result) {
                //Este while loop basicamente llena el array de arriba con los resultados
                while ($row = mysqli_fetch_array($user_details_result, MYSQLI_ASSOC)) 
                {
                    array_push($user_details_array,$row);
                }
                
                echo json_encode($user_details_array, JSON_PRETTY_PRINT);
           } else {
               echo "Query execution failed: " . mysqli_error($con);
           }

    } else {
           echo "Buscando usuario...";
       }
}
    ?>
