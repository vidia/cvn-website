<?php session_start(); 
include_once("assets/includes/db.php");
include_once("assets/includes/header.php");
include("assets/includes/constants.php"); 

$Email = mysql_real_escape_string($_GET['Email']);
$Key  = mysql_real_escape_string($_GET['Key']);

if($Email == '' || $Key == '') {
	$_SESSION['error'] = "Please make sure you copy and paste the entire reset link. If this still doesnt work please recovering your <a class='alert-link' href='recover-password.php'>password again here</a>. If you are still having trouble please contact us at cvn2@purdue.edu.";
} else {
	$query = "SELECT * FROM User WHERE Email='".$Email."' AND ConfirmationKey='".$Key."'";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
		if($num_rows == 0) {
			$_SESSION['error'] = "Invalid reset link. Please try recovering your <a href='recover-password.php'>password again here</a>";
		}
}

?>

<?php 

$SQL = "SELECT * FROM Event WHERE ID='".$_GET['ID']."'";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);
?>

<div class="container">
      
      <div class="row">
        <div class="col-lg-12">
          <?php 
          // a random hello
          $helloArray = array("Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey,", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
          $randHello = array_rand($helloArray);
          ?>
          <h1 class="page-header">Reset Password <small>Update your password to log into your account</small></h1>
          <ol class="breadcrumb">
          	<li><a href="/">Home</a></li>
            <li class="active">Reset Password</li>
          </ol>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-12">
        <?php 
           if($_SESSION['success'] != '') {
					echo "<div class='alert alert-success'>".$_SESSION['success']."</div>"; 
					$_SESSION['success'] = '';
			}
			
			if($_SESSION['error'] != '') {
					echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>"; 
					$_SESSION['error'] = '';
			}
		?>
			<form class="form-horizontal" enctype="application/x-www-form-urlencoded" action="doReset.php" method="post">
				<div class="form-group">
					<label for="Password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-6">
						<input class="form-control" type="password" name="Password" id="Password" />
					</div>
				</div>

				<div class="form-group">
					<label for="CPassword" class="col-sm-2 control-label">Confirm Password</label>
					<div class="col-sm-6">
						<input class="form-control" type="password" name="CPassword" id="CPassword" />
					</div>
				</div>

                <input type="hidden" value="<?php echo $Email; ?>" name="Email" id="Email" />
                <input type="hidden" value="<?php echo $Key; ?>" name="Key" id="Key" />

                <div class="form-group">
					<label for="CPassword" class="col-sm-2 control-label"></label>
					<div class="col-sm-6">
						<input class="btn btn-success" type="submit" value="Reset Password" name="reset" id="reset" />
					</div>
				</div>


                <br />
                
            </form>
	</div>
</div>
<?php
include_once("assets/includes/footer.php");
?>