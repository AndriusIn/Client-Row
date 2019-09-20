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
	$language = L_ENGLISH;
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

// Gets form data
$client_id = $_GET['client-id'];
$specialist_id = $_GET['specialist-id'];

// Submission message
$_SESSION['new-ticket-submission-message'] = '<p style="display: inline;">' . $language['new-ticket-message-name'];

// Checks connection
if (!$connection)
{
	$_SESSION['new-ticket-submission-message'] .= '<br>' . $language['new-ticket-connection-error'];
	$_SESSION['new-ticket-submission-message'] .= '<br>' . $language['new-ticket-message-fail'];
	$_SESSION['new-ticket-submission-message'] .= '</p>';
}
else
{
	// Inserts new ticket to database
	$sql = "INSERT INTO " . TBL_TICKET . " (client_id, specialist_id) VALUES ('$client_id', '$specialist_id')";
	if (!mysqli_query($connection, $sql))
	{
		$_SESSION['new-ticket-submission-message'] .= '<br>' . $language['new-ticket-insert-error'];
		$_SESSION['new-ticket-submission-message'] .= '<br>' . $language['new-ticket-message-fail'];
		$_SESSION['new-ticket-submission-message'] .= '</p>';
	}
	else
	{
		$_SESSION['new-ticket-submission-message'] .= '<br>' . $language['new-ticket-message-success'];
		$_SESSION['new-ticket-submission-message'] .= '</p>';
		
		// Gets client's name, surname and email
		$sql = "SELECT name, surname, email FROM " . TBL_USER . " WHERE id = '$client_id' LIMIT 1";
		$result = mysqli_query($connection, $sql);
		if ($result)
		{
			if (mysqli_num_rows($result) > 0)
			{
				$client = mysqli_fetch_assoc($result);
				$_SESSION['new-ticket-submission-client-name'] = $client['name'];
				$_SESSION['new-ticket-submission-client-surname'] = $client['surname'];
				$_SESSION['new-ticket-submission-client-email'] = $client['email'];
			}
		}
		
		// Gets specialist's name, surname and email
		$sql = "SELECT name, surname, email FROM " . TBL_USER . " WHERE id = '$specialist_id' LIMIT 1";
		$result = mysqli_query($connection, $sql);
		if ($result)
		{
			if (mysqli_num_rows($result) > 0)
			{
				$specialist = mysqli_fetch_assoc($result);
				$_SESSION['new-ticket-submission-specialist-name'] = $specialist['name'];
				$_SESSION['new-ticket-submission-specialist-surname'] = $specialist['surname'];
				$_SESSION['new-ticket-submission-specialist-email'] = $specialist['email'];
			}
		}
	}
}
?>