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

// Gets form data
$name = mb_convert_case(mb_strtolower(trim($_POST['new-user-name']), 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
$surname = mb_convert_case(mb_strtolower(trim($_POST['new-user-surname']), 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
$email = mb_strtolower(trim($_POST['new-user-email']), 'UTF-8');
$roles = json_encode(array($_POST['new-user-role']));

$userDataIsValid = true;

// Submission message
$_SESSION['new-user-submission-message'] = '<p style="display: inline;">' . $language['new-user-message-name'];

// Checks if name is NULL or an empty string
if (empty($name)) 
{
	$userDataIsValid = false;
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-name-empty-error'];
}
else if (!preg_match('/^\pL+$/u', $name))
{
	// Checks if name does not consist of only letters
	$userDataIsValid = false;
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-name-pattern-error'];
}

// Checks if surname is NULL or an empty string
if (empty($surname)) 
{
	$userDataIsValid = false;
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-surname-empty-error'];
}
else if (!preg_match('/^\pL+$/u', $surname))
{
	// Checks if surname does not consist of only letters
	$userDataIsValid = false;
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-surname-pattern-error'];
}

// Checks if email is NULL or an empty string
if (empty($email)) 
{
	$userDataIsValid = false;
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-email-empty-error'];
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	// Checks if email format is invalid
	$userDataIsValid = false;
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-email-pattern-error'];
}
else
{
	// Checks if email already exists
	if ($connection)
	{
		$sql = "SELECT email FROM " . TBL_USER . " WHERE email = '$email'";
		$identicalEmail = mysqli_query($connection, $sql);
		if ($identicalEmail)
		{
			if (mysqli_num_rows($identicalEmail) > 0)
			{
				$userDataIsValid = false;
				$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-email-exists-error'] . ' (' . $email . ')!';
			}
		}
	}
}

// Checks if user data is valid
if ($userDataIsValid)
{
	// Checks connection
	if (!$connection)
	{
		$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-connection-error'];
		$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-message-fail'];
		$_SESSION['new-user-submission-message'] .= '</p>';
	}
	else
	{
		// Inserts new user to database
		$sql = "INSERT INTO " . TBL_USER . " (name, surname, email, roles) VALUES ('$name', '$surname', '$email', '$roles')";
		if (!mysqli_query($connection, $sql))
		{
			$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-insert-error'];
			$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-message-fail'];
			$_SESSION['new-user-submission-message'] .= '</p>';
		}
		else
		{
			$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-message-success'] . ' (' . $email . ').';
			$_SESSION['new-user-submission-message'] .= '</p>';
		}
	}
}
else
{
	$_SESSION['new-user-submission-message'] .= '<br>' . $language['new-user-message-fail'];
	$_SESSION['new-user-submission-message'] .= '</p>';
}
?>