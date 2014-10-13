<?php
session_start();
ob_start();
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include("assets/includes/constants.php");

if($_SESSION["AccountType"] != "ADMIN") {
  header("Location: dashboard.php");
}
?>

<script type="text/javascript">
function Verify_Delete()
{
    var r=confirm("Are you sure you would like to delete the event. It will also delete any attendances related to this event?");

    if (r==true)
    {
        return true;
    }
    else
    {
        return false;
    }
}
</script>


<div class="container">

      <div class="row">
        <div class="col-lg-12">
          <?php
          // a random hello
          $helloArray = array("Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey,", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
          $randHello = array_rand($helloArray);
          ?>
          <h1 class="page-header">Season Manager <small><?= $helloArray[$randHello] . " " . $_SESSION["Name"] . " <a href='my-account.php#breakdown' rel='tooltip' title='Total points' class='label label-info'>" . $_SESSION["Points"] . "</a>"; ?></small></h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Season Manager</li>
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

            <div class="row">
            <div class="col-md-5">
            <h3>Create a New Season</h3>

              <form class="form-inline" role="form" method="post" action="doEditSeason.php">
                <div class="form-group">
                  <label class="sr-only" for="season">Season</label>
                  <input type="text" class="form-control" name="seasonName" value="<?= $season["Season"]?>">
                  <input type="hidden" class="form-control" name="action" value="add">
                </div>
                <button action="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Season</button>
              </form>

              <h3>View Current & Future Seasons</h3>


              <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Current</th>
                  <th style="width:88%">Season</th>
                  <th>Admin</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $sql = "SELECT SeasonID FROM Season WHERE Current=1";
                $result = mysql_query($sql) or die(mysql_error());
                $currentSeason = mysql_fetch_array($result);

                $sql = "SELECT * FROM Season WHERE SeasonID>=" . $currentSeason["SeasonID"];
                $result = mysql_query($sql);
                while($season = mysql_fetch_array($result)) :
              ?>
                <tr>
                  <td style="text-align: center; vertical-align: middle;"><?php if($season["Current"] == 1) { echo "<i class='fa fa-star'></i>"; } ?></td>
                  <td>
                  <form class="form-inline" role="form" method="post" action="doEditSeason.php">
                    <div class="form-group">
                      <label class="sr-only" for="season">Season</label>
                      <input type="text" class="form-control" name="seasonName" value="<?= $season["Season"]?>">
                      <input type="hidden" class="form-control" name="seasonID" value="<?= $season["SeasonID"]?>">
                      <input type="hidden" class="form-control" name="action" value="edit">
                    </div>
                    <button action="submit" class="btn btn-default"><i class="fa fa-edit"></i></button>
                  </form>



                  </td>
                  <td><a class="btn btn-danger disabled"><i class="fa fa-trash-o"></i></a>
                      <!--<a href="doEditSeason.php?action=delete&id=<?= $season["SeasonID"]?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>-->
                  </td>
                </tr>
              <? endwhile; ?>
              </tbody>
              </table>
            </div>

            <div class="col-md-7">
              <div class="well well-sm">
                <h3>Did You Know? <strong>Seasons</strong></h3>
                <p>Seasons are periods of times designated by the CVN Executive Team. As of August 2014, a "Season" consists of one semester.</p>
                <p>Currently, point totals are affected by seasons. Points are awarded to ushers based on their last season's activity. Ushers receive one tenth of their previous season's point total rounded up to the nearest ones value.</p>
                <p>You cannot modify previous seasons. In addition, the ability to delete seasons is deactivated. Contact your <a href="mailto:kenny@digital-inflection.com">webmaster</a> to delete a season.</p>
                <p>To change the current season, visit the <a href="event-admin.php">Event Administrator</a>.</p>
            </div>
            </div>











<?php
include_once("assets/includes/footer.php");
?>