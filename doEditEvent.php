<?php session_start();
include_once("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$eventID = $_POST['ID'];
$name = $_POST['Name'];
$type = $_POST['Type'];
$preshow = $_POST['preshow'];
$location = $_POST['Location'];
$meetingloc = $_POST['MeetingLoc'];
$description = $_POST['Description'];
$specialinstr = $_POST['SpecialInstr'];
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
    $amORpm1 = substr($plainDate, 16, 3);
    $amORpm = str_replace(" ", "", $amORpm1);


    if (($amORpm == 'PM' || $amORpm == 'pm') && $hour != 12) {
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


$SQL = "UPDATE Event SET Name='" . $name . "', Description='" . $description . "', SpecialInstr='" . $specialinstr . "', Point='" . $point . "', Type='" . $type . "', Location='" . $location . "', MeetingLoc='" . $meetingloc . "', UpTime='" . $upTime . "', EndTime='" . $endTime . "', CallTime='" . $callTime . "', SeasonID=" . $season . ", NoRegister=" . $preshow . ", UC='" . $uc . "' WHERE ID=" . $eventID;
//echo $SQL;
mysql_query($SQL) or die($SQL);


$_SESSION['success'] = "The event has successfully been edited!";
header("Location: edit-event.php?ID=" . $eventID);
?>