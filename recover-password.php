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

<body class="cvn login">
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
            <h2>Recover Password</h2><br />
            <?php if($_SESSION['form-error'] != '') {
					echo "<div class='error'>".$_SESSION['form-error']."</div>"; 
			}
			?>
             <?php if($_SESSION['form-success'] != '') {
					echo "<div class='success'>".$_SESSION['form-success']."</div>"; 
			} else {
			?>
			<form enctype="application/x-www-form-urlencoded" action="actions/doRecover.php" method="post">
            	<label>Email</label><input type="text" name="email" id="email" /><br /><br />
                <input type="submit" value="Recover Password" name="recover" id="recover" /><br />
            </form>
            <?php } ?>
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
<?php $_SESSION['form-success'] = ''; ?>