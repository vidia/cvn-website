<?php session_start();
$hostname = 'mydb.ics.purdue.edu';
$username = 'cvn';
$password = 'stag3d00r';
$dbname = 'cvn';
mysql_connect($hostname, $username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/rae_constants.php");

print_r($_GET);
echo "<br /><br />";

$eventID = $_GET['eventID'];
/*$userArray = array();
$cutArray = array();
$requestedArray = array();
$finishedArray = array();

// grab from cut first
$query = "SELECT U.ID as ID, U.LastName as LastName, U.AcctType as AcctType, U.FirstName as FirstName, U.Email as Email FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
if (!empty($num_rows)) {
	while($row = mysql_fetch_array($result)) {
		array_push($cutArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'PointTotal'=>calculatePointTotal($row['ID'])));
		array_push($userArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'PointTotal'=>calculatePointTotal($row['ID'])));
	}	
}

// grab from requested second
$query = "SELECT U.ID as ID, U.LastName as LastName,  U.AcctType as AcctType, U.FirstName as FirstName, U.Email as Email FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND U.ID=A.UserID AND A.RequestStatus='Requested'";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
	array_push($requestedArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'PointTotal'=>calculatePointTotal($row['ID'])));
	array_push($userArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'PointTotal'=>calculatePointTotal($row['ID'])));
}
*/

/******************************
 * GRAB HOW MANY STUDENTS WERE REQUESTED
 ******************************/


//	$requestCount = count($userArray);
$numberWanted = $_GET['number-pull'];

pullAttendance($numberWanted, $eventID, 0, 0);

/*	
//	$cutArray = subval_sort($cutArray, 'PointTotal'); 
//	$requestedArray = subval_sort($requestedArray, 'PointTotal'); 
	$cutArray = array_orderby($cutArray, 'PointTotal', SORT_DESC);
	$requestedArray = array_orderby($requestedArray, 'PointTotal', SORT_DESC);
	$finishedArray = array_merge((array)$cutArray, (array)$requestedArray);
//	print_r($finishedArray);
	
	
	//echo $requestCount;
	if ($requestCount < $numberWanted) {
		$numberWanted = $requestCount;
	}
*/
//if ($requestCount == 0) {
/*		//echo "ERROR";
		$_SESSION['attendance-error'] = "There are no current usher requests for that show.";
		header("Location: attendance-admin.php");*/
/*	} 
	else {
		
		for($i=0; $i<$numberWanted; $i++) {
			echo "SELECTED: " .$finishedArray[$i]['PointTotal'] . " | ". $finishedArray[$i]['AcctType']. " ".$finishedArray[$i]['LastName']. ", ". $finishedArray[$i]['FirstName']. ", " . $finishedArray[$i]['ID']. "<br />";
*/
/*	$SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
        sendEmail($finishedArray[$i]['ID'], $eventID, 'confirmation-email');
        mysql_query($SQL);*/
/*	}

    for($i=$numberWanted; $i<$requestCount; $i++) {
        echo "CUT: " .$finishedArray[$i]['PointTotal'] . " | ". $finishedArray[$i]['AcctType']. " ".$finishedArray[$i]['LastName']. ", ". $finishedArray[$i]['FirstName']. ", " . $finishedArray[$i]['ID'].  "<br />";
*/
/*	$SQL = "UPDATE Attendance SET RequestStatus='Cut' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
        sendEmail($finishedArray[$i]['ID'], $eventID, 'cut-email');
        mysql_query($SQL);*/
/*	}*/


/*
    USHER COORDINATORS GET A SPOT ON THE SHOW NO MATTER WHAT
*/

/*for($i=0; $i<$requestCount; $i++)
    {
        if($finishedArray[$i]['AcctType'] == "UC")
        {
        //	echo "UC: " . $finishedArray[$i]['LastName']. " " . $finishedArray[$i]['ID']. " | ".$finishedArray[$i]['PointTotal'] . "<br /><br />";
            $SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
            sendEmail($finishedArray[$i]['ID'], $eventID, 'confirmation-email');
            mysql_query($SQL);
            // Change UC to Ushering and then remove them from the Array
            // After deleting, subtract 1 wanted for each loop
            unset($finishedArray[$i]);
        }
    }

*/
/*	
		$_SESSION['attendance-message'] = "The attendance has been successfully pulled and the ushers have been notified.";
		header("Location: attendance-admin.php");

*/
//	}

?>