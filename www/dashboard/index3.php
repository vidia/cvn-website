<?php session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/jquery.plugins.js"></script>
<script type="text/javascript" src="assets/js/jquery.cvn.js"></script>
<script type="text/javascript" src="assets/js/jquery.tipTip.js"></script>

<link rel="stylesheet" type="text/css" href="assets/css/screen.css"/>
<!--[if lt IE 8]>
   <link href="assets/css/ie.css" rel="stylesheet" type="text/css" />  
<![endif]-->
<title>Purdue CVN || Usher Tracker</title>
</head>
<body class="cvn home">
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
            <?php if($_SESSION['security-error'] != '') {
					echo "<div class='error'>".$_SESSION['security-error']."</div>"; 
					$_SESSION['security-error'] = '';
			}?>
			
			<?php if($_SESSION['AccountType'] == 'UC' || $_SESSION['AccountType'] == 'ADMIN' ) { ?>
			<script type="text/javascript">
				function createCookie(name,value,days) {
				if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
				}
				else {var expires = "";}
				document.cookie = name+"="+value+expires+"; path=/";  // the cookie is valid throughout the entire domain.
				}

				function readCookie(name) {
				var nameEQ = name + "=";
				var ca = document.cookie.split(';');
				for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
				}
				return null;
				}

				function eraseCookie(name) {
				createCookie(name,"",-1);
				}
				</script>
			
				<div id="message"></div>

				<script type="text/javascript">
				if(!readCookie('beenHereBefore')) {
				document.getElementById("message").innerHTML = "<div class='notice'>Hello Usher Coordinator, there have been several additions to the website for you. As you can see above, you have access to two new pages that allow you to edit the attendance of users as well as the ability to export information. If you have questions on how to use these sections, please contact Kate so that she can help you through the process. <br /><br />In addition to the new section, there have been two additional attendance statuses created. One for a dress code violation and one for arriving to the event late. Please mark your attendance as usual on the attendance page and then visit the users' profiles with whom you need to mark for these special events. If you find an error, please let Kate know as well. <br/><br/>Your actions are recorded and abuse will be tracked.Thanks.</div>";
				createCookie('beenHereBefore', 'beenHereBefore', 365);  // 365 days persistence
				}
				</script>
			
			<?php } ?>
			
			
            <h2>Welcome to the CVN Usher Tracking Application</h2>
            <img src="assets/images/cvn-logo.jpg" width="200" class="float-right" />

		   <strong>Who are we?</strong>

<p>Students for the Arts!!! Convocations Voice Network (CVN) was officially established in 1985 to support and promote the performing arts presentations brought to campus by Convocations. Today, CVN has a membership of more than 300 students from various majors and backgrounds and participates in every performance of the season.</p>
<br />
<strong>What does CVN do?</strong>

<p>CVN provides volunteer ushering for all of the Convocations events in Elliott Hall, Loeb Playhouse, and Fowler Hall each season. All members ushering for a given show are invited to stay and see that show for FREE! CVN members may usher for as many or as few shows as they like.</p>
<br />
<p>CVN also takes part in a variety of special events, including receptions with the performers, parties with the patrons, and lots of social activities.</p>
<br />



<strong>Why should you join?</strong>
<ul>
    <li>No dues to pay ever!</li>
    <li>Free food at meetings!</li>
    <li>Develop valuable public relations and publicity skills!</li>
    <li>See Convocations shows for FREE when you usher!</li>
    <li>Interact with performers from around the world!</li>
    <li>Take part in fun social events!</li>
    <li>Develop a brand new network of friendships!</li>
</ul>

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
<?php $_SESSION['security-error'] = ''; ?>