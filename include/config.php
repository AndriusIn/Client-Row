<?php
// Database parameters
define("DB_SERVER", "clientrow.com");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "clientrow");

// Database tables
define("TBL_USER", "user");
define("TBL_TICKET", "ticket");

// Languages
define("DEFAULT_LANGUAGE", "L_ENGLISH");
define("L_ENGLISH", 
	array(
		// Page titles
		'admin-page-title' => 'Admin Interface', 
		'board-page-title' => 'Client Board', 
		'specialist-page-title' => 'Specialist Interface', 
		'visitor-page-title' => 'Visitor Page', 
		
		// Navigation bar
		'navbar-title' => 'Client Board', 
		'navbar-admin-interface' => 'Admin Interface', 
		'navbar-client-board' => 'Client Board', 
		'navbar-specialist-interface' => 'Specialist Interface', 
		'navbar-visitor-page' => 'Visitor Page', 
		
		// Visitor page ticket search form
		'ticket-search-id' => 'Ticket ID', 
		'ticket-search-id-placeholder' => 'Ticket ID', 
		'ticket-search-submit-button-title' => 'Search', 
		
		// Admin action buttons
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
		'new-user-submit-button-title' => 'Submit', 
		
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
		'new-ticket-submit-button-title' => 'Submit', 
		
		// Admin new ticket form submission
		'new-ticket-connection-error' => 'Could not connect to database!', 
		'new-ticket-insert-error' => 'Could not insert ticket to database!', 
		'new-ticket-message-name' => 'Message:', 
		'new-ticket-message-success' => 'Ticket submission complete.', 
		'new-ticket-client-header' => 'Client', 
		'new-ticket-specialist-header' => 'Specialist', 
		'new-ticket-user-id-header' => 'ID', 
		'new-ticket-user-name-header' => 'Name', 
		'new-ticket-user-surname-header' => 'Surname', 
		'new-ticket-user-email-header' => 'Email', 
		'new-ticket-client-id-error' => 'Failed to get client ID!', 
		'new-ticket-client-name-error' => 'Failed to get client name!', 
		'new-ticket-client-surname-error' => 'Failed to get client surname!', 
		'new-ticket-client-email-error' => 'Failed to get client email!', 
		'new-ticket-specialist-id-error' => 'Failed to get specialist ID!', 
		'new-ticket-specialist-name-error' => 'Failed to get specialist name!', 
		'new-ticket-specialist-surname-error' => 'Failed to get specialist surname!', 
		'new-ticket-specialist-email-error' => 'Failed to get specialist email!', 
		'new-ticket-message-fail' => 'Ticket submission failed!', 
		
		// Cliend board
		'client-board-ticket-id-header' => 'Ticket ID', 
		'client-board-client-header' => 'Client', 
		'client-board-specialist-header' => 'Specialist', 
		'client-board-tickets-error' => 'No tickets found!', 
		'client-board-load-button-title' => 'Load more', 
		
		// Specialist selection form
		'specialist-select-label' => 'Specialist', 
		'specialist-connection-error' => 'Could not connect to database!', 
		'specialist-select-error' => 'Could not select specialists from database!', 
		'specialist-empty-error' => 'Please register new specialists', 
		'specialist-select-submit-button-title' => 'Submit', 
		
		// Specialist selection form submission
		'ticket-table-id-header' => 'Ticket ID', 
		'ticket-table-datetime-header' => 'Ticket datetime', 
		'ticket-table-checked-datetime-message' => 'Ticket is checked', 
		'ticket-table-client-header' => 'Client', 
		'ticket-table-button-header' => 'Action', 
		'ticket-table-error' => 'No tickets found!', 
		'ticket-table-submit-button-title' => 'Remove', 
		'ticket-table-check-submit-button-title' => 'Mark as checked', 
		'ticket-table-load-button-title' => 'Load more', 
		'ticket-remove-message-name' => 'Message:', 
		'ticket-remove-message-fail' => 'Could not remove ticket', 
		'ticket-remove-message-success' => 'Ticket removed.', 
		'ticket-remove-message-connection-error' => 'Could not remove ticket (database connection error)!', 
		'ticket-remove-table-header' => 'Removed ticket', 
		'ticket-remove-table-id-header' => 'Ticket ID', 
		'ticket-remove-table-datetime-header' => 'Ticket datetime', 
		'ticket-remove-table-client-header' => 'Client', 
		'ticket-remove-table-specialist-header' => 'Specialist', 
		'ticket-remove-table-id-error' => 'Failed to get ticket ID!', 
		'ticket-remove-table-datetime-error' => 'Failed to get ticket datetime!', 
		'ticket-remove-table-client-error' => 'Failed to get ticket client!', 
		'ticket-remove-table-specialist-error' => 'Failed to get ticket specialist!', 
		'ticket-check-message-name' => 'Message:', 
		'ticket-check-message-fail' => 'Could not update ticket', 
		'ticket-check-message-success' => 'Ticket updated.', 
		'ticket-check-message-connection-error' => 'Could not update ticket (database connection error)!', 
		'ticket-check-table-header' => 'Updated ticket', 
		'ticket-check-table-id-header' => 'Ticket ID', 
		'ticket-check-table-datetime-header' => 'Ticket datetime', 
		'ticket-check-table-client-header' => 'Client', 
		'ticket-check-table-specialist-header' => 'Specialist', 
		'ticket-check-table-id-error' => 'Failed to get ticket ID!', 
		'ticket-check-table-datetime-error' => 'Failed to get ticket datetime!', 
		'ticket-check-table-client-error' => 'Failed to get ticket client!', 
		'ticket-check-table-specialist-error' => 'Failed to get ticket specialist!'
	)
);
define("L_LITHUANIAN", 
	array(
		// Page titles
		'admin-page-title' => 'Administratoriaus Sąsaja', 
		'board-page-title' => 'Klientų Švieslentė', 
		'specialist-page-title' => 'Specialisto Sąsaja', 
		'visitor-page-title' => 'Lankytojo Puslapis', 
		
		// Navigation bar
		'navbar-title' => 'Klientų Švieslentė', 
		'navbar-admin-interface' => 'Administratoriaus Sąsaja', 
		'navbar-client-board' => 'Klientų Švieslentė', 
		'navbar-specialist-interface' => 'Specialisto Sąsaja', 
		'navbar-visitor-page' => 'Lankytojo Puslapis', 
		
		// Visitor page ticket search form
		'ticket-search-id' => 'Lapuko ID', 
		'ticket-search-id-placeholder' => 'Lapuko ID', 
		'ticket-search-submit-button-title' => 'Ieškoti', 
		
		// Admin action buttons
		'new-user-button-name' => 'Registruoti naują vartotoją', 
		'new-ticket-button-name' => 'Pridėti klientą į švieslentę', 
		
		// Admin new user form
		'new-user-name' => 'Vardas', 
		'new-user-name-placeholder' => 'Vardas', 
		'new-user-surname' => 'Pavardė', 
		'new-user-surname-placeholder' => 'Pavardė', 
		'new-user-email' => 'El. paštas', 
		'new-user-email-placeholder' => 'El. paštas', 
		'new-user-role-select-label' => 'Rolė', 
		'new-user-client-role-name' => 'Klientas', 
		'new-user-admin-role-name' => 'Administratorius', 
		'new-user-specialist-role-name' => 'Specialistas', 
		'new-user-submit-button-title' => 'Patvirtinti', 
		
		// Admin new user form submission
		'new-user-name-empty-error' => 'Vardas tuščias!', 
		'new-user-name-pattern-error' => 'Varde yra neleistinų simbolių (tarpai, skaičiai ir t.t.)!', 
		'new-user-surname-empty-error' => 'Pavardė tuščia!', 
		'new-user-surname-pattern-error' => 'Pavardėje yra neleistinų simbolių (tarpai, skaičiai ir t.t.)!', 
		'new-user-email-empty-error' => 'El. paštas tuščias!', 
		'new-user-email-pattern-error' => 'Netinkamas el. pašto formatas!', 
		'new-user-email-exists-error' => 'Toks el. paštas jau užregistruotas', 
		'new-user-connection-error' => 'Prisijungimo prie duombazės klaida!', 
		'new-user-insert-error' => 'Vartotojo pridėjimo į duombazę klaida!', 
		'new-user-message-name' => 'Pranešimas:', 
		'new-user-message-success' => 'Užregistruota sėkmingai', 
		'new-user-message-fail' => 'Įvyko klaida, kreipkitės telefonu', 
		
		// Admin new ticket form
		'new-ticket-client-select-label' => 'Klientas', 
		'new-ticket-client-connection-error' => 'Prisijungimo prie duombazės klaida!', 
		'new-ticket-client-select-error' => 'Klientų gavimo iš duombazės klaida!', 
		'new-ticket-client-empty-error' => 'Prašome užregistruoti klientus', 
		'new-ticket-specialist-select-label' => 'Specialistas', 
		'new-ticket-specialist-connection-error' => 'Prisijungimo prie duombazės klaida!', 
		'new-ticket-specialist-select-error' => 'Specialistų gavimo iš duombazės klaida!', 
		'new-ticket-specialist-empty-error' => 'Prašome užregistruoti specialistus', 
		'new-ticket-submit-button-title' => 'Patvirtinti', 
		
		// Admin new ticket form submission
		'new-ticket-connection-error' => 'Prisijungimo prie duombazės klaida!', 
		'new-ticket-insert-error' => 'Lapuko pridėjimo į duombazę klaida!', 
		'new-ticket-message-name' => 'Pranešimas:', 
		'new-ticket-message-success' => 'Lapukas sėkmingai užregistruotas.', 
		'new-ticket-client-header' => 'Klientas', 
		'new-ticket-specialist-header' => 'Specialistas', 
		'new-ticket-user-id-header' => 'ID', 
		'new-ticket-user-name-header' => 'Vardas', 
		'new-ticket-user-surname-header' => 'Pavardė', 
		'new-ticket-user-email-header' => 'El. paštas', 
		'new-ticket-client-id-error' => 'Nepavyko gauti kliento ID!', 
		'new-ticket-client-name-error' => 'Nepavyko gauti kliento vardo!', 
		'new-ticket-client-surname-error' => 'Nepavyko gauti kliento pavardės!', 
		'new-ticket-client-email-error' => 'Nepavyko gauti kliento el. pašto!', 
		'new-ticket-specialist-id-error' => 'Nepavyko gauti specialisto ID!', 
		'new-ticket-specialist-name-error' => 'Nepavyko gauti specialisto vardo!', 
		'new-ticket-specialist-surname-error' => 'Nepavyko gauti specialisto pavardės!', 
		'new-ticket-specialist-email-error' => 'Nepavyko gauti specialisto el. pašto!', 
		'new-ticket-message-fail' => 'Lapuko registracijos klaida!', 
		
		// Cliend board
		'client-board-ticket-id-header' => 'Lapuko ID', 
		'client-board-client-header' => 'Klientas', 
		'client-board-specialist-header' => 'Specialistas', 
		'client-board-tickets-error' => 'Lapukų nėra!', 
		'client-board-load-button-title' => 'Rodyti daugiau', 
		
		// Specialist selection form
		'specialist-select-label' => 'Specialistas', 
		'specialist-connection-error' => 'Prisijungimo prie duombazės klaida!', 
		'specialist-select-error' => 'Specialistų gavimo iš duombazės klaida!', 
		'specialist-empty-error' => 'Prašome užregistruoti specialistus', 
		'specialist-select-submit-button-title' => 'Patvirtinti', 
		
		// Specialist selection form submission
		'ticket-table-id-header' => 'Lapuko ID', 
		'ticket-table-datetime-header' => 'Lapuko data ir laikas', 
		'ticket-table-checked-datetime-message' => 'Klientas jau aptarnautas', 
		'ticket-table-client-header' => 'Klientas', 
		'ticket-table-button-header' => 'Veiksmai', 
		'ticket-table-error' => 'Lapukų nėra!', 
		'ticket-table-submit-button-title' => 'Pašalinti', 
		'ticket-table-check-submit-button-title' => 'Pažymėti kaip aptarnautą', 
		'ticket-table-load-button-title' => 'Rodyti daugiau', 
		'ticket-remove-message-name' => 'Pranešimas:', 
		'ticket-remove-message-fail' => 'Lapuko pašalinimo klaida', 
		'ticket-remove-message-success' => 'Lapukas pašalintas.', 
		'ticket-remove-message-connection-error' => 'Lapuko pašalinimo klaida (prisijungimo prie duombazės klaida)!', 
		'ticket-remove-table-header' => 'Pašalintas lapukas', 
		'ticket-remove-table-id-header' => 'Lapuko ID', 
		'ticket-remove-table-datetime-header' => 'Lapuko data ir laikas', 
		'ticket-remove-table-client-header' => 'Klientas', 
		'ticket-remove-table-specialist-header' => 'Specialistas', 
		'ticket-remove-table-id-error' => 'Nepavyko gauti lapuko ID!', 
		'ticket-remove-table-datetime-error' => 'Nepavyko gauti lapuko datos ir laiko!', 
		'ticket-remove-table-client-error' => 'Nepavyko gauti lapuko kliento!', 
		'ticket-remove-table-specialist-error' => 'Nepavyko gauti lapuko specialisto!', 
		'ticket-check-message-name' => 'Pranešimas:', 
		'ticket-check-message-fail' => 'Lapuko atnaujinimo klaida', 
		'ticket-check-message-success' => 'Lapukas atnaujintas.', 
		'ticket-check-message-connection-error' => 'Lapuko atnaujinimo klaida (prisijungimo prie duombazės klaida)!', 
		'ticket-check-table-header' => 'Atnaujintas lapukas', 
		'ticket-check-table-id-header' => 'Lapuko ID', 
		'ticket-check-table-datetime-header' => 'Lapuko data ir laikas', 
		'ticket-check-table-client-header' => 'Klientas', 
		'ticket-check-table-specialist-header' => 'Specialistas', 
		'ticket-check-table-id-error' => 'Nepavyko gauti lapuko ID!', 
		'ticket-check-table-datetime-error' => 'Nepavyko gauti lapuko datos ir laiko!', 
		'ticket-check-table-client-error' => 'Nepavyko gauti lapuko kliento!', 
		'ticket-check-table-specialist-error' => 'Nepavyko gauti lapuko specialisto!'
	)
);
?>