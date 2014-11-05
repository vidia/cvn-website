<?php

include_once("assets/includes/verify.php");
include_once("assets/includes/header.php");
include_once("assets/includes/constants.php");


?>

<div class="container">
<div class="row">
    <div class="col-lg-12">

        <?php
        $PageTitle = "Dashboard";
        include("assets/includes/randomHello.php"); ?>

        <ol class="breadcrumb">
            <li class="active">Dashboard</li>
        </ol>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12 hidden-xs">
        <img src="assets/images/banner.jpg" class="img-thumbnail img-responsive"/>
    </div>
</div>
<!-- /.row -->

<!-- Service Images -->
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
    <h2 class="page-header">Manage Your Events</h2>
</div>

<div class="col-sm-4">
    <h3><i class="fa fa-star-o"></i> Available Events</h3>

    <p>Below is a list of events that you can request to usher. Simply click the <span
            class='label label-success'><i class="fa fa-plus-circle"></i> Request Event</span> button and your name
        will be submitted to usher the event.</p>
    <?php
    $sqlAvailable = "SELECT E.ID AS ID, E.UpTime AS UpTime, E.EndTime AS EndTime, E.Name AS Name, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, E.Type AS Type, E.Description AS Description, Atten.RequestStatus AS RequestStatus FROM Event E LEFT JOIN (SELECT * FROM Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "') AS Atten ON E.ID = Atten.EventID ORDER BY E.CallTime ASC";
    $resultAvailable = mysql_query($sqlAvailable);
    $counter = 0;
    while ($row = mysql_fetch_array($resultAvailable)) {
        ($row["Type"] == "Show") ? $type = "<small><i rel='tooltip' title='Show' class='fa fa-magic'></i></small>" : $type = "<small><i rel='tooltip' title='Meeting' class='fa fa-users'></i></small>";
        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s") && $row['RequestStatus'] == '') {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                        <span rel="tooltip" title="Points offered for this event."
                              class="pull-right badge"><?= $row["Point"] ?></span>
                    <h4 class="list-group-item-heading"><?= $type . " " . $row["Name"] ?></h4>
                </div>

                <div class="panel-body">
                    <p><i class="fa fa-clock-o"></i> <?= date("F j, Y, g:i a", strtotime($row['CallTime'])) ?>
                        <button type="button" class="btn btn-sm btn-default pull-right" data-toggle="collapse"
                                data-target="#desc<?= $counter; ?>">
                            <i class="fa fa-eye"></i> Toggle Description
                        </button>
                        <br/>
                        <i class="fa fa-building-o"></i> <?= $row["Location"] ?></p>

                    <div id="desc<?= $counter; ?>" class="collapse">
                        <blockquote>
                            <?= $row["Description"] ?>
                        </blockquote>
                    </div>
                    <p><a class="btn btn-sm btn-block btn-success"
                          href="doRequest.php?id=<?php echo $row['ID']; ?>"><i class='fa fa-plus-circle'></i>
                            Request Event</a></p>
                </div>
            </div>

            <?php
            $counter++;
        } // end if
    } // end while
    ?>
</div>

<div class="col-sm-4">
    <h3><i class="fa fa-star-half-o"></i> Requested Events</h3>

    <p>Below is a list of events you've requested to usher. A few days before the event, the Usher Coordinator will
        choose the ushers for a show based on point total.</p>
    <?php
    $sqlRequested = "SELECT E.ID AS ID, E.Name AS Name, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, UpTime, EndTime, E.Type AS Type, E.Description AS Description FROM Event E, Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "' AND E.ID=A.EventID AND A.RequestStatus='Requested' ORDER BY E.CallTime ASC";
    $resultRequested = mysql_query($sqlRequested);
    $counter = 0;
    while ($row = mysql_fetch_array($resultRequested)) {
        ($row["Type"] == "Show") ? $type = "<small><i rel='tooltip' title='Show' class='fa fa-magic'></i></small>" : $type = "<small><i rel='tooltip' title='Meeting' class='fa fa-users'></i></small>";
        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s") && $row['RequestStatus'] == '') {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                        <span rel="tooltip" title="Points offered for this event."
                              class="pull-right badge"><?= $row["Point"] ?></span>
                    <h4 class="list-group-item-heading"><?= $type . " " . $row["Name"] ?></h4>
                </div>
                <div class="panel-body">
                    <p><i class="fa fa-clock-o"></i> <?= date("F j, Y, g:i a", strtotime($row['CallTime'])) ?>
                        <button type="button" class="btn btn-sm btn-default pull-right" data-toggle="collapse"
                                data-target="#descRequested<?= $counter; ?>">
                            <i class="fa fa-eye"></i> Toggle Description
                        </button>
                        <br/>
                        <i class="fa fa-building-o"></i> <?= $row["Location"] ?></p>

                    <div id="descRequested<?= $counter; ?>" class="collapse">
                        <blockquote>
                            <?= $row["Description"] ?>
                        </blockquote>
                    </div>

                    <p><a class="btn btn-sm btn-block btn-danger"
                          href="doCancelRequest.php?id=<?php echo $row['ID']; ?>"><i class='fa fa-minus-circle'></i>
                            Cancel Request</a></p>
                </div>
            </div>

            <!--   <div class="event">
                  <?php echo $row['Name']; ?></div>
                               <div class="toggle-container">
                                <div class="event-name"><strong>Name:</strong> <?php echo $row['Name']; ?></div>
                                  <div class="event-time"><strong>Call Time:</strong> <?php echo date("F j, Y, g:i a", strtotime($row['CallTime'])); ?></div>
                                  <div class="event-location"><strong>Location:</strong> <?php echo $row['Location']; ?></div>
                                  <div class="event-points">This <u><?php echo $row['Type']; ?></u> is worth <u><?php echo $row['Point']; ?></u> points.</div>
                                  <div class="event-description"><strong>Description:</strong> <br /><?php echo $row['Description']; ?></div>
                                  <br />
                                <a class="request" href="doRequest.php?id=<?php echo $row['ID']; ?>">Request Event</a>
                               </div> -->
            <?php
            $counter++;
        } // end if
    } // end while
    ?>
</div>

<div class="col-sm-4">
    <h3><i class="fa fa-star"></i> Scheduled Events</h3>

    <p>Below is a list of events that you are scheduled to usher. You can cancel your attendance up to 48 hours
        before a show with no point deduction. <a href="http://www.purduecvn.com/resources/">Learn more about
            points</a>.</p>
    <?php
    $sqlScheduled = "SELECT E.Name AS Name, UpTime, EndTime, E.ID AS ID, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, E.Type AS Type, E.Description AS Description  FROM Event E, Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "' AND E.ID=A.EventID AND A.RequestStatus='Ushering' AND E.CallTime >= '" . date("Y-m-d H:i:s") . "' ORDER BY RequestDate DESC";
    $resultScheduled = mysql_query($sqlScheduled);
    $counter = 0;
    while ($row = mysql_fetch_array($resultScheduled)) {
        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s")) {
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                        <span rel="tooltip" title="Points offered for this event."
                              class="pull-right badge"><?= $row["Point"] ?></span>
                    <h4 class="list-group-item-heading"><?= $type . " " . $row["Name"] ?></h4>
                </div>

                <div class="panel-body">
                    <p><i class="fa fa-clock-o"></i> <?= date("F j, Y, g:i a", strtotime($row['CallTime'])) ?>
                        <button type="button" class="btn btn-sm btn-default pull-right" data-toggle="collapse"
                                data-target="#descScheduled<?= $counter; ?>">
                            <i class="fa fa-eye"></i> Toggle Description
                        </button>
                        <br/>
                        <i class="fa fa-building-o"></i> <?= $row["Location"] ?></p>

                    <div id="descScheduled<?= $counter; ?>" class="collapse">
                        <blockquote>
                            <?= $row["Description"] ?>
                        </blockquote>
                    </div>

                    <p><a class="btn btn-sm btn-block btn-danger"
                          href="doCancelRequest.php?id=<?php echo $row['ID']; ?>"><i class='fa fa-minus-circle'></i>
                            Cancel Attendance</a></p>
                </div>
            </div>

            <?php
            $counter++;
        }
    } // end while
    ?>


    <h3><i class="fa fa-times"></i> Cut Events</h3>

    <p>Below is a list of events that you have been cut from. Being cut means you are on a waiting list in case
        otther ushers drop the show. <a href="http://www.purduecvn.com/resources/">Learn more about being cut</a>.
    </p>
    <?php
    $sqlScheduled = "SELECT E.Name AS Name, UpTime, EndTime, E.ID AS ID, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, E.Type AS Type, E.Description AS Description  FROM Event E, Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "' AND E.ID=A.EventID AND A.RequestStatus='Cut' AND E.CallTime >= '" . date("Y-m-d H:i:s") . "' ORDER BY RequestDate DESC";
    $resultScheduled = mysql_query($sqlScheduled);
    $counter = 0;
    while ($row = mysql_fetch_array($resultScheduled)) {
        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s")) {
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                        <span rel="tooltip" title="Points offered for this event."
                              class="pull-right badge"><?= $row["Point"] ?></span>
                    <h4 class="list-group-item-heading"><?= $type . " " . $row["Name"] ?></h4>
                </div>

                <div class="panel-body">
                    <p><i class="fa fa-clock-o"></i> <?= date("F j, Y, g:i a", strtotime($row['CallTime'])) ?>
                        <button type="button" class="btn btn-sm btn-default pull-right" data-toggle="collapse"
                                data-target="#descScheduled<?= $counter; ?>">
                            <i class="fa fa-eye"></i> Toggle Description
                        </button>
                        <br/>
                        <i class="fa fa-building-o"></i> <?= $row["Location"] ?></p>

                    <div id="descScheduled<?= $counter; ?>" class="collapse">
                        <blockquote>
                            <?= $row["Description"] ?>
                        </blockquote>
                    </div>

                    <p><a class="btn btn-sm btn-block btn-danger"
                          href="doCancelRequest.php?id=<?php echo $row['ID']; ?>"><i class='fa fa-minus-circle'></i>
                            Cancel Attendance</a></p>
                </div>
            </div>

            <?php
            $counter++;
        }
    } // end while
    ?>


</div>
</div>
<!-- /.row -->
</div><!-- /.container -->

<?php include_once("assets/includes/footer.php") ?>



