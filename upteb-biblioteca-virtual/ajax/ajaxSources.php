    <?php
    //Including Database configuration file.
    include "../connect.php";
    //Getting value of "search_names" variable from "search_script.js", which occurs after a succesful query of publications.
    if (isset($_POST['search_ids'])) {
    //Search box value assigning to $Name variable.
       $pub_ids = $_POST['search_ids'];



    // Check if there's only one pub_id in the array
    if (count($pub_ids) == 1) {
        // Extract the single pub_id from the array
        $pub_id = reset($pub_ids); // Get the first element of the array


           $authorExtractQuery = "SELECT * FROM cited_sources WHERE pub_id = $pub_id";
           $cited_sources_result = mysqli_query($con, $authorExtractQuery);
           if ($cited_sources_result) {
               $cited_sources = mysqli_fetch_all($cited_sources_result, MYSQLI_ASSOC);

               $autor_names = [];
               foreach ($cited_sources as $source) {
                   if ($source["role"] == "Autor") {
                       $autor_names[] = $source["name"];
                   }
               }

               $autor_names_str = implode(", ", $autor_names);
               echo $autor_names_str;
           } else {
               echo "Error encontrando fuentes.";
           }

    } else {
           echo "Buscando publicación...";
       }
}
    ?>
