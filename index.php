<?php

	include_once('php/config/conf.consts.php');

	// TO-DO: check config (r/w permissions, email addresses)

	if ( !file_exists(VCCARD_DB_FILE) ) {
		readfile('html/vccard-create.html');
		exit;
	}

	readfile('html/vccard-query.html');
	exit;
