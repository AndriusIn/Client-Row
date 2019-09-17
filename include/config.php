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
		'new-user-button-name' => 'Add new user to queue', 
		'existing-user-button-name' => 'Add existing user to queue', 
		
		// Admin new user form
		'new-user-name' => 'Name', 
		'new-user-name-placeholder' => 'Name', 
		'new-user-surname' => 'Surname', 
		'new-user-surname-placeholder' => 'Surname', 
		'new-user-email' => 'Email', 
		'new-user-email-placeholder' => 'Email', 
		'new-user-specialist-select-label' => 'Specialist', 
		'new-user-specialist-error' => 'No specialists to display', 
		'new-user-submit' => 'Submit', 
		
		// Admin existing user form
		'existing-user-select-label' => 'User', 
		'existing-user-error' => 'No users to display', 
		'existing-user-submit' => 'Submit'
	)
);
?>