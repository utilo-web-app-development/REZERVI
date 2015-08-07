<? session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");	
include_once("../../templates/components.php"); 

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
<?php 
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("�ndern der Suchoptionen",$sprache,$link)); ?>.</p>
<br/>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); } else {echo("class=\"belegt\"");} ?>><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<form action="./sucheAendern.php" method="post" target="_self">
<table class="table">
<tr>
<td>
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <tr>
    <td colspan="2"><?php echo(getUebersetzung("Markieren sie jene Auswahlm�glichkeiten, die bei der Suche zur Verf�gung stehen sollen",$sprache,$link)); ?>:</td>
  </tr>
  <tr>
    <td>
      <input type="checkbox" name="showParent" value="true"			  
	  <?php 
	  if (getPropertyValue(SEARCH_SHOW_PARENT_ROOM,$unterkunft_id,$link) == "true"){
	  	echo(" checked");
	  }
	  ?>
	  >
	</td>
	<td>
      <?php echo(getUebersetzung("Zusammengefasste Zimmer (z. B. H�user) in Suche gesondert anzeigen.",$sprache,$link)); ?>
    </td>
  </tr>		  
  <?php
  //sprachen anzeigen die aktiviert sind: 
  	//liefert alle M�glichkeiten, die durch den Benutzer ausgesucht werden k�nnen
	$res = getPropertiesSuche($unterkunft_id, $link); //Methode in einstellungenFunctions.php definiert
  	while($d = mysql_fetch_array($res))
	{
  	  $name = $d["Name"];
	  //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlm�glichkeiten "angehackelt"
  	  $aktiviert = isPropertyShown($unterkunft_id,$name,$link); //Methode in einstellungenFunctions.php definiert     
    ?>  
      <tr>
        <td><input name="<?php echo($name); ?>" type="checkbox" id="<?php echo($name); ?>" value="true" 
    	<?php
		  if($aktiviert){ echo(" checked"); }
		?>
		>
		</td>
        <td>
	      <?php 
	      	echo(getUebersetzung($name,$sprache,$link));
	      ?>
		</td>
      </tr>
	<?php
  	} //end while-loop
  	?>
  	</table>
  	<br/>
  	<table class="tableColor">  
		<tr>
		  <td>
		      <input name="suchFilter" type="radio" value="filterUnterkunft" 
			  <?php 
			  if (getPropertyValue(SUCHFILTER_UNTERKUNFT,$unterkunft_id,$link) == "true"){
			  	echo(" checked");
			  }
			  ?>
			  >
		      <?php echo(getUebersetzung("Suche nach Anzahl der Erwachsenen und/oder Kindern auf gesamte Unterkunft einschr�nken",$sprache,$link)); ?></td>
	      </tr>
		  <tr>
		    <td>
		      <input type="radio" name="suchFilter" value="filterZimmer"			  
			  <?php 
			  if (getPropertyValue(SUCHFILTER_ZIMMER,$unterkunft_id,$link) == "true"){
			  	echo(" checked");
			  }
			  ?>
			  >
		      <?php echo(getUebersetzung("Suche nach Anzahl der Erwachsenen und/oder Kindern auf einzelne Zimmer einschr�nken",$sprache,$link)); ?>
		    </td>
		  </tr>		  
	</table>
</td>
</tr>
  <tr>
   <td>
 	 <?php 
	 	showSubmitButton(getUebersetzung("�ndern",$sprache,$link));
	?>
	</td>
  </tr>
</table>
</form>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zur�ck",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); ?>