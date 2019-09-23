<?php
include("include/config.php");

session_start();

// Sets language
$language;
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

// Sets connection
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($connection)
{
	$connection->query('set character_set_client=utf8');
	$connection->query('set character_set_connection=utf8');
	$connection->query('set character_set_results=utf8');
	$connection->query('set character_set_server=utf8');
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $language['visitor-page-title']; ?></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<!-- Ajax requests -->
		<script>
			// Updates estimated waiting duration every 5 seconds => not working :(
			/*
			function refresh_waiting_duration() {
				$("#update-average-duration-row").load("index.php #update-average-duration-col");
			}
			setInterval(refresh_waiting_duration, 5000);
			refresh_waiting_duration();
			*/
		</script>
	</head>
	<body>
		<!-- Navigation bar -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<!-- Title -->
			<a class="navbar-brand" href="index.php"><?php echo $language['navbar-title']; ?></a>
			
			<!-- Links -->
			<div class="navbar-nav">
				<!-- Visitor page link -->
				<a class="nav-item nav-link" href="index.php"><?php echo $language['navbar-visitor-page']; ?></a>
				
				<!-- Admin interface link -->
				<a class="nav-item nav-link" href="admin.php"><?php echo $language['navbar-admin-interface']; ?></a>
				
				<!-- Client board link -->
				<a class="nav-item nav-link" href="board.php"><?php echo $language['navbar-client-board']; ?></a>
				
				<!-- Specialist interface link -->
				<a class="nav-item nav-link" href="specialist.php"><?php echo $language['navbar-specialist-interface']; ?></a>
			</div>
		</nav>
		
		<!-- Page heading -->
		<h1 class="display-4" style="text-align: center;"><?php echo $language['visitor-page-title']; ?></h1>
		
		<!-- Page content -->
		<div class="container-fluid py-3">
			<!-- Ticket search form -->
			<div class="row">
				<div class="col">
					<form method="get">
						<!-- Ticket ID -->
						<div class="form-group">
							<label for="ticket-id"><b><?php echo $language['ticket-search-id']; ?></b></label>
							<?php
							if (isset($_GET['ticket-id']))
							{
								echo '<input type="text" class="form-control" id="ticket-id" name="ticket-id" placeholder="' . $language['ticket-search-id-placeholder'] . '" value="' . trim($_GET['ticket-id']) . '">';
							}
							else
							{
								echo '<input type="text" class="form-control" id="ticket-id" name="ticket-id" placeholder="' . $language['ticket-search-id-placeholder'] . '">';
							}
							?>
						</div>
						
						<button type="submit" class="btn btn-primary"><?php echo $language['ticket-search-submit-button-title']; ?></button>
					</form>
				</div>
			</div>
			
			<!-- Ticket search result table -->
			<?php
			$ticketTableDisplayStyle = 'display: none;';
			
			if (isset($_GET['ticket-id']))
			{
				$ticketTableDisplayStyle = "";
			}
			?>
			<div class="row" style="<?php echo $ticketTableDisplayStyle; ?>">
				<div class="col">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th><?php echo $language['ticket-search-table-id-header']; ?></th>
								<th><?php echo $language['ticket-search-table-client-header']; ?></th>
								<th><?php echo $language['ticket-search-table-specialist-header']; ?></th>
								<th><?php echo $language['ticket-search-table-average-duration-header']; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset($_GET['ticket-id']))
							{
								$ticketSearchInput = trim($_GET['ticket-id']);
								$ticketSearchInputIsValid = false;
								if (ctype_digit($ticketSearchInput))
								{
									$ticketSearchInputIsValid = true;
								}
								if ($ticketSearchInputIsValid)
								{
									$sql = "SELECT";
									$sql .= " " . TBL_TICKET . ".id AS ticket_id,";
									$sql .= " " . TBL_TICKET . ".specialist_id AS ticket_specialist_id,";
									$sql .= " " . "client.name AS client_name,";
									$sql .= " " . "client.surname AS client_surname,";
									$sql .= " " . "specialist.name AS specialist_name,";
									$sql .= " " . "specialist.surname AS specialist_surname";
									$sql .= " " . "FROM " . TBL_TICKET;
									$sql .= " " . "JOIN " . TBL_USER . " AS client";
									$sql .= " " . "ON client.id = " . TBL_TICKET . ".client_id";
									$sql .= " " . "JOIN " . TBL_USER . " AS specialist";
									$sql .= " " . "ON specialist.id = " . TBL_TICKET . ".specialist_id";
									$sql .= " " . "WHERE " . TBL_TICKET . ".id = " . "'$ticketSearchInput'";
									$result = mysqli_query($connection, $sql);
									if ($result)
									{
										if (mysqli_num_rows($result) > 0)
										{
											$ticket = mysqli_fetch_assoc($result);
											echo '<tr>';
											echo 	'<td>';
											echo 		$ticket['ticket_id'];
											echo 	'</td>';
											echo 	'<td>';
											echo 		$ticket['client_name'] . ' ' . $ticket['client_surname'];
											echo 	'</td>';
											echo 	'<td>';
											echo 		$ticket['specialist_name'] . ' ' . $ticket['specialist_surname'];
											echo 	'</td>';
											echo 	'<td>';
											echo 		'<div class="row" id="update-average-duration-row">';
											echo 			'<div class="col" id="update-average-duration-col">';
											$sql = "SELECT SEC_TO_TIME(FLOOR(AVG(TIME_TO_SEC(waiting_duration)))) AS avg_wait FROM " . TBL_TICKET . " WHERE specialist_id = " . $ticket['ticket_specialist_id'];
											$result = mysqli_query($connection, $sql);
											$avg_wait = mysqli_fetch_assoc($result)['avg_wait'];
											if (is_null($avg_wait))
											{
												echo 			$language['ticket-search-table-average-duration-error'];
											}
											else
											{
												echo 			$avg_wait;
											}
											echo 			'</div>';
											echo 		'</div>';
											echo 	'</td>';
											echo '</tr>';
										}
										else
										{
											echo '<tr>';
											echo 	'<td colspan="4" style="text-align: center;">';
											echo 		$language['ticket-search-id-error'];
											echo 	'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr>';
										echo 	'<td colspan="4" style="text-align: center;">';
										echo 		$language['ticket-search-id-error'];
										echo 	'</td>';
										echo '</tr>';
									}
								}
								else
								{
									echo '<tr>';
									echo 	'<td colspan="4" style="text-align: center;">';
									echo 		$language['ticket-search-id-error'];
									echo 	'</td>';
									echo '</tr>';
								}
							}
							else
							{
								echo '<tr>';
								echo 	'<td colspan="4" style="text-align: center;">';
								echo 		$language['ticket-search-id-error'];
								echo 	'</td>';
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>