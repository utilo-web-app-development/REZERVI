<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");	
include_once("../../templates/components.php");

include_once("../../templates/auth.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id,$link);
			
?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Ändern der Suchoptionen",$sprache,$link)); ?>.</h2>
    </div>
    <div class="panel-body">
<?php 
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
        <!-- Show message if there is -->
        <?php include_once("../../templates/message.php"); ?>

<form action="./sucheAendern.php" method="post" target="_self">

 <ul class="list-unstyled list-group"  >
    <li class=" list-group-item active" style="margin-bottom: 5px;">
        <?php echo(getUebersetzung("Markieren sie jene Auswahlmöglichkeiten, die bei der Suche zur Verfügung stehen sollen",$sprache,$link)); ?>:
    </li>
     <li style="margin-left: 20px;">
         <label class="label-control">
         <input type="checkbox" name="showParent" value="true"
             <?php
             if (getPropertyValue(SEARCH_SHOW_PARENT_ROOM,$unterkunft_id,$link) == "true"){
                 echo(" checked");
             }
             ?>
         >
         <?php echo(getUebersetzung("Zusammengefasste Zimmer (z. B. Häuser) in Suche gesondert anzeigen.",$sprache,$link)); ?>
         </label>
     </li>
     <?php
     //sprachen anzeigen die aktiviert sind:
     //liefert alle Möglichkeiten, die durch den Benutzer ausgesucht werden können
     $res = getPropertiesSuche($unterkunft_id, $link); //Methode in einstellungenFunctions.php definiert
     while($d = mysqli_fetch_array($res))
     {
     $name = $d["Name"];
     //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
     $aktiviert = isPropertyShown($unterkunft_id,$name,$link); //Methode in einstellungenFunctions.php definiert
     ?>
     <li  style="margin-left: 20px;">
         <label class="label-control">
             <input name="<?php echo($name); ?>" type="checkbox" id="<?php echo($name); ?>" value="true"
                 <?php
                 if($aktiviert){ echo(" checked"); }
                 ?>
             >
             <?php   echo(getUebersetzung($name,$sprache,$link)); ?>

         </label>
     </li>
         <?php
     } //end while-loop
     ?>
     <li  style="margin-left: 20px;">
         <label class="label-control">
             <input name="suchFilter" type="radio" value="filterUnterkunft"
                 <?php
                 if (getPropertyValue(SUCHFILTER_UNTERKUNFT,$unterkunft_id,$link) == "true"){
                     echo(" checked");
                 }
                 ?>
             >
             <?php echo(getUebersetzung("Suche nach Anzahl der Erwachsenen und/oder Kindern auf gesamte Unterkunft einschränken",$sprache,$link)); ?>
         </label>
     </li>
 </ul>

    <div class="row">
        <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
            <button name="aendern" type="submit" class="btn btn-success" id="aendern">
                <span class="glyphicon glyphicon-wrench"></span>
                <?php echo(getUebersetzung("Ändern", $sprache, $link)); ?>
            </button>

        </div>
    </div>
</form>

<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); ?>