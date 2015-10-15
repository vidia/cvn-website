<?php
session_start();
if ($_SESSION["Login"] == "") {
    $_SESSION["error"] = "You must be logged in to view this page.";
    header("Location: login.php?r=auth");
}


// function curPageURL() {
//  $pageURL = 'http';
//  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
//  $pageURL .= "://";
//  if ($_SERVER["SERVER_PORT"] != "80") {
//   $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
//  } else {
//   $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
//  }
//  return $pageURL;
// }

// $url = curPageURL();

// if($_SESSION['Login'] == '') {
// 	$_SESSION['security-error'] = "Please login to view account pages.";
// 	header("Location: login.php");
// }

/*##########################################
	Users must fill in their first and last name. Grandfathered in upon login.
	New users are required to fill in their name. Old users will be continuously prompted 
	to fill in their name; otherwise, they will be unable to sign up for events. 
###########################################*/
/*
if($url != "http://web.ics.purdue.edu/~cvn/my-account.php" || $url != "http://web.ics.purdue.edu/~cvn/index.php")
{
	if(empty($_SESSION['LastName']) || empty($_SESSION['FirstName']))
	{
		$_SESSION['noname-error'] = "<b>Important</b>: You must supply us with your first and last name in order to sign up for events. Please fill in the blanks provided below and then Save your account.";
		header("Location: my-account.php");
	}
}

*/
?>