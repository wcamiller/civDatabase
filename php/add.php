
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_POST['addCivName'];
$uniqueAbility = $_POST['addUniqueAbility'];
$civLeader = $_POST['addLeader'];

$addUnitName1 = $_POST['addUnit1'];
$addHP1 = $_POST['addHP1'];
$addMelee1 = $_POST['addMelee1'];
$addDefense1 = $_POST['addDefense1'];
$addSight1 = $_POST['addSight1'];
$addReplacesUnit1 = $_POST['addReplacesUnit1'];
$addUnit1 = $_POST['addUnit1'];
$addUnitName1 = $_POST['addUnit1'];

$addunitName2 = $_POST['addUnit2'];
$addHP2 = $_POST['addHP2'];
$addMelee2 = $_POST['addMelee2'];
$addDefense2 = $_POST['addDefense2'];
$addSight2 = $_POST['addSight2'];
$addReplacesUnit2 = $_POST['addReplacesUnit2'];
$addUnit2 = $_POST['addUnit2'];
$addUnitName2 = $_POST['addUnit2'];

$addBuildingName1 = $_POST['addBuildingName1'];
$addReplacesBuilding1 = $_POST['addReplacesBuilding1'];
$addBuildingDesc1 = $_POST['addBuildingDesc1'];

$addBuildingName2 = $_POST['addBuildingName2'];
$addReplacesBuilding2 = $_POST['addReplacesBuilding2'];
$addBuildingDesc2 = $_POST['addBuildingDesc2'];

$rows = array();

echo $civName;

if ($uniqueAbility) {
	$addCivQuery = "INSERT INTO civ_civs (name, leader) VALUES ($civName, $civLeader)";
}


// if ($result = $mysqli->query($query)) {
// 	while($row = $result->fetch_assoc()) {
// 		$rows[] = $row;
// 	}
// }


 //print json_encode($rows);

?>