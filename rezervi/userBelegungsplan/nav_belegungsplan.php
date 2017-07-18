<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>
<?php
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);

$sprache = getSessionWert(SPRACHE);
$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA, $unterkunft_id, $link);

//falls keine zimmer_id ausgewählt wurde, das erste gefundene zimmer nehmen:
if (!isset($zimmer_id) || $zimmer_id == "" || empty($zimmer_id)) {
    $query = "
			select 
			PK_ID 
			from
			Rezervi_Zimmer
			where
			FK_Unterkunft_ID = '$unterkunft_id' 
			ORDER BY 
			Zimmernr";

    $res = mysqli_query($link, $query);
    if (!$res) {
        echo("Anfrage $query scheitert.");
    }

    $d = mysqli_fetch_array($res);
    $zimmer_id = $d["PK_ID"];
}

//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
if (!isset($jahr) || $jahr == "" || empty($jahr)) {
    $jahr = getTodayYear();
}

//falls kein monat ausgewählt wurde, das aktuelle monat verwenden:
if (!isset($monat) || $monat == "" || empty($monat)) {
    $monat = getTodayMonth();
}
//should the reservation state be shown?
$showReservation = getPropertyValue(SHOW_RESERVATION_STATE, $unterkunft_id, $link);
if ($showReservation != "true") {
    $showReservation = false;
}
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand" >
                <?php echo(getUebersetzung("Belegungsplan", $sprache, $link)); ?>
            </span>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <!--<li>
                    <a onclick="showReservierungAendernDialog(null,null,null,null,null,null,null);">
                        <?php /*echo(getUebersetzung("Reservierung ändern", $sprache, $link)); */?>
                    </a>
                </li>-->

                <li class="dropdown">
                    <input type="hidden" name="zimmer_id" id="zimmer_id" value="<?php echo $zimmer_id;?>" />
                    <input type="hidden" name="unterkunft_id" id="unterkunft_id" value="<?php echo unterkunft_id;?>" />
                    <input type="hidden" name="saAktiviert"  id="saAktiviert" value="<?php echo saAktiviert;?>" />
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo(getUebersetzung("Zimmer Wählen", $sprache, $link)); ?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" id="zimmers">
                        <li >
                            <a onclick="zimmer_idChanged({{zimmer.zimmerid}},{{zimmer.zimmerartnr}});" id="{{zimmer.zimmerid}}">{{zimmer.zimmerartnr}}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php include_once ("subtemplates/navJS.php");?>