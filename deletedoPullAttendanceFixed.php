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
$cutUserArray = array();
$requestedUserArray = array();

function filter_by_value($array, $index, $value)
{
    if (is_array($array) && count($array) > 0) {
        foreach (array_keys($array) as $key) {
            $temp[$key] = $array[$key][$index];

            if ($temp[$key] == $value) {
                $newarray[$key] = $array[$key];
            }
        }
    }
    return $newarray;
}


echo "THIS IS A DEVELOPER'S VIEW OF THE FUNCTIONALITY BEHIND THE SCENES. IF YOU MEANT TO PULL ATTENDANCE THIS HAS <B>NOT</B> WORKED. PLEASE CONTACT KENNY AT KENNY@DIGITAL-INFLECTION.COM FOR HELP.";
echo "<br /><br /><br />";
/*****************************
 * GRAB FROM CUT LIST
 ******************************/
$query = "SELECT U.ID AS ID, U.LastName AS LastName, U.FirstName AS FirstName, U.Email AS Email FROM Attendance A, User U WHERE A.EventID='" . $eventID . "' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

if (!empty($num_rows)) {
    while ($row = mysql_fetch_array($result)) {
        array_push($userArray, array('List' => 'Cut', 'ID' => $row['ID'], 'LastName' => $row['LastName'], 'FirstName' => $row['FirstName'], 'Email' => $row['Email'], 'PointTotal' => calculatePointTotal($row['ID'])));
    }
}

/*****************************
 * GRAB FROM REQUESTED LIST
 ******************************/
$query = "SELECT U.ID AS ID, U.LastName AS LastName, U.FirstName AS FirstName, U.Email AS Email FROM Attendance A, User U WHERE A.EventID='" . $eventID . "' AND U.ID=A.UserID AND A.RequestStatus='Requested'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
if (!empty($num_rows)) {
    while ($row = mysql_fetch_array($result)) {
        array_push($userArray, array('List' => 'Requested', 'ID' => $row['ID'], 'LastName' => $row['LastName'], 'FirstName' => $row['FirstName'], 'Email' => $row['Email'], 'PointTotal' => calculatePointTotal($row['ID'])));
    }
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
}

/*****************************
 * ADD CUT USERS FIRST
 * Count the number added and subtract it from numberWanted for Requested Users next
 *
 * NUMBER ADDED DOESN'T WORK BECAUSE THE ARRAY KEEPS THE ORIGINAL INDEX. TRY TRY AGAIN.
 ******************************/

$cutUserArray = filter_by_value($userArray, 'List', 'Cut');
subval_sort($cutUserArray, 'PointTotal');
print_r($cutUserArray);
for ($i = 0; $i < $numberWanted; $i++) {
    echo $cutUserArray[$i]['List'] . " " . $cutUserArray[$i]['FirstName'] . " " . $cutUserArray[$i]['ID'] . " | " . $cutUserArray[$i]['PointTotal'] . "<br /><br />";
    //$SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$userArray[$i]['ID']."' AND EventID='".$eventID."'";
    //echo $SQL."<br>";
    //mysql_query($SQL);

}

/*****************************
 * ADD REQUESTED USERS SECOND
 ******************************/
$numberWanted -= $numberAdded;
echo $numberWanted;
$requestedUserArray = filter_by_value($userArray, 'List', 'Requested');
subval_sort($requestedUserArray, 'PointTotal');
print_r($requestedUserArray);
for ($i = 0; $i < $numberWanted; $i++) {
    echo $requestedUserArray[$i]['FirstName'] . " " . $requestedUserArray[$i]['ID'] . " | " . $requestedUserArray[$i]['PointTotal'] . "<br /><br />";
    //	$SQL = "UPDATE Attendance SET RequestStatus='Ushering' WHERE UserID='".$userArray[$i]['ID']."' AND EventID='".$eventID."'";

    //	sendEmail($userArray[$i]['ID'], $eventID, 'confirmation-email');
    //	mysql_query($SQL);
}


//$_SESSION['attendance-message'] = "The attendance has been successfully pulled and the ushers have been notified.";
//header("Location: attendance-admin.php");


