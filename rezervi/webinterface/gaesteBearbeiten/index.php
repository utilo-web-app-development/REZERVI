<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			startseite zur wartung der reservierung für den benutzer
			author: christian osterrieder utilo.eu						
			
			dieser seite muss übergeben werden:
			Benutzer PK_ID $benutzer_id
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<script language="JavaScript">
    <!--
    function setVal() {
        if (document.listeAnzeigen.anrede_val.checked) {
            document.suche.anrede_val.value = "true";
        }
        if (document.listeAnzeigen.vorname_val.checked) {
            document.suche.vorname_val.value = "true";
        }
        if (document.listeAnzeigen.nachname_val.checked) {
            document.suche.nachname_val.value = "true";
        }
        if (document.listeAnzeigen.strasse_val.checked) {
            document.suche.strasse_val.value = "true";
        }
        if (document.listeAnzeigen.plz_val.checked) {
            document.suche.plz_val.value = "true";
        }
        if (document.listeAnzeigen.ort_val.checked) {
            document.suche.ort_val.value = "true";
        }
        if (document.listeAnzeigen.land_val.checked) {
            document.suche.land_val.value = "true";
        }
        if (document.listeAnzeigen.email_val.checked) {
            document.suche.email_val.value = "true";
        }
        if (document.listeAnzeigen.tel_val.checked) {
            document.suche.tel_val.value = "true";
        }
        if (document.listeAnzeigen.fax_val.checked) {
            document.suche.fax_val.value = "true";
        }
        if (document.listeAnzeigen.anmerkung_val.checked) {
            document.suche.anmerkung_val.value = "true";
        }
        return true;
    }
    //-->
</script>
<?php
//passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)){ ?>


<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo getUebersetzung("G&auml;ste-Daten abfragen und bearbeiten", $sprache, $link) ?></h2>
    </div>
    <div class="panel-body">
        <div class="alert alert-info" role="alert">
            <label style="margin-bottom: 0;"><?php echo(getUebersetzung("Bitte wählen Sie aus, welche Daten der Gäste angezeigt werden sollen", $sprache, $link)); ?></label>
        </div>
        <form action="./gaesteListe/index.php" method="post" name="listeAnzeigen" target="_self"
              onSubmit="return chkFormular();" class="form-horizontal">

            <div class="row">
                <div class="col-sm-12">
                    <input name="anrede_val" type="checkbox" id="anrede_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Anrede", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input name="vorname_val" type="checkbox" id="vorname_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Vorname", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input name="nachname_val" type="checkbox" id="nachname_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Nachname", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input name="strasse_val" type="checkbox" id="strasse_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="plz_val" type="checkbox" id="plz_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("PLZ", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <input name="ort_val" type="checkbox" id="ort_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Ort", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="land_val" type="checkbox" id="land_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Land", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="email_val" type="checkbox" id="email_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="tel_val" type="checkbox" id="tel_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="fax_val" type="checkbox" id="fax_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="sprache_val" type="checkbox" id="sprache_val" value="true" checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("bevorzugte Sprache", $sprache, $link)); ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input name="anmerkung_val" type="checkbox" id="anmerkung_val" value="true"
                                              checked>
                    <label class="control-label">
                        <?php echo(getUebersetzung("Anmerkungen", $sprache, $link)); ?>
                    </label>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
                    <button type="submit" class="btn btn-primary" >
                        <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                        &nbsp;<?php echo(getUebersetzung("Gästeliste anzeigen", $sprache, $link)); ?>
                    </button>
                </div>
            </div>

    </form>
        <div class="row">
            <hr>
        </div>
    <div  class="row">
         <div class="col-sm-offset-9 col-sm-3">
             <a class="btn btn-primary" href="./gastAnlegen/index.php" style="float: right;">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                 &nbsp;<?php echo(getUebersetzung("neuen Gast anlegen", $sprache, $link)); ?>
             </a>
         </div>
    </div>

    <?php } //ende else
    ?>

</div>
</div>
</body>
</html>
