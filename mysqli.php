<?php
/* SQL Details */
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'password');
define('DATABASE', 'short');

/* Create a new SQLi */
$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);

/* Check if exists */
function CheckShort($short, $mysqli)
	{
		$result = $mysqli->query("SELECT null FROM urls WHERE url_short = '" . $short . "' LIMIT 1");
		$row_cnt = $result->num_rows;
		return $row_cnt;
	}

function IsShortened($url, $mysqli)
	{
		$result = $mysqli->query("SELECT null FROM urls WHERE url = '" . $url . "' LIMIT 1");
		$row_cnt = $result->num_rows;
		return $row_cnt;
	}
	
function GrabAlreadyShortened($already, $mysqli)
	{
		$query = $result = $mysqli->query("SELECT url_short FROM urls WHERE url = '" . $already . "' LIMIT 1");
		$result = $query->fetch_assoc();
		return $result[url_short];
	}
	
function GrabUrl($already, $mysqli)
	{
		$query = $result = $mysqli->query("SELECT url FROM urls WHERE url_short = '" . $already . "' LIMIT 1");
		$result = $query->fetch_assoc();
		return $result[url];
	}
?>