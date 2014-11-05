<div class="container">

    <hr>

    <footer>
        <div class="row">
            <div class="col-lg-12">
                <?php
                if ($_SESSION["AccountType"] == "ADMIN") {
                    $at = " | <i class='fa fa-star'></i> You are logged in as an <strong>administrator</strong>.";
                } else if ($_SESSION["AccountType"] == "UC") {
                    $at = " | <i class='fa fa-star-o'></i> You are logged in as an <strong>Usher Coordinator</strong>.";
                }
                ?>
                <p>Copyright &copy; <a href="http://purduecvn.com">Convocations Voice Network</a><?= date("Y") ?> | <a
                        href="http://goo.gl/forms/tVmrUh6Sni">Feedback form</a><?= $at ?></p>
            </div>
        </div>
    </footer>

</div><!-- /.container -->

<!-- JavaScript -->
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/modern-business.js"></script>

<script>
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
    $(function () {
        $("[rel='popover']").popover();
    });
</script>


</body>
</html>
