<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

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
	    function setVal(){
			if (document.listeAnzeigen.anrede_val.checked){
				document.suche.anrede_val.value = "true";
			}
			if (document.listeAnzeigen.vorname_val.checked){
				document.suche.vorname_val.value = "true";
			}
			if (document.listeAnzeigen.nachname_val.checked){
				document.suche.nachname_val.value = "true";
			}
			if (document.listeAnzeigen.strasse_val.checked){
				document.suche.strasse_val.value = "true";
			}
			if (document.listeAnzeigen.plz_val.checked){
				document.suche.plz_val.value = "true";
			}
			if (document.listeAnzeigen.ort_val.checked){
				document.suche.ort_val.value = "true";
			}
			if (document.listeAnzeigen.land_val.checked){
				document.suche.land_val.value = "true";
			}
			if (document.listeAnzeigen.email_val.checked){
				document.suche.email_val.value = "true";
			}
			if (document.listeAnzeigen.tel_val.checked){
				document.suche.tel_val.value = "true";
			}
			if (document.listeAnzeigen.fax_val.checked){
				document.suche.fax_val.value = "true";
			}
			if (document.listeAnzeigen.anmerkung_val.checked){
				document.suche.anmerkung_val.value = "true";
			}
	    	return true; 	    
	    }
	    //-->
</script>
<?php		
//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>

<!-- Alte überschrift & form action
	<p class="standardSchriftBold">
<?php echo getUebersetzung("G&auml;ste-Daten abfragen und bearbeiten",$sprache,$link) ?>
</p>

<form action="./gaesteListe/index.php" method="post" name="listeAnzeigen" target="_self" id="listeAnzeigen">
<table border="0" cellpadding="0" cellspacing="3" class="table">
  <tr> 
    <td><table border="0" cellpadding="0" cellspacing="3" class="table">
      <tr>
        <td><p><?php echo(getUebersetzung("Bitte wählen Sie aus, welche Daten der Gäste angezeigt werden sollen",$sprache,$link)); ?>:</p></td>
      </tr>
    </table>
      <br/> -->
      <h2><?php echo getUebersetzung("G&auml;ste-Daten abfragen und bearbeiten",$sprache,$link) ?></h2>
<div class="panel panel-default">
  <div class="panel-body">
  	<?php echo(getUebersetzung("Bitte wählen Sie aus, welche Daten der Gäste angezeigt werden sollen",$sprache,$link)); ?>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
  	
	<form action="./gaesteListe/index.php" method="post" name="listeAnzeigen" target="_self" onSubmit="return chkFormular();" class="form-horizontal">

<!-- Test Forumular Anrede
	<div class="form-group">
				<label for="anrede" class="col-sm-2 control-label"><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></label>
				<div class="col-sm-10">
					<input name="anrede-val" type="checkbox" id="anrede-val" value="true" checked> <class="form-control">
				</div>
				</div>	
				 -->
      <table border="0" cellspacing="1" cellpadding="0" class="tableColor">
          <tr> 
            <td width="1"> <input name="anrede_val" type="checkbox" id="anrede_val" value="true" checked> 
            </td>
            <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="vorname_val" type="checkbox" id="vorname_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="nachname_val" type="checkbox" id="nachname_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="strasse_val" type="checkbox" id="strasse_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Straße/Hausnummer",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="plz_val" type="checkbox" id="plz_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("PLZ",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="ort_val" type="checkbox" id="ort_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Ort",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="land_val" type="checkbox" id="land_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="email_val" type="checkbox" id="email_val" value="true" checked> 
            </td>
            <td><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="tel_val" type="checkbox" id="tel_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="fax_val" type="checkbox" id="fax_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		   <tr> 
            <td><input name="sprache_val" type="checkbox" id="sprache_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("bevorzugte Sprache",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><input name="anmerkung_val" type="checkbox" id="anmerkung_val" value="true" checked></td>
            <td><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> 
            	
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
	  </td>
  </tr>
</table>
<a class="btn btn-primary" href="./gaesteListe/index.php"><span class="glyphicon glyphicon-book" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Gästeliste anzeigen",$sprache,$link)); ?></a>
</form><?php /*
<table width="100%" border="0" cellpadding="0" cellspacing="3" class="table">
  <tr> 
    <td><p>Hier k&ouml;nnen Sie nach einem Gast in der Liste suchen (es k&ouml;nnen 
        auch Felder leer gelassen werden): (Seite im Aufbau!)</p></td>
  </tr>
</table>
<br/>
<form action="suche/index.php" method="post" name="suche" target="_self" id="suche" onSubmit="return setVal()">
  <table width="100%" border="0" cellpadding="0" cellspacing="3" class="table">
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr> 
            <td width="1">Vorname</td>
            <td> <input name="vorname" type="text" class="table" id="vorname"> 
            </td>
          </tr>
          <tr> 
            <td width="1">Nachname</td>
            <td><input name="nachname" type="text" class="table" id="nachname"></td>
          </tr>
          <tr> 
            <td width="1">Ort</td>
            <td><input name="ort" type="text" class="table" id="ort2"></td>
          </tr>
          <tr> 
            <td width="1">Land</td>
            <td><input name="land" type="text" class="table" id="land"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="unterkunft_id" type="hidden" id="unterkunft_id" value="<?php echo $unterkunft_id ?>">
              <input name="sucheStarten" type="submit" class="button200pxA" id="sucheStarten" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="Suche starten">
              <input name="benutzer_id" type="hidden" id="benutzer_id" value="<?php echo $benutzer_id?>">
              <input name="anrede_val" type="hidden" id="anrede_var" value="<?php echo($anrede_val); ?>"> 
              <input name="vorname_val" type="hidden" id="vorname_var3" value="<?php echo($vorname_val); ?>"> 
              <input name="nachname_val" type="hidden" id="anrede_var4" value="<?php echo($nachname_val); ?>"> 
              <input name="strasse_val" type="hidden" id="anrede_var5" value="<?php echo($strasse_val); ?>"> 
              <input name="ort_val" type="hidden" id="anrede_var6" value="<?php echo($ort_val); ?>"> 
              <input name="land_val" type="hidden" id="anrede_var7" value="<?php echo($land_val); ?>"> 
              <input name="email_val" type="hidden" id="anrede_var8" value="<?php echo($email_val); ?>"> 
              <input name="tel_val" type="hidden" id="anrede_var9" value="<?php echo($tel_val); ?>"> 
              <input name="fax_val" type="hidden" id="anrede_var" value="<?php echo($fax_val); ?>"> 
              <input name="anmerkung_val" type="hidden" id="anrede_var" value="<?php echo($anmerkung_val); ?>">
              <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
 </form>
 */ 
 ?>
  
 <table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr> 
  <br>
    <a class="btn btn-primary" href="./gastAnlegen/index.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("neuen Gast anlegen",$sprache,$link)); ?></a>
  </tr>
</table>

<?php } //ende else
 ?>
</body>
</html>
