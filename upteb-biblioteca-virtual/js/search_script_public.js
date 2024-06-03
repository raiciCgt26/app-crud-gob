$(document).ready(function() {

//Variable para cosas que se supone ocurren solo al cargarse la página.
var oneTime = false;

    //Llenar la tabla de publicaciones al cargarse la página.
    if (!oneTime)
    {
        disableCalendarCheckButtons();
        pubLookup();
        oneTime = true;
    }
 
// Re-hacer búsqueda cada vez que el usuario escribe algo en el campo de búsqueda.
       $("#search_pub").keyup(function() {
             pubLookup();   
           
       });


    // Y cada vez que el usuario presione uno de los botones.
    const radioButtons = document.querySelectorAll('input[name="doc_type"]');
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener("click", function() {
            pubLookup();
        });
    });

function pubLookup() {

           //Assigning search box value to javascript variable named as "name".
           var name = $('#search_pub').val();

        //Get the value of the currently selected radio button
                var docType = $("input[name='doc_type']:checked").val();

               //AJAX is called.
               $.ajax({
                   //AJAX type is "Post".
                   type: "POST",
                   //Data will be sent to "ajax.php".
                   url: "ajax/ajaxPublications_Public.php",
                   //Data, that will be sent to "ajax.php".
                   data: {
                       doc_type: docType,
                       search_pub: name
                   },
                 dataType: 'json', // Specify the response type as JSON
                    success: function(pubData) {

                              // Inicializar el arreglo que utilizará la table principal 
                                 var autoPubData = []; 
                                // Iterate over pubData array to extract pub_id and name values
                                pubData.forEach(function(entry) {
                                    autoPubData.push({ // Push label and value into autoPubData array
                                        "pub_id": entry.pub_id,
                                        "name": entry.name,
                                        "description": entry.description,
                                        "quantity": entry.quantity.toString(),
                                        "code": entry.code !== null ? entry.code.toString() : "",
                                        "link": entry.link !== null ? entry.link.toString() : "",
                                        "document_type": entry.Documento,
                                        "pnf": entry.PNF,
                                        "location": entry.Ubicación.toString(),
                                        "authors": entry.autor_names !== null ? entry.autor_names.toString() : "",
                                        "tutors": entry.tutor_names !== null ? entry.tutor_names.toString() : "",

                                    });
                                });

                                
                                updateTable(autoPubData);

                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText); // Log any errors for debugging
                            }
                    });

}


// Function to update the table
function updateTable(autoPubData) {
    const tableBody = document.querySelector("#publications_public tbody");
    tableBody.innerHTML = ""; // Clear the existing table rows

    autoPubData.forEach(function(entry) {
        const row = document.createElement("tr");
        row.className = "table-light mb-3 rounded"; // Bootstrap classes for styling

        // Create cells and populate with data
        const pnfCell = document.createElement("td");
        pnfCell.textContent = entry.pnf;
        row.appendChild(pnfCell);

        const nameCell = document.createElement("td");
        nameCell.textContent = entry.name;
        row.appendChild(nameCell);

        const authorCell = document.createElement("td");
        authorCell.textContent = entry.authors;
        row.appendChild(authorCell);

        if (entry.document_type === "Tesis") {
            const thesisCell = document.createElement("td");
            thesisCell.textContent = entry.tutors;
            row.appendChild(thesisCell);


        }

        const quantityCell = document.createElement("td");
        quantityCell.textContent = entry.quantity;
        row.appendChild(quantityCell);

        const locationCell = document.createElement("td");
        locationCell.textContent = entry.location;
        row.appendChild(locationCell);

        const buttonsCell = document.createElement("td");
        const buttonDiv = document.createElement("div");
        buttonDiv.className = "d-flex justify-content-evenly";

        const infoButton = document.createElement("button");
        infoButton.type = "button";
        infoButton.className = "btn btn-info";
        infoButton.innerHTML = '<i class="bi bi-file-plus"></i>';
        infoButton.dataset.code = entry.code;
        infoButton.dataset.description = entry.description;
        buttonDiv.appendChild(infoButton);

        const calendarButton = document.createElement("button");
        calendarButton.type = "button";
        calendarButton.className = "btn btn-success";
        calendarButton.innerHTML = '<i class="bi bi-calendar-check calendar-button"></i>';
        calendarButton.dataset.pubId = entry.pub_id;
        calendarButton.dataset.name = entry.name;
        calendarButton.dataset.location = entry.location;
        calendarButton.dataset.bsToggle = "modal";
        calendarButton.dataset.bsTarget = "#reserveModal";
        calendarButton.onclick = fillModal; 
        buttonDiv.appendChild(calendarButton);

        buttonsCell.appendChild(buttonDiv);
        row.appendChild(buttonsCell);

        // Append the row to the table body
        tableBody.appendChild(row);
    });
}

    // Function to fill modal with data
    function fillModal(event) {
        const button = event.target.closest('button');
        const pubName = button.dataset.name;
        const location = button.dataset.location;

        document.getElementById('modalPubName').textContent = pubName;
        document.getElementById('modalLocation').textContent = location;
    }

    function disableCalendarCheckButtons() {
        if (!isLogged) {
            const calendarCheckButtons = document.querySelectorAll('.calendar-button');
            calendarCheckButtons.forEach(function(button) {
                button.disabled = true;
            });
        }
    }

        // Código que hace que aparezca el modal.
        const calendarButtons = document.querySelectorAll('.calendar-button');
        calendarButtons.forEach(function(button) {
            button.addEventListener("click", fillModal);
        });

});
