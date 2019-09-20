<?php
include("include/config.php");

session_start();

// Sets language
$language = L_ENGLISH;
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
				$(document).on('click', '.btn.btn-secondary.toggle-new-user', function () {
					$.ajax({
						success: function () {
							// Hides or shows new user form
							$('#new-user-form-row').toggle();
							
							// Hides new ticket form
							$('#new-ticket-form-row').hide();
							
							// Hides or shows submission message
							$('#submission-message-row').toggle();
						}
					});
				});
			});
			
			// Hides or shows new ticket form
			$(function () {
				$(document).on('click', '.btn.btn-secondary.toggle-new-ticket', function () {
					$.ajax({
						success: function () {
							// Hides or shows new ticket form
							$('#new-ticket-form-row').toggle();
							
							// Hides new user form
							$('#new-user-form-row').hide();
							
							// Hides submission message
							$('#submission-message-row').hide();
						}
					});
				});
			});
			
			// Submits new user
			$(function (){
				$('#new-user-form').on('submit', function (e){
					e.preventDefault();
					$.ajax({
						type: 'post', 
						url: 'create_user.php', 
						data: $('#new-user-form').serialize(), 
						success: function () {
							// Loads submission message
							$('#submission-message-row').load('index.php #submission-message-col');
							
							// Loads new ticket form
							$('#new-ticket-form-row').load('index.php #new-ticket-form-col');
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
		
		<!-- Page container -->
		<div class="container-fluid py-3">
			<!-- Action buttons -->
			<div class="row">
				<div class="col">
					<div class="btn-group" role="group" aria-label="<?php echo $language['button-group-aria-label']; ?>">
						<!-- New user button -->
						<button type="button" class="btn btn-secondary toggle-new-user"><?php echo $language['new-user-button-name']; ?></button>
						
						<!-- New ticket button -->
						<button type="button" class="btn btn-secondary toggle-new-ticket"><?php echo $language['new-ticket-button-name']; ?></button>
					</div>
				</div>
			</div>
			
			<!-- New user form -->
			<div class="row" id="new-user-form-row" style="display: none;">
				<div class="col" id="new-user-form-col">
					<form id="new-user-form" method="post">
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
						
						<button type="submit" class="btn btn-primary"><?php echo $language['new-user-submit']; ?></button>
					</form>
				</div>
			</div>
			
			<!-- New ticket form -->
			<div class="row" id="new-ticket-form-row" style="display: none;">
				<div class="col" id="new-ticket-form-col">
					<form id="new-ticket-form" method="get" action="specialist.php">
						<!-- Clients -->
						<div class="form-group">
							<label for="client"><b><?php echo $language['new-ticket-client-select-label']; ?></b></label>
							<select class="form-control" id="client" name="client-id">
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
							<label for="specialist"><b><?php echo $language['new-ticket-specialist-select-label']; ?></b></label>
							<select class="form-control" id="specialist" name="specialist-id">
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
							echo '<button type="submit" class="btn btn-primary">' . $language['new-ticket-submit'] . '</button>';
						}
						else
						{
							echo '<button type="submit" class="btn btn-primary" disabled>' . $language['new-ticket-submit'] . '</button>';
						}
						?>
					</form>
				</div>
			</div>
			
			<!-- Submission message -->
			<div class="row" id="submission-message-row" style="display: none;">
				<div class="col" id="submission-message-col">
					<?php
					// Prints submission message
					if (isset($_SESSION['submission-message']))
					{
						echo $_SESSION['submission-message'];
						unset($_SESSION['submission-message']);
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>