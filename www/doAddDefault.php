<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");

$reason = $_POST["reason"];
$UserID = $_POST["user"];
$CurrentUser = $_SESSION['UID'];

//grab the current season
$SQL = "SELECT SeasonID FROM Season WHERE Current=1;";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);
$seasonID = $row["SeasonID"];

//grab UserID


if($reason != "Select a Reason")
{
	$SQL2 = "INSERT INTO Defaults (UserID, ReportedBy, Reason, SeasonID, Archived) VALUES (" . $UserID . ", " . $CurrentUser . ", '" . $reason . "', " . $seasonID . ", 0);";
	mysql_query($SQL2);
	$_SESSION['success'] = "You have successfully reported the UC for <strong>" . $reason . "</strong>.";
	header("Location: edit-user.php?ID=" . $UserID);
}
else
{
	$_SESSION['error'] = "Please select a reason for the UC's default.";
	header("Location: edit-user.php?ID=" . $UserID);
}



?>

