<?php 
session_start();
include("../assets/includes/db.php");
include("../assets/includes/verify.php");
include("../assets/includes/verify-admin.php");

$FirstName = str_replace("'", " ", $_POST['firstname']);
$LastName = str_replace("'", " ", $_POST['lastname']);
$Email = str_replace("'", " ", $_POST['email']);
$CEmail = str_replace("'", " ", $_POST['confirm-email']);
$Password = str_replace("'", " ", $_POST['password']);
$CPassword = str_replace("'", " ", $_POST['confirm-password']);
$AcctType = str_replace("'", " ", $_POST['AcctType']);

/* Removed from form during redesign to simplify creation process */
$Class = str_replace("'", " ", $_POST['year']);
$Graduation = str_replace("'", " ", $_POST['grad']);
$College = str_replace("'", " ", $_POST['college']);
$Marketing = str_replace("'", " ", $_POST['marketing']);
$PrevPointTotal = str_replace("'", " ", $_POST['prev-point-total']);

$Created = date("Y-m-d H:i:s");
$ConfirmationKey = md5($Email);

$_SESSION['nFirstName'] = $FirstName;
$_SESSION['nLastName'] = $LastName;
$_SESSION['nEmail'] = $Email;
$_SESSION['nCEmail'] = $CEmail;
$_SESSION['nGrad'] = $Graduation;
$_SESSION['nYear'] = $Class;
$_SESSION['nCollege'] = $College;
$_SESSION['nMarketing'] = $Marketing;
$_SESSION['nAcctType'] = $AcctType;

//echo $Password." ".$CPassword;

if($FirstName ==  "" || $LastName == "" || $Email == "" || $CEmail == "" || $Password == "" || $CPassword == "") { 
	$_SESSION['error'] = "Please fill in all required fields.";
	header("Location: /add-user.php");
} else {
	$sql = "SELECT Email FROM User WHERE Email='".$Email."'";
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0) {
		$_SESSION['error'] = "The Email you are trying to register with already has an account setup.";
		header("Location: /add-user.php");
	} elseif($Email != $CEmail) { 
		$_SESSION['error'] = "Please make sure that the emails match. It will be used as your username.";
		header("Location: /add-user.php");
	} else {

		if($Password != $CPassword || $Password == "" || $CPassword == "") { 
			$_SESSION['error'] = "Please make sure that your passwords match.";
			header("Location: /add-user.php");
		} else {
			$Password = md5($Password);		
			$sql = "INSERT INTO User (Username, Password, FirstName, LastName, Email, AcctType, Class, GraduationDate, College, Marketing, Created, ConfirmationKey) VALUES ('".$Email."', '".$Password."', '".$FirstName."', '".$LastName."', '".$Email."', '".$AcctType."', '".$Class."', '".$Graduation."', '".$College."', '".$Marketing."', '".$Created."', '".$ConfirmationKey."')";
			mysql_query($sql);
			$_SESSION['add-message'] = "The user has successfully been added.";
			$_SESSION['nFirstName'] = '';
			$_SESSION['nLastName'] = '';
			$_SESSION['nEmail'] = '';
			$_SESSION['nCEmail'] = '';
			$_SESSION['nGrad'] = '';
			$_SESSION['nYear'] = '';
			$_SESSION['nCollege'] = '';
			$_SESSION['nMarketing'] = '';
			$_SESSION["success"] = "You've successfully created a new user.";
			header("Location: /user-admin.php");
		}
		
		
		
	}
}
?>