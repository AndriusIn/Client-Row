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

// Sets minimum visit time (H:i:s)
$min_visit_time = "0:5:0";

// Sets maximum visit time (H:i:s)
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

// Marks ticked as checked
if ($connection)
{
	// Visit duration (in hours) function:
	// SEC_TO_TIME(FLOOR(RAND() * (TIME_TO_SEC('$max_visit_time') - TIME_TO_SEC('$min_visit_time') + 1) + TIME_TO_SEC('$min_visit_time')))
	// 1. Converts minimum and maximum visit duration to seconds
	// 2. Calculates a random number between minimum and maximum seconds
	// 3. Converts calculated number (seconds) back to hours
	
	$sql = "UPDATE " . TBL_TICKET . " SET checked_datetime = NOW(), " 
		. "visit_duration = SEC_TO_TIME(FLOOR(RAND() * (TIME_TO_SEC('$max_visit_time') - TIME_TO_SEC('$min_visit_time') + 1) + TIME_TO_SEC('$min_visit_time'))) " 
		. "WHERE id = " . "'$ticket_id'";
	$result = mysqli_query($connection, $sql);
	if (!$result)
	{
		$_SESSION['ticket-check-message'] .= '<br>' . $language['ticket-check-message-fail'] . ' (ID = ' . $ticket_id . ')!';
		$_SESSION['ticket-check-message'] .= '</p>';
	}
	else
	{
		// Arrival datetime:
		// DATE_SUB(ticket.checked_datetime, INTERVAL TIME_TO_SEC(ticket.visit_duration) SECOND)
		// 1. Converts visit duration to seconds
		// 2. Subtracts visit duration seconds from checked ticket datetime
		// 3. Returned result will be the arrival datetime
		
		$sql = "UPDATE " . TBL_TICKET . " SET arrival_datetime = DATE_SUB(checked_datetime, INTERVAL TIME_TO_SEC(visit_duration) SECOND) WHERE id = " . "'$ticket_id'";
		$result = mysqli_query($connection, $sql);
		if (!$result)
		{
			$_SESSION['ticket-check-message'] .= '<br>' . $language['ticket-check-message-fail'] . ' (ID = ' . $ticket_id . ')!';
			$_SESSION['ticket-check-message'] .= '</p>';
		}
		else
		{
			// Waiting duration (in hours) until arrival:
			// SEC_TO_TIME(TIMESTAMPDIFF(SECOND, ticket.datetime, ticket.arrival_datetime))
			// 1. Subtracts ticket creation datetime from arrival datetime
			// 2. Returned result will be the waiting duration (in seconds) until arrival
			// 3. Converts result from seconds to hours
			
			$sql = "UPDATE " . TBL_TICKET . " SET waiting_duration = SEC_TO_TIME(TIMESTAMPDIFF(SECOND, datetime, arrival_datetime)) WHERE id = " . "'$ticket_id'";
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
	}
}
else
{
	$_SESSION['ticket-check-message'] .= '<br>' . $language['ticket-check-message-connection-error'];
	$_SESSION['ticket-check-message'] .= '</p>';
}
?>