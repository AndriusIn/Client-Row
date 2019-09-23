<?php
include("include/config.php");

session_start();

// Sets language
$language;
if (isset($_SESSION['language']))
{
	$language = $_SESSION['language'];
}
else
{
	switch (DEFAULT_LANGUAGE)
	{
		case "L_LITHUANIAN":
			$language = L_LITHUANIAN;
			break;
		default:
			$language = L_ENGLISH;
			break;
	}
	$_SESSION['language'] = $language;
}

// Sets connection
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($connection)
{
	$connection->query('set character_set_client=utf8');
	$connection->query('set character_set_connection=utf8');
	$connection->query('set character_set_results=utf8');
	$connection->query('set character_set_server=utf8');
}

// Sets minimum visit time (H:M:S)
$min_visit_time = "0:5:0";

// Sets maximum visit time (H:M:S)
$max_visit_time = "0:30:0";

// Gets ticket ID
$ticket_id = $_POST['ticket-id'];

// Gets ticket information
$_SESSION['ticket-check-table-id'] = $_POST['ticket-id'];
$_SESSION['ticket-check-table-datetime'] = $_POST['ticket-datetime'];
$_SESSION['ticket-check-table-client'] = $_POST['ticket-client'];
$_SESSION['ticket-check-table-specialist'] = $_POST['ticket-specialist'];

// Remembers specialist ID to refresh ticket table
$_SESSION['specialist-id'] = $_POST['specialist-id'];

// Ticket check message
$_SESSION['ticket-check-message'] = '<p style="display: inline;">' . $language['ticket-check-message-name'];

// Checks ticket
if ($connection)
{
	// Visit time function:
	// SEC_TO_TIME(FLOOR(RAND() * (TIME_TO_SEC('$max_visit_time') - TIME_TO_SEC('$min_visit_time') + 1) + TIME_TO_SEC('$min_visit_time')))
	// 1. Converts minimum and maximum visit times to seconds
	// 2. Calculates a random number between minimum and maximum seconds
	// 3. Converts calculated number (seconds) back to time
	
	$sql = "UPDATE " . TBL_TICKET . " SET checked_datetime = NOW(), " 
		. "visit_time = SEC_TO_TIME(FLOOR(RAND() * (TIME_TO_SEC('$max_visit_time') - TIME_TO_SEC('$min_visit_time') + 1) + TIME_TO_SEC('$min_visit_time'))) " 
		. "WHERE id = " . "'$ticket_id'";
	$result = mysqli_query($connection, $sql);
	if (!$result)
	{
		$_SESSION['ticket-check-message'] .= '<br>' . $language['ticket-check-message-fail'] . ' (ID = ' . $ticket_id . ')!';
		$_SESSION['ticket-check-message'] .= '</p>';
	}
	else
	{
		$_SESSION['ticket-check-message'] .= '<br>' . $language['ticket-check-message-success'];
		$_SESSION['ticket-check-message'] .= '</p>';
	}
}
else
{
	$_SESSION['ticket-check-message'] .= '<br>' . $language['ticket-check-message-connection-error'];
	$_SESSION['ticket-check-message'] .= '</p>';
}
?>