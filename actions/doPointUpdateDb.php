<?php session_start(); 
include_once("../assets/includes/constants.php");
include_once("../assets/includes/db.php");
include("../assets/includes/verify-admin.php");

if($_SESSION["AccountType"] == "ADMIN") {

	$SQL2 = "SELECT ID FROM User";
	$result2 = mysql_query($SQL2);
	while($row2 = mysql_fetch_array($result2)) {
		calculatePointTotalDB($row2['ID']);
	}
	$_SESSION["success"] = "Scores have been updated to match new point scheme."; 
}
else {
	$_SESSION["error"] = "You must be an admin to update the scores in this way."; 
}

header("Location: /site-admin.php");

?>
