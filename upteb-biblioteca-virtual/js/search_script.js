
$(document).ready(function() {


//Esta variable la utilizamos para que el siguiente código solo corra una vez.
var oneTime = false;
var cotaUrl = "ajax/ajaxCota.php";

 if (typeof isEditPage !== 'undefined' && isEditPage)
 {
    if (oneTime == false)
    {
    cotaUrl = "ajax/ajaxCotaOneTime.php";
    }
    else
    {
    cotaUrl = "ajax/ajaxCota.php";
    }
 }


    // Initial check
    if ($('#user_system_check').prop('checked')) {
        executeCheckedBlock(); // Call the function for checked state initially
    } else {
        executeUncheckedBlock(); // Call the function for unchecked state initially
    }

    // Add event listener for checkbox state change
    $('#user_system_check').change(function() {
        if ($(this).prop('checked')) {
            executeCheckedBlock(); // Call the function for checked state
        } else {
            executeUncheckedBlock(); // Call the function for unchecked state
        }
    });


    //Los autocomplete - Primero el de usuario y luego de publicación

const userField = document.getElementById('lend_name');
const userAc = new Autocomplete(userField, {
  data: [{label: "Buscando usuario...", value: 0}],
  maximumItems: 5,
  threshold: 1,
  onSelectItem: ({label, value}) => {

    if ($('#user_system_check').prop('checked'))
    {
    // Convert value into an array with a single element
    var userIds = [value];

    // Call the secondaryLookup function with the converted array
    secondaryLookupUsers(userIds);
    }
   }
  });



    // Function for checked state
    function executeCheckedBlock() {


        // Al presionar una tecla en el campo de nombre de prestatario, llamar esta función.
        $("#lend_name").on('keyup',function() {
            // Agarrar lo que está escrito allí y convertirlo en variable de javascript.
            var usersNames = $('#lend_name').val();

            // If name is empty.
            if (usersNames == "") {
                $("#lend_cedula").val("");
                $("#lend_student_pnf").prop("selectedIndex", 0);
                $("#lender_phone").val("");
                                // Return the dropdown menu to the first element
                $("#community_type_drop").prop("selectedIndex", 0);
            } else {
                // AJAX is called.
                $.ajax({
                    type: "POST",
                    url: "ajax/ajaxUsers.php",
                    data: {
                        search_users: usersNames,
                    },
                    dataType: 'json',
                    success: function(userData) {

                        var userIds = [];
                        var userNames = [];
                        var autoUserData = [];

                        userData.forEach(function(entry) {
                            userIds.push(entry.user_id.toString());
                            userNames.push(entry.username);
                            autoUserData.push({
                                "label": entry.username,
                                "value": entry.user_id.toString()
                            });
                        });
                        
                        userAc.setData(autoUserData);

                        if (userIds.length == 1) {
                            secondaryLookupUsers(userIds);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }

    // Function for unchecked state
    function executeUncheckedBlock() {
            $("#lend_name").off("keyup");
        ac.setData([
            {
                "label": "Ingrese los datos de usuario manualmente.",
                "value": "00"
            }
        ]);
    }


       //Esta función se activa cuando se empieza a escribir en el campo de búsqueda de publicación.
       $("#search_pub").keyup(function() {
           //Assigning search box value to javascript variable named as "name".
           var name = $('#search_pub').val();

        //Get the value of the currently selected radio button
                var docType = $("input[name='doc_type']:checked").val();

           //If name is not empty.
           if (name == "") {
            $("#author_names").val("");
            $("#lend_location").val("");
            $("#pub_id_hidden").val("");
                // Remove all checkboxes and labels in the cota_boxes div
                $("#cota_boxes").empty();
           }
           else
           {
               //AJAX is called.
               $.ajax({
                   //AJAX type is "Post".
                   type: "POST",
                   //Data will be sent to "ajax.php".
                   url: "ajax/ajaxPublications.php",
                   //Data, that will be sent to "ajax.php".
                   data: {
                       //Assigning value of "name" into "search" variable.
                       search_pub: name,
                       doc_type: docType
                   },
                 dataType: 'json', // Specify the response type as JSON
                    success: function(pubData) {
                        //console.log(pubData); // Log the raw data first to understand its structure
                        
                                // Initialize empty arrays to store pub_id and name values separately
                                var pubIds = [];
                                var entryNames = [];
                                var autoPubData = []; // Initialize an empty array for autoPubData

                                // Iterate over pubData array to extract pub_id and name values
                                pubData.forEach(function(entry) {
                                    pubIds.push(entry.pub_id.toString());
                                    entryNames.push(entry.name);
                                    autoPubData.push({ // Push label and value into autoPubData array
                                        "label": entry.name,
                                        "value": entry.pub_id.toString()
                                    });
                                });

                                    ac.setData(autoPubData);

                                    if (pubIds.length == 1)
                                    {                                  //Se llama ajax jalando el arreglo de PubIds para buscar el autor.
                                        secondaryLookup(pubIds);
                                    }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText); // Log any errors for debugging
                            }
                    });
           }
       });


const field = document.getElementById('search_pub');
const ac = new Autocomplete(field, {
  data: [{label: "Autosugerencias de Publicación...", value: 0}],
  maximumItems: 5,
  threshold: 1,
  onSelectItem: ({label, value}) => {
    // Convert value into an array with a single element
    var pubIds = [value];

    // Call the secondaryLookup function with the converted array
    secondaryLookup(pubIds);
   }
  });

function secondaryLookup(pubIds)
    {

        $("#pub_id_hidden").val(pubIds[0]);

         $.ajax({
                                               //AJAX type is "Post".
           type: "POST",
                                               //Data will be sent to "ajaxSources.php".
           url: "ajax/ajaxSources.php",
                                               //Data, that will be sent to "ajax.php".
           data: {
                                                   //El valor de pubIds se agarra y se pone en ajaxSources.
              search_ids: pubIds
            },
                                               //If result found, this funtion will be called.
           success: function(html) {
                                                                           //Assigning result to the author names field.
            $("#author_names").val(html);
              }
            });

            $.ajax({
                                               //AJAX type is "Post".
            type: "POST",
                                               //Data will be sent to "ajaxSources.php".
            url: "ajax/ajaxLocation.php",
                                               //Data, that will be sent to "ajax.php".
            data: {
                                                   //El valor de pubIds se agarra y se pone en ajaxSources.
              search_location: pubIds
               },
                                               //If result found, this funtion will be called.
            success: function(html) {
                                                                           //Assigning result to the author names field.
                      $("#lend_location").val(html);
                  }
            });

            $.ajax({
                 //AJAX type is "Post".
                 type: "POST",
                                               //Data will be sent to "ajaxSources.php".
                 url: cotaUrl,
                                               //Data, that will be sent to "ajax.php".
                  data: {
                                                   //El valor de pubIds se agarra y se pone en ajaxSources.
                      search_cotas: pubIds
                  },
                   dataType: 'json',
                                               //If result found, this funtion will be called.
                   success: function(cotaData) {
                     var complexCotaArray = [];


                    cotaData.forEach(function(entry) {
                      complexCotaArray.push({
                      "cota_id": entry.pub_cd_id,
                      "prefix_string": entry.prefix_string,
                       "cota_number": entry.cota.toString(),
                       "checked": entry.hasOwnProperty('checked') ? entry.checked.toString() : "false" //Este ternario basicamente dice que si no estamos en modo de editar, asumir que todas las cotas NO estan chequeadas.
                        });
                      });
              

                       // Clear existing checkboxes before adding new ones
                        $('#cota_boxes').empty();

                       if (complexCotaArray.length >= 1) {
                        // Si hay cotas, cambiar el nombre del título a "Cotas de la Publicación"
                        document.getElementById('cota-quant-label').innerText = "Cotas de la Publicación";

                        var cotaBoxesDiv = document.getElementById('cota_boxes');

            
                       complexCotaArray.forEach(function(cota) {
                        //Este ternario basicamente dice que si existe un prefix string, lo agrega con parentesis antes del número de cota, si no solo pone el número de cota.
                        var checkboxLabel = cota.prefix_string ? `(${cota.prefix_string}) ${cota.cota_number}` : cota.cota_number;

                          var checkboxDiv = document.createElement('div');
                         checkboxDiv.classList.add('form-check', 'form-check-inline');

                        var checkboxInput = document.createElement('input');
                        checkboxInput.classList.add('form-check-input');
                        checkboxInput.type = 'checkbox';
                        checkboxInput.name = 'cotas_checked[]';
                        checkboxInput.value = cota.cota_id;

                        //Como convertimos al objeto en un arreglo de strings, no podemos directamente asignar el true or false.
                        if (cota.checked === "true") {
                            checkboxInput.checked = true;
                        } else {
                            checkboxInput.checked = false;
                        }

                        var checkboxLabelElement = document.createElement('label');
                        checkboxLabelElement.classList.add('form-check-label');
                        checkboxLabelElement.textContent = checkboxLabel;

                         checkboxDiv.appendChild(checkboxInput);
                         checkboxDiv.appendChild(checkboxLabelElement);

                         cotaBoxesDiv.appendChild(checkboxDiv);
                          });
                         }
                         else {
                            // Change the label text to "Cantidad a Prestar"
                            document.getElementById('cota-quant-label').innerText = "Cantidad a Prestar";

                              // Create a simple input number
                                var quantityInput = document.createElement('input');
                                quantityInput.type = 'number';
                                quantityInput.classList.add('form-control');
                                quantityInput.id = 'quantity_check';
                                quantityInput.name = 'quantity_check';
                                quantityInput.placeholder = 'Ingresar cantidad de ejemplares a prestar.';
                                quantityInput.required = true;

                                // Append the input to the desired location
                                var quantityContainer = document.getElementById('cota_boxes');
                                quantityContainer.appendChild(quantityInput);

                         }                             
                        }
            });
        }

function secondaryLookupUsers(userIds) {

                            $.ajax({
                                type: "POST",
                                url: "ajax/ajaxCedula.php",
                                data: {
                                    search_ced: userIds
                                },
                                dataType: 'json',
                                success: function(userDetailData) {
                                    var extraUserData = [];

                                    userDetailData.forEach(function(entry) {
                                        extraUserData.push({
                                            "cedula": entry.cedula_id,
                                            "role": entry.user_type,
                                            "pnf": entry.pnf,
                                            "telf": entry.contact_number.toString()
                                        });
                                    });

                                    for (var i = 0; i < extraUserData.length; i++) {
                                        $("#lender_phone").val(extraUserData[i].telf);
                                        $("#lend_cedula").val(extraUserData[i].cedula);

                                            // Select the option in the dropdown based on the user's role
                                        var role = extraUserData[i].role;
                                        $("#community_type_drop option").each(function() {
                                            if ($(this).val() === role) {
                                                $(this).prop("selected", true);
                                            }
                                        });

                                       
                                                                                    // Select the option in the dropdown based on the user's role
                                        var pnf = extraUserData[i].pnf;
                                        var dropdown = document.getElementById("lend_student_pnf");
                                        var options = dropdown.options;

                                        for (var j = 0; j < options.length; j++) {
                                            if (options[j].text === pnf) {
                                                options[j].selected = true;
                                                break;  // Exit the loop once the option is selected
                                            }
                                        }
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
    }

 // Chequeamos que isEditPage sea verdadero, que solo ocurre en la página de editar.
    if (typeof isEditPage !== 'undefined' && isEditPage) {

        // Your code to run once when the page finishes loading and URL matches
        console.log('Page finished loading and URL matches.');
        if (!oneTime)
        {
            // Agarrar lo que está escrito allí y convertirlo en variable de javascript.
            var usersNames = $('#lend_name').val();

            if (usersNames != "") {
                // AJAX is called.
                $.ajax({
                    type: "POST",
                    url: "ajax/ajaxUsers.php",
                    data: {
                        search_users: usersNames,
                    },
                    dataType: 'json',
                    success: function(userData) {
                        var userIds = [];
                        var userNames = [];
                        var autoUserData = [];

                        userData.forEach(function(entry) {
                            userIds.push(entry.user_id.toString());
                            userNames.push(entry.username);
                            autoUserData.push({
                                "label": entry.username,
                                "value": entry.user_id.toString()
                            });
                        });

                        userAc.setData(autoUserData);

                        if (userIds.length == 1) {
                            secondaryLookupUsers(userIds);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            //Y ahora hacer lo mismo con publicaciones.
            var name = $('#search_pub').val();
                var docType = $("input[name='doc_type']:checked").val();

           if (name != "") {
                           //AJAX is called.
                   $.ajax({
                       //AJAX type is "Post".
                       type: "POST",
                       //Data will be sent to "ajax.php".
                       url: "ajax/ajaxPublications.php",
                       //Data, that will be sent to "ajax.php".
                       data: {
                           //Assigning value of "name" into "search" variable.
                           search_pub: name,
                           doc_type: docType
                       },
                     dataType: 'json', // Specify the response type as JSON
                        success: function(pubData) {
                            //console.log(pubData); // Log the raw data first to understand its structure
                            
                                    // Initialize empty arrays to store pub_id and name values separately
                                    var pubIds = [];
                                    var entryNames = [];
                                    var autoPubData = []; // Initialize an empty array for autoPubData

                                    // Iterate over pubData array to extract pub_id and name values
                                    pubData.forEach(function(entry) {
                                        pubIds.push(entry.pub_id.toString());
                                        entryNames.push(entry.name);
                                        autoPubData.push({ // Push label and value into autoPubData array
                                            "label": entry.name,
                                            "value": entry.pub_id.toString()
                                        });
                                    });

                                        ac.setData(autoPubData);

                                        if (pubIds.length == 1)
                                        {                                  //Se llama ajax jalando el arreglo de PubIds para buscar el autor.
                                            secondaryLookup(pubIds);
                                        }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText); // Log any errors for debugging
                                }
                        });
               }
               oneTime = true;
        }
    }

});


