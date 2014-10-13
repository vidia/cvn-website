<?php session_start(); 
include("assets/includes/verify.php");
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/jquery.plugins.js"></script>
<script type="text/javascript" src="assets/js/jquery.cvn.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/screen.css"/>
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
           <h2>CVN Events</h2><br />
           <?php
		   if(isset($_GET['id'])) {
			   $query = "SELECT * FROM Event WHERE ID='".$_GET['id']."'";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result)){ 
			?>
                	<a class="event" href="events.php?id=<?php echo $row['ID']; ?>">
                        <div class="event-name"><strong>Name:</strong> <?php echo $row['Name']; ?></div>
                        <div class="event-time"><strong>Call Time:</strong> <?php echo date("n-j-Y g:i a", strtotime($row['CallTime'])); ?></div>
                        <div class="event-location"><strong>Location:</strong> <?php echo $row['Location']; ?></div>
                        <div class="event-points">This <u><?php echo $row['Type']; ?></u> is worth <u><?php echo $row['Point']; ?></u> points.</div>
                        <div class="event-description"><strong>Description:</strong> <br /><?php echo $row['Description']; ?></div>
                    </a>
                    <a href="events.php">&laquo; View all events</a>
           <?php 
				}
		   } else { 
		   		$query = "SELECT * FROM Event WHERE Type<>'Meeting' ORDER BY CallTime ASC";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result)){ 
		  ?>
                	<a class="event" href="events.php?id=<?php echo $row['ID']; ?>">
                        <div class="event-name"><strong>Name:</strong> <?php echo $row['Name']; ?></div>
                        <div class="event-time"><strong>Call Time:</strong> <?php echo date("n-j-Y g:i a", strtotime($row['CallTime'])); ?></div>
                        <div class="event-location"><strong>Location:</strong> <?php echo $row['Location']; ?></div>
                        <div class="event-points">This <u><?php echo $row['Type']; ?></u> is worth <u><?php echo $row['Point']; ?></u> points.</div>
                        <div class="event-description"><strong>Description:</strong> <br /><?php echo $row['Description']; ?></div>
                    </a>
                <?php 
				}
		   }
		   ?>            
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
