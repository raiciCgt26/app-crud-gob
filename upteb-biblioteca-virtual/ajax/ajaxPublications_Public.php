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
       if (!empty($Name))
       {
           if (!empty($docType))
           {
            $Query = "SELECT publications.*
              FROM publications
              INNER JOIN pub_join_tags
              ON publications.pub_id = pub_join_tags.pub_id
              WHERE publications.name LIKE '%$Name%'
              AND publications.removed = 0
              AND pub_join_tags.tag_id = $docType";
                
            }
            else
            {
                $Query = "SELECT * FROM publications WHERE name LIKE '%$Name%' AND removed = 0";
            }
        }
        else
        {
            $Query = "SELECT publications.*
              FROM publications
              INNER JOIN pub_join_tags
              ON publications.pub_id = pub_join_tags.pub_id
              WHERE publications.removed = 0
              AND pub_join_tags.tag_id = $docType";
        }

   $ExecQuery = mysqli_query($con, $Query);
   if ($ExecQuery) {
        //Este while loop basicamente llena el array de arriba con los resultados
    while ($row = mysqli_fetch_array($ExecQuery, MYSQLI_ASSOC)) {
        
        // Query for tags associated with the publication
        $tagsQuery = "SELECT * FROM pub_join_tags WHERE pub_id = " . $row["pub_id"];
        $tag_ids_result = mysqli_query($con, $tagsQuery);
        $tag_ids = mysqli_fetch_all($tag_ids_result, MYSQLI_ASSOC);
        $tag_ids = array_column($tag_ids, "tag_id");

        // Conseguir todas las etiquetas desde su propia tabla en donde el tag id esté incluido en el array anterior y convertir los nombres en un string.
        $tags = [];
        if (count($tag_ids) > 0) {
            $tagsQuery = "SELECT * FROM tags WHERE tag_id IN (" . implode(", ", $tag_ids) . ")";
            $tags_result = mysqli_query($con, $tagsQuery);
            $tags = mysqli_fetch_all($tags_result, MYSQLI_ASSOC);
            $tags = array_column($tags, "name", "tag_category");
        }

        // Add tags to the row
        foreach ($tags as $category => $tagName) {
            $row[$category] = $tagName;
        }

        // Query for cited sources associated with the publication
        $sourcesQuery = "SELECT * FROM cited_sources WHERE pub_id = " . $row["pub_id"];
        $cited_sources_result = mysqli_query($con, $sourcesQuery);
        $cited_sources = mysqli_fetch_all($cited_sources_result, MYSQLI_ASSOC);

        // Initialize arrays to hold author and tutor names
        $indexed_sources = [];
        foreach ($cited_sources as $source) {
            if (!isset($indexed_sources[$source["role"]])) {
                $indexed_sources[$source["role"]] = [];
            }
            $indexed_sources[$source["role"]][] = $source;
        }

        // Get author and tutor names
        $autor_names = isset($indexed_sources["Autor"]) ? implode(", ", array_column($indexed_sources["Autor"], "name")) : "";
        $tutor_names = isset($indexed_sources["Tutor"]) ? implode(", ", array_column($indexed_sources["Tutor"], "name")) : "";

        // Add author and tutor names to the row
        $row["autor_names"] = $autor_names;
        $row["tutor_names"] = $tutor_names;

        // Push the modified row to the publications_autoList array
        array_push($publications_autoList, $row);
    }
        
        echo json_encode($publications_autoList, JSON_PRETTY_PRINT);
   } else {
       echo "Query execution failed: " . mysqli_error($con);
   }
}
    ?>