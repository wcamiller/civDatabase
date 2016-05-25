
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

$query = "SELECT civ.name, abil.descrip FROM civ_civs civ
					INNER JOIN civ_unique_abilities abil ON abil.civ_id = civ.id
					WHERE civ.name LIKE '%$searchString%' ORDER BY name";


if ($result = $mysqli->query($query)) {
	while($row = $result->fetch_assoc()) {
		$rows[] = $row;
	}
}


print json_encode($rows);

?>