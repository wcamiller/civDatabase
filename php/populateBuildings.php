
<?php

//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "[username]", "[password]", "[db]");

if ($mysqli->connect_errno) {
	print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civNameBuildings = $_GET['dropDown2'];

$buildingsRows = array();
$abilitiesRows = array();
$typeRows = array();
$json_array = array();

$buildingsQuery = sprintf("SELECT buildings.name, buildings.replaces FROM civ_unique_buildings buildings
							 		 INNER JOIN civ_civs civs ON civs.id = buildings.civ_id WHERE civs.name = '%s'", $civNameBuildings);

$uniqueAbilitiesQuery = sprintf("SELECT abils.descrip FROM civ_unique_abilities abils
												 INNER JOIN civ_unique_buildings buildings ON buildings.id = abils.building_id
												 INNER JOIN civ_civs civs ON civs.id = buildings.civ_id WHERE civs.name = '%s'", $civNameBuildings);

$abilityTypeQuery = sprintf("SELECT types.name FROM civ_ability_types types
										 INNER JOIN civ_abil_to_type att ON att.type_id = types.id
										 INNER JOIN civ_unique_abilities abils ON abils.id = att.ability_id
										 INNER JOIN civ_unique_buildings buildings ON buildings.id = abils.building_id
										 INNER JOIN civ_civs civs ON civs.id = buildings.civ_id
										 WHERE civs.name = '%s'", $civNameBuildings);

if ($buildingsResult = $mysqli->query($buildingsQuery)) {
	while ($buildingsRow = $buildingsResult->fetch_assoc()) {
		$buildingsRows[] = $buildingsRow;
	}
}

if ($abilitiesResult = $mysqli->query($uniqueAbilitiesQuery)) {
	while ($abilityRow = $abilitiesResult->fetch_assoc()) {
		$abilitiesRows[] = $abilityRow;
	}
}

if ($typeResult = $mysqli->query($abilityTypeQuery)) {
	while ($typeRow = $typeResult->fetch_assoc()) {
		$typeRows[] = $typeRow;
	}
}

array_push($json_array, $buildingsRows, $abilitiesRows, $typeRows);

print json_encode($json_array);




