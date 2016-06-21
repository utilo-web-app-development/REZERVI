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

//datenbank öffnen:
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
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
 <div class="panel panel-default">
  <div class="panel-body">
<h1><?php echo(getUebersetzung("Ändern der Suchoptionen",$sprache,$link)); ?>.</h1>
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

 
    <td colspan="2"><?php echo(getUebersetzung("Markieren sie jene Auswahlmöglichkeiten, die bei der Suche zur Verfügung stehen sollen",$sprache,$link)); ?>:</td>
 </br>
  </br>
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
      <?php echo(getUebersetzung("Zusammengefasste Zimmer (z. B. Häuser) in Suche gesondert anzeigen.",$sprache,$link)); ?>
   
    </td>
  </tr>		  
  <?php
  //sprachen anzeigen die aktiviert sind: 
  	//liefert alle Möglichkeiten, die durch den Benutzer ausgesucht werden können
	$res = getPropertiesSuche($unterkunft_id, $link); //Methode in einstellungenFunctions.php definiert
  	while($d = mysql_fetch_array($res))
	{
  	  $name = $d["Name"];
	  //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
  	  $aktiviert = isPropertyShown($unterkunft_id,$name,$link); //Methode in einstellungenFunctions.php definiert     
    ?>  
      <tr>
      	
      </br>
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
 </br>
  </br>
		<tr>
		  <td>
		      <input name="suchFilter" type="radio" value="filterUnterkunft" 
			  <?php 
			  if (getPropertyValue(SUCHFILTER_UNTERKUNFT,$unterkunft_id,$link) == "true"){
			  	echo(" checked");
			  }
			  ?>
			  >
		      <?php echo(getUebersetzung("Suche nach Anzahl der Erwachsenen und/oder Kindern auf gesamte Unterkunft einschränken",$sprache,$link)); ?></td>
	      </tr>
	      
	     </br>
		  <tr>
		    <td>
		      <input type="radio" name="suchFilter" value="filterZimmer"			  
			  <?php 
			  if (getPropertyValue(SUCHFILTER_ZIMMER,$unterkunft_id,$link) == "true"){
			  	echo(" checked");
			  }
			  ?>
			  >
		      <?php echo(getUebersetzung("Suche nach Anzahl der Erwachsenen und/oder Kindern auf einzelne Zimmer einschränken",$sprache,$link)); ?>
		    </td>
		   </br>
		  </tr>		  
	</table>
</td>
</tr>
  <tr>
   <td>
   </br>
 	 <?php 
	 	showSubmitButton(getUebersetzung("ändern",$sprache,$link));
	?>
	</td>
  </tr>
</table>
</form>
<br/>
<!-- <?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?> -->
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); ?>