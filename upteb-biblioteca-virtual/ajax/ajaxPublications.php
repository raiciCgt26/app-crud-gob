    <?php
    //Including Database configuration file.
    include "../connect.php";
    //Getting value of "search" variable from "script.js".
    if (isset($_POST['search_pub'])) {

$publications_autoList = array();

    //Search box value assigning to $Name variable.
       $Name = $_POST['search_pub'];


       $docType = $_POST['doc_type'];

    //Search query
       if (!empty($docType))
       {
        $Query = "SELECT publications.pub_id, publications.name
          FROM publications
          INNER JOIN pub_join_tags
          ON publications.pub_id = pub_join_tags.pub_id
          WHERE publications.name LIKE '%$Name%'
          AND publications.removed = 0
          AND pub_join_tags.tag_id = $docType
          LIMIT 5";
            
        }
        else
        {
            $Query = "SELECT pub_id, name FROM publications WHERE name LIKE '%$Name%' AND removed = 0 LIMIT 5";
        }

   $ExecQuery = mysqli_query($con, $Query);
   if ($ExecQuery) {
        //Este while loop basicamente llena el array de arriba con los resultados
        while ($row = mysqli_fetch_array($ExecQuery, MYSQLI_ASSOC)) 
        {
            array_push($publications_autoList,$row);
        }
        
        echo json_encode($publications_autoList, JSON_PRETTY_PRINT);
   } else {
       echo "Query execution failed: " . mysqli_error($con);
   }
}
    ?>