<?php session_start();
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include_once("assets/includes/constants.php");  

$SQL = "SELECT * FROM Email";
$result = mysql_query($SQL);

?>

<script src="assets/js/datetimepicker_css.js"></script>
<div class="container">
      <div class="row">
        <div class="col-lg-12">
	<?php
	$PageTitle = "Manage Emails";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Manage Emails</li>
          </ol>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="confirmation-email.php">Send Confirmation Email</a></li>
                <?php 
                while($email = mysql_fetch_array($result)) {
                    if($email["ID"] == (int) $_GET["ID"]) { ?>
                        <li class="active"><a href="edit-email.php?ID=<?= $email["ID"]?>"><?= $email["Email_Name"]?></a></li>
                    <?php
                    }
                    else { ?>
                        <li><a href="edit-email.php?ID=<?= $email["ID"]?>"><?= $email["Email_Name"]?></a></li>
                    <?php
                    } //end else
                } // end while
                ?>
            </ul>
        </div>
        <div class="col-lg-9">
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

           <?php 
            if(!empty($_GET["ID"])) {
    			$SQL = "SELECT * FROM Email WHERE ID='". (int) $_GET['ID']."'";
    			$result = mysql_query($SQL);
    			while($row = mysql_fetch_array($result)) { ?>
                
                <form class="form-horizontal" action="actions/doEditEmail.php" method="post">

                <div class="form-group">
                    <label for="Email_Name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                         <input class="form-control disabled" type="text" disabled="disabled" name="Email_Name" id="Email_Name" value="<?php echo $row['Email_Name']; ?>" />
                    </div>
                </div>

                 <div class="form-group">
                    <label for="Email_Subject" class="col-sm-2 control-label">Subject</label>
                    <div class="col-sm-10">
                         <input class="form-control" type="text" name="Email_Subject" id="Email_Subject" value="<?php echo $row['Email_Subject']; ?>" />
                    </div>
                </div>


                 <div class="form-group">
                    <label for="Email_Body" class="col-sm-2 control-label">Subject</label>
                    <div class="col-sm-10">
                         <textarea class="form-control"name="Email_Body" rows="10" id="Email_Body"><?php echo $row['Email_Body']; ?></textarea>
                         <div class="help-block"><span style="cursor: pointer;" rel="popover" title="Allowed Variable Tags" data-placement="bottom" data-html="true" data-content="{{usher name}}<br />{{usher email}}<br />{{event name}}<br />{{event time}}<br />{{event place}}<br />{{event date}}<br />{{event uc}}<br />{{Points}}<br />{{special instr}}<br />{{event uc name}}<br />{{meeting loc}}" class="label label-info"><i class="fa fa-info-circle"></i> Allowed Tags</span></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                         <input type="submit" class="btn btn-success btn-block" name="submit-email" id="submit-email" value="Edit Email"/>
                    </div>
                </div>
                    <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']; ?>" />
                </form>

                <?php
    			} // end while
            } // end if empty
            else {
                echo "<div class='alert alert-info'>Select an email from the left to get started. Or <a href='confirmation-email.php' class='alert-link'>send a confirmation email</a>.</div>";
            }
			?>

        </div>
    </div>


<?php
include_once("assets/includes/footer.php");
?>
