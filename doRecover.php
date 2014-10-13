<?php session_start();
include_once("assets/includes/db.php");

$Email = mysql_real_escape_string($_POST['resetEmail']);

$query = "SELECT * FROM User WHERE Email='".$Email."'";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

if($num_rows>0) {
	//echo "valid";
	while($row = mysql_fetch_array($result)){
		$_SESSION['Name'] = $row['FirstName']." ".$row['LastName'];
		$ConfirmationKey = $row['ConfirmationKey'];
	}
	$url = "http://www.purduecvn.com/reset-password.php?Email=".$Email."&Key=".$ConfirmationKey;
	$Name= $_SESSION['Name'];
	$Email = $Email;
	$Subject = "Convocations Voice Network - Password Reset";
	$Message = "Dear ".$Name.",<br><br> To recover your password for the CVN tracking application please follow the link below and follow the instructions.<br/><a href='$url'>Reset Password for CVN</a><br><br> Thanks, <br> Convocations Voice Network";
	$headers = "Content-type: text/html\r\n";
	mail($Email, $Subject, $Message, $headers);
	$_SESSION['success'] = "An email has been sent to the supplied email address with instructions on reseting your password. Please check your spam box if you do not receive the email.";
	header("Location: login.php");
} else {
	//echo "not valid";
	$_SESSION['error'] = "The supplied email address does not match any in our system. Please try again or <a class='alert-link' href='register.php'>register here</a> for a new account.";
	header("Location: login.php");
}

?>