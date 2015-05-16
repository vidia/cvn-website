<?php 
session_start();
include_once("assets/includes/db.php");
include("assets/includes/verify.php");

$FirstName = mysql_escape_string($_POST['firstname']);
$LastName = mysql_escape_string($_POST['lastname']);
$Email = mysql_escape_string($_POST['email']);
$Password = mysql_escape_string($_POST['password']);
$CPassword = mysql_escape_string( $_POST['confirm-password']);
$Class = mysql_escape_string($_POST['year']);
$Graduation = mysql_escape_string($_POST['grad']);
$College = mysql_escape_string($_POST['college']);
$Marketing = mysql_escape_string($_POST['marketing']);

// added 7/11/2012
$referred = mysql_escape_string($_POST['referred']);
$bdmonth = mysql_escape_string($_POST['bdmonth']);
$bdday = mysql_escape_string($_POST['bdday']);
$bdyear = mysql_escape_string($_POST['bdyear']);
$residence = mysql_escape_string($_POST['residence']);
$artist = mysql_escape_string($_POST['artist']);
$song = mysql_escape_string($_POST['song']);
$movie = mysql_escape_string($_POST['movie']);
$book = mysql_escape_string($_POST['book']);
$show = mysql_escape_string($_POST['show']);




if($FirstName == '') {
	$_SESSION['error'] = "Please fill in your first name.";
	header("Location: my-account.php");	
}
elseif ($LastName == '') {
	$_SESSION['error'] = "Please fill in your last name.";
	header("Location: my-account.php");	
}
elseif ($Email == '') {
	$_SESSION['error'] = "Please fill in your e-mail address.";
	header("Location: my-account.php");	
}
	else{
	// then check to see if they want to change their password
		if($Password != '' && $CPassword != '' && $Password == $CPassword) {
			$Password = md5($Password);
			$SQL = "UPDATE User SET Password='".$Password."', FirstName='".$FirstName."', LastName='".$LastName."', referred='" . $referred . "', bdmonth='" . $bdmonth . "', bdday=" . $bdday . ", bdyear=" . $bdyear . ", residence='" . $residence . "', Email='".$Email."', Class='".$Class."', GraduationDate='".$Graduation."', artist='" . $artist . "', song='" . $song . "', movie='" . $movie . "', book='" . $book . "', usershow='" . $show . "', College='".$College."', Marketing='".$Marketing."' WHERE Username='".$_SESSION['Login']."'";
			mysql_query($SQL);
			//echo $SQL;
			$_SESSION['success'] = "Your account information and password has been successfully updated.";
			// added because of first and last name requirements upon login
				$_SESSION['FirstName'] = $FirstName;
				$_SESSION['LastName'] = $LastName;
			// end
			header("Location: my-account.php");
		} elseif ($Password == '' && $CPassword == '') {
	// if they didn't enter anything on their password, then change everything but password
			$SQL = "UPDATE User SET FirstName='".$FirstName."', LastName='".$LastName."', referred='" . $referred . "', bdmonth='" . $bdmonth . "', bdday=" . $bdday . ", bdyear=" . $bdyear . ", residence='" . $residence . "', Email='".$Email."', Class='".$Class."', GraduationDate='".$Graduation."', artist='" . $artist . "', song='" . $song . "', movie='" . $movie . "', book='" . $book . "', usershow='" . $show . "', College='".$College."', Marketing='".$Marketing."' WHERE Username='".$_SESSION['Login']."'";
			mysql_query($SQL);
			//echo $SQL;
			$_SESSION['success'] = "Your account has successfully been updated.";
			// added because of first and last name requirements upon login
				$_SESSION['FirstName'] = $FirstName;
				$_SESSION['LastName'] = $LastName;
			// end
			header("Location: my-account.php");
		} else {
	// they screwed up their passwords
			$_SESSION['error'] = "Your account was not updated because your passwords did not match.";
			header("Location: my-account.php");		
		}
}


?>