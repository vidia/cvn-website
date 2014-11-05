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
            $PageTitle = "Export Data";
            include("assets/includes/randomHello.php"); ?>
            <ol class="breadcrumb">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li class="active">Export Data</li>
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

            if ($_SESSION['error'] != '') {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                $_SESSION['error'] = '';
            }
            ?>


            <table class="table table-hover">
                <tr>
                    <td valign="center">All Users<a class="btn btn-default pull-right" href="export-all.php"><i
                                class="fa fa-download"></i> Download</a><br class="clear"/></td>
                </tr>
                <tr>
                    <td valign="center">Users Interested in Marketing<a class="btn btn-default pull-right"
                                                                        href="export-marketing.php"><i
                                class="fa fa-download"></i> Download</a><br class="clear"/></td>
                </tr>
                <tr>
                    <td valign="center">All Users with Amount of Shows and Meetings Attended<a
                            class="btn btn-default pull-right" href="export-points.php"><i class="fa fa-download"></i>
                            Download</a><br class="clear"/></td>
                </tr>
                <tr>
                    <td valign="center">User Attendance for All Shows<a class="btn btn-default pull-right"
                                                                        href="export-allEventAttendance.php"><i
                                class="fa fa-download"></i> Download</a></td>
                </tr>
                <tr>
                    <td valign="center">UC Defaults by UC<a class="btn btn-default pull-right"
                                                            href="export-defaults.php"><i class="fa fa-download"></i>
                            Download</a></td>
                </tr>
                <tr>
                    <td valign="center">User Activity Report<a class="btn btn-default pull-right"
                                                               href="export-activity.php"><i class="fa fa-download"></i>
                            Download</a></td>
                </tr>
                <!--
                <tr><td valign="center"><div class="warning">Not finished</div>User Staff Attendance for Shows<a class="btn btn-default pull-right" href="export-staff.php"><i class="fa fa-download"></i> Download</a></td></tr>
             -->
            </table>
        </div>
    </div>
</div>
<?php
include_once("assets/includes/footer.php");
?>
