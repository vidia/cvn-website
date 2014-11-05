<?php session_start();
include_once("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$eventID = $_POST['ID'];
$name = $_POST['Name'];
$type = $_POST['Type'];
$noregister = $_POST["preshow"];
$location = $_POST['Location'];
$description = $_POST['Description'];
$point = $_POST['Point'];

$upTime = $_POST['UpTime'];
$endTime = $_POST['EndTime'];
$callTime = $_POST['CallTime'];
$season = $_POST['season'];

$uc = $_POST['UC'];

function formatDate($plainDate)
{
    $month = substr($plainDate, 0, 2);
    $day = substr($plainDate, 3, 2);
    $year = substr($plainDate, 6, 4);
    $hour = substr($plainDate, 11, 2);
    $minute = substr($plainDate, 14, 2);
    $amORpm = substr($plainDate, 16, 3);
    $amORpm = preg_replace('/\s+/', '', $amORpm);


    if ($amORpm == 'PM') {
        $hour = $hour + 12;
    }

    $date = $year . "-" . $month . "-" . $day;
    $time = $hour . ":" . $minute . ":00";
    $fullDate = $date . " " . $time;

    return $fullDate;

}

$upTime = formatDate($upTime);
$endTime = formatDate($endTime);
$callTime = formatDate($callTime);

$SQL = "INSERT INTO Event (Name, Description, Point, Type, Location, UpTime, EndTime, CallTime, UC, SeasonID, noregister) VALUES ('" . $name . "', '" . $description . "', '" . $point . "', '" . $type . "', '" . $location . "', '" . $upTime . "', '" . $endTime . "', '" . $callTime . "', '" . $uc . "', '" . $season . "', '" . $noregister . "')";
mysql_query($SQL) or die(mysql_error());

$_SESSION['success'] = "The event has successfully been created.";
header("Location: event-admin.php");
?>