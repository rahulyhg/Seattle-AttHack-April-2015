<?php
function getDB() {
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="root";
	$dbname="gladiator_db";
	$dbport="8889";
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname;port=$dbport", $dbuser, $dbpass);	
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}
?>