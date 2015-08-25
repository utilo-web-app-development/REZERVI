<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
	reservierungsplan
	startseite zur wartung der zimmer
	author: christian osterrieder utilo.eu						
	
	dieser seite muss �bergeben werden:
	Benutzer PK_ID $benutzer_id
*/

//variablen:
$sprache = getSessionWert(SPRACHE);
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//datenbank �ffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/propertiesFunctions.php");	
include_once("../templates/components.php"); 

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<? 		/* 
		zimmer �ndern:
		nur wenn bereits zimmer angelegt wurden:
		*/
		$anzahlVorhandenerZimmer = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
		if ($anzahlVorhandenerZimmer > 0){
?>
	<?php
	if (isset($nachricht) && $nachricht != ""){
	?>
	<table class="<?php if (isset($fehler) && $fehler == true) { 
	  		  		echo("belegt");
			  	  } 
	  			  else{
			  		echo("standardSchriftBold");
				  }
	  		  ?>">
		<tr>
		  <td><?php echo($nachricht); ?>
			</td>
		  <td>&nbsp;</td>
		</tr>
	</table>
	<br/>
	<?php
	}
	?>
<form action="./zimmerAendern.php" method="post" name="zimmerAendern" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><p class="standardSchriftBold"><?php echo(getUebersetzung("Zimmer/Appartement/Wohnung/etc. bearbeiten",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte wählen Sie das zu verändernde Zimmer/Appartement/Wohnung/etc. aus",$sprache,$link)); ?>:</span></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
      	<select name="zimmer_id" size="5" id="zimmer_id">
          <?php	
			 $res = getZimmer($unterkunft_id,$link);
			  //zimmer ausgeben:
			  $i = 0;
				  while($d = mysql_fetch_array($res)) {
					$ziArt = getUebersetzungUnterkunft($d["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($d["Zimmernr"],$sprache,$unterkunft_id,$link);
					?>
					<option value="<?= $d["PK_ID"] ?>"<?php
						if ($i == 0){
						?>
							selected="selected"
						<?php
						}
						$i++;
						?>
						>
						<?= $ziArt." ".$ziNr ?>
					</option>
					<?php
				  } //ende while
			 //ende zimmer ausgeben    
			 ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <!--alter button <td><input name="Submit" type="submit" id="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
		   onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Zimmer �ndern",$sprache,$link)); ?>"></td> -->
		<td><input name="Submit" type="submit" id="Submit" class="btn btn-primary"  value="<?php echo(getUebersetzung("Zimmer ändern",$sprache,$link)); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
//-------------ende zimmer �ndern
/*
//-------------Zimmer l�schen
pr�fen ob zimmer �berhaupt vorhanden sind �bernimmt pr�fung bei zimmer�ndern
*/
?>
<form action="./zimmerLoeschenBestaetigen.php" method="post" name="zimmerLoeschen" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><p class="standardSchriftBold"><?php echo(getUebersetzung("Zimmer/Appartement/Wohnung/etc. l�schen",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte wählen Sie die zu löschenden Zimmer/Appartement/Wohnung/etc. aus",$sprache,$link)); ?>. <?php echo(getUebersetzung("Sie können mehrere Zimmer/Appartements/Wohnungen/etc. zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Bezeichnung klicken",$sprache,$link)); ?>.</span></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><select name="zimmer_id[]" size="5" multiple id="select">
          <?php
			 $res = getZimmer($unterkunft_id,$link);
			  //zimmer ausgeben:
			  $i = 0;
				  while($d = mysql_fetch_array($res)) {
					$ziArt = getUebersetzungUnterkunft($d["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($d["Zimmernr"],$sprache,$unterkunft_id,$link);
					?>
					<option value="<?= $d["PK_ID"] ?>"<?php
						if ($i == 0){
						?>
							selected="selected"
						<?php
						}
						$i++;
						?>						
						>
						<?= $ziArt." ".$ziNr ?>
					</option>
					<?php
				  } //ende while
			 //ende zimmer ausgeben    
			 ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <!-- alter button <td><input name="Submit2" type="submit" id="Submit2" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Zimmer l�schen",$sprache,$link)); ?>"></td> -->
        <td><input name="Submit2" type="submit" id="Submit2" class="btn btn-danger" value="<?php echo(getUebersetzung("Zimmer löschen",$sprache,$link)); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
} //ende anzahlVorhandenerZimmer ist ok
/*
//---zimmer anlegen:
pr�fen ob noch weitere zimmer angelegt werden k�nnen:
*/
$anzahlZimmer = getAnzahlZimmer($unterkunft_id,$link);
if ( $anzahlVorhandenerZimmer < $anzahlZimmer ){
?>
<form action="./zimmerAnlegen.php" method="post" name="zimmerAnlegen" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Zimmer/Appartement/Wohnung/etc. anlegen",$sprache,$link)); ?></span><br/>
        </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <!--alter buton <td><input name="zimmerAnlegenButton" type="submit" id="zimmerAnlegenButton" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Zimmer anlegen",$sprache,$link)); ?>"></td> -->
       <td><a class="btn btn-primary" href="./zimmerAnlegen.php"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Zimmer anlegen",$sprache,$link)); ?></a>
     	</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
	//hochladen von bildern, falls dies aktiviert wurde
  	$active = getPropertyValue(ZIMMER_THUMBS_ACTIV,$unterkunft_id,$link);
  	$active2= getPropertyValue(ZIMMER_THUMBS_AV_OV,$unterkunft_id,$link);
	if ($active != "true"){
		$active = false;
	}
	else{
		$active = true;
	}
	if ($active2 != "true"){
		$active2 = false;
	}
	else{
		$active2 = true;
	}	
	if ($active || $active2){
?><form action="./bilderHochladen.php" method="post" name="bilder" target="_self" id="bilder">
	<table border="0" cellpadding="0" cellspacing="3" class="table">
	    <tr>
      <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Bilder f�r Zimmer/Appartement/Wohnung/etc. hochladen",$sprache,$link)); ?></span><br/>
        </td>
      <td>&nbsp;</td>
    </tr>
	  <tr>
		<td>	
			<input name="hochladen" type="submit" class="button200pxA" id="hochladen" onMouseOver="this.className='button200pxB';"
		 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Bilder hochladen",$sprache,$link)); ?>">
		</td>
	  </tr>
	</table>
</form>
<form action="./bilderLoeschen.php" method="post" name="bilder" target="_self" id="bilder">
	<table border="0" cellpadding="0" cellspacing="3" class="table">
	    <tr>
      <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Bilder f�r Zimmer/Appartement/Wohnung/etc. löschen",$sprache,$link)); ?></span><br/>
        </td>
      <td>&nbsp;</td>
    </tr>
	  <tr>
		<td>	
			<input name="hochladen" type="submit" class="button200pxA" id="hochladen" onMouseOver="this.className='button200pxB';"
		 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Bilder l�schen",$sprache,$link)); ?>">
		</td>
	  </tr>
	</table>
</form>
<?php
	} //ende bilder hochladen
?>
<?php
} //ende zimmer anlegen
if ($anzahlVorhandenerZimmer > 0){
?>
<!-- preise definieren -->
<form action="./preis.php" method="post" name="preis" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td>
      	<span class="standardSchriftBold"><?php echo(getUebersetzung("Preise hinzufügen, ändern, löschen",$sprache,$link)); ?></span><br/>
      </td>
    </tr>
    <tr>
      <td>
      	<span class="standardSchrift">
      		<?php echo(getUebersetzung("Der Standardpreis ist gültig wenn zum ausgewählten Zeitpunkt "+
      		           "kein Saisonpreis angegeben wurde.",$sprache,$link)); ?>
      	</span>
      </td>
    </tr>    
    <tr>
      <td>
      	<!-- alter button <input 
      		name="addAttribut" type="submit" id="addAttribut" 
      		class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" 
       		value="<?php echo(getUebersetzung("Saisonpreise bearbeiten",$sprache,$link)); ?>" /> -->
       
       		<a class="btn btn-primary" href="./preis.php"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Saisonpreise bearbeiten",$sprache,$link)); ?></a>
			
      </td>
    </tr>
  </table>
</form>
<form action="./standardpreis.php" method="post" name="preis" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td>
      	<!-- alter button <input 
      		name="addAttribut" type="submit" id="addAttribut" 
      		class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" 
       		value="<?php echo(getUebersetzung("Standardpreise bearbeiten",$sprache,$link)); ?>" /> -->
       			<a class="btn btn-primary" href="./standardpreis.php"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Standardpreise bearbeiten",$sprache,$link)); ?></a>
      </td>
    </tr>
  </table>
</form>
<!-- end preise definieren -->
<!-- zusammenfassen von zimmern zu haus -->
<form action="./mergeRooms/index.php" method="post" name="mergeRooms" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td>
      	<span class="standardSchriftBold">
      		<?php echo(getUebersetzung("Zimmer zusammenfassen",$sprache,$link)); ?>
      	</span>
      	<br/>
      </td>
    </tr>
    <tr>
      <td>
      	<span class="standardSchrift">
      		<?php echo(getUebersetzung("Falls Sie ein Haus mit mehreren Zimmern vermieten und die Zimmer des ".
                       "Hauses und das Haus selbst vermieten wollen, können Sie hier die Zimmer zum Haus ".
                       "festlegen. Das Haus und die Zimmer m�ssen vorher angelegt worden sein.",$sprache,$link)); ?>
      	</span>
      	<br/>
      </td>
    </tr>    
    <tr>
      <td>
      	<!-- alter button <input 
      		name="addAttribut" type="submit" id="addAttribut" 
      		class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" 
       		value="<?php echo(getUebersetzung("Zimmer zusammenfassen",$sprache,$link)); ?>" /> -->
       		<a class="btn btn-primary" href="./mergeRooms/index.php"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Zimmer zusammenfassen",$sprache,$link)); ?></a>
      </td>
    </tr>
  </table>
</form>
<!-- end zusammenfassen von zimmern zu haus -->
<?php }//ende wenn zimmer vorhanden ?>
<!-- hinzuf�gen von weiteren attributen f�r zimmer -->
<form action="./attributeHinzufuegen.php" method="post" name="attributeHinzufuegen" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td>
      	<span class="standardSchriftBold"><?php echo(getUebersetzung("Weitere Attribute für Zimmer/Appartement/Wohnung/etc. bearbeiten",$sprache,$link)); ?></span><br/>
      </td>
    </tr>
    <tr>
      <td>
      	<!-- <input 
      		name="addAttribut" type="submit" id="addAttribut" 
      		class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" 
       		value="<?php echo(getUebersetzung("Attribute �ndern",$sprache,$link)); ?>" /> -->
       		<a class="btn btn-primary" href="./attributeHinzufuegen.php"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Attribute ändern",$sprache,$link)); ?></a>
      </td>
    </tr>
  </table>
</form>
<!-- end hinzuf�gen von weiteren attributen f�r zimmer -->
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
?>
</body>
</html>
