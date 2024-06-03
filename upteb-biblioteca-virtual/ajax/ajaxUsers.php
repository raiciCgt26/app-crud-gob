    <?php
    //Including Database configuration file.
    include "../connect.php";
    //Getting value of "search" variable from "script.js".
    if (isset($_POST['search_users'])) {

$users_autoList = array();

    //Search box value assigning to $Name variable.
       $Name = $_POST['search_users'];


    //Search query
    $Query = "SELECT user_id, username FROM users WHERE username LIKE '%$Name%' LIMIT 5";
        

   $ExecQuery = mysqli_query($con, $Query);
   if ($ExecQuery) {
        //Este while loop basicamente llena el array de arriba con los resultados
        while ($row = mysqli_fetch_array($ExecQuery, MYSQLI_ASSOC)) 
        {
            array_push($users_autoList,$row);
        }
        
        echo json_encode($users_autoList, JSON_PRETTY_PRINT);
   } else {
       echo "Query execution failed: " . mysqli_error($con);
   }
}
    ?>