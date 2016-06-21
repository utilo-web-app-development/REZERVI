<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi
			author: christian osterrieder utilo.eu						

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
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>

<!-- <form action="./benutzerAendern.php" method="post" name="zimmerAendern" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="table"> -->
    
   <div class="panel panel-default">
  <div class="panel-body">
  	
<form action="./benutzerAendern.php" method="post" name="zimmerAendern" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
    
 
      <h1><?php echo(getUebersetzung("Benutzer bearbeiten",$sprache,$link)); ?></h1>     
      <h5><?php echo(getUebersetzung("Bitte wählen Sie den zu verändernden Benutzer aus",$sprache,$link)); ?>:</h5>
      
   <div class="form-group">
				
				<div class="col-sm-12">
			 <select name="id" type="text" id="id" value="" class="form-control">
			
          <?php
		
		//benutzer auslesen:
		$query = "select 
				  PK_ID, Name
				  from 
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY 
				  Name";
	
		 $res = mysql_query($query, $link);
		 if (!$res){
			echo("die Anfrage $query scheitert.");
		 }
		 else{
		  //benutzer ausgeben:
		  $i = 0;
			  while($d = mysql_fetch_array($res)) {?>
          		<option value="<?php echo($d["PK_ID"]); ?>" 
          			<?php if ($i == 0) echo(" selected"); $i++; ?>> 
          			<?php echo($d["Name"]); ?> </option>
          	  <?php
			  } //ende while
			} //ende else
		 //ende benutzer ausgeben    
		 ?>
        </select>
    		</div>
	</div>	 
<input name="benutzerAendern" type="submit" id="benutzerAendern" class="btn btn-primary" value="<?php echo(getUebersetzung("Benutzer Ändern",$sprache,$link)); ?>">      
</form>
<?php
//-------------ende benutzer ändern
/*
//-------------benutzer löschen
prüfen ob benutzer überhaupt vorhanden sind 
*/
if (getAnzahlVorhandeneBenutzer($unterkunft_id,$link) > 1){
?>
<!-- <form action="./benutzerLoeschenBestaetigen.php" method="post" name="benutzerLoeschen" target="_self"> -->

<form action="./benutzerLoeschenBestaetigen.php" method="post" name="benuterLoeschen" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
  <h1><?php echo(getUebersetzung("Benutzer löschen",$sprache,$link)); ?></h1>
 <!-- <h5><?php echo(getUebersetzung("Bitte wählen Sie den zu löschenden Benutzer aus",$sprache,$link)); ?>. 
	 <?php echo(getUebersetzung("Sie können mehrere Benutzer zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Benutzernamen klicken",$sprache,$link)); ?>.</h5> -->
   
        
       <!-- Selectbox -->
     
      <!-- <div class="form-group">
				
				<div class="col-sm-12">
			 <select name="id[]" type="text" id="select" value="" class="form-control">
			
          <?php 
		  		//benutzer auslesen:
		$query = "select 
				  PK_ID, Name, Passwort
				  from 
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY 
				  Name";
	
		 $res = mysql_query($query, $link);
		 if (!$res)
			echo("die Anfrage $query scheitert.");
		 else{     
		  	$i = 0;
			  while($d = mysql_fetch_array($res)) {
			  //selbst nicht loeschen!
			  if ($d["Name"] == $benutzername && $d["Passwort"] == $passwort){
			  	continue;
			  }	
			  ?>
          		<option value="<?php echo($d["PK_ID"]); ?>" 
          			<?php if ($i == 0) echo(" selected"); $i++; ?>> 
          			<?php echo($d["Name"]); ?></option>
          	  <?php
			  } //ende while
		  }	  
		 ?>
        </select>
    		</div>
	</div> -->
   <input name="benutzerLoeschen" type="submit" id="benutzerLoeschen" class="btn btn-danger" 
      	  value="<?php echo(getUebersetzung("Benutzer löschen",$sprache,$link)); ?>">
    

</form>
<?php
} //ende anzahlBenutzer ist ok
?>
<form action="./benutzerAnlegen.php" method="post" name="benutzerAnlegen" target="_self">
 
    <tr>
      <h1><?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?></h1>
        <h5><?php echo(getUebersetzung("Klicken Sie auf den Button [Benutzer anlegen] um einen neuen Benutzer hinzuzufügen",$sprache,$link)); ?>.</h5>
      
 <!-- alter button -->
      <!-- <td><input name="benutzerAnlegenButton" type="submit" id="benutzerAnlegenButton" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?>"></td> -->
       
     <a class="btn btn-primary" href="./benutzerAnlegen.php"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?></a>
     	
     
    

</form>
<br/>
<!-- <table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<p> </p>
<p> -->  <?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>
