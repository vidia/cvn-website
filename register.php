<?php 
include_once("assets/includes/header.php");
include("assets/includes/constants.php"); 
$SQL = "SELECT * FROM Event WHERE ID='".$_GET['ID']."'";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);
?>

<script src="assets/js/datetimepicker_css.js"></script>

<div class="container">
      
      <div class="row">
        <div class="col-lg-12">
          <?php 
          // a random hello
          $helloArray = array("Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey,", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
          $randHello = array_rand($helloArray);
          ?>
          <h1 class="page-header">Register an Account <small>Start ushering today and create an account</small></h1>
          <ol class="breadcrumb">
          	<li><a href="/">Home</a></li>
            <li class="active">Register an Account</li>
          </ol>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-8">
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

			<form class="form-horizontal" enctype="application/x-www-form-urlencoded" action="doRegister.php" method="post">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">General Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label">First Name</label>
							<div class="col-sm-10">
								<input class="form-control" placeholder="John" type="text" name="firstname" id="firstname" value="<?php echo $_SESSION['FirstName']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="lastname" class="col-sm-2 control-label">Last Name</label>
							<div class="col-sm-10">
								<input class="form-control" placeholder="Doe" type="text" name="lastname" id="lastname" value="<?php echo $_SESSION['LastName']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input class="form-control" placeholder="jdoe@purdue.edu" type="email" name="email" id="email" value="<?php echo $_SESSION['Email']; ?>" /> 
							</div>
						</div>

						<div class="form-group">
							<label for="confirm-email" class="col-sm-2 control-label">Confirm Email</label>
							<div class="col-sm-10">
								<input class="form-control" placeholder="jdoe@purdue.edu" type="email" name="confirm-email" id="confirm-email" value="<?php echo $_SESSION['CEmail']; ?>" />
							</div>
						</div>
					</div>
				</div> <!-- /.panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Account Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="password" id="password" />
							</div>
						</div>

						<div class="form-group">
							<label for="confirm-password" class="col-sm-2 control-label">Confirm Password</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="confirm-password" id="confirm-password" />
							</div>
						</div>
					</div>
				</div>




				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">College Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="year" class="col-sm-2 control-label">Class</label>
							<div class="col-sm-10">
								 <select class="form-control" name="year" id="year">
					                 <?php
										$yearArray = array("Freshman",  "Sophomore", "Junior", "Senior", "Graduate Student", "Staff");
										foreach($yearArray as $value) {
											if ($_SESSION['Year'] == $value) {
												echo "<option selected='selected' value='".$value."'>".$value."</option>";
											} else {
												echo "<option value='".$value."'>".$value."</option>";
											}
										}

										?>
					      		</select>
							</div>
						</div>

						<div class="form-group">
							<label for="grad" class="col-sm-2 control-label">Graduation Year</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="grad" maxlength="4" id="grad" value="<?php echo $_SESSION['Grad']; ?>" />
								<div class="help-block">Example: 2016</div>
							</div>
						</div>

						<div class="form-group">
							<label for="college" class="col-sm-2 control-label">College</label>
							<div class="col-sm-10">
								<select class="form-control" name="college" id="college">
				                    <?php
									$yearArray = array("College of Agriculture", "College of Consumer and Family Sciences", "College of Education", "College of Engineering", "College of Liberal Arts", "Krannert School of Management", "College of Pharmacy, Nursing, and Health Sciences", "College of Science", "College of Technology", "School of Veterinary Medicine", "Other");
									foreach($yearArray as $value) {
										if ($_SESSION['College'] == $value) {
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

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Volunteer Opportunities</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="confirm-password" class="col-sm-2 control-label">Options</label>
							<div class="col-sm-10">
								<div class="checkbox">
								    <label>
									    <input type="checkbox" value="1" name="marketing" id="marketing" <?php if($_SESSION['Marketing'] =='1') { echo 'checked="checked"'; } ?> /> Yes, I am interested in being contacted to help with marketing events in exchange for show tickets							      
								    </label>
						    	</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button class="btn btn-success btn-block" type="submit" name="register" id="register" />Register Now</button>
					</div>
				</div>
            </form>
           </div>

           <div class="col-sm-4">
			<img src="assets/images/register.jpg" class="img-responsive img-thumbnail" alt="Register today for great rewards!" />
			<h2>Join Today</h2>
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
       </div>

<?php 
include_once("assets/includes/footer.php");
?>