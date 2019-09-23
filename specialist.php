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
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $language['specialist-page-title']; ?></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<!-- Ajax requests -->
		<script>
			// Removes ticket
			$(function () {
				$(document).on('submit', '.ticket-check-form', function (e) {
					e.preventDefault();
					$.ajax({
						type: 'post', 
						url: 'check_ticket.php', 
						data: $('#' + e.target.id).serialize(), 
						success: function () {
							// Loads ticket table
							$('#ticket-table-row').load('specialist.php #ticket-table-col');
						}
					});
				});
			});
			
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
		<h1 class="display-4" style="text-align: center;"><?php echo $language['specialist-page-title']; ?></h1>
		
		<!-- Page content -->
		<div class="container-fluid py-3">
			<!-- Specialist selection form -->
			<div class="row">
				<div class="col">
					<form method="get">
						<!-- Specialists -->
						<div class="form-group">
							<label for="specialist-id"><b><?php echo $language['specialist-select-label']; ?></b></label>
							<select class="form-control" id="specialist-id" name="specialist-id">
								<?php
								if (!$connection)
								{
									echo '<option value="-1">' . $language['specialist-connection-error'] . '</option>';
								}
								else
								{
									// Selects all specialists
									$sql = "SELECT id, name, surname, email FROM " . TBL_USER . " WHERE JSON_CONTAINS(roles, '\"ROLE_SPECIALIST\"') = 1 ORDER BY name ASC, surname ASC, email ASC";
									$specialists = mysqli_query($connection, $sql);
									
									if (!$specialists)
									{
										echo '<option value="-1">' . $language['specialist-select-error'] . '</option>';
									}
									else
									{
										// Prints all specialists
										if (mysqli_num_rows($specialists) > 0)
										{
											while($specialist = mysqli_fetch_assoc($specialists))
											{
												$fullName = $specialist['name'] . ' ' . $specialist['surname'] . ' (' . $specialist['email'] . ')';
												if (isset($_GET['specialist-id']))
												{
													if ($specialist['id'] === $_GET['specialist-id'])
													{
														echo '<option value="' . $specialist['id'] . '" selected>' . $fullName . '</option>';
													}
													else
													{
														echo '<option value="' . $specialist['id'] . '">' . $fullName . '</option>';
													}
												}
												else
												{
													echo '<option value="' . $specialist['id'] . '">' . $fullName . '</option>';
												}
											}
										}
										else
										{
											echo '<option value="-1">' . $language['specialist-empty-error'] . '</option>';
										}
									}
								}
								?>
							</select>
						</div>
						
						<!-- Specialist selection submission button -->
						<?php
						$buttonIsEnabled = false;
						
						// Checks if specialists are not missing
						if ($specialists)
						{
							if (mysqli_num_rows($specialists) > 0)
							{
								$buttonIsEnabled = true;
							}
						}
						
						if ($buttonIsEnabled)
						{
							echo '<button type="submit" class="btn btn-primary">' . $language['specialist-select-submit-button-title'] . '</button>';
						}
						else
						{
							echo '<button type="submit" class="btn btn-primary" disabled>' . $language['specialist-select-submit-button-title'] . '</button>';
						}
						?>
					</form>
				</div>
			</div>
			
			<!-- Ticket table and submission message -->
			<?php
			$ticketTableDisplayStyle = 'display: none;';
			
			if (isset($_GET['specialist-id']))
			{
				$ticketTableDisplayStyle = "";
			}
			?>
			<div class="row" id="ticket-table-row" style="<?php echo $ticketTableDisplayStyle; ?>">
				<div class="col" id="ticket-table-col">
					<!-- Ticket table -->
					<div class="row">
						<div class="col">
							<table class="table table-striped">
								<thead class="thead-dark">
									<tr>
										<th><?php echo $language['ticket-table-id-header']; ?></th>
										<th><?php echo $language['ticket-table-datetime-header']; ?></th>
										<th><?php echo $language['ticket-table-client-header']; ?></th>
										<th><?php echo $language['ticket-table-button-header']; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									// Gets tickets (ticket ID, client name, client surname, specialist name, specialist surname)
									$tickets;
									$ticketCount = 0;
									$loadButtonArray = [];
									if (isset($_GET['specialist-id']))
									{
										if ($connection)
										{
											$specialistID = $_GET['specialist-id'];
											
											$sql = "SELECT";
											$sql .= " " . TBL_TICKET . ".id AS ticket_id,";
											$sql .= " " . TBL_TICKET . ".datetime AS ticket_datetime,";
											$sql .= " " . TBL_TICKET . ".checked_datetime AS ticket_checked_datetime,";
											$sql .= " " . "client.name AS client_name,";
											$sql .= " " . "client.surname AS client_surname,";
											$sql .= " " . "specialist.id AS specialist_id,";
											$sql .= " " . "specialist.name AS specialist_name,";
											$sql .= " " . "specialist.surname AS specialist_surname";
											$sql .= " " . "FROM " . TBL_TICKET;
											$sql .= " " . "JOIN " . TBL_USER . " AS client";
											$sql .= " " . "ON client.id = " . TBL_TICKET . ".client_id";
											$sql .= " " . "JOIN " . TBL_USER . " AS specialist";
											$sql .= " " . "ON specialist.id = " . TBL_TICKET . ".specialist_id";
											$sql .= " " . "WHERE " . TBL_TICKET . ".specialist_id = " . "'$specialistID'";
											$sql .= " " . "ORDER BY " . TBL_TICKET . ".checked_datetime ASC, " . TBL_TICKET . ".datetime ASC";
											
											$tickets = mysqli_query($connection, $sql);
											if ($tickets)
											{
												$ticketCount = mysqli_num_rows($tickets);
											}
										}
									}
									else if (isset($_SESSION['specialist-id']))
									{
										if ($connection)
										{
											$specialistID = $_SESSION['specialist-id'];
											
											$sql = "SELECT";
											$sql .= " " . TBL_TICKET . ".id AS ticket_id,";
											$sql .= " " . TBL_TICKET . ".datetime AS ticket_datetime,";
											$sql .= " " . TBL_TICKET . ".checked_datetime AS ticket_checked_datetime,";
											$sql .= " " . "client.name AS client_name,";
											$sql .= " " . "client.surname AS client_surname,";
											$sql .= " " . "specialist.id AS specialist_id,";
											$sql .= " " . "specialist.name AS specialist_name,";
											$sql .= " " . "specialist.surname AS specialist_surname";
											$sql .= " " . "FROM " . TBL_TICKET;
											$sql .= " " . "JOIN " . TBL_USER . " AS client";
											$sql .= " " . "ON client.id = " . TBL_TICKET . ".client_id";
											$sql .= " " . "JOIN " . TBL_USER . " AS specialist";
											$sql .= " " . "ON specialist.id = " . TBL_TICKET . ".specialist_id";
											$sql .= " " . "WHERE " . TBL_TICKET . ".specialist_id = " . "'$specialistID'";
											$sql .= " " . "ORDER BY " . TBL_TICKET . ".checked_datetime ASC, " . TBL_TICKET . ".datetime ASC";
											
											$tickets = mysqli_query($connection, $sql);
											if ($tickets)
											{
												$ticketCount = mysqli_num_rows($tickets);
											}
										}
										unset($_SESSION['specialist-id']);
									}
									
									if ($ticketCount === 0)
									{
										echo '<tr>';
										echo 	'<td colspan="4" style="text-align: center;">';
										echo 		$language['ticket-table-error'];
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
														echo 	'<td style="padding-top: 0px; padding-bottom: 0px;">';
														echo 		$ticket['ticket_id'];
														echo 	'</td>';
														echo 	'<td style="padding-top: 0px; padding-bottom: 0px;">';
														echo 		$ticket['ticket_datetime'];
														echo 	'</td>';
														echo 	'<td style="padding-top: 0px; padding-bottom: 0px;">';
														echo 		$ticket['client_name'] . ' ' . $ticket['client_surname'];
														echo 	'</td>';
														echo 	'<td style="padding: 0px;">';
														if (is_null($ticket['ticket_checked_datetime']))
														{
															echo 	'<form id="ticket-check-form-' . $ticket['ticket_id'] . '" class="ticket-check-form" style="padding: 0px; margin: 0px;" method="post">';
															echo 		'<input type="hidden" name="ticket-id" value="' . $ticket['ticket_id'] . '">';
															echo 		'<input type="hidden" name="ticket-datetime" value="' . $ticket['ticket_datetime'] . '">';
															echo 		'<input type="hidden" name="ticket-client" value="' . $ticket['client_name'] . ' ' . $ticket['client_surname'] . '">';
															echo 		'<input type="hidden" name="ticket-specialist" value="' . $ticket['specialist_name'] . ' ' . $ticket['specialist_surname'] . '">';
															echo 		'<input type="hidden" name="specialist-id" value="' . $ticket['specialist_id'] . '">';
															echo 		'<button type="submit" class="btn btn-danger btn-block m-0">' . $language['ticket-table-check-submit-button-title'] . '</button>';
															echo 	'</form>';
														}
														else
														{
															echo 	'<button class="btn btn-success btn-block m-0">' . $language['ticket-table-checked-datetime-message'] . '</button>';
														}
														
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
												
												// Adds load button to array
												$loadButtonDisplayStyle = 'display: none;';
												if ($loadButtonCount === 1)
												{
													$loadButtonDisplayStyle = "";
												}
												$loadButton = "";
												$loadButton .= '<tr id="load-button-row-' . $loadButtonCount . '" style="' . $loadButtonDisplayStyle . '">';
												$loadButton .= 		'<td colspan="4" style="padding: 0px;">';
												$loadButton .= 			'<button ' 
																			. 'id="load-button-' . $loadButtonCount . '" ' 
																			. 'data-id="' . $loadButtonCount . '" ' 
																			. 'data-start="' . $i . '" ' 
																			. 'data-end="' . ($i + $ticketsToPrint) . '" ' 
																			. 'data-next-button="' . ($loadButtonCount + 1) . '" ' 
																			. 'class="btn btn-primary btn-block load-more-tickets">' 
																			. $language['ticket-table-load-button-title'] . ' (' . $ticketsToPrint . ')' 
																			. '</button>';
												$loadButton .= 		'</td>';
												$loadButton .= '</tr>';
												array_push($loadButtonArray, $loadButton);
												
												// Prints loadable tickets
												for ($j = 1; $j <= $ticketsToPrint; $j++, $i++)
												{
													if ($ticket = mysqli_fetch_assoc($tickets))
													{
														echo '<tr id="load-ticket-' . $i . '" style="display: none;">';
														echo 	'<td style="padding-top: 0px; padding-bottom: 0px;">';
														echo 		$ticket['ticket_id'];
														echo 	'</td>';
														echo 	'<td style="padding-top: 0px; padding-bottom: 0px;">';
														echo 		$ticket['ticket_datetime'];
														echo 	'</td>';
														echo 	'<td style="padding-top: 0px; padding-bottom: 0px;">';
														echo 		$ticket['client_name'] . ' ' . $ticket['client_surname'];
														echo 	'</td>';
														echo 	'<td style="padding: 0px;">';
														if (is_null($ticket['ticket_checked_datetime']))
														{
															echo 	'<form id="ticket-check-form-' . $ticket['ticket_id'] . '" class="ticket-check-form" style="padding: 0px; margin: 0px;" method="post">';
															echo 		'<input type="hidden" name="ticket-id" value="' . $ticket['ticket_id'] . '">';
															echo 		'<input type="hidden" name="ticket-datetime" value="' . $ticket['ticket_datetime'] . '">';
															echo 		'<input type="hidden" name="ticket-client" value="' . $ticket['client_name'] . ' ' . $ticket['client_surname'] . '">';
															echo 		'<input type="hidden" name="ticket-specialist" value="' . $ticket['specialist_name'] . ' ' . $ticket['specialist_surname'] . '">';
															echo 		'<input type="hidden" name="specialist-id" value="' . $ticket['specialist_id'] . '">';
															echo 		'<button type="submit" class="btn btn-danger btn-block m-0">' . $language['ticket-table-check-submit-button-title'] . '</button>';
															echo 	'</form>';
														}
														else
														{
															echo 	'<button class="btn btn-success btn-block m-0">' . $language['ticket-table-checked-datetime-message'] . '</button>';
														}
														
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
					
					<!-- Load buttons -->
					<div class="row">
						<div class="col">
							<table class="table">
								<tbody>
									<?php
									// Prints load buttons
									foreach($loadButtonArray as $loadButton)
									{
										echo $loadButton;
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					
					<!-- Ticket check message -->
					<?php
					$messageDisplayStyle = 'display: none;';
					
					if (isset($_SESSION['ticket-check-message']))
					{
						$messageDisplayStyle = "";
					}
					?>
					<div class="row" style="<?php echo $messageDisplayStyle; ?>">
						<div class="col">
							<?php
							// Prints submission message
							if (isset($_SESSION['ticket-check-message']))
							{
								echo $_SESSION['ticket-check-message'];
								unset($_SESSION['ticket-check-message']);
							}
							?>
						</div>
					</div>
					
					<!-- Removed ticket table -->
					<div class="row" style="<?php echo $messageDisplayStyle; ?>">
						<div class="col">
							<table class="table">
								<thead class="thead-light">
									<tr>
										<th colspan="4" style="text-align: center;"><?php echo $language['ticket-check-table-header']; ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?php echo $language['ticket-check-table-id-header']; ?></th>
										<th><?php echo $language['ticket-check-table-datetime-header']; ?></th>
										<th><?php echo $language['ticket-check-table-client-header']; ?></th>
										<th><?php echo $language['ticket-check-table-specialist-header']; ?></th>
									</tr>
									<tr>
										<td>
											<?php
											// Prints ticket ID
											if (isset($_SESSION['ticket-check-table-id']))
											{
												echo $_SESSION['ticket-check-table-id'];
												unset($_SESSION['ticket-check-table-id']);
											}
											else
											{
												echo $language['ticket-check-table-id-error'];
											}
											?>
										</td>
										<td>
											<?php
											// Prints ticket datetime
											if (isset($_SESSION['ticket-check-table-datetime']))
											{
												echo $_SESSION['ticket-check-table-datetime'];
												unset($_SESSION['ticket-check-table-datetime']);
											}
											else
											{
												echo $language['ticket-check-table-datetime-error'];
											}
											?>
										</td>
										<td>
											<?php
											// Prints ticket client
											if (isset($_SESSION['ticket-check-table-client']))
											{
												echo $_SESSION['ticket-check-table-client'];
												unset($_SESSION['ticket-check-table-client']);
											}
											else
											{
												echo $language['ticket-check-table-client-error'];
											}
											?>
										</td>
										<td>
											<?php
											// Prints ticket specialist
											if (isset($_SESSION['ticket-check-table-specialist']))
											{
												echo $_SESSION['ticket-check-table-specialist'];
												unset($_SESSION['ticket-check-table-specialist']);
											}
											else
											{
												echo $language['ticket-check-table-specialist-error'];
											}
											?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>