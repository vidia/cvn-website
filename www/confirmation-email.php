<?php session_start();
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
	$PageTitle = "Send Confirmation Email";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
          	<li><a href="edit-email.php">Manage Emails</a></li>
            <li class="active">Send Confirmation Email</li>
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


			<table class="table table-bordered table-hover table-striped">
           	<thead><tr><th>Name</th><th>Date</th><th>Time</th><th>Link</th></tr></thead>
			<?php
			$SQL = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 ORDER BY CallTime DESC";
			$result = mysql_query($SQL);
			while($row = mysql_fetch_array($result)) {
				echo "<tr><td>".$row['Name']."</td><td>".date("m/d/Y", strtotime($row['CallTime']))."</td><td>".date("g:i a", strtotime($row['CallTime']))."</td><td><a href='send-confirmation-email.php?ID=".$row['ID']."' />Send Email</a></td></tr>";
			}
			?>
            </table>


        </div>
    </div>
</div>



<?php
include_once("assets/includes/footer.php");
?>
