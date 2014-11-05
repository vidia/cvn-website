<?php session_start();
include("../assets/includes/db.php");
include("../assets/includes/verify.php");
include("../assets/includes/verify-uc.php");


// grab variables from query string
$action = $_GET["action"]; // not needed now, created for expansion of function
$user = $_GET["user"];
$id = $_GET["ID"];


$SQL = "SELECT * FROM Defaults WHERE UserID=" . $user . " AND DefaultID=" . $id . ";";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);
$deletedBy = $_SESSION["UID"];

if(!empty($row))
{
	$SQL2 = "UPDATE Defaults SET Archived=1, DeletedBy=" . $deletedBy . " WHERE UserID=" . $user . " AND DefaultID=" . $id . ";";
	mysql_query($SQL2);
	$_SESSION['success'] = "You have removed the default.";
	header("Location: /edit-user.php?ID=" . $user);
}
else
{
	$_SESSION['error'] = "You did not supply a proper username or default identification number. Please go back and try again.";
	header("Location: /edit-user.php?ID=" . $user);
}



?>