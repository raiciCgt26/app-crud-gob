<?php 
//Este archivo se encarga de constantemente verificar que no hayan prestamos expirados.
$lend_number_alert = 0; //Este número es la cantidad de préstamos expirados en cada tiempo.
$lend_alert = ""; //Esta variable se utiliza para crear una alerta, utilizando la variable anterior para determinar el número a mostrar.

$currentDate = date("Y-m-d"); //Se saca la fecha actual...

	//Se sacan todos los tickets de préstamos, sus fechas de fin y su estatus
	$queryComparison = "SELECT book_act_id, start_date, end_date FROM pub_lending WHERE lend_status = 1";
	$pub_lend_dates = mysqli_query($con, $queryComparison);
	$pub_lend_dates = mysqli_fetch_all($pub_lend_dates, MYSQLI_ASSOC);

	foreach ($pub_lend_dates as $pub_lend) {
	    $end_date = $pub_lend["end_date"];
	    $start_date = $pub_lend["start_date"];

	    if ($start_date > $currentDate) {
	        // Update the lend_status to 1 for tickets that shouldn't be active yet.
	        $updateQuery = "UPDATE pub_lending SET lend_status = 0 WHERE book_act_id = {$pub_lend['book_act_id']}";
	        mysqli_query($con, $updateQuery);
	    }

	    if ($end_date <= $currentDate) {
	        // Update the lend_status to 3 for expired tickets
	        $updateQuery = "UPDATE pub_lending SET lend_status = 3 WHERE book_act_id = {$pub_lend['book_act_id']}";
	        mysqli_query($con, $updateQuery);

	        // Increment the alert counter
	        $lend_number_alert++;
	    }
	}

if ($lend_number_alert > 0) {
    $plural = $lend_number_alert > 1 ? 'préstamos han' : 'préstamo ha';
    $lend_alert = "¡{$lend_number_alert} {$plural} pasado su fecha de retorno! Se recomienda contactar a los prestatarios.";
}
?>

