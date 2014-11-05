<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$userID = $_POST['ID'];
$FirstName = str_replace("'", " ", $_POST['firstname']);
$LastName = str_replace("'", " ", $_POST['lastname']);
$Email = str_replace("'", " ", $_POST['email']);
$Password = str_replace("'", " ", $_POST['password']);
$CPassword = str_replace("'", " ", $_POST['confirm-password']);
$AcctType = str_replace("'", " ", $_POST['AcctType']);
$Class = str_replace("'", " ", $_POST['year']);
$Graduation = str_replace("'", " ", $_POST['grad']);
$College = str_replace("'", " ", $_POST['college']);
$Marketing = str_replace("'", " ", $_POST['marketing']);

if ($Password != '' && $CPassword != '' && $Password == $CPassword) {
    $Password = md5($Password);
    $SQL = "UPDATE User SET Password='" . $Password . "', FirstName='" . $FirstName . "', LastName='" . $LastName . "', Email='" . $Email . "', AcctType='" . $AcctType . "', Class='" . $Class . "', GraduationDate='" . $Graduation . "', College='" . $College . "', Marketing='" . $Marketing . "' WHERE ID='" . $userID . "'";
    mysql_query($SQL);
    //echo $SQL;
    $_SESSION['success'] = "The user has successfully been edited and their password has been changed.";
    header("Location: edit-user.php?ID=" . $userID);
} elseif ($Password == '' && $CPassword == '') {
    $SQL = "UPDATE User SET FirstName='" . $FirstName . "', LastName='" . $LastName . "', Email='" . $Email . "', AcctType='" . $AcctType . "', Class='" . $Class . "', GraduationDate='" . $Graduation . "', College='" . $College . "', Marketing='" . $Marketing . "' WHERE ID='" . $userID . "'";
    mysql_query($SQL) or die("A MySQL error has occurred.<br />Your Query: " . $your_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());

    //$test = "SELECT * FROM User WHERE ID='".$userID."'";
    //$result = mysql_query($SQL);
    //$row = mysql_fetch_array($result);
    //echo $SQL;
    $_SESSION['success'] = "The " . $AcctType . " has successfully been edited.";
    header("Location: edit-user.php?ID=" . $userID);
} else {
    $_SESSION['error'] = "Please make sure that your passwords match";
    header("Location: edit-user.php?ID=" . $userID);
}
?>
