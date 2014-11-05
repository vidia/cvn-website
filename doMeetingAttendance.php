<?php
session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$eventID = $_POST['eventID'];
$requestDate = date("Y-m-d H:i:s");

$currentAtten = array();
$SQL = "SELECT * FROM Attendance WHERE EventID='" . $eventID . "'";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    //echo $row['UserID']."<br>";
    array_push($currentAtten, $row['UserID']);
}
//print_r($currentAtten);
//echo " - current atten<br>";

$user = $_POST['user'];
//print_r($user);
//echo " - form array <br>";

if ($user != '') {
    $deleteAtten = array_diff($currentAtten, $user);
} else {
    $deleteAtten = $currentAtten;
}
//print_r($deleteAtten);
//echo " - delete array <br>";
foreach ($deleteAtten as $value) {
    $SQL = "DELETE FROM Attendance WHERE EventID='" . $eventID . "' AND UserID='" . $value . "'";
    mysql_query($SQL);
    //echo $SQL."<br>";
}

$total = count($user);
//echo $total;
for ($i = 0; $i < $total; $i++) {
    if (!in_array($user[$i], $currentAtten)) {
        $SQL = "INSERT INTO Attendance (UserID, EventID, RequestStatus, RequestDate) VALUES ('" . $user[$i] . "', '" . $eventID . "', 'Present', '" . $requestDate . "')";
        mysql_query($SQL);
        //echo $SQL."<br>";
    } else {
        //echo "$user[$i] - nothing cause already in<br>";
    }
}

$_SESSION['success'] = "The attendance has been updated for this meeting.";
header("Location: meeting-attendance.php?ID=" . $eventID);
?>