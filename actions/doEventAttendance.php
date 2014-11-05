<?php session_start();
include("../assets/includes/db.php");
include("../assets/includes/verify.php");
include("../assets/includes/verify-uc.php");
include("../assets/includes/constants.php");


$body = "UC: ".$_SESSION['UID']."<br><br>";

$eventID = $_POST['EventID'];
$requestDate = date("Y-m-d H:i:s");
//echo $eventID;

$SQL = "SELECT CallTime FROM Event WHERE ID='".$eventID."'";
$result = mysql_query($SQL);
while($row = mysql_fetch_array($result)){
	$callTime = $row['CallTime'];
}
$body .= "call time:".$callTime."<br>";

$currentAtten = array();
$requestTimes = array();
$SQL = "SELECT * FROM Attendance WHERE EventID='".$eventID."' AND (RequestStatus='Ushering' OR RequestStatus='No-Show' OR RequestStatus='Present')";
$result = mysql_query($SQL);
while($row = mysql_fetch_array($result)) {
	//echo $row['UserID']."<br>"; 
	array_push($currentAtten, $row['UserID']);
	$requestTimes[$row['UserID']] = date('Y-m-d H:i:s', strtotime($row['RequestDate'].'+2 days'));
}

$present=$_POST['present'];
//print_r($present);
//echo " - form array <br>";

if($present != '') { 
	$deleteAtten = array_diff($currentAtten,$present);
} else {
	$deleteAtten = $currentAtten;
}

$body .= "no-shows:<br>";
foreach ($deleteAtten as $value) {
	$body .= $value." - Request time:".$requestTimes[$value]."<br>";
	if($callTime < $requestTimes[$value]){
		$SQL = "UPDATE Attendance SET RequestStatus='Late-Add-Cancel' WHERE UserID='".$value."' AND EventID='".$eventID."'";
		mysql_query($SQL);
	} else {
		$SQL = "UPDATE Attendance SET RequestStatus='No-Show' WHERE UserID='".$value."' AND EventID='".$eventID."'";
		mysql_query($SQL);
		//echo $SQL."<br>";
		sendEmail($value, $eventID, "no-show");
	}
	$body .= $SQL."<br>";
}

$total = count($present);
//echo $total;
$body .= "present ushers:<br>";
for($i=0; $i<$total; $i++) { 
	$body .= $present[$i]." - Request time: ".$requestTimes[$present[$i]]."<br>";
	$SQL = "UPDATE Attendance SET RequestStatus='Present' WHERE UserID='".$present[$i]."' AND EventID='".$eventID."'";
	mysql_query($SQL);
	sendEmail($present[$i], $eventID, 'thank-you');
	$body .= $SQL."<br>";
}

$extra=$_POST['extra'];
//print_r($extra);
if($extra != '') {
	$body .= "extras:<br>";
	$extra = array_unique($extra);

	//print_r($extra);
	
	$extraCut = array();
	$SQL = "SELECT * FROM Attendance WHERE EventID='".$eventID."' AND (RequestStatus='Cut' OR RequestStatus='Cancelled')";
	$result = mysql_query($SQL);
	while($row = mysql_fetch_array($result)) {
		//echo $row['UserID']."<br>"; 
		array_push($extraCut, $row['UserID']);
	}
	
	foreach ($extra as $value) {
		$body .= $value." - Request time:".$requestTimes[$value]."<br>";
		if(in_array($value, $extraCut)) {
			$SQL = "UPDATE Attendance SET RequestStatus='Present' WHERE UserID='".$value."' AND EventID='".$eventID."'";
			mysql_query($SQL);
			sendEmail($value, $eventID, 'thank-you');
			//echo $SQL."<br>";
		} elseif($value != "None") {
			$SQL = "INSERT INTO Attendance (UserID, EventID, RequestStatus, RequestDate) VALUES ('".$value."', '".$eventID."', 'Present', '".$requestDate."')";
			mysql_query($SQL);
			sendEmail($value, $eventID, 'thank-you');
			//echo $SQL."<br>";
		}
		$body .= $SQL."<br>";
	}
}

mail("cvn2@purdue.edu,purduekenny@live.com", "[debug] Event attendance debug email", $body, "Content-type: text/html\r\n");

$_SESSION['success'] = "The attendance has been updated for the show.";
header("Location: /attendance-admin.php");
?>