<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/jquery.plugins.js"></script>
<script type="text/javascript" src="assets/js/jquery.cvn.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/screen.css"/>
<!--[if lt IE 8]>
   <link href="assets/css/ie.css" rel="stylesheet" type="text/css" />  
<![endif]-->
<title>Purdue CVN || Usher Tracker</title>
</head>

<body class="cvn faqs">
	<div id="container">
    	<div id="header">
        	<img src="assets/images/cvn-header.jpg" alt="CVN Header" />
        	<?php 
			if($_SESSION['Login'] != '') {
				include("assets/includes/admin-menu.php");
			} else {
				include("assets/includes/menu.php");
			}
			if($_SESSION['AccountType'] == 'ADMIN') {
				include("assets/includes/site-admin-menu.php");
			} elseif($_SESSION['AccountType'] == 'UC') {
				include("assets/includes/uc-admin-menu.php");
			}
			
			?>
        </div><!-- end header -->
        
        <div id="content">
        	<div id="main" class="float-left">
           <h2>FAQ's</h2>
           
           <strong>Q</strong>: How can I apply to be on the E-board?<br />

<strong>A</strong>: <a target="_blank" href="assets/files/2013_Written_Application.pdf">Click here for application for Fall 2013!</a><br /><br />

<strong>Q</strong>: Where can I find more information about the club?<br />

<strong>A</strong>: Try our <a target="_blank" href="assets/files/cvn_brochure.pdf">Member Information Guide</a><br /><br />

<strong>Q</strong>: Where can I see powerpoints from the General meeting? <br />
<strong>A</strong>: Try our <a target="_blank" href="assets/files/2012_08_28_Fall_Callout.pptx">CVN Powerpoint</a><br /><br />

<!--
<strong>Q</strong>: When will the show be available for selection?<br />

<strong>A</strong>: The shows will be available on the day of the general meeting.<br /><br />
-->

<strong>Q</strong>: Who are the executive board members?<br />

<strong>A</strong>: <a target="_blank" href="assets/files/execboard_s13.pdf">Click here.</a><br /><br />

<strong>Q</strong>: When will I know if I made the list?<br />

<strong>A</strong>: You will be notified if you have made the list or not 7 days before the event. If you didn't make the list the first time around you will be put on a waiting list and might still have a chance to usher if somebody on the show list cancels. You will be emailed in all cases.<br /><br />

 

<strong>Q</strong>: When is the last time I'm able to cancel ushing a show without a penalty?<br />

<strong>A</strong>: 48 hours before calltime. There are people waiting to hear from us about cancellations, so please do it as soon as possible.<br /><br />


<strong>Q</strong>: Where can I find the Constitution?<br />
<strong>A</strong>: Try our <a href="assets/files/const_f12.pdf">Constitution</a>.

 

            </div>
            <?php include('assets/includes/sidebar.php'); ?>
            <br class="clear" />
        </div><!-- end content -->
        
        <div id="footer">
        	© 2008-2010 all rights reserved.
        </div><!-- end footer -->
	</div>
</body>
</html>
