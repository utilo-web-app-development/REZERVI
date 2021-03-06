<?php
/*
 * Created on 20.09.2005
 *
 * author: coster
 */
 
 include_once ($root."/include/benutzerFunctions.inc.php");
 include_once ($root."/include/mietobjektFunctions.inc.php");
 include_once ($root."/include/sessionFunctions.inc.php");
 
 $benutzer_id = getSessionWert(BENUTZER_ID);
 $benutzerrechte = getUserRights($benutzer_id);
 $anzahlVorhandenerMietobjekte = getAnzahlVorhandeneMietobjekte($vermieter_id);

?>
<table cellpadding="3" cellspacing="0" border="0" class="<?php echo TABLE_STANDARD ?>">
	<tr>
		<?php		
		//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 1 && $anzahlVorhandenerMietobjekte > 0) {
		?>
		  <form action="<?php echo$root ?>/webinterface/reservierung/index.php" method="post" name="resEingebenAendern" target="_self">    
		      <tr><td><input name="resEingebenAendern" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Belegungsplan bearbeiten")); ?>">
		      </td></tr>
		  </form>
		  <form action="<?php echo$root ?>/webinterface/anfragenBearbeiten/index.php" method="post" name="resEingebenAendern" target="_self">
		      <tr><td>
		        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("Anfragen bearbeiten")); ?>" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';"></td></tr>
		  </form>
		  <form action="<?php echo$root ?>/webinterface/mieterBearbeiten/index.php" method="post" name="gaesteBearbeiten" target="_self">
		      <tr><td>
		        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("Mieter bearbeiten")); ?>" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';"></td></tr>
		  </form>
		  <?php		
		} //ende benutzerrechte >= 1
		if ($benutzerrechte >= 2) {
		?>
		  <form name="benutzerdatenEingebenAendern" method="post" action="<?php echo$root ?>/webinterface/benutzerBearbeiten/index.php">
		      <tr><td><input name="Benutzerdatenbearbeiten" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="Benutzerdatenbearbeiten" value="<?php echo(getUebersetzung("Benutzerdaten bearbeiten")); ?>"></td></tr>
		  </form>
		  <?php		
		}
		//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
		?>
		  <form action="<?php echo$root ?>/webinterface/mietobjektBearbeiten/index.php" method="post" name="ZimmerBearbeiten" target="_self">
		      <tr><td><input name="ZimmerBearbeiten" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="ZimmerBearbeiten" value="<?php echo(getUebersetzung("Mietobjekt bearbeiten")); ?>"></td></tr>
		  </form>
		  <?php		
		} 
		//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
		?>
		  <form action="<?php echo$root ?>/webinterface/vermieter/index.php" method="post" name="UnterkunftBearbeiten" target="_self">
		      <tr><td><input name="UnterkunftBearbeiten" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="UnterkunftBearbeiten" value="<?php echo(getUebersetzung("Stammdaten bearbeiten")); ?>"></td></tr>
		  </form>
		  <?php		
		} 
		//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
		?>
		  <form action="<?php echo$root ?>/webinterface/divEinstellungen/index.php" method="post" name="DiverseEinstellungen" target="_self">
		      <tr><td><input name="divEinstellungen" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="divEinstellungen" value="<?php echo(getUebersetzung("Diverse Einstellungen")); ?>"></td></tr>
		  </form>
		  <?php		
		} 
		//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
		?>
		  <form name="designBearbeiten" method="post" action="<?php echo$root ?>/webinterface/designBearbeiten/index.php">
		      <tr><td><input name="designBearbeiten" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Design bearbeiten")); ?>">
		      </td></tr>
		  </form>
		  <?php		
		} //ende if benutzerrechte <= 2
		//prüfen ob benutzer das recht hat den folgenden link auszuführen:
		if ($benutzerrechte >= 2) {
		?>
		  <form name="antwortenBearbeiten" method="post" action="<?php echo$root ?>/webinterface/autoResponse/index.php">
		      <tr><td><input name="antwortenBearbeiten" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="designBearbeiten2" value="<?php echo(getUebersetzung("Automatische e-Mails")); ?>">
		      </td></tr>
		  </form>
		  <?php		
		} //ende if benutzerrechte <= 2
		if ($benutzerrechte >= 1) {
		?>
		  <form name="abmelden" method="post" action="<?php echo$root ?>/webinterface/abmelden.php">
		      <tr><td><input name="abmelden" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		       onMouseOut="this.className='<?php echo BUTTON ?>';" id="abmelden" value="<?php echo(getUebersetzung("Abmelden")); ?>"></td></tr>
		  </form>
		  <?php		
		}
		?>
	</tr>
</table>