<?php
include_once ("./include.php");
include_once("../templates/headerA.php");

?>
<title>Zimmerreservierungsplan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
</script>
<?php include_once("../templates/headerB.php"); ?>

<?php include_once("../templates/bodyA.php"); ?>


    <?php include_once("./nav_belegungsplan.php"); ?>
    <?php
    if ($error == false && $error != null)
    {
        ?>
        <div class="panel panel-danger">
            <div class="panel-body">
                <div class="alert alert-success">
                    <?php echo $message1; ?>
                    <?php echo $message2; ?>
                </div>
            </div>
        </div>
        <?php
    } ?>

    <?php include_once ("./full_year.php"); ?>

<?php include_once("../templates/end.php"); ?>