
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "[username]", "[password]", "[db]");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_GET['query'];


$basicInfoRows = array();
$buildingInfoRows = array();
$unitInfoRows = array();
$abilityInfoRows = array();
$civAbilityTypeRows = array();
$buildingAbilityTypeRows = array();

$json_array = array();

$basicInfo = sprintf("SELECT civ.name, civ.leader FROM civ_civs civ
							WHERE civ.name = '%s'", $civName);

$abilityInfo = sprintf("SELECT abil.descrip FROM civ_unique_abilities abil
								INNER JOIN civ_civs civ ON abil.civ_id = civ.id
								WHERE civ.name = '%s'", $civName);

$buildingInfo = sprintf("SELECT build.name, build.replaces, abil.descrip FROM civ_unique_buildings build
								 INNER JOIN civ_civs civ ON civ.id = build.civ_id
								 INNER JOIN civ_unique_abilities abil ON abil.building_id = build.id
								 WHERE civ.name = '%s'", $civName);

$unitInfo =  sprintf("SELECT unit.name, unit.combat_strength, unit.ranged_strength, unit.movement, unit.replaces, unit.descrip FROM civ_unique_units unit
							INNER JOIN civ_civs civ ON civ.id = unit.civ_id WHERE civ.name = '%s'", $civName);

$abilityTypeInfoBuilding = sprintf("SELECT type.name FROM civ_ability_types type
											 			INNER JOIN civ_abil_to_type att ON att.type_id = type.id
											 			INNER JOIN civ_unique_abilities abil ON abil.id = att.ability_id
											 			INNER JOIN civ_unique_buildings build ON build.id = abil.building_id
											 			INNER JOIN civ_civs civ ON civ.id = build.civ_id WHERE civ.name = '%s'", $civName);

$abilityTypeInfoCiv = sprintf("SELECT type.name FROM civ_ability_types type
											 INNER JOIN civ_abil_to_type att ON att.type_id = type.id
											 INNER JOIN civ_unique_abilities abil ON abil.id = att.ability_id
											 INNER JOIN civ_civs civ ON civ.id = abil.civ_id WHERE civ.name = '%s'", $civName);



if ($basicInfoResult = $mysqli->query($basicInfo)) {
	while($basicInfoRow = $basicInfoResult->fetch_assoc()) {
		$basicInfoRows[] = $basicInfoRow;
	}
}

if ($abilityInfoResult = $mysqli->query($abilityInfo)) {
	while($abilityInfoRow = $abilityInfoResult->fetch_assoc()) {
		$abilityInfoRows[] = $abilityInfoRow;
	}
}

if ($buildingInfoResult = $mysqli->query($buildingInfo)) {
	while($buildingInfoRow = $buildingInfoResult->fetch_assoc()) {
		$buildingInfoRows[] = $buildingInfoRow;
	}
}

if ($unitInfoResult = $mysqli->query($unitInfo)) {
	while($unitInfoRow = $unitInfoResult->fetch_assoc()) {
		$unitInfoRows[] = $unitInfoRow;
	}
}

if ($buildingTypeResult = $mysqli->query($abilityTypeInfoBuilding)) {
	while($buildingTypeRow = $buildingTypeResult->fetch_assoc()) {
		$buildingAbilityTypeRows[] = $buildingTypeRow;
	}
}

if ($civTypeResult = $mysqli->query($abilityTypeInfoCiv)) {
	while($civTypeRow = $civTypeResult->fetch_assoc()) {
		$civAbilityTypeRows[] = $civTypeRow;
	}
}

array_push($json_array, $basicInfoRows, $abilityInfoRows, $buildingInfoRows, $unitInfoRows, $civAbilityTypeRows, $buildingAbilityTypeRows);

print json_encode($json_array);

?>
