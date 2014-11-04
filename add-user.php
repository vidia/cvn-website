<?php 
session_start();
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");
include("assets/includes/header.php");
?>

<div class="container">
      <div class="row">
        <div class="col-lg-12">

          <h1 class="page-header">Add User <small>Create a new account</small></h1>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
          	<li><a href="user-admin.php">Manage Users</a></li>
            <li class="active">Add User</li>
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


            <form class="form-horizontal" action="actions/doAddUser.php" method="post">
            	<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">General Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">First Name</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $_SESSION['nFirstName']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Last Name</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="lastname" id="lastname" value="<?php echo $_SESSION['nLastName']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="email" id="email" value="<?php echo $_SESSION['nEmail']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Confirm Email</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="confirm-email" id="confirm-email" value="<?php echo $_SESSION['nCEmail']; ?>" />
							</div>
						</div>
					</div>
				</div> <!-- / .panel-->

				 <form class="form-horizontal" action="actions/doAddUser.php" method="post">
            	<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Account Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="password" id="password" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Confirm Password</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="confirm-password" id="confirm-password" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Account Type</label>
							<div class="col-sm-10">
								 <select class="form-control" name="AcctType" id="AcctType">
				               		 <?php
				               		 	if($_SESSION["AccountType"] == "ADMIN") {
											$accountArray = array("USHER",  "UC", "ADMIN");
										}
										else if($_SESSION["AccountType"] == "UC") {
											$accountArray = array("USHER",  "UC");
										}

										foreach($accountArray as $value) {
											if ($_SESSION['nAcctType'] == $value) {
												echo "<option selected='selected' value='".$value."'>".$value."</option>";
											} else {
												echo "<option value='".$value."'>".$value."</option>";
											}
										}
									?>
				                </select>
							</div>
						</div>
					</div>
				</div> <!-- /.panel -->

				<div class="form-group">
					<div class="col-sm-12">
						<input class="btn btn-success btn-block" type="submit" value="Add User" name="add-user" id="add-user" />
					</div>
				</div>

	
            </form>

		</div>
	</div>
</div>

<?php
include_once("assets/includes/footer.php");
?>

<!-- 
<legend>College Information</legend>
<label>Class</label>
<select name="year" id="year">
<?php
	// $yearArray = array("Freshman",  "Sophomore", "Junior", "Senior", "Graduate Student", "Staff");
	// foreach($yearArray as $value) {
	// 	if ($_SESSION['nYear'] == $value) {
	// 		echo "<option selected='selected' value='".$value."'>".$value."</option>";
	// 	} else {
	// 		echo "<option value='".$value."'>".$value."</option>";
	// 	}
	// }

	?>
</select><br /><br />
<label>Graduation Year</label><input type="text" name="grad" id="grad" maxlength="4" value="<?php echo $_SESSION['Grad']; ?>" /><br /><br />
<label>College</label>
<select name="college" id="college">
<?php
	// $collegeArray = array("College of Agriculture", "College of Consumer and Family Sciences", "College of Education", "College of Engineering", "College of Liberal Arts", "Krannert School of Management", "College of Pharmacy, Nursing, and Health Sciences", "College of Science", "College of Technology", "School of Veterinary Medicine", "Other");
	// foreach($collegeArray as $value) {
	// 	if ($_SESSION['nCollege'] == $value) {
	// 		echo "<option selected='selected' value='".$value."'>".$value."</option>";
	// 	} else {
	// 		echo "<option value='".$value."'>".$value."</option>";
	// 	}
	// }
	?>
</select><br /><br />
</fieldset>
<fieldset>
<legend>Volunteer Opportunities</legend>
<input type="checkbox" value="1" name="marketing" id="marketing" <?php if($_SESSION['nMarketing'] =='1') { echo 'checked="checked"'; } ?> /> User is interested in being contacted to help with marketing events in exchange for show tickets
<br /><br />
</fieldset> -->