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

// Sets max number of rows
$maxRowCount = 10;

// Sets max number of loaded rows
$maxRowLoadCount = 10;

// Gets tickets (ticket ID, client name, client surname, specialist name, specialist surname)
$tickets;
$ticketCount = 0;
if ($connection)
{
	$sql = "SELECT";
	$sql .= " " . TBL_TICKET . ".id AS ticket_id,";
	$sql .= " " . "client.name AS client_name,";
	$sql .= " " . "client.surname AS client_surname,";
	$sql .= " " . "specialist.name AS specialist_name,";
	$sql .= " " . "specialist.surname AS specialist_surname";
	$sql .= " " . "FROM " . TBL_TICKET;
	$sql .= " " . "JOIN " . TBL_USER . " AS client";
	$sql .= " " . "ON client.id = " . TBL_TICKET . ".client_id";
	$sql .= " " . "JOIN " . TBL_USER . " AS specialist";
	$sql .= " " . "ON specialist.id = " . TBL_TICKET . ".specialist_id";
	$sql .= " " . "WHERE " . TBL_TICKET . ".checked_datetime IS NULL";
	$sql .= " " . "ORDER BY " . TBL_TICKET . ".datetime ASC";
	
	$tickets = mysqli_query($connection, $sql);
	if ($tickets)
	{
		$ticketCount = mysqli_num_rows($tickets);
	}
}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $language['board-page-title']; ?></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<!-- Ajax requests -->
		<script>
			// Loads more tickets
			$(function () {
				$(document).on('click', '.btn.btn-primary.btn-block.load-more-tickets', function (e) {
					$.ajax({
						success: function () {
							var buttonID = $('#' + e.target.id).attr('data-id');
							var startTicket = $('#' + e.target.id).attr('data-start');
							var endTicket = $('#' + e.target.id).attr('data-end');
							var nextButtonID = $('#' + e.target.id).attr('data-next-button');
							
							// Hides load button
							$('#load-button-row-' + buttonID).hide();
							
							// Shows more tickets
							for (var i = startTicket; i < endTicket; i++) {
								$('#load-ticket-' + i).show();
							}
							
							// Shows next load button
							if ($('#load-button-row-' + nextButtonID).length > 0)
							{
								$('#load-button-row-' + nextButtonID).show();
							}
						}
					});
				});
			});
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
		<h1 class="display-4" style="text-align: center;"><?php echo $language['board-page-title']; ?></h1>
		
		<!-- Page content -->
		<div class="container-fluid py-3">
			<!-- Ticket table -->
			<div class="row">
				<div class="col">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th><?php echo $language['client-board-ticket-id-header']; ?></th>
								<th><?php echo $language['client-board-client-header']; ?></th>
								<th><?php echo $language['client-board-specialist-header']; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($ticketCount === 0)
							{
								echo '<tr>';
								echo 	'<td colspan="3" style="text-align: center;">';
								echo 		$language['client-board-tickets-error'];
								echo 	'</td>';
								echo '</tr>';
							}
							else
							{
								$loadButtonCount = 0;
								for ($i = 1; $i <= $ticketCount; $i++)
								{
									if ($i === 1)
									{
										// Prints first tickets
										for ($j = 1; $j <= $maxRowCount; $j++, $i++)
										{
											if ($ticket = mysqli_fetch_assoc($tickets))
											{
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
												echo '</tr>';
											}
											else
											{
												break;
											}
										}
										$i--;
									}
									else
									{
										$loadButtonCount++;
										$ticketsToPrint = $maxRowLoadCount;
										$ticketsLeftToPrint = $ticketCount - ($i - 1);
										if ($ticketsLeftToPrint < $maxRowLoadCount)
										{
											$ticketsToPrint = $ticketsLeftToPrint;
										}
										
										// Prints load button
										$loadButtonDisplayStyle = 'display: none;';
										if ($loadButtonCount === 1)
										{
											$loadButtonDisplayStyle = "";
										}
										echo '<tr id="load-button-row-' . $loadButtonCount . '" style="' . $loadButtonDisplayStyle . '">';
										echo 	'<td colspan="3" style="padding: 0px;">';
										echo 		'<button ' 
														. 'id="load-button-' . $loadButtonCount . '" ' 
														. 'data-id="' . $loadButtonCount . '" ' 
														. 'data-start="' . $i . '" ' 
														. 'data-end="' . ($i + $ticketsToPrint) . '" ' 
														. 'data-next-button="' . ($loadButtonCount + 1) . '" ' 
														. 'class="btn btn-primary btn-block load-more-tickets">' 
														. $language['client-board-load-button-title'] . ' (' . $ticketsToPrint . ')' 
														. '</button>';
										echo 	'</td>';
										echo '</tr>';
										
										// Prints loadable tickets
										for ($j = 1; $j <= $ticketsToPrint; $j++, $i++)
										{
											if ($ticket = mysqli_fetch_assoc($tickets))
											{
												echo '<tr id="load-ticket-' . $i . '" style="display: none;">';
												echo 	'<td>';
												echo 		$ticket['ticket_id'];
												echo 	'</td>';
												echo 	'<td>';
												echo 		$ticket['client_name'] . ' ' . $ticket['client_surname'];
												echo 	'</td>';
												echo 	'<td>';
												echo 		$ticket['specialist_name'] . ' ' . $ticket['specialist_surname'];
												echo 	'</td>';
												echo '</tr>';
											}
											else
											{
												break;
											}
										}
										$i--;
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>