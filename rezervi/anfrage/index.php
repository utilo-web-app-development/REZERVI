<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			rezervi
			daten des gastes aufnehmen
			author: christian osterrieder utilo.eu					
			
			dieser seite muss übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
			Zimmer PK_ID ($zimmer_id)
			Datum: $vonTag,$vonMonat,$vonJahr
				   $bisTag,$bisMonat,$bisJahr			
			
			die seite verwendet anfrage/send.php um das ausgefüllte
			formular zu versenden
*/ 	 

	//Unterkunft-funktionen einbeziehen:
	include_once($root."/include/unterkunftFunctions.php");
	//zimmer-funktionen einbeziehen:
	include_once($root."/include/zimmerFunctions.php");
	//datum-funktionen einbeziehen:
	include_once($root."/include/datumFunctions.php");
	//reservierungs-funktionen
	include_once($root."/include/reservierungFunctions.php");
	//uebersetzer:
	include_once($root."/include/uebersetzer.php");
	include_once($root."/suche/sucheFunctions.php");
	include_once($root."/include/propertiesFunctions.php");
	include_once($root."/include/buchungseinschraenkung.php");
	include_once($root."/include/priceFunctions.inc.php");
	
	//variablen initialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$sprache = getSessionWert(SPRACHE);
	//von left.php und suche/sucheDurchfuehren.php:
	$datumDPv = $_POST["datumVon"];
	$datumDPb = $_POST["datumBis"];
	$datumVAr = convertDatePickerDate($datumDPv);
	$datumBAr = convertDatePickerDate($datumDPb);
	$vonTag = $datumVAr[0];
	$vonMonat = $datumVAr[1];
	$vonJahr = $datumVAr[2];
	$bisTag = $datumBAr[0];
	$bisMonat = $datumBAr[1];
	$bisJahr = $datumBAr[2];

	if (isset($_POST["haustiere"])){
		$haustiere = $_POST["haustiere"];
	}
	else{
		$haustiere = false;
	}
	
	//von suche/sucheDurchfuehren.php:
	if (isset($_POST["anzahlErwachsene"])){
		$anzahlErwachsene = $_POST["anzahlErwachsene"];
	}
	if (isset($_POST["anzahlKinder"])){
		$anzahlKinder = $_POST["anzahlKinder"];
	}
	if (isset($_POST["anzahlZimmer"])){
		$anzahlZimmer = $_POST["anzahlZimmer"];	
	}
	if (isset($_POST["zimmer_ids"])){
		$zimmer_ids = $_POST["zimmer_ids"];
		$vonSuche = true;
	}
	else{
		//von left.php:
		$zimmer_id = $_POST["zimmer_id"];
		if (isset($zimmer_ids)){
			unset($zimmer_ids);
		}
		$anzahlErwachsene = false;
		$vonSuche = false;
	}
	//trotzdem array mit zimmer-ids mitführen, auch wenns nur eines:
	$zi_ids = array();
	if (isset($zimmer_ids) && count($zimmer_ids)>0){
		$zi_ids = $zimmer_ids;
	}
	else{
		$zi_ids[] = $zimmer_id;
	}
	
	$anzahlTage = numberOfDays($vonMonat,$vonTag,$vonJahr,$bisMonat,$bisTag,$bisJahr);
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!-- checken ob formular korrekt ausgefüllt wurde: -->
<script language="JavaScript" type="text/javascript" src="./indexJS.php">
</script>
<?php include_once("../templates/headerB.php");
?>
<div class="container" style="margin-top: 70px;">
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>
            <?php echo(getUebersetzung("Reservierung Anfrage",$sprache,$link));?>
        </h2>
    </div>
    <div class="panel-body">
        <?php

        //wenn anfrage über suche kommt, prüfen ob genug zimmer angeklickt wurden:
        //if ($vonSuche == true && ($anzahlZimmer > count($zimmer_ids))){
        if(false){
            ?>
            <table border="0" class="table">
                <tr>
                    <td><?php echo(getUebersetzung("Sie haben eine Anfrage für ",$sprache,$link));
                        echo($anzahlZimmer);
                        echo(getUebersetzung(" Zimmer gestellt, jedoch nur ",$sprache,$link));
                        echo(count($zimmer_ids));
                        echo(getUebersetzung(" Zimmer ausgewählt. Bitte korrigieren Sie Ihre Anfrage!",$sprache,$link)); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input name="Submit" type="submit" class="button200pxA"
                               onMouseOver="this.className='button200pxB';"
                               onMouseOut="this.className='button200pxA';"
                               onClick="history.back()"
                               value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
                    </td>
                </tr>
            </table>
            <?php
        }
        else {
            ?>
            <?php
            //zuerst mal prüfen ob datum und so passt:
            //variableninitialisierungen:
            $datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
            $datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);

            //wenn nicht ok:
            //1. zimmer ist zu dieser zeit belegt:
            $taken = false;
            if (!isset($zimmer_ids)){
                $taken = isRoomTaken($zimmer_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link);
                //if the room is a parent room, check if the child rooms are taken:
                if (!$taken && hasChildRooms($zimmer_id)){
                    $childs = getChildRooms($zimmer_id);
                    while ($c = mysqli_fetch_array($childs)){
                        $child_zi_id = $c['PK_ID'];
                        $taken =  isRoomTaken($child_zi_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link);
                        if ($taken){
                            break;
                        }
                    }
                }
            }

            if ($taken){

                include_once("./subtemplates/isTaken.php");
                include_once("./subtemplates/backForm.php");
            }
            //2. das datum ist nicht korrekt, das von-datum "höher" als bis-datum
            //mit einem schmäh eine typkonvertierung mit dem +_operator durchführen:
            elseif (isDatumEarlier($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr) == FALSE) {
                ?>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-danger">
                        <?php echo(getUebersetzung("Das Reservierungs-Datum wurde nicht korrekt angegeben!",$sprache,$link)); ?>
                    </div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-warning">
                        <?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?>
                    </div>
                </div>
                <?php include_once("./subtemplates/backForm.php"); ?>
                <?php
            }//ende if datum
            else if ($anzahlTage < 1){
                ?>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-danger">
                        <?php echo(getUebersetzung("Es ist mindestens eine Übernachtung erforderlich",$sprache,$link)); ?>
                    </div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-warning">
                        <?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?>
                    </div>
                </div>
                <?php include_once("./subtemplates/backForm.php"); ?>
                <?php
            }
            else if (isDatumAbgelaufen($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr)){
                ?>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-danger">
                        <?php echo(getUebersetzung("Das gewählte Datum ist bereits abgelaufen.",$sprache,$link)); ?>
                    </div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-warning">
                        <?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?>
                    </div>
                </div>
                <?php include_once("./subtemplates/backForm.php"); ?>
                <?php
            }
            else if ($vonSuche == false && hasActualBuchungsbeschraenkungen($unterkunft_id)
                && !checkBuchungseinschraenkung($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zi_ids)){
                ?>
                <div class="row" style="padding: 10px;">
                    <label>
                        <?php echo getBuchungseinschraenkungText($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zi_ids); ?>
                    </label>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="alert alert-warning">
                        <?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?>
                    </div>
                </div>
                <?php include_once("./subtemplates/backForm.php"); ?>
                <?php
            }
            //wenn datum ok:
            else{

                //berechne den preis falls Überhaupt welche definiert wurden:
                $preis = 0;
                if(isset($zimmer_ids)){
                    foreach($zimmer_ids as $zi_id){
                        $preis += calculatePrice($zi_id,$datumVon,$datumBis);
                    }
                }
                else{
                    $preis = calculatePrice($zimmer_id,$datumVon,$datumBis);
                }

                include_once("./subtemplates/addressForm.php");

            } //ende else - datum ok
        }//ende else zu wenig zimmer ausgewaehlt
        ?>
    </div>
</div>
</div>
</body>
</html>