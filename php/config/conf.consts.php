<?php

	define( 'VCCARD_DB_FILE', $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/db/coords.db' );
	define( 'VCCARD_MSG_SUBJECT', 'VCCard Response ('.date('Ymd H:i:s').')' );
	define( 'VCCARD_DEST_EMAIL', isset($_SERVER['VCCARD_DEST_EMAIL']) ? $_SERVER['VCCARD_DEST_EMAIL'] : '' );
	define( 'VCCARD_FROM_EMAIL', isset($_SERVER['VCCARD_FROM_EMAIL']) ? $_SERVER['VCCARD_FROM_EMAIL'] : '' );
