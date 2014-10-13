<?php session_start(); 
include_once("assets/includes/db.php");
include("assets/includes/verify.php");

$eventid = $_GET['id'];
$requestDate = date("Y-m-d H:i:s");

// Grab the Event Requested using ID - specifically the no-register column
	$SQL = "SELECT  NoRegister FROM Event WHERE ID = " . $eventid ;
	$result = mysql_query($SQL);
	$row = mysql_fetch_array($result);

// check the attendance table to see if user (session[UID]) is requested, ushing, waitlist, etc. for that show 

	$SQL2 = "SELECT EventID FROM Attendance WHERE UserID ='" . $_SESSION["UID"] . "' AND EventID = '" . $row["NoRegister"] . "'";
	$result2 = mysql_query($SQL2);
	$row2 = mysql_fetch_array($result2);

	// if eventID is blank then okay and register 

	if(empty($row2["EventID"]))
	{
		$SQL = "INSERT INTO Attendance (ID, UserID, EventID, RequestStatus, RequestDate) VALUES (null, '".$_SESSION['UID']."', '".$eventid."', 'Requested', '".$requestDate."')";
		mysql_query($SQL);
		$_SESSION['success'] = "Your request has been received and you will be notified if you are selected to usher. Thanks!";
		header("Location: dashboard.php");
	}
	else
	// if there is a return then send an error saying they signed up the show they weren't supposed to
	{
		// grab the name of the event that they couldn't register for because we are nice and care about user experience
		$SQL = "SELECT Name FROM Event WHERE ID = " . $row2["EventID"] ;
		$result = mysql_query($SQL);
		$row3 = mysql_fetch_array($result);

		$_SESSION["error"] = "Unfortunately, you cannot request to usher this show and <strong>" . $row3["Name"] . "</strong>, which you have already requested. You can either remove your request from " . $row3["Name"] . " or request another show. If you believe you have come across this in error, please let Kate or your Executive Board know.";
		header("Location: dashboard.php");
	}




?>