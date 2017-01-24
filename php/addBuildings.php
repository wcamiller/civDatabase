
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "[username]", "[password]", "[db]");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}



$civName = $_POST['dropDown2'];
global $buildingId1;

$buildingName1 = $_POST['buildingName1'];
$replacesBuilding1 = (empty($_POST['replacesBuilding1'])) ? NULL : $_POST['replacesBuilding1'];
$buildingAbility1 = (empty($_POST['buildingAbility1'])) ? NULL : $_POST['buildingAbility1'];
$buildingAbilityType1 = $_POST['civAbilityType3'];
$buildingAbilityType2 = $_POST['civAbilityType4'];


$rows = array();
$json_array = array();

$building1Added = "Building successfully added (" . $buildingName1 . ").";
$uniqueAbilityAdded = "Unique building ability successfully added.";
$uniqueAbilityTypeAdded = "Unique building ability type succesfully stored.";

$civIdQuery = sprintf("SELECT id FROM civ_civs WHERE civ_civs.name='%s'", $civName);


if ($civIdResult = $mysqli->query($civIdQuery)) {
	if ($civIdRow = $civIdResult->fetch_assoc()) {
		$civId = $civIdRow["id"];
	}
} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
}

$addBuilding1Query = sprintf("INSERT INTO civ_unique_buildings (civ_id, name, replaces) VALUES (%d, '%s', '%s')
								  						ON DUPLICATE KEY UPDATE name='%s', replaces='%s'", 
								  						$civId, $buildingName1, $replacesBuilding1, $buildingName1, $replacesBuilding1);


$buildingIDquery = sprintf("SELECT id FROM civ_unique_buildings WHERE civ_unique_buildings.name = '%s'", $buildingName1);

if ($buildingName1) {
	if ($mysqli->query($addBuilding1Query)) {
		array_push($json_array, '{"success":' . '"' . $building1Added . '"}');
		if ($buildingIdQueryResult = $mysqli->query($buildingIDquery)) {
			if ($buildingIdRow = $buildingIdQueryResult->fetch_assoc()) {
				$buildingId1 = $buildingIdRow["id"];
				$insertAbilityQuery1 = sprintf("INSERT INTO civ_unique_abilities (building_id, descrip) VALUES (%d, 
															  '%s') ON DUPLICATE KEY UPDATE descrip='%s'", $buildingId1, $buildingAbility1, $buildingAbility1);
				if ($abilSuccess1 = $mysqli->query($insertAbilityQuery1)) {
					array_push($json_array, '{"success":' . '"' . $uniqueAbilityAdded . '"}');
				} else {
					array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');	
				}
			}
		}
	} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
}

	
$insertAbilityTypeQuery1 = sprintf("INSERT INTO civ_abil_to_type (ability_id, type_id) VALUES
													 ((SELECT abils.id FROM civ_unique_abilities abils WHERE
													 abils.building_id = %d), (SELECT type.id FROM civ_ability_types type WHERE
													 type.name = '%s')) ON DUPLICATE KEY UPDATE
													 type_id=(SELECT type.id FROM civ_ability_types type WHERE 
													 type.name='%s')", $buildingId1, $buildingAbilityType1, $buildingAbilityType1);

$insertAbilityTypeQuery2 = sprintf("INSERT INTO civ_abil_to_type (ability_id, type_id) VALUES
													 ((SELECT abils.id FROM civ_unique_abilities abils WHERE
													 abils.building_id = %d), (SELECT type.id FROM civ_ability_types type WHERE
													 type.name = '%s')) ON DUPLICATE KEY UPDATE
													 type_id=(SELECT type.id FROM civ_ability_types type WHERE 
													 type.name='%s')", $buildingId1, $buildingAbilityType2, $buildingAbilityType2);




if ($abilSuccess1) {
	if ($mysqli->query($insertAbilityTypeQuery1)) {
		array_push($json_array, '{"success":' . '"' . $uniqueAbilityTypeAdded . '"}');
	} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
}

if ($abilSuccess1 && $buildingAbilityType2) {
	if ($mysqli->query($insertAbilityTypeQuery2)) {
			array_push($json_array, '{"success":' . '"' . $uniqueAbilityTypeAdded . '"}');
		} else {
			array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
		}
}


print json_encode($json_array);

?>
