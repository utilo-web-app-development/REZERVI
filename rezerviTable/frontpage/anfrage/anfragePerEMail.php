<?php $root="../..";

include_once($root."/templates/header.inc.php");

if (!isset($fehler) || $fehler != true){

	$ansicht = $_POST["ansicht"];
	$tag=$_POST["tag"];
	$monat=$_POST["monat"];
	$jahr=$_POST["jahr"];
	$mietobjekt_id = $_POST["mietobjekt_id"];
	
}

include_once($root."/templates/bodyStart.inc.php"); 

?>

<form action="./sendEMail.php" method="post" name="e_mail_form" target="_self" id="e_mail_form">
  <table border="0" cellspacing="0" cellpadding="3">
    <tr class="<?php echo STANDARD_SCHRIFT ?>">
      <td><?php echo(getUebersetzung("Name")); ?></td>
      <td><input name="name" type="text"  id="name" size="50" <?php if (isset($name)) echo("value=\"$name\""); ?>/>*</td>
    </tr>
    <tr class="<?php echo STANDARD_SCHRIFT ?>">
      <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
      <td><input name="email" type="text"  id="email" size="50" <?php if (isset($email)) echo("value=\"$email\""); ?>/>*</td>
    </tr>
    <tr class="<?php echo STANDARD_SCHRIFT ?>">
      <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
      <td><input name="telefon" type="text"  id="telefon" size="50" <?php if (isset($telefon)) echo("value=\"$telefon\""); ?>/></td>
    </tr>
    <tr class="<?php echo STANDARD_SCHRIFT ?>">
      <td><?php echo(getUebersetzung("Ihre Nachricht")); ?></td>
      <td><textarea name="ihreNachricht" cols="50" rows="10"  id="ihreNachricht"><?php if (isset($ihreNachricht)) echo($ihreNachricht); ?></textarea>*</td>
    </tr>
  </table>
  <p class="<?php echo STANDARD_SCHRIFT ?>">(<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder m�ssen ausgef�llt werden!")); ?>)
  </p>
  <p>
    <input name="send" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="send" value="<?php echo(getUebersetzung("Absenden")); ?>"/>
			<input name="jahr" type="hidden" value="<?php echo($jahr); ?>"/>
			<input name="monat" type="hidden" value="<?php echo($monat); ?>"/>
			<input name="tag" type="hidden" id="monat" value="<?php echo($tag); ?>"/>
			<input name="ansicht" type="hidden" id="ansicht" value="<?php echo($ansicht); ?>"/>
			<input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo($mietobjekt_id); ?>"/>		
  </p>
</form>
<?php
	include_once($root."/templates/footer.inc.php");
?>
