
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$searchString = $_GET['query'];


$rows = array();

$query = sprintf("SELECT * FROM civ_civs WHERE civ_civs.name LIKE '%%%s%%' ORDER BY name", $searchString);


if ($result = $mysqli->query($query)) {
	while($row = $result->fetch_assoc()) {
		$rows[] = $row;
	}
}

print json_encode($rows);

?>