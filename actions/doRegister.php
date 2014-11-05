<?php session_start();
include_once("../assets/includes/db.php");

//$MarketingEmail = "aeeddy@purdue.edu";

$FirstName = str_replace("'", " ", $_POST['firstname']);
$LastName = str_replace("'", " ", $_POST['lastname']);
$Email = str_replace("'", " ", $_POST['email']);
$CEmail = str_replace("'", " ", $_POST['confirm-email']);
$Password = str_replace("'", " ", $_POST['password']);
$CPassword = str_replace("'", " ", $_POST['confirm-password']);
$Class = str_replace("'", " ", $_POST['year']);
$Graduation = str_replace("'", " ", $_POST['grad']);
$College = str_replace("'", " ", $_POST['college']);
$Marketing = str_replace("'", " ", $_POST['marketing']);

$Created = date("Y-m-d H:i:s");
$ConfirmationKey = md5($Email);

$_SESSION['FirstName'] = $FirstName;
$_SESSION['LastName'] = $LastName;
$_SESSION['Email'] = $Email;
$_SESSION['CEmail'] = $CEmail;
$_SESSION['Grad'] = $Graduation;
$_SESSION['Year'] = $Class;
$_SESSION['College'] = $College;
$_SESSION['Marketing'] = $Marketing;

//echo $Password." ".$CPassword;

if(isSchoolEmail($Email))
{
	if($FirstName ==  "" || $LastName == "" || $Email == "" || $CEmail == "" || $Password == "" || $CPassword == "") 
	{ 
		$_SESSION['error'] = "Please fill in all required fields.";
		header("Location: /register.php");
	}
	else {
		if(accountExistForEmail($Email)) {
			$_SESSION['error'] = "The Email you are trying to register with already has an account setup. If you would like to login <a href='../login.php'>click here</a> or if you have lost or forgotten you password <a href='../recover-password.php'>click here.</a>";
			header("Location: register.php");
		} elseif($Email != $CEmail) { 
			$_SESSION['error'] = "Please make sure that the emails match. It will be used as your username.";
			header("Location: /register.php");
		} else {

			if($Password != $CPassword || $Password == "" || $CPassword == "") { 
				$_SESSION['error'] = "Please make sure that your passwords match.";
				header("Location: /register.php");
			} else {
				$Password = md5($Password);
				
				$sql = "INSERT INTO User (Username, Password, FirstName, LastName, Email, AcctType, Class, GraduationDate, College, Marketing, Created, ConfirmationKey) VALUES ('".$Email."', '".$Password."', '".$FirstName."', '".$LastName."', '".$Email."', 'USHER', '".$Class."', '".$Graduation."', '".$College."', '".$Marketing."', '".$Created."', '".$ConfirmationKey."')";
				mysql_query($sql);
				//echo $sql;
				$sql = "SELECT * FROM User WHERE Username='".$Email."'";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					$_SESSION['Login'] = $row['Username'];
					$_SESSION['Name'] = $row['FirstName']." ".$row['LastName'];
					$_SESSION['UID'] = $row['ID'];
					$_SESSION['AccountType'] = $row['AcctType'];
					$_SESSION['LastLogin'] = "Just Registered";
				}
				$_SESSION["success"] = "Welcome to your Dashboard. From here, you can sign up to usher upcoming events.";
				header("Location: /dashboard.php");
			}
		}
	}
}
else
{
	$_SESSION['error'] = "You must register with a Purdue University or Ivy Tech e-mail address.";
	header("Location: /register.php");
}

function accountExistForEmail($email) {
    $sql = "SELECT Email FROM User WHERE Email='".$email."'";
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);
    return ($num_rows > 0);
}

function isSchoolEmail($email) {
    $emailCheck=split("@",$email);
    return $emailCheck[1] == "purdue.edu" || $emailCheck[1] == "ivytech.edu";
}


?>