<?php 
/*   
			reservierungsplan
			nachricht an den vermieter senden
			author: christian osterrieder utilo.eu					
			
			dieser seite muss Übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
			
			die seite verwendet anfrage/sendEMail.php um das ausgefüllte
			formular zu versenden
*/ 
session_start(); 
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
		
//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$zimmer_id = $_POST["zimmer_id"];
$jahr = $_POST["jahr"];
$monat = $_POST["monat"];
	
//funktions einbinden:
include_once("../include/unterkunftFunctions.php");
include_once("../include/datumFunctions.php");
include_once("../include/uebersetzer.php");
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!-- checken ob formular korrekt ausgefüllt wurde: -->
<script language="JavaScript" type="text/javascript" src="./anfragePerEmailJS.php">
</script>
<?php include_once("../templates/headerB.php"); ?>

<form action="../anfrage/sendEMail.php" method="post" name="e_mail_form" target="_self" id="e_mail_form" onSubmit="return chkFormular()">
  <table border="0" cellspacing="0" cellpadding="3">
    <tr class="standardSchrift">
      <td><?php echo(getUebersetzung("Name",$sprache,$link)); ?>*</td>
      <td><input name="name" type="text"  id="name" size="50"></td>
    </tr>
    <tr class="standardSchrift">
      <td><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?>*</td>
      <td><input name="email" type="text"  id="email" size="50"></td>
    </tr>
    <tr class="standardSchrift">
      <td><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
      <td><input name="telefon" type="text"  id="telefon" size="50"></td>
    </tr>
    <tr class="standardSchrift">
      <td><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
      <td><input name="fax" type="text"  id="fax" size="50"></td>
    </tr>
    <tr class="standardSchrift">
      <td><?php echo(getUebersetzung("Ihre Nachricht",$sprache,$link)); ?>*</td>
      <td><textarea name="nachricht" cols="40" rows="10"  id="nachricht"></textarea></td>
    </tr>
  </table>
  <p class="standardSchrift">(<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder müssen ausgefüllt werden!",$sprache,$link)); ?>)
  </p>
  <p>
    <input name="send" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="send" value="<?php echo(getUebersetzung("Absenden",$sprache,$link)); ?>">
			<input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
			<input name="jahr" type="hidden" value="<?php echo($jahr); ?>">
			<input name="monat" type="hidden" value="<?php echo(parseMonthNumber($monat)); ?>">	
  </p>
</form>
</body>
</html>
