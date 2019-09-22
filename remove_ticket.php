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

// Gets ticket ID
$ticket_id = $_POST['ticket-id'];

// Gets removed ticket information
$_SESSION['ticket-remove-table-id'] = $_POST['ticket-id'];
$_SESSION['ticket-remove-table-datetime'] = $_POST['ticket-datetime'];
$_SESSION['ticket-remove-table-client'] = $_POST['ticket-client'];
$_SESSION['ticket-remove-table-specialist'] = $_POST['ticket-specialist'];

// Remembers specialist ID to refresh ticket table
$_SESSION['specialist-id'] = $_POST['specialist-id'];

// Ticket remove message
$_SESSION['ticket-remove-message'] = '<p style="display: inline;">' . $language['ticket-remove-message-name'];

// Removes ticket
if ($connection)
{
	$sql = "DELETE FROM " . TBL_TICKET . " WHERE id = " . "'$ticket_id'";
	$result = mysqli_query($connection, $sql);
	if (!$result)
	{
		$_SESSION['ticket-remove-message'] .= '<br>' . $language['ticket-remove-message-fail'] . ' (ID = ' . $ticket_id . ')!';
		$_SESSION['ticket-remove-message'] .= '</p>';
	}
	else
	{
		$_SESSION['ticket-remove-message'] .= '<br>' . $language['ticket-remove-message-success'];
		$_SESSION['ticket-remove-message'] .= '</p>';
	}
}
else
{
	$_SESSION['ticket-remove-message'] .= '<br>' . $language['ticket-remove-message-connection-error'];
	$_SESSION['ticket-remove-message'] .= '</p>';
}
?>