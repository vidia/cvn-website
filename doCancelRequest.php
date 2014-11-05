<?php session_start();
include_once("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/constants.php");

//ini_set('display_errors', 1);
//error_reporting('E_ALL');


$eventid = $_GET['id'];
$body = "USHER: " . $_SESSION['UID'] . "<br><br>";

$SQL = "SELECT CallTime, UC FROM Event WHERE ID='" . $eventid . "'";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $callTime = $row['CallTime'];
    $UC = $row['UC'];
    $body .= "Call time: " . $callTime . "<br>";
}

$SQL = "SELECT RequestStatus, RequestDate FROM Attendance WHERE UserID='" . $_SESSION['UID'] . "' AND EventID='" . $eventid . "'";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $status = $row['RequestStatus'];
    $reqDate = $row['RequestDate'];
}

$body .= "Last status: " . $status . "<br>Last request date: " . $reqDate . "<br><br>";

$now = date("Y-m-d H:i:s");
$body .= "Now: " . $now . "<br>";

$fiveDayLimit = date('Y-m-d H:i:s', strtotime('7 days'));
$body .= '"fiveDayLimit":' . $fiveDayLimit . "<br>";

$twoDayLimit = date('Y-m-d H:i:s', strtotime('2 days'));
$body .= 'Two day limit: ' . $twoDayLimit . "<br>";

/*
	UC'S CAN NOW REGISTER FOR SHOWS
	THEY CAN CANCEL UP TO 24HRS BEFORE THE SHOW
*/

//i'm tired.


/*
	END UC CHECK
*/


if ($callTime < $fiveDayLimit && $callTime > $twoDayLimit) {
    $body .= "within 5 days but greater than 2 <br>";
    $SQL = "DELETE FROM Attendance WHERE UserID='" . $_SESSION['UID'] . "' AND EventID='" . $eventid . "'";
    mysql_query($SQL);
    $body .= $SQL . "<br>" . "<br>";

    //insert find anther usher and email them
    /*	$query = "SELECT UserID FROM Attendance WHERE RequestStatus='Cut' AND EventID='".$eventid."' LIMIT 1";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
        if($num_rows > 0) {
            while($row = mysql_fetch_array($result)){
                $ID = $row['UserID'];
            }
            $sql_u = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$ID."' AND EventID='".$eventid."'";
            mysql_query($sql_u);
            sendEmail($ID, $eventid, 'replacement-email');
        } else {
            $query = "SELECT UserID FROM Attendance WHERE RequestStatus='Requested' AND EventID='".$eventid."' LIMIT 1";
            $result = mysql_query($query);
            $num_rows = mysql_num_rows($result);
            if($num_rows > 0) {
                while($row = mysql_fetch_array($result)){
                    $ID = $row['UserID'];
                }
                $sql_u = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$ID."' AND EventID='".$eventid."'";
                mysql_query($sql_u);
                sendEmail($ID, $eventid, 'replacement-email');
            } else {
                //Send email to user with ID 17 (cvn2 account)
                sendEmail(17, $eventid, 'no-replacement');
            }
        }*/
    if ($status == 'Ushering') {
        $body .= pullAttendance(1, $eventid, 1, 0);
    }

} elseif ($callTime < $twoDayLimit) {
    $body .= "within 2 days <br>";
    if ($status == 'Ushering' || $status == 'Cancelled') {
        $reqPlusTwo = date('Y-m-d H:i:s', strtotime($reqDate . '+2 days'));
        $body .= 'Request + two days: ' . $reqPlusTwo . "<br>";
        if ($callTime > $reqPlusTwo) {
            $SQL = "UPDATE Attendance SET RequestStatus='Cancelled' WHERE UserID='" . $_SESSION['UID'] . "' AND EventID='" . $eventid . "'";
        } else {
            $body .= "late add, exempt from 48 hour penalty <br>";
            $SQL = "UPDATE Attendance SET RequestStatus='Late-Add-Cancel' WHERE UserID='" . $_SESSION['UID'] . "' AND EventID='" . $eventid . "'";
            //$SQL = "DELETE FROM Attendance WHERE UserID='".$_SESSION['UID']."' AND EventID='".$eventid."'";
        }
        $body .= $SQL . "<br>" . "<br>";
        $body .= pullAttendance(1, $eventid, 1, 1);

        //Notify UC that there was a late cut
        $query = "SELECT ID FROM User WHERE Username='" . $UC . "'";
        $result = mysql_query($query);
        while ($row = mysql_fetch_array($result)) {
            $ID = $row['ID'];
        }
        //send email to event UC
        sendEmail($ID, $eventid, 'late-cut');

        mysql_query($SQL);
        //echo $SQL;
    } else {
        $body .= "not ushering, exempt from 48 hour penalty <br>";
        $SQL = "DELETE FROM Attendance WHERE UserID='" . $_SESSION['UID'] . "' AND EventID='" . $eventid . "'";
        mysql_query($SQL);
        $body .= $SQL . "<br>" . "<br>";
    }
} else {
    $body .= "early still <br>";
    $SQL = "DELETE FROM Attendance WHERE UserID='" . $_SESSION['UID'] . "' AND EventID='" . $eventid . "'";
    mysql_query($SQL);
    $body .= $SQL . "<br>" . "<br>";
}

mail("cvn2@purdue.edu", "[debug] Cancel debug email", $body, "Content-type: text/html\r\n");

$_SESSION['success'] = "You have successfully cancelled your request.";
header("Location: dashboard.php");
?>
