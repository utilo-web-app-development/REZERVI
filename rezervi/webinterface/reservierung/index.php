<?php
//session_save_path('/Users/emreerden/Desktop/temp');
session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/einstellungenFunctions.php");
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);

//datums-funktionen einbinden:
include_once("../../include/datumFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/reseller/reseller.php");
//funktions einbinden:


include_once("../../include/reservierungFunctions.php");
include_once("../../include/gastFunctions.php");

include_once("./rightHelper.php");
include_once("../../leftHelper.php");

include_once("../templates/headerA.php");

?>
<title>Zimmerreservierungsplan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>

<script language="JavaScript" type="text/javascript" src="../../templates/changeForms.js">
</script>
<!--<script language="JavaScript" type="text/javascript" src="./leftJS.js">-->
<!--</script>-->
<!--<script language="JavaScript" type="text/javascript" src="./rightJS.js">-->
<!--</script>-->
<?php include_once("../templates/headerB.php"); ?>

<?php include_once("../templates/bodyA.php"); ?>
<div class="row" ng-app="rezervierungApp" ng-controller="rezervierungController">
    <div class="col-sm-5">

        <?php include_once("left.php"); ?>
    </div>
    <div class="col-sm-7">
        <?php include_once("right.php"); ?>
    </div>
</div>
</body>
</html>