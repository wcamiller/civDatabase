
<?php

//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "[username]", "[password]", "[db]");

if ($mysqli->connect_errno) {
	print "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_GET['dropDown3'];

$civRows = array();
$abilitiesRows = array();
$json_array = array();

$civQuery = sprintf("SELECT name, leader FROM civ_civs
						 WHERE civ_civs.name = '%s'", $civName);

$abilityQuery = sprintf("SELECT abils.descrip, types.name FROM civ_unique_abilities abils
								 INNER JOIN civ_abil_to_type att ON att.ability_id = abils.id
								 INNER JOIN civ_ability_types types ON types.id = att.type_id
								 INNER JOIN civ_civs civs ON civs.id = abils.civ_id
								 WHERE civs.name = '%s'", $civName);

if ($civName != 'Add New Civilization') {
	if ($civsResult = $mysqli->query($civQuery)) {
		while ($civRow = $civsResult->fetch_assoc()) {
			$civRows[] = $civRow;		
		}
	} else {
		print $mysqli->error;
	}
	if ($abilityResult = $mysqli->query($abilityQuery)) {
		while ($abilityRow = $abilityResult->fetch_assoc()) {
			$abilitiesRows[] = $abilityRow;		
		}
	} else {
		print $mysqli->error;
	}
}
array_push($json_array, $civRows, $abilitiesRows);
print json_encode($json_array);


?>
