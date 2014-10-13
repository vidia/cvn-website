<?php
session_start();
include("assets/includes/db.php");
include("assets/includes/constants.php");

$Username = str_replace("'", " ", $_POST['username']);
$Password = str_replace("'", " ", $_POST['password']);
$Password = md5($Password);

$query = "SELECT * FROM User WHERE Username='".$Username."' AND Password='".$Password."'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);



if($num_rows>0) {

	$_SESSION['Login'] = $Username;
	while($row = mysql_fetch_array($result)){

		$_SESSION['Name'] = $row['FirstName']." ".$row['LastName'];
		$_SESSION['FirstName'] = $row['FirstName'];
		$_SESSION['LastName'] = $row['LastName'];
		$_SESSION['AccountType'] = $row['AcctType'];
		$_SESSION['LastLogin'] = $row['LastLogin'];
		$_SESSION['UID'] = $row['ID'];
		$created = $row['Created'];
	}

	/******
	******* DEVELPOMENT LOGIN ONLY - MAINTENANCE MODE ENABLE
	*/

	$sql = "SELECT * FROM Settings WHERE intSettingsID=1";
	$result = mysql_query($sql);
	$settings = mysql_fetch_array($result);

	if($settings["isMaintenance"]) {
		if($_SESSION["AccountType"] != "ADMIN")
		{
			$_SESSION['error'] = "Sorry, this site is currently in maintenance mode and logging in is disabled. If you think that this is in error, please contact <a href='mailto:kenny@digital-inflection.com'>the webmaster</a>.";
			session_destroy();
			header("Location: login.php?r=mm");
			die();
		}
	}

	/******
	******* DEVELPOMENT LOGIN ONLY END
	*******/


	$newLastLogin = date("Y-m-d H:i:s");

	// YearsInvolved
	// Grabs how many years they've been involved, multiplies years by two (because of semesters)
	// If user was registered in January or February(beginning of semester) of the same year,
	// then add a year (because of Spring semester)
	function getYear($plainDate) {
		$year = substr($plainDate, 0, 4);
		return $year;
	}
	function getMonth($plainDate) {
		$year = substr($plainDate, 5, 2);
		return $year;
	}

	$currentDate = getYear($newLastLogin);
	$registerDate = getYear($created);
	$yearsInvolved = $currentDate - $registerDate;
	$month = getMonth($created);
	$total = 0;
	$total = $yearsInvolved*2;

	if(($month == 01 || $month == 02) && getMonth(date("Y-m-d H:i:s")) > 05) {
			$total++;
	}

	// END YEARS INVOLVED

	$convertedPoints = calculatePointTotalDB($_SESSION['UID']);


	// query
	$query="UPDATE User SET LastLogin='".$newLastLogin."', YearsInvolved='" . $total . "', Points=" . $convertedPoints . " WHERE Username= '".$_SESSION['Login']."'";
	$result=mysql_query($query);
	$_SESSION['Points'] = $convertedPoints;
	$_SESSION['error'] = "";

	//updated 3/6/2012 because of change in colleges in profile
	//check to see if they have a college selected
	// if not, direct them to profile

	$query = "SELECT * FROM User WHERE Username='".$Username."' AND Password='".$Password."'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if($row["College"] == "Other" || $row["College"] == "College of Consumer and Family Sciences" || $row["College"] == "College of Pharmacy, Nursing, and Health Sciences" || $row["College"] == "Not Selected")
	{
		header("Location: my-account.php?college=" . $row["College"] . "&status=old");
	}

	header("Location: dashboard.php");
} else {
	//echo "not valid";
	$_SESSION['Username'] = $Username;
	$_SESSION['Login'] = "";
	$_SESSION['error'] = "Your password and username did not match, please try again.";
	header("Location: login.php");
}

?>