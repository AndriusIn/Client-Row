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
		<title><?php echo $language['admin-page-title']; ?></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<!-- Ajax requests -->
		<script>
			// Hides or shows new user form
			$(function () {
				$(document).on('click', '.btn.btn-secondary.btn-block.toggle-new-user', function () {
					$.ajax({
						success: function () {
							// Hides or shows new user form
							$('#new-user-form-row').toggle();
							
							// Hides new ticket form
							$('#new-ticket-form-row').hide();
						}
					});
				});
			});
			
			// Hides or shows new ticket form
			$(function () {
				$(document).on('click', '.btn.btn-secondary.btn-block.toggle-new-ticket', function () {
					$.ajax({
						success: function () {
							// Hides or shows new ticket form
							$('#new-ticket-form-row').toggle();
							
							// Hides new user form
							$('#new-user-form-row').hide();
						}
					});
				});
			});
			
			// Submits new user
			$(function (){
				$(document).on('submit', '.new-user-form', function (e) {
					e.preventDefault();
					$.ajax({
						type: 'post', 
						url: 'create_user.php', 
						data: $('#' + e.target.id).serialize(), 
						success: function () {
							// Loads new user submission message
							$('#new-user-submission-message-row').load('index.php #new-user-submission-message-col');
							
							// Loads new ticket form
							$('#new-ticket-form-row').load('index.php #new-ticket-form-col');
						}
					});
				});
			});
			
			// Submits new ticket
			$(function (){
				$(document).on('submit', '.new-ticket-form', function (e) {
					e.preventDefault();
					$.ajax({
						type: 'post', 
						url: 'create_ticket.php', 
						data: $('#' + e.target.id).serialize(), 
						success: function () {
							// Loads new ticket submission message
							$('#new-ticket-submission-message-row').load('index.php #new-ticket-submission-message-col');
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
				<!-- Admin interface link -->
				<a class="nav-item nav-link" href="index.php"><?php echo $language['navbar-admin-interface']; ?></a>
				
				<!-- Client board link -->
				<a class="nav-item nav-link" href="board.php"><?php echo $language['navbar-client-board']; ?></a>
				
				<!-- Specialist interface link -->
				<a class="nav-item nav-link" href="specialist.php"><?php echo $language['navbar-specialist-interface']; ?></a>
			</div>
		</nav>
		
		<!-- Page heading -->
		<h1 class="display-4" style="text-align: center;"><?php echo $language['admin-page-title']; ?></h1>
		
		<!-- Page content -->
		<div class="container-fluid py-3">
			<!-- Action buttons -->
			<div class="row">
				<div class="col">
					<!-- New user button -->
					<button type="button" class="btn btn-secondary btn-block toggle-new-user"><?php echo $language['new-user-button-name']; ?></button>
					
					<!-- New ticket button -->
					<button type="button" class="btn btn-secondary btn-block toggle-new-ticket"><?php echo $language['new-ticket-button-name']; ?></button>
				</div>
			</div>
			
			<!-- New user form and submission message -->
			<div class="row" id="new-user-form-row" style="display: none;">
				<div class="col" id="new-user-form-col">
					<!-- New user form -->
					<div class="row">
						<div class="col">
							<form id="new-user-form" class="new-user-form" method="post">
								<!-- Name -->
								<div class="form-group">
									<label for="new-user-name"><b><?php echo $language['new-user-name']; ?></b></label>
									<input type="text" class="form-control" id="new-user-name" name="new-user-name" placeholder="<?php echo $language['new-user-name-placeholder']; ?>">
								</div>
								
								<!-- Surname -->
								<div class="form-group">
									<label for="new-user-surname"><b><?php echo $language['new-user-surname']; ?></b></label>
									<input type="text" class="form-control" id="new-user-surname" name="new-user-surname" placeholder="<?php echo $language['new-user-surname-placeholder']; ?>">
								</div>
								
								<!-- Email -->
								<div class="form-group">
									<label for="new-user-email"><b><?php echo $language['new-user-email']; ?></b></label>
									<input type="text" class="form-control" id="new-user-email" name="new-user-email" placeholder="<?php echo $language['new-user-email-placeholder']; ?>">
								</div>
								
								<!-- Role -->
								<div class="form-group">
									<label for="new-user-role"><b><?php echo $language['new-user-role-select-label']; ?></b></label>
									<select class="form-control" id="new-user-role" name="new-user-role">
										<option value="ROLE_CLIENT"><?php echo $language['new-user-client-role-name']; ?></option>
										<option value="ROLE_ADMIN"><?php echo $language['new-user-admin-role-name']; ?></option>
										<option value="ROLE_SPECIALIST"><?php echo $language['new-user-specialist-role-name']; ?></option>
									</select>
								</div>
								
								<button type="submit" class="btn btn-primary"><?php echo $language['new-user-submit-button-title']; ?></button>
							</form>
						</div>
					</div>
					
					<!-- New user submission message -->
					<div class="row" id="new-user-submission-message-row">
						<div class="col" id="new-user-submission-message-col">
							<?php
							// Prints submission message
							if (isset($_SESSION['new-user-submission-message']))
							{
								echo $_SESSION['new-user-submission-message'];
								unset($_SESSION['new-user-submission-message']);
							}
							?>
						</div>
					</div>
				</div>
			</div>
			
			<!-- New ticket form and submission message -->
			<div class="row" id="new-ticket-form-row" style="display: none;">
				<div class="col" id="new-ticket-form-col">
					<!-- New ticket form -->
					<div class="row">
						<div class="col">
							<form id="new-ticket-form" class="new-ticket-form" method="post">
								<!-- Clients -->
								<div class="form-group">
									<label for="client-id"><b><?php echo $language['new-ticket-client-select-label']; ?></b></label>
									<select class="form-control" id="client-id" name="client-id">
										<?php
										if (!$connection)
										{
											echo '<option value="-1">' . $language['new-ticket-client-connection-error'] . '</option>';
										}
										else
										{
											// Selects all clients
											$sql = "SELECT id, name, surname, email FROM " . TBL_USER . " WHERE JSON_CONTAINS(roles, '\"ROLE_CLIENT\"') = 1 ORDER BY name ASC, surname ASC, email ASC";
											$clients = mysqli_query($connection, $sql);
											
											if (!$clients)
											{
												echo '<option value="-1">' . $language['new-ticket-client-select-error'] . '</option>';
											}
											else
											{
												// Prints all clients
												if (mysqli_num_rows($clients) > 0)
												{
													while($client = mysqli_fetch_assoc($clients))
													{
														$fullName = $client['name'] . ' ' . $client['surname'] . ' (' . $client['email'] . ')';
														echo '<option value="' . $client['id'] . '">' . $fullName . '</option>';
													}
												}
												else
												{
													echo '<option value="-1">' . $language['new-ticket-client-empty-error'] . '</option>';
												}
											}
										}
										?>
									</select>
								</div>
								
								<!-- Specialists -->
								<div class="form-group">
									<label for="specialist-id"><b><?php echo $language['new-ticket-specialist-select-label']; ?></b></label>
									<select class="form-control" id="specialist-id" name="specialist-id">
										<?php
										if (!$connection)
										{
											echo '<option value="-1">' . $language['new-ticket-specialist-connection-error'] . '</option>';
										}
										else
										{
											// Selects all specialists
											$sql = "SELECT id, name, surname, email FROM " . TBL_USER . " WHERE JSON_CONTAINS(roles, '\"ROLE_SPECIALIST\"') = 1 ORDER BY name ASC, surname ASC, email ASC";
											$specialists = mysqli_query($connection, $sql);
											
											if (!$specialists)
											{
												echo '<option value="-1">' . $language['new-ticket-specialist-select-error'] . '</option>';
											}
											else
											{
												// Prints all specialists
												if (mysqli_num_rows($specialists) > 0)
												{
													while($specialist = mysqli_fetch_assoc($specialists))
													{
														$fullName = $specialist['name'] . ' ' . $specialist['surname'] . ' (' . $specialist['email'] . ')';
														echo '<option value="' . $specialist['id'] . '">' . $fullName . '</option>';
													}
												}
												else
												{
													echo '<option value="-1">' . $language['new-ticket-specialist-empty-error'] . '</option>';
												}
											}
										}
										?>
									</select>
								</div>
								
								<!-- New ticket submission button -->
								<?php
								$buttonIsEnabled = false;
								
								// Checks if clients and specialists are not missing
								if ($clients && $specialists)
								{
									if (mysqli_num_rows($clients) > 0 && mysqli_num_rows($specialists) > 0)
									{
										$buttonIsEnabled = true;
									}
								}
								
								if ($buttonIsEnabled)
								{
									echo '<button type="submit" class="btn btn-primary">' . $language['new-ticket-submit-button-title'] . '</button>';
								}
								else
								{
									echo '<button type="submit" class="btn btn-primary" disabled>' . $language['new-ticket-submit-button-title'] . '</button>';
								}
								?>
							</form>
						</div>
					</div>
					
					<!-- New ticket submission message and tables -->
					<div class="row" id="new-ticket-submission-message-row">
						<div class="col" id="new-ticket-submission-message-col">
							<?php
							$newTicketMessageDisplayStyle = 'display: none;';
							
							if (isset($_SESSION['new-ticket-submission-message']))
							{
								$newTicketMessageDisplayStyle = "";
							}
							?>
							
							<!-- New ticket submission message -->
							<div class="row" style="<?php echo $newTicketMessageDisplayStyle; ?>">
								<div class="col">
									<?php
									// Prints submission message
									if (isset($_SESSION['new-ticket-submission-message']))
									{
										echo $_SESSION['new-ticket-submission-message'];
										unset($_SESSION['new-ticket-submission-message']);
									}
									?>
								</div>
							</div>
							
							<!-- Client table -->
							<div class="row" style="<?php echo $newTicketMessageDisplayStyle; ?>">
								<div class="col">
									<table class="table">
										<thead class="thead-dark">
											<tr>
												<th colspan="4" style="text-align: center;"><?php echo $language['new-ticket-client-header']; ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-id-header']; ?></th>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-name-header']; ?></th>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-surname-header']; ?></th>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-email-header']; ?></th>
											</tr>
											<tr>
												<td style="width: 25%;">
													<?php
													// Prints client ID
													if (isset($_SESSION['new-ticket-submission-client-id']))
													{
														echo $_SESSION['new-ticket-submission-client-id'];
														unset($_SESSION['new-ticket-submission-client-id']);
													}
													else
													{
														echo $language['new-ticket-client-id-error'];
													}
													?>
												</td>
												<td style="width: 25%;">
													<?php
													// Prints client name
													if (isset($_SESSION['new-ticket-submission-client-name']))
													{
														echo $_SESSION['new-ticket-submission-client-name'];
														unset($_SESSION['new-ticket-submission-client-name']);
													}
													else
													{
														echo $language['new-ticket-client-name-error'];
													}
													?>
												</td>
												<td style="width: 25%;">
													<?php
													// Prints client surname
													if (isset($_SESSION['new-ticket-submission-client-surname']))
													{
														echo $_SESSION['new-ticket-submission-client-surname'];
														unset($_SESSION['new-ticket-submission-client-surname']);
													}
													else
													{
														echo $language['new-ticket-client-surname-error'];
													}
													?>
												</td>
												<td style="width: 25%;">
													<?php
													// Prints client email
													if (isset($_SESSION['new-ticket-submission-client-email']))
													{
														echo $_SESSION['new-ticket-submission-client-email'];
														unset($_SESSION['new-ticket-submission-client-email']);
													}
													else
													{
														echo $language['new-ticket-client-email-error'];
													}
													?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<!-- Specialist table -->
							<div class="row" style="<?php echo $newTicketMessageDisplayStyle; ?>">
								<div class="col">
									<table class="table">
										<thead class="thead-light">
											<tr>
												<th colspan="4" style="text-align: center;"><?php echo $language['new-ticket-specialist-header']; ?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-id-header']; ?></th>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-name-header']; ?></th>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-surname-header']; ?></th>
												<th style="width: 25%;"><?php echo $language['new-ticket-user-email-header']; ?></th>
											</tr>
											<tr>
												<td style="width: 25%;">
													<?php
													// Prints specialist ID
													if (isset($_SESSION['new-ticket-submission-specialist-id']))
													{
														echo $_SESSION['new-ticket-submission-specialist-id'];
														unset($_SESSION['new-ticket-submission-specialist-id']);
													}
													else
													{
														echo $language['new-ticket-specialist-id-error'];
													}
													?>
												</td>
												<td style="width: 25%;">
													<?php
													// Prints specialist name
													if (isset($_SESSION['new-ticket-submission-specialist-name']))
													{
														echo $_SESSION['new-ticket-submission-specialist-name'];
														unset($_SESSION['new-ticket-submission-specialist-name']);
													}
													else
													{
														echo $language['new-ticket-specialist-name-error'];
													}
													?>
												</td>
												<td style="width: 25%;">
													<?php
													// Prints specialist surname
													if (isset($_SESSION['new-ticket-submission-specialist-surname']))
													{
														echo $_SESSION['new-ticket-submission-specialist-surname'];
														unset($_SESSION['new-ticket-submission-specialist-surname']);
													}
													else
													{
														echo $language['new-ticket-specialist-surname-error'];
													}
													?>
												</td>
												<td style="width: 25%;">
													<?php
													// Prints specialist email
													if (isset($_SESSION['new-ticket-submission-specialist-email']))
													{
														echo $_SESSION['new-ticket-submission-specialist-email'];
														unset($_SESSION['new-ticket-submission-specialist-email']);
													}
													else
													{
														echo $language['new-ticket-specialist-email-error'];
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
			</div>
		</div>
	</body>
</html>