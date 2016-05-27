
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_GET['query'];


$basicInfoRows = array();
$buildingInfoRows = array();
$unitInfoRows = array();
$abilityInfoRows = array();

$json_array = array();

$basicInfo = "SELECT civ.name, civ.leader FROM civ_civs civ
							WHERE civ.name = '$civName'";

$abilityInfo = "SELECT abil.descrip FROM civ_unique_abilities abil
								INNER JOIN civ_civs civ ON abil.civ_id = civ.id
								WHERE civ.name = '$civName'";

$buildingInfo = "SELECT build.name, build.replaces, abil.descrip FROM civ_unique_buildings build
								 INNER JOIN civ_civs civ ON civ.id = build.civ_id
								 INNER JOIN civ_unique_abilities abil ON abil.building_id = build.id
								 WHERE civ.name = '$civName'";

$unitInfo =  "SELECT unit.name, unit.combat_strength, unit.ranged_strength, unit.movement, unit.replaces, unit.descrip FROM civ_unique_units unit
							INNER JOIN civ_civs civ ON civ.id = unit.civ_id WHERE civ.name = '$civName'";

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

array_push($json_array, $basicInfoRows, $abilityInfoRows, $buildingInfoRows, $unitInfoRows);

print json_encode($json_array);

?>