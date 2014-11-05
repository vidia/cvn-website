<?php session_start();
$hostname = 'mydb.ics.purdue.edu';
$username = 'cvn';
$password = 'stag3d00r';
$dbname = 'cvn';
mysql_connect($hostname, $username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");

$eventID = $_POST['eventID'];

$userArray = array();

// grab from cut first
$query = "SELECT U.ID AS ID, U.LastName AS LastName, U.FirstName AS FirstName, U.Email AS Email FROM Attendance A, User U WHERE A.EventID='" . $eventID . "' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    array_push($userArray, array('ID' => $row['ID'], 'LastName' => $row['LastName'], 'FirstName' => $row['FirstName'], 'Email' => $row['Email'], 'PointTotal' => calculatePointTotal($row['ID'])));
}

// grab from requested second
$query = "SELECT U.ID AS ID, U.LastName AS LastName, U.FirstName AS FirstName, U.Email AS Email FROM Attendance A, User U WHERE A.EventID='" . $eventID . "' AND U.ID=A.UserID AND A.RequestStatus='Requested'";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {
    array_push($userArray, array('ID' => $row['ID'], 'LastName' => $row['LastName'], 'FirstName' => $row['FirstName'], 'Email' => $row['Email'], 'PointTotal' => calculatePointTotal($row['ID'])));
}


$requestCount = count($userArray);
$numberWanted = $_POST['number-pull'];
//echo $requestCount;
if ($requestCount < $numberWanted) {
    $numberWanted = $requestCount;
}

if ($requestCount == 0) {
    //echo "ERROR";
    $_SESSION['attendance-error'] = "There are no current usher requests for that show.";
    header("Location: attendance-admin.php");
} else {
    $userArray = subval_sort($userArray, 'PointTotal');


//echo "USER ARRAY<br>";
//print_r($userArray);
//echo "<br><br />";

    for ($i = 0; $i < $numberWanted; $i++) {
        //	echo $userArray[$i]['FirstName']. " " . $userArray[$i]['ID']. " | ".$userArray[$i]['PointTotal'] . "<br /><br />";
        $SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='" . $userArray[$i]['ID'] . "' AND EventID='" . $eventID . "'";
        //echo $SQL."<br>";
        sendEmail($userArray[$i]['ID'], $eventID, 'confirmation-email');
        mysql_query($SQL);
    }

    for ($i = $numberWanted; $i < $requestCount; $i++) {
        //echo "CUT: " . $userArray[$i]['FirstName']. " " . $userArray[$i]['ID']. " | ".$userArray[$i]['PointTotal'] . "<br /><br />";
        $SQL = "UPDATE Attendance SET RequestStatus='Cut' WHERE UserID='" . $userArray[$i]['ID'] . "' AND EventID='" . $eventID . "'";
        //echo $SQL."<br>";
        sendEmail($userArray[$i]['ID'], $eventID, 'cut-email');
        mysql_query($SQL);
    }

    $query = "SELECT * FROM User WHERE AcctType='UC'";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        //echo $row['ID']."<br>";
        //sendEmail($row['ID'], $eventID, 'uc-email');
    }

    $_SESSION['attendance-message'] = "The attendance has been successfully pulled and the ushers have been notified.";
    header("Location: attendance-admin.php");

}
?>