<?php session_start();
include("../assets/includes/db.php");
include("../assets/includes/verify.php");
include("../assets/includes/verify-uc.php");
include("../assets/includes/constants.php");

$action = $_GET["action"];
$id = $_GET["ID"];
$user = $_GET["user"];

$status = $_POST["RequestStatus"];
$formUserID = $_POST["user"];
$formAction = $_POST["action"];
$formAttendanceID = $_POST["attendanceID"];

$userf = $_POST["addUser"];
$event = $_POST["addEvent"];
$request = $_POST["addRequest"];
$requestDate = $_POST["addDate"];


if($action == "delete") {
//delete
$SQL = "DELETE FROM Attendance WHERE ID=" . $id . " AND UserID="  . $user . ";";
mysql_query($SQL);
calculatePointTotalDB($user);
$_SESSION['success'] = "You have successfully deleted the user's attendance.";
header("Location:edit-user.php?ID=" . $user);
}
else if($formAction == "edit") {
//edit
$SQL = "UPDATE Attendance SET RequestStatus='" . $status . "' 	WHERE ID=" . $formAttendanceID . " AND UserID=" . $formUserID . ";";
mysql_query($SQL);
calculatePointTotalDB($formUserID);
$_SESSION['success'] = "You have successfully edited the user's attendance.";
header("Location:edit-user.php?ID=" . $formUserID);
}
else if($formAction == "add") {
//add

$SQL = "INSERT INTO Attendance (UserID, EventID, RequestStatus, RequestDate, SeasonID) VALUES (" . $userf . ", " . $event . ", '" . $request . "', '" . $requestDate . "', 0);";
mysql_query($SQL);
calculatePointTotalDB($userf);
$_SESSION['success'] = "You have successfully added the user's attendance.";
header("Location:edit-user.php?action=done&ID=".$userf);

}
else {
//error
$_SESSION['error'] = "You have done something awfully wrong. Try it again. The right way!";
header("Location:edit-user.php?ID=" . $user);
}

?>