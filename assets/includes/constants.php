<?php

$attendanceArray = array("Requested", "Present", "Cancelled", "Cut", "No-Show", "Dress-Violation", "Late", "Tardy", "Late-Add-Cancel");

function calculateActivity($UID) {
	$points = array();

	$SQL = "SELECT * FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='". $UID ."' AND E.ID=A.EventID AND E.Archive<>1 AND S.Current = 1 ORDER BY E.CallTime ASC";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {

		if($row['RequestStatus'] == 'Present') {
			if($row['Type'] == 'Meeting') {
				$points['Meeting']++;
			}
			else {
				$points['Present'] += $row['Point'];
			}
		} else {
			$points[$row['RequestStatus']]++;
		}

	} // end while
	//$CurrentPoints = $ushered + $cut + $skipped + $cancelled + $meetings + $dress + $late + $requested;

	return $points;
} // end function

function calculatePoints($UID)
{
	$sqlYears = "SELECT YearsInvolved FROM User WHERE ID='" . $UID . "';";
	$result2 = mysql_query($sqlYears);
	$row2 = mysql_fetch_array($result2);
	$years = $row2["YearsInvolved"];

	$totals = array();
	$totals['Years'] = $years;

	foreach(calculateActivity($UID) as $pointtype => $points)
	{
		switch ($pointtype)
		{
			case 'Cut':
			case 'Late-Add-Cancel':
				$totals[$pointtype] = $points*15;
				break;

			case 'Present':
				$totals[$pointtype] = $points*1;
				break;

			case 'Dress-Violation':
			case 'Tardy':
				$totals[$pointtype] = $points*-5;
				break;

			case 'Meeting':
				$totals[$pointtype] = $points*7;
				break;

			case 'Cancelled':
			case 'Late':
				$totals[$pointtype] = $points*-15;
				break;

			case 'No-Show':
				$totals[$pointtype] = $points*-45;
				break;
		}
	}
	return $totals;
}


// NOT USED in the files below because they require granular showing of information
// THIS IS NOT USED IN my-account.php
// THIS IS NOT USED IN edit-user.php
function calculatePointTotal($UID)
{
	return array_sum(calculatePoints($UID));
} // end function


/*##########################################################################################################
############################################################################################################
############################################################################################################
############################################################################################################
############################################################################################################

	POINT TOTAL CHANGE AS OF 08/03/2014
		* Points only count for one semester (season)
		* Previous season's points are divided by 10 and rounded up
		* User's previous years involved are then added
		* User's current season's points are then added

		* Now points are calculated during Attendance Pull (and admin functions) and then saved to DB
		* Points are pulled from DB and are no longer calculated on the fly

		* Deprecated functions include
			* calculatePointTotal() (delete after stable release)

############################################################################################################
############################################################################################################
############################################################################################################
############################################################################################################
##########################################################################################################*/

function calculatePreviousActivity($UID, $SeasonID) {
	$points = array();

	$SQL = "SELECT * FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='". $UID ."' AND E.ID=A.EventID AND E.Archive<>1 AND S.SeasonID = " . $SeasonID . " ORDER BY E.CallTime ASC";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {

		if($row['RequestStatus'] == 'Present') {
			if($row['Type'] == 'Meeting') {
				$points['Meeting']++;
			}
			else {
				$points['Present'] += $row['Point'];
			}
		} else {
			$points[$row['RequestStatus']]++;
		}

	} // end while
	//$CurrentPoints = $ushered + $cut + $skipped + $cancelled + $meetings + $dress + $late + $requested;
	return $points;
} // end function


function calculatePreviousPoints($UID, $SeasonID)
{
	$totals = array();
	foreach(calculatePreviousActivity($UID, $SeasonID) as $pointtype => $points)
	{
		switch ($pointtype)
		{
			case 'Cut':
			case 'Late-Add-Cancel':
				$totals[$pointtype] = $points*15;
				break;

			case 'Present':
				$totals[$pointtype] = $points*1;
				break;

			case 'Dress-Violation':
			case 'Tardy':
				$totals[$pointtype] = $points*5;
				break;

			case 'Meeting':
				$totals[$pointtype] = $points*3;
				break;

			case 'Cancelled':
			case 'Late':
				$totals[$pointtype] = $points*-15;
				break;

			case 'No-Show':
				$totals[$pointtype] = $points*-45;
				break;
		}
	}
	return $totals;
}


function calculatePointTotalDB($UID)
{
	// get the current season from the DB
	$sql = "SELECT SeasonID FROM Season WHERE Current=1";
	$result = mysql_query($sql);
	$currentSeasonID = mysql_fetch_array($result);
	$previousSeasonID = $currentSeasonID["SeasonID"]-1;

	// Select and calculate the points from the PREVIOUS season
	$previousPoints = array_sum(calculatePreviousPoints($UID, $previousSeasonID));
	// Starting August 2014, previous semester's points will be divided by 10
	// and rounded up and added to previous years
	$previousPoints = round($previousPoints/10);
	// includes points from years involved & current season events
	$currentPoints = array_sum(calculatePoints($UID));
	// add previous and current points to get total points
	$totalPoints = $previousPoints + $currentPoints;

	// now, we're storing this in the DB so we don't calculate on the fly anymore
	$sql = "UPDATE User SET Points=" . $totalPoints . ", datePointsUpdated='" . date("Y-m-d H:i:s") . "' WHERE ID=" . $UID . " LIMIT 1";
	mysql_query($sql) or die(mysql_error());
	return $totalPoints;
} // end function

function getPoints($UID) {
	$sql = "SELECT Points FROM User WHERE ID=" . $UID;
	$result = mysql_query($sql);
	$user = mysql_fetch_array($result);
	return $user["Points"];
}




function subval_sort($a,$subkey)
{
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $k=>$v) {
		$c[] = $a[$k];
	}
	return $c;
}


function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

function sendEmail($UID, $EID, $EmailID) {

	$SQL = "SELECT * FROM User WHERE ID='".$UID."'";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {
		$UsherName = $row['FirstName']." ".$row['LastName'];
		$UsherEmail = $row['Email'];
	}

	$SQL = "SELECT * FROM Event WHERE ID='".$EID."'";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {
		$EventName = $row['Name'];
		$EventLocation = $row['Location'];
		$EventDate = date("l, F d, Y", strtotime($row['CallTime']));
		$EventTime = date("g:i a", strtotime($row['CallTime']));
		$EventUC = $row['UC'];
		$specialInstr = $row['SpecialInstr'];
		$meetingLoc = $row['MeetingLoc'];
	}



	$SQL = "SELECT * FROM User WHERE Email='".$EventUC."'";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {
		$eventUCName = $row['FirstName']." ".$row['LastName'];
	}

	$SQL = "SELECT * FROM Email WHERE Email_Name='".$EmailID."'";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {
		$EmailSubject = $row['Email_Subject'];
		$EmailBody = $row['Email_Body'];
	}

	//echo $EmailSubject."<br>";
	//echo $EmailBody."<br>";

	//calculate points for each person
	$points = calculatePointTotal($UID);

	$placeholders = array('{{usher name}}', '{{usher email}}', '{{event name}}', '{{event time}}', '{{event place}}', '{{event date}}', '{{event uc}}', '{{Points}}','{{special instr}}','{{event uc name}}','{{meeting loc}}');
	$actualValues = array($UsherName, $UsherEmail, $EventName, $EventTime, $EventLocation, $EventDate, $EventUC, $points, $specialInstr, $eventUCName,$meetingLoc);

	$EmailSubject = str_replace($placeholders, $actualValues, $EmailSubject);
	$EmailBody = str_replace($placeholders, $actualValues, $EmailBody);
	//echo $EmailSubject."<br>";
	//echo $EmailBody."<br>";

	$headers = "Reply-To: cvn@purdue.edu\r\n";
//		"Content-type: text/html\r\n";

	$mailSuccess = mail($UsherEmail, $EmailSubject, $EmailBody, $headers);


}

function pullAttendance($numpull, $eventID, $replacement, $twoday)
{
	$userArray = array();
	$cutArray = array();
	$requestedArray = array();
	$finishedArray = array();
	$body = "";

	// grab from cut first
	$query = "SELECT U.ID as ID, U.LastName as LastName, U.AcctType as AcctType, U.FirstName as FirstName, U.Email as Email, A.RequestStatus as RequestStatus FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if (!empty($num_rows)) {
		while($row = mysql_fetch_array($result)) {
			array_push($cutArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>getPoints($row['ID'])));
			array_push($userArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>getPoints($row['ID'])));
		}
	}

	// grab from requested second
	$query = "SELECT U.ID as ID, U.LastName as LastName,  U.AcctType as AcctType, U.FirstName as FirstName, U.Email as Email, A.RequestStatus as RequestStatus FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND U.ID=A.UserID AND A.RequestStatus='Requested'";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if (!empty($num_rows)) {
	while($row = mysql_fetch_array($result)) {
		array_push($requestedArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>getPoints($row['ID'])));
		array_push($userArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>getPoints($row['ID'])));
	}
	}

	/******************************
		GRAB HOW MANY STUDENTS WERE REQUESTED
	******************************/


	$requestCount = count($userArray);
	$numberWanted = $numpull;

	$cutArray = array_orderby($cutArray, 'PointTotal', SORT_DESC);
	$requestedArray = array_orderby($requestedArray, 'PointTotal', SORT_DESC);
	$finishedArray = array_merge((array)$cutArray, (array)$requestedArray);
//	print_r($finishedArray);


	//echo $requestCount;
	if ($requestCount < $numberWanted) {
		$numberWanted = $requestCount;
	}

	if ($requestCount == 0) {
		$body .= "ERROR<br>";
/*		$_SESSION['attendance-error'] = "There are no current usher requests for that show.";
		header("Location: attendance-admin.php");
*/
	}
	else
	{

		for($i=0; $i<$numberWanted; $i++) {
			$body .= "SELECTED: [" .$finishedArray[$i]['PointTotal'] . "] | ". $finishedArray[$i]['AcctType']. " ".$finishedArray[$i]['LastName']. ", ". $finishedArray[$i]['FirstName']. ", " . $finishedArray[$i]['ID']. "<hr />";
			/*if ($twoday == 1)
			{*/
				$SQL = "UPDATE Attendance SET RequestStatus='Ushering', RequestDate='".date("Y-m-d H:i:s")."' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
			/*} else {
				$SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
			}*/
			if ($replacement==1)
			{
				if ($twoday==1) {
					sendEmail($finishedArray[$i]['ID'], $eventID, 'two-day-replacement-email');
				} else {
					sendEmail($finishedArray[$i]['ID'], $eventID, 'replacement-email');
				}
			}
			else{
				sendEmail($finishedArray[$i]['ID'], $eventID, 'confirmation-email');
			}
			mysql_query($SQL);
		}

		for($i=$numberWanted; $i<$requestCount; $i++) {
			if ($replacement!=1) //comment this line to move late requests to cut list
			{	//comment this line to move late requests to cut list
				$body .= "CUT: [" .$finishedArray[$i]['PointTotal'] . "] | ". $finishedArray[$i]['AcctType']. " ".$finishedArray[$i]['LastName']. ", ". $finishedArray[$i]['FirstName']. ", " . $finishedArray[$i]['ID'].  "<hr />";
				$SQL = "UPDATE Attendance SET RequestStatus='Cut' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
				if($finishedArray[$i]['RequestStatus']!='Cut')
				{
					sendEmail($finishedArray[$i]['ID'], $eventID, 'cut-email');
				} else {$body .= "Already cut. <br>";}
				mysql_query($SQL);
			} //comment this line to move late requests to cut list
		}


		/*
			USHER COORDINATORS GET A SPOT ON THE SHOW NO MATTER WHAT
		*/

		for($i=0; $i<$requestCount; $i++)
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


//		$_SESSION['attendance-message'] = "The attendance has been successfully pulled and the ushers have been notified.";
//		header("Location: attendance-admin.php");
	}
	return $body;
}



?>
