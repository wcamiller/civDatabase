
<?php

//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "[username]", "[password]", "[db]");

if ($mysqli->connect_errno) {
	print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civNameUnits = $_GET['dropDown1'];

$rowsUnits = array();

$unitsQuery = sprintf("SELECT units.name, units.combat_strength, units.ranged_strength, units.movement, units.descrip, units.replaces FROM civ_unique_units units
							 INNER JOIN civ_civs civs ON civs.id = units.civ_id WHERE civs.name = '%s'", $civNameUnits);

if ($unitsResult = $mysqli->query($unitsQuery)) {
	while ($unitsRow = $unitsResult->fetch_assoc()) {
		$rowsUnits[] = $unitsRow;		
	}
}

print json_encode($rowsUnits);


?>
