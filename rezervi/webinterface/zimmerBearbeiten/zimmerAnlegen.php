<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			ein neues zimmer anlegen.
*/
	//datenbank �ffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/einstellungenFunctions.php");
	include_once("../../include/uebersetzer.php");
	include_once("../../include/zimmerFunctions.php");
	include_once($root."/include/zimmerAttributes.inc.php");
	include_once($root."/include/propertiesFunctions.php");	
	
	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$sprache = getSessionWert(SPRACHE);
	$standardsprache = getStandardSprache($unterkunft_id,$link);
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<form action="./zimmerEintragen.php" method="post" name="zimmerEintragen" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="tableColor">
    <tr> 
      <td colspan="2"><p class="standardSchriftBold"><?php echo(getUebersetzung("Ein neues Zimmer/Appartement/Wohnung/etc. anlegen",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte f�llen Sie die untenstehenden Felder aus.",$sprache,$link)); ?> 
		  <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder m�ssen ausgef�llt werden",$sprache,$link)); ?>!
		  </span></p></td>
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    if (isGermanShown($unterkunft_id,$link)){
    ?>
	    <tr> 
	      <td width="50%"><?php echo(getUebersetzung("Zimmerart in deutsch",$sprache,$link)); ?> 
	      <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?>	       
	      <?php if ($standardsprache == "de"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	      <td width="50%"><input name="zimmerart" type="text" id="zimmerart" value="<?php if (isset($zimmerart)) {echo($zimmerart);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    if (isEnglishShown($unterkunft_id,$link)){
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Zimmerart in englisch",$sprache,$link)); ?>
	       <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?> 
	      <?php if ($standardsprache == "en"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>	      
	      </td>
	      <td><input name="zimmerart_en" type="text" id="zimmerart_en" value="<?php if (isset($zimmerart_en)) {echo($zimmerart_en);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    if (isFrenchShown($unterkunft_id,$link)){
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Zimmerart in franz�sisch",$sprache,$link)); ?>
	       <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?> 
	      <?php if ($standardsprache == "fr"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	      <td><input name="zimmerart_fr" type="text" id="zimmerart_fr"  value="<?php if (isset($zimmerart_fr)) {echo($zimmerart_fr);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    if (isItalianShown($unterkunft_id,$link)){
    ?>
    	<tr> 
	      <td><?php echo(getUebersetzung("Zimmerart in italienisch",$sprache,$link)); ?> 
	       <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?>
	      <?php if ($standardsprache == "it"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	      <td><input name="zimmerart_it" type="text" id="zimmerart_it"  value="<?php if (isset($zimmerart_it)) {echo($zimmerart_it);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    if (isNetherlandsShown($unterkunft_id,$link)){
    ?>
    	<tr> 
	      <td><?php echo(getUebersetzung("Zimmerart in holl�ndisch",$sprache,$link)); ?> 
	       <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?>
	      <?php if ($standardsprache == "nl"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	      <td><input name="zimmerart_nl" type="text" id="zimmerart_nl"  value="<?php if (isset($zimmerart_nl)) {echo($zimmerart_nl);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }    
    if (isEspaniaShown($unterkunft_id,$link)){
    ?>
        <tr> 
	      <td><?php echo(getUebersetzung("Zimmerart in spanisch",$sprache,$link)); ?>
	       <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?>
	      <?php if ($standardsprache == "sp"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	       </td>
	      <td><input name="zimmerart_sp" type="text" id="zimmerart_sp"  value="<?php if (isset($zimmerart_sp)) {echo($zimmerart_sp);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    if (isEstoniaShown($unterkunft_id,$link)){
    ?>
        <tr> 
	      <td><?php echo(getUebersetzung("Zimmerart in estnisch",$sprache,$link)); ?> 
	       <?php echo(getUebersetzung("(z. B. Zimmer, Wohnung, Ferienwohnung, Appartement, etc.)",$sprache,$link)); ?>
	      <?php if ($standardsprache == "es"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	      <td><input name="zimmerart_es" type="text" id="zimmerart_es"  value="<?php if (isset($zimmerart_es)) {echo($zimmerart_es);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    ?>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    if (isGermanShown($unterkunft_id,$link)){
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Zimmernummer in deutsch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?>
	      <?php if ($standardsprache == "de"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	       </td>
	      <td><input name="zimmernr" type="text" id="zimmernr"  value="<?php if (isset($zimmernr)) {echo($zimmernr);} ?>" maxlength="30"></td>
	    </tr>
	<?php
    }
    if (isEnglishShown($unterkunft_id,$link)){
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Zimmernummer in englisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?> 
	   	      <?php if ($standardsprache == "en"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	      <td><input name="zimmernr_en" type="text" id="zimmernr_en"  value="<?php if (isset($zimmernr_en)) {echo($zimmernr_en);} ?>" maxlength="30"></td>
	    </tr>
    <?php
    }
    if (isFrenchShown($unterkunft_id,$link)){
    ?>
    <tr> 
      <td><?php echo(getUebersetzung("Zimmernummer in französisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?> 
      	      <?php if ($standardsprache == "fr"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
	      </td>
      <td><input name="zimmernr_fr" type="text" id="zimmernr_fr"  value="<?php if (isset($zimmernr_fr)) {echo($zimmernr_fr);} ?>" maxlength="30"></td>
    </tr>
    <?php
    }
    if (isItalianShown($unterkunft_id,$link)){
    ?>
    <tr> 
      <td><?php echo(getUebersetzung("Zimmernummer in italienisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?> 
	      <?php if ($standardsprache == "es"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
      </td>
      <td><input name="zimmernr_it" type="text" id="zimmernr_it"  value="<?php if (isset($zimmernr_it)) {echo($zimmernr_it);} ?>" maxlength="30"></td>
    </tr>
    <?php
    }
    if (isNetherlandsShown($unterkunft_id,$link)){
    ?>
    <tr> 
      <td><?php echo(getUebersetzung("Zimmernummer in holländisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?> 
	      <?php if ($standardsprache == "nl"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
      </td>
      <td><input name="zimmernr_nl" type="text" id="zimmernr_nl"  value="<?php if (isset($zimmernr_nl)) {echo($zimmernr_nl);} ?>" maxlength="30"></td>
    </tr>
    <?php
    }    
    if (isEspaniaShown($unterkunft_id,$link)){
    ?>
    <tr> 
      <td><?php echo(getUebersetzung("Zimmernummer in spanisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?> 
	      <?php if ($standardsprache == "sp"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
      </td>
      <td><input name="zimmernr_sp" type="text" id="zimmernr_sp"  value="<?php if (isset($zimmernr_sp)) {echo($zimmernr_sp);} ?>" maxlength="30"></td>
    </tr>
    <?php
    }
    if (isEstoniaShown($unterkunft_id,$link)){
    ?>
    <tr> 
      <td><?php echo(getUebersetzung("Zimmernummer in estnisch (z. B. Typ A, Nr. 10, Balkonzimmer, etc.)",$sprache,$link)); ?> 
	      <?php if ($standardsprache == "es"){ ?>
	      	*
	      <?php } 
	      	else {
	      ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.",$sprache,$link)); ?>)
	      <?php
	      	}
	      ?>
      </td>
      <td><input name="zimmernr_sp" type="text" id="zimmernr_sp"  value="<?php if (isset($zimmernr_sp)) {echo($zimmernr_sp);} ?>" maxlength="30"></td>
    </tr>
    <?php
    }
    ?>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td><?php echo(getUebersetzung("Anzahl der Betten f�r Erwachsene",$sprache,$link)); ?>*</td>
      <td><input name="betten" type="text" id="betten" value="<?php if (isset($betten)) {echo($betten);} ?>" maxlength="6"></td>
    </tr>
    <tr>
      <td><?php echo(getUebersetzung("Anzahl der Betten f�r Kinder",$sprache,$link)); ?>*</td>
      <td><input name="bettenKinder" type="text" id="bettenKinder" value="<?php if (isset($bettenKinder)) { 
	  																					echo($bettenKinder); 
																					} 
																					else{ 
																						echo("0"); 
																					} ?>" maxlength="6"></td>
    </tr>
	<tr> 
      <td><?php echo(getUebersetzung("URL zu weiteren Informationen (z. B. http://www.rezervi.com/index.php)",$sprache,$link)); ?></td>
      <td><input name="linkName" type="text" id="linkName"  value="<?php if (isset($linkName)) {echo($linkName);} ?>" maxlength="100"></td>
    </tr>
	<tr> 
      <td>
	    <?php echo(getUebersetzung("Haustiere erlaubt",$sprache,$link));?>
	  </td>
	  <td>
	    <select name="Haustiere" id="Haustiere">
                <option value="false"><?php echo(getUebersetzung("nein",$sprache,$link));?></option>
                <option value="true"><?php echo(getUebersetzung("ja",$sprache,$link));?></option>
	    </select>
	  </td>
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    //sollen auch noch weitere attribute angezeigt werden?
	if (getPropertyValue(SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT,$unterkunft_id,$link) == "true"){
		$res = getAttributes();
		while ($d = mysql_fetch_array($res)){
			$bezeichnung = $d["Bezeichnung"];
			$beschreibung = $d["Beschreibung"];
			$att_id = $d["PK_ID"];
			?>
			<tr> 
		      <td><?= $bezeichnung ?> 
		      <?php if (!empty($beschreibung)){ ?>
		      	(<?= $beschreibung ?>)</td>
		      <?php } ?>
		      <td>
		      	<input name="attWert_<?= $att_id ?>" type="text" 
		      		   id="attWert_<?= $att_id ?>"
		      		   value="" />
		      </td>
		    </tr>
			<?php
		}
	}
    ?>
    <tr> 
      <td colspan="2"><input name="Submit" type="submit" id="Submit" class="btn btn-success"
      value="<?php echo(getUebersetzung("Zimmer eintragen",$sprache,$link)); ?>"></td>
    </tr>
  </table>
</form>

<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td>
    	<!-- <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
		<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 	onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>"></form> -->
	 	
	 	<a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
	</td>
  </tr>
</table><br/>

<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">

	<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>">
  </form></td>
  </tr>
</table>

    </body>
</html>
