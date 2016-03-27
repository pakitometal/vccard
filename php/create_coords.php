<?php

// TO-DO: web form instead of CLI script

$GLOBALS['tables']['coords'] = [
	'_pos_' => 'INTEGER',
	'val'   => 'INTEGER DEFAULT 0'
];

include_once('includes/inc.sqlite3.php');
include_once('config/conf.consts.php');

echo 'DB encryption password: ';
$password = array_shift(fscanf(STDIN, '%s'));

if ( !($csv = fopen('coords.csv', 'r')) ) {
	echo "\nERROR\n";
	die;
}

$coords_db = sqlite3_open(DB_FILE, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $password);
$params = [
	'db'         => $coords_db,
	'db.encrypt' => [ 'val' => 1 ]
];
while ($row = fgetcsv($csv)) {
	$r = sqlite3_insertIntoTable2('coords', [ '_pos_' => (string)$row[0], 'val' => (string)$row[1] ], $params);
}
