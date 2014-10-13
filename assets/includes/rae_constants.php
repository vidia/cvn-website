<?php


function calculatePointTotal($UID) {

// THIS IS NOT USED IN my-account.php!!!!
// THIS IS NOT USED IN export-points.php!!!!

	$SQL = "SELECT * FROM User WHERE ID='".$UID."'";
	$result = mysql_query($SQL);
	$ushered = 0;
	$cut = 0;
	$skipped = 0;
	$cancelled = 0;
	$meetings = 0;
	$SQL = "SELECT * FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='". $UID ."' AND E.ID=A.EventID AND E.Archive<>1 AND S.Current = 1 ORDER BY E.CallTime ASC";
	$sqlYears = "SELECT YearsInvolved FROM User WHERE ID='" . $UID . "';";
	$result2 = mysql_query($sqlYears);
	$row2 = mysql_fetch_array($result2);
	$years = $row2["YearsInvolved"];
	
		
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {
		
		if($row['Type'] == 'Meeting' && $row['RequestStatus'] == 'Present') { 
			$meetings++;	
		} else {
			if($row['RequestStatus'] == 'Present') {
				$ushered++;
			} elseif($row['RequestStatus'] == 'Cut') {
				$cut++;
			} elseif($row['RequestStatus'] == 'No-Show') {
				$skipped++;
			} elseif($row['RequestStatus'] == 'Cancelled') {
				$cancelled++;
			}elseif($row['RequestStatus'] == 'Dress-Violation') {
				$dress++;
			}elseif($row['RequestStatus'] == 'Late') {
				$late++;
			}
		} // end if
		
	} // end while
	$CurrentPoints = (1 * $ushered) + (1.5 * $cut) - (4.5 * $skipped) - (1.5 * $cancelled) + (.3 * $meetings) + (.1 * $years) - (1.5 * $dress) + (0 * $late);
	$CurrentPoints *= 10;
	

		return $CurrentPoints;
} // end function



function subval_sort($a,$subkey) {
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

	$placeholders = array('{{usher name}}', '{{usher email}}', '{{event name}}', '{{event time}}', '{{event place}}', '{{event date}}', '{{event uc}}', '{{Points}}');
	$actualValues = array($UsherName, $UsherEmail, $EventName, $EventTime, $EventLocation, $EventDate, $EventUC, $points);
	
	$EmailSubject = str_replace($placeholders, $actualValues, $EmailSubject);
	$EmailBody = str_replace($placeholders, $actualValues, $EmailBody);
	//echo $EmailSubject."<br>";
	//echo $EmailBody."<br>";	
	
	
	//$headers = "Content-type: text/html\r\n";
	mail($UsherEmail, $EmailSubject, $EmailBody, $headers);
}

function pullAttendance($numpull, $eventID, $replacement, $twoday) {
$userArray = array();
$cutArray = array();
$requestedArray = array();
$finishedArray = array();

// grab from cut first
$query = "SELECT U.ID as ID, U.LastName as LastName, U.AcctType as AcctType, U.FirstName as FirstName, U.Email as Email, A.RequestStatus as RequestStatus FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
if (!empty($num_rows)) {
	while($row = mysql_fetch_array($result)) {
		array_push($cutArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>calculatePointTotal($row['ID'])));
		array_push($userArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>calculatePointTotal($row['ID'])));
	}	
}

// grab from requested second
$query = "SELECT U.ID as ID, U.LastName as LastName,  U.AcctType as AcctType, U.FirstName as FirstName, U.Email as Email, A.RequestStatus as RequestStatus FROM Attendance A, User U WHERE A.EventID='".$eventID."' AND U.ID=A.UserID AND A.RequestStatus='Requested'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
if (!empty($num_rows)) {
while($row = mysql_fetch_array($result)) {
	array_push($requestedArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>calculatePointTotal($row['ID'])));
	array_push($userArray, array('ID'=>$row['ID'], 'AcctType'=>$row['AcctType'], 'LastName'=>$row['LastName'], 'FirstName'=>$row['FirstName'], 'Email'=>$row['Email'], 'RequestStatus'=>$row['RequestStatus'], 'PointTotal'=>calculatePointTotal($row['ID'])));
}
}

/******************************
	GRAB HOW MANY STUDENTS WERE REQUESTED
******************************/


	$requestCount = count($userArray);
	$numberWanted = $numpull;
	
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

	if ($requestCount == 0) {
/*		//echo "ERROR";
		$_SESSION['attendance-error'] = "There are no current usher requests for that show.";
		header("Location: attendance-admin.php");*/
	} 
	else {
		
		for($i=0; $i<$numberWanted; $i++) {
			echo "SELECTED: " .$finishedArray[$i]['PointTotal'] . " | ". $finishedArray[$i]['AcctType']. " ".$finishedArray[$i]['LastName']. ", ". $finishedArray[$i]['FirstName']. ", " . $finishedArray[$i]['ID']. "<br />";
			if ($twoday == 1)
			{
				$SQL = "UPDATE Attendance SET RequestStatus='Ushering', RequestDate='".date("Y-m-d H:i:s")."' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
			} else {
				$SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
			}
			echo $SQL."<br>";
			if ($replacement==1)
			{
				echo "Replacement<br>";
			//	sendEmail($finishedArray[$i]['ID'], $eventID, 'replacement-email');
			}
			else{
			//	sendEmail($finishedArray[$i]['ID'], $eventID, 'confirmation-email');
				echo "No Replacement<br>";
			}
		//	mysql_query($SQL);
		}
	
		for($i=$numberWanted; $i<$requestCount; $i++) {
			echo "CUT: " .$finishedArray[$i]['PointTotal'] . " | ". $finishedArray[$i]['AcctType']. " ".$finishedArray[$i]['LastName']. ", ". $finishedArray[$i]['FirstName']. ", " . $finishedArray[$i]['ID'].  "<br />";
			$SQL = "UPDATE Attendance SET RequestStatus='Cut' WHERE UserID='".$finishedArray[$i]['ID']."' AND EventID='".$eventID."'";
			echo $SQL."<br>";
			if($finishedArray[$i]['RequestStatus']!='Cut') 
			{
				echo "Sending email to ".$finishedArray[$i]['ID']."<br>";
				//sendEmail($finishedArray[$i]['ID'], $eventID, 'cut-email');
			} else {echo "Already cut. <br>";}
			//mysql_query($SQL);
		}
		
		
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
	
	
		$_SESSION['attendance-message'] = "The attendance has been successfully pulled and the ushers have been notified.";
		header("Location: attendance-admin.php");

*/
	}
}



?>