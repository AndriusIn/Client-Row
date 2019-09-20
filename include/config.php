<?php
// Database parameters
define("DB_SERVER", "clientrow.com");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "clientrow");

// Database tables
define("TBL_USER", "user");
define("TBL_TICKET", "ticket");

// Admin interface limits
define("admin-user-table-limit", 10);
define("admin-user-table-load-limit", 10);

// Languages
define("L_ENGLISH", 
	array(
		// Page titles
		'admin-page-title' => 'Admin interface', 
		'board-page-title' => 'Client Board', 
		'specialist-page-title' => 'Specialist interface', 
		
		// Navigation bar
		'navbar-title' => 'Client Board', 
		'navbar-admin-interface' => 'Admin interface', 
		'navbar-client-board' => 'Client board', 
		'navbar-specialist-interface' => 'Specialist interface', 
		
		// Admin action buttons
		'button-group-aria-label' => 'Actions', 
		'new-user-button-name' => 'Register new user', 
		'new-ticket-button-name' => 'Add client to client board', 
		
		// Admin new user form
		'new-user-name' => 'Name', 
		'new-user-name-placeholder' => 'Name', 
		'new-user-surname' => 'Surname', 
		'new-user-surname-placeholder' => 'Surname', 
		'new-user-email' => 'Email', 
		'new-user-email-placeholder' => 'Email', 
		'new-user-role-select-label' => 'Role', 
		'new-user-client-role-name' => 'Client', 
		'new-user-admin-role-name' => 'Admin', 
		'new-user-specialist-role-name' => 'Specialist', 
		'new-user-submit' => 'Submit', 
		
		// Admin new user form submission
		'new-user-name-empty-error' => 'Name is empty!', 
		'new-user-name-pattern-error' => 'Name contains non-letter characters!', 
		'new-user-surname-empty-error' => 'Surname is empty!', 
		'new-user-surname-pattern-error' => 'Surname contains non-letter characters!', 
		'new-user-email-empty-error' => 'Email is empty!', 
		'new-user-email-pattern-error' => 'Email format is invalid!', 
		'new-user-email-exists-error' => 'Email already exists', 
		'new-user-connection-error' => 'Could not connect to database!', 
		'new-user-insert-error' => 'Could not insert user to database!', 
		'new-user-message-name' => 'Message:', 
		'new-user-message-success' => 'User registration complete', 
		'new-user-message-fail' => 'User registration failed!', 
		
		// Admin new ticket form
		'new-ticket-client-select-label' => 'Client', 
		'new-ticket-client-connection-error' => 'Could not connect to database!', 
		'new-ticket-client-select-error' => 'Could not select clients from database!', 
		'new-ticket-client-empty-error' => 'Please register new clients', 
		'new-ticket-specialist-select-label' => 'Specialist', 
		'new-ticket-specialist-connection-error' => 'Could not connect to database!', 
		'new-ticket-specialist-select-error' => 'Could not select specialists from database!', 
		'new-ticket-specialist-empty-error' => 'Please register new specialists', 
		'new-ticket-submit' => 'Submit', 
		
		// Admin new ticket form submission
		'new-ticket-connection-error' => 'Could not connect to database!', 
		'new-ticket-insert-error' => 'Could not insert ticket to database!', 
		'new-ticket-message-name' => 'Message:', 
		'new-ticket-message-success' => 'Ticket submission complete.', 
		'new-ticket-client-header' => 'Client', 
		'new-ticket-specialist-header' => 'Specialist', 
		'new-ticket-user-name-header' => 'Name', 
		'new-ticket-user-surname-header' => 'Surname', 
		'new-ticket-user-email-header' => 'Email', 
		'new-ticket-client-name-error' => 'Failed to get client name!', 
		'new-ticket-client-surname-error' => 'Failed to get client surname!', 
		'new-ticket-client-email-error' => 'Failed to get client email!', 
		'new-ticket-specialist-name-error' => 'Failed to get specialist name!', 
		'new-ticket-specialist-surname-error' => 'Failed to get specialist surname!', 
		'new-ticket-specialist-email-error' => 'Failed to get specialist email!', 
		'new-ticket-message-fail' => 'Ticket submission failed!'
	)
);
?>