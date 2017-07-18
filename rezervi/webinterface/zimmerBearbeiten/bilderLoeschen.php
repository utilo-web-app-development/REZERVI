<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			hochladen eines bilder fuer ein zimmer
			author: coster
			date: 18.8.05
*/

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/uebersetzer.php");
	include_once("../../include/bildFunctions.php");
	include_once("../../include/zimmerFunctions.php");	
	include_once("../templates/components.php"); 

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$sprache = getSessionWert(SPRACHE);
	$limit = 5; //limit wie viele bilder pro seite anzeigen
	if (isset($_POST["index"]) && $_POST["index"] != ""){
		$index = $_POST["index"];
	}
	else{
		$index = 0;
	}

$nachricht_alert = $_POST['nachricht_alert'];
$fehler_alert = $_POST['fehler_alert'];
			
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm('<?php echo(getUebersetzung("Bild wirklich löschen?",$sprache,$link)); ?>'); 	    
	    }
	    //-->
</script>
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><?php echo(getUebersetzung("Bilder für Zimmer/Appartement/Wohnung/etc. löschen",$sprache,$link)); ?></h3>
            </div>
            <div class="panel-body">
                <?php
                if (isset($nachricht) && $nachricht != ""){
                    ?>

                        <div
                            <?php
                            if ($fehler == true) {
                                ?>
                                class="alert alert-danger"
                                <?php
                            }
                            else {
                                ?>
                                class="alert alert-success"
                                <?php
                            }
                            ?>
                        ><?php echo($nachricht); ?>
                        </div>

                    <?php
                }
                ?>

                <?php
                if (isset($nachricht_alert) && $nachricht_alert != ""){
                ?>

                <div class="alert
                            <?php
                if ($fehler == true) {
                ?>
                                alert-danger"
                    <?php
                    }
                    else {
                    ?>
                     alert-success"
                <?php
                }
                ?>
                >
                <?php echo($nachricht_alert); ?>
            </div>

            <?php
            }
            ?>


            <div class="row" style="border-bottom: 1px darkgray solid; ">
                    <div class="col-sm-4" >
                        <label>
                            <?php echo(getUebersetzung("Bild",$sprache,$link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <label>
                            <?php echo(getUebersetzung("Zimmer",$sprache,$link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <label>
                            <?php echo(getUebersetzung("Beschreibung",$sprache,$link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <label>
                            <?php echo(getUebersetzung("löschen",$sprache,$link)); ?>
                        </label>
                    </div>
                </div>

                <?php
                $res = getAllPicturesFromUnterkunftWithLimit($unterkunft_id,$limit,$index,$link);
                while ($d=mysqli_fetch_array($res)){
                    $bild = $d["Pfad"];
                    $zimmer = $d["Zimmernr"];
                    $description = $d["Beschreibung"];
                    ?>
                    <div class="row" style="border-bottom: 1px darkgray solid; padding-top:10px;padding-bottom:10px;" >
                        <div class="col-sm-4">
                            <img class="img-responsive" src="<?php echo($bild); ?>" />
                        </div>
                        <div class="col-sm-3">
                            <?php echo($zimmer); ?>
                        </div>
                        <div class="col-sm-3">
                            <?php echo($description); ?>
                        </div>
                        <div>
                            <form action="./bilderLoeschenDurchf.php"
                                  method="post" name="zimmerloeschen<?php echo($d["PK_ID"]); ?>"
                                  target="_self" onSubmit="return sicher()"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="bilder_id" value="<?php echo($d["PK_ID"]); ?>"/>
                                <input type="hidden" name="index" value="<?php echo($index); ?>"/>
                                <button name="Submit" type="submit" id="Submit" class="btn btn-danger">
                                    <?php echo(getUebersetzung("Bild löschen",$sprache,$link)); ?>
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                    <?php
                    if (($index - $limit) > -1){
                        ?>
                        <div class="col-sm-12" style="text-align: right;">
                            <form action="./bilderLoeschen.php" method="post" name="zurueck" target="_self" enctype="multipart/form-data">
                                <input name="index" type="hidden" value="<?php echo($index-$limit); ?>"/>
                                <button class="btn btn-primary" type="submit">
                                    <?php echo getUebersetzung("zurückblättern",$sprache,$link); ?>
                                </button>

                            </form>
                        </div>
                        <?php
                    }
                    if (($index + $limit) < getAnzahlBilder($unterkunft_id,$link)){
                        ?>
                        <div class="col-sm-12" style="text-align: right;">
                            <form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
                                <input name="index" type="hidden" value="<?php echo($index+$limit); ?>"/>
                                <button class="btn btn-primary" type="submit">
                                    <?php echo getUebersetzung("weiterblättern",$sprache,$link); ?>
                                </button>
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        <a href="./index.php" class="btn btn-default">
                            <?php echo getUebersetzung("zurück",$sprache,$link);?>
                        </a>
                        <a href="../index.php" class="btn btn-primary">
                            <span class="glyphicon glyphicon-home"></span>
                            <?php echo getUebersetzung("Hauptmenü",$sprache,$link);?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>   
 <?php include_once("../templates/end.php"); ?>
