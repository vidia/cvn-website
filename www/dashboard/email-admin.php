<?php session_start();
// delete me later 
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include_once("assets/includes/constants.php"); 	
?>


<script src="assets/js/datetimepicker_css.js"></script>
<div class="container">
      <div class="row">
        <div class="col-lg-12">
<?php
	$PageTitle = "Email Admin";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Email Admin</li>
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

          
 		<a class="btn btn-default pull-right" href="confirmation-email.php">Send Confirmation Email</a>
 		<br class="clearfix" />
 		<br class="clearfix" />


			<?php
			
			$SQL = "SELECT * FROM Email";
			$result = mysql_query($SQL);
			echo "<ul class='list-group'>";
			while($row = mysql_fetch_array($result)) {
			 	
				  	echo "<li class='list-group-item'>";
				    echo "<a  href='edit-email.php?ID=".$row['ID']."' class='btn btn-xs btn-default pull-right'>Edit Email</a>";
					echo $row["Email_Name"];
				    echo "</li>";


				//echo "".$row['Email_Name']."<a class='add float-right' href='edit-email.php?ID=".$row['ID']."' />Edit Email</a><br class='clear'/>";
			}
			echo "</ul>";	
			?>

<?php
include_once("assets/includes/footer.php"); 	
?>
