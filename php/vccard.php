<?php

require_once('includes/inc.sqlite3.php');
include_once('config/conf.consts.php');

function response( $status ) {
	echo json_encode([ 'status' => (bool)$status ]);
	die;
}

// Parameter validation ('pos' between 1 and 50, 'loc' not empty)
if ( !(isset($_POST['pos']) && false !== preg_match('#^(50|[1-4]{1}[0-9]{1}|[1-9]{1})$#', $_POST['pos']) && isset($_POST['loc']) && $_POST['loc']) ) {
	response(false);
}

// Open connection with DB
if ( !$conn = sqlite3_open(VCCARD_DB_FILE, SQLITE3_OPEN_READONLY, $_POST['loc']) ) {
	response(false);
}

$params = [
	'db'         => $conn,
	'db.encrypt' => [ 'val' => 0 ],
	'indexBy'    => 'pos'
];
$result = sqlite3_getSingle('coords', 'pos='.$_POST['pos'], $params);
sqlite3_close($conn);
if ( !($result && $result['val']) ) {
	response(false);
}

// Send value via email
$to_mail   = isset( $_SERVER['VCCARD_DEST_MAIL'] ) ? $_SERVER['VCCARD_DEST_MAIL'] : VCCARD_DEST_MAIL;
$from_mail = isset( $_SERVER['VCCARD_DEST_MAIL'] ) ? $_SERVER['VCCARD_FROM_MAIL'] : VCCARD_FROM_MAIL;

$subject = 'Answer ('.date('Ymd H:i:s').')';
$message = $result['val'];
$headers_array = [
	'From:'.$from_mail,
	'X-Mailer:PHP/'.phpversion()
];
$headers = implode("\r\n", $headers_array);
response(mail($to_mail, $subject, $message, $headers));
