    <?php
    //Including Database configuration file.
    include "../connect.php";
    //Getting value of "search_names" variable from "search_script.js", which occurs after a succesful query of publications.
    if (isset($_POST['search_location'])) {
    //Search box value assigning to $Name variable.
       $pub_ids = $_POST['search_location'];



    // Check if there's only one pub_id in the array
    if (count($pub_ids) == 1) {
        // Extract the single pub_id from the array
        $pub_id = reset($pub_ids); // Get the first element of the array


           $Query = "SELECT * FROM pub_join_tags WHERE pub_id = $pub_id";
            $tag_ids = mysqli_query($con, $Query);
            $tag_ids = mysqli_fetch_all($tag_ids, MYSQLI_ASSOC);
            $tag_ids = array_column($tag_ids, "tag_id");

            // Conseguir todas las etiquetas desde su propia tabla en donde el tag id esté incluido en el array anterior y convertir los nombres en un string.
            if (count($tag_ids) > 0)
            {
                    $query = "SELECT * FROM tags WHERE tag_id IN (" . implode(", ", $tag_ids) . ")";
                    $tags = mysqli_query($con, $query);
                    $tags = mysqli_fetch_all($tags, MYSQLI_ASSOC);
                    $tags = array_column($tags, "name", "tag_category");

                    echo $tags["Ubicación"];
            }
            else
            {
                echo "<i>Ninguna</i>";
            }

    } else {
           echo "Buscando ubicación...";
       }
}
    ?>
