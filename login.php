<?php
ob_start();
session_start();
include_once("assets/includes/header.php");
include("assets/includes/constants.php");
$SQL = "SELECT * FROM Event WHERE ID='" . $_GET['ID'] . "'";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);

if (!empty($_SESSION["Name"])) {
    // this means that someone is already logged, redirec them to dashboard
    header("Location: dashboard.php");
}


?>

<script src="assets/js/datetimepicker_css.js"></script>

<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Log In
                <small>Gain access to sign up for events and manage your profile</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active">Log In</li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($_SESSION['success'] != '') {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                $_SESSION['success'] = '';
            }

            if ($_GET["r"] == "auth") {
                echo "<div class='alert alert-danger'><h4>Houston, we have a problem.</h4><p>You are not authorized to view that page. Please make sure you are logged in. If you believe you are seeing this message in error, please email us at <a href='mailto:cvn2@purdue.edu' class='alert-link'>cnv2@purdue.edu</a>.</p></div>";
            }

            if ($_GET["r"] == "mm") {
                echo "<div class='alert alert-danger'><h4>Houston, we have a problem.</h4><p>The site is currently in maintenance mode, you are not authorized to log in.</p></div>";
            }

            if ($_SESSION['error'] != '') {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                $_SESSION['error'] = '';
            }
            ?>

            <form class="form-horizontal" enctype="application/x-www-form-urlencoded" action="doLogin.php"
                  method="post">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="username" id="username"
                               value="<?php echo $_SESSION['Username']; ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-6">
                        <input class="form-control" type="password" name="password" id="password"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label"></label>

                    <div class="col-sm-6">
                        <button type="submit" name="login" id="login" class="btn btn-success">Log In</button>
                        <small><a style="cursor:pointer;" data-toggle="modal" data-target="#myModal">Forgot your
                                password?</a></small>
                    </div>
                </div>


            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Recover Account</h4>
                    </div>
                    <div class="modal-body">
                        <p>To recover your account, please type in your email address with which you've registered and
                            check your email.</p>

                        <form class="form-horizontal" enctype="application/x-www-form-urlencoded" action="doRecover.php"
                              method="post">
                            <div class="form-group">
                                <label for="resetEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-6">
                                    <input placeholder="jdoe@purdue.edu" class="form-control" type="text"
                                           name="resetEmail" id="resetEmail"/><br/><br/>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Recover Account</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->






        <?php
        include_once("assets/includes/footer.php");
        ?>
