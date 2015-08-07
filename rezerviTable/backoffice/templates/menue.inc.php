<?php 
/*
 * Created on 24.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Hauptseite von Backoffice
 *  
 */
 include_once ($root."/include/benutzerFunctions.inc.php");
 include_once ($root."/include/mietobjektFunctions.inc.php");
 include_once ($root."/include/sessionFunctions.inc.php");
 
 $benutzer_id = getSessionWert(BENUTZER_ID);
 $benutzerrechte = getUserRights($benutzer_id);
 $anzahlVorhandenerMietobjekte = getAnzahlVorhandeneRaeume($gastro_id);

?>
<link href="<?= $root ?>/backoffice/templates/yui_menu.css" rel="stylesheet" type="text/css">
<!-- Menu source file -->
<script type="text/javascript" src="<?= $root ?>/yui/build/menu/menu.js"></script>
<!-- Page-specific script -->
<script type="text/javascript">
	YAHOO.util.Event.onContentReady("nav_sub", function () {
		var oMenu = new YAHOO.widget.Menu(
              "nav_sub", {					
				position:"static",
				showdelay:450,
				hidedelay:250,
				lazyload:true,
				effect:{
				effect:YAHOO.widget.ContainerEffect.FADE,
					duration:0.25
				}
			}
		);
		oMenu.beforeRenderEvent.subscribe(function () {
                   var oSubmenuData = {	
				"<?= getUebersetzung("Reservierungen") ?>": [
					{ text: "<?= getUebersetzung("Tagesansicht") ?>", url: "<?=$root ?>/backoffice/reservierung/index.php?ansicht=Tagesansicht" },
					{ text: "<?= getUebersetzung("Listenansicht") ?>", url: "<?=$root ?>/backoffice/reservierung/index.php?ansicht=Listenansicht" },
					],				
				"<?= getUebersetzung("Tischkarten") ?>": [
					{ text: "<?= getUebersetzung("Design") ?>", url: "<?=$root ?>/backoffice/tischkarten/design/index.php" },
					{ text: "<?= getUebersetzung("Drucken") ?>", url: "<?=$root ?>/backoffice/tischkarten/print/index.php" },
					{ text: "<?= getUebersetzung("Übersicht") ?>", url: "<?=$root ?>/backoffice/tischkarten/resUebersicht/index.php" },
                       ],
				"<?= getUebersetzung("Gäste") ?>": [
					{ text: "<?= getUebersetzung("Anlegen") ?>", url: "<?=$root ?>/backoffice/mieterBearbeiten/mieterAnlegen/index.php" },
					{ text: "<?= getUebersetzung("Gästeliste") ?>", url: "<?=$root ?>/backoffice/mieterBearbeiten/mieterListe/index.php" },
					<?php /*
					{ text: "<?= getUebersetzung("Gruppen") ?>", url: "<?=$root ?>/backoffice/mieterBearbeiten/mieterGruppen/index.php" },
					*/ ?>
					],
				"<?= getUebersetzung("Benutzerdaten") ?>": [
					{ text: "<?= getUebersetzung("Ändern") ?>", url: "<?=$root ?>/backoffice/benutzerBearbeiten/benutzerAendern/index.php" },
					{ text: "<?= getUebersetzung("Löschen") ?>", url: "<?=$root ?>/backoffice/benutzerBearbeiten/benutzerLoeschen/index.php" },
					{ text: "<?= getUebersetzung("Anlegen") ?>", url: "<?=$root ?>/backoffice/benutzerBearbeiten/benutzerAnlegen_2/index.php" },
					],
				"<?= getUebersetzung("Raum") ?>": [
					{ text: "<?= getUebersetzung("Ändern") ?>", url: "<?=$root ?>/backoffice/raumBearbeiten/raumAendern/index.php" },
					{ text: "<?= getUebersetzung("Löschen") ?>", url: "<?=$root ?>/backoffice/raumBearbeiten/raumLoeschen/index.php" },
					{ text: "<?= getUebersetzung("Anlegen") ?>", url: "<?=$root ?>/backoffice/raumBearbeiten/raumAnlegen/index.php" },
					],
				"<?= getUebersetzung("Tisch") ?>": [
					<?php if (getAnzahlVorhandeneTische($gastro_id) > 0) { ?>
					{ text: "<?= getUebersetzung("Ändern") ?>", url: "<?=$root ?>/backoffice/tischBearbeiten/tischAendern/index.php" },
					{ text: "<?= getUebersetzung("Löschen") ?>", url: "<?=$root ?>/backoffice/tischBearbeiten/tischLoeschen/index.php" },
					{ text: "<?= getUebersetzung("Positionieren") ?>", url: "<?=$root ?>/backoffice/tischBearbeiten/tischPositionieren/index.php" },
					<?php /* 
					{ text: "<?= getUebersetzung("Gruppen") ?>", url: "<?=$root ?>/backoffice/tischBearbeiten/tischGruppen/index.php" },
					*/ ?>
					<?php } ?>
					{ text: "<?= getUebersetzung("Anlegen") ?>", url: "<?=$root ?>/backoffice/tischBearbeiten/tischAnlegen/index.php" },
					],
				"<?= getUebersetzung("Diverse Einstellungen") ?>": [
					{ text: "<?= getUebersetzung("Sprachen") ?>", url: "<?=$root ?>/backoffice/divEinstellungen/sprachen/sprachen.php" },
					{ text: "<?= getUebersetzung("Übersetzungen") ?>", url: "<?=$root ?>/backoffice/divEinstellungen/uebersetzungen/index.php" },
					{ text: "<?= getUebersetzung("Bilder") ?>", url: "<?=$root ?>/backoffice/divEinstellungen/bilder/index.php" },
					{ text: "<?= getUebersetzung("Links") ?>", url: "<?=$root ?>/backoffice/divEinstellungen/links/index.php" },
					{ text: "<?= getUebersetzung("Reservierungen") ?>", url: "<?=$root ?>/backoffice/divEinstellungen/buchung/index.php" },
					{ text: "<?= getUebersetzung("Registrierungen") ?>", url: "<?=$root ?>/backoffice/divEinstellungen/register/index.php" },
					],
				"<?= getUebersetzung("Design") ?>": [
					{ text: "<?= getUebersetzung("Frei/Belegt Symbole") ?>", url: "<?=$root ?>/backoffice/designBearbeiten/freiBelegtTisch.php" },
					{ text: "<?= getUebersetzung("Stile") ?>", url: "<?=$root ?>/backoffice/designBearbeiten/styles.php" },
					{ text: "<?= getUebersetzung("Standardwerte") ?>", url: "<?=$root ?>/backoffice/designBearbeiten/standardWerte.php" },
					{ text: "<?= getUebersetzung("Hochladen") ?>", url: "<?=$root ?>/backoffice/designBearbeiten/stylesHochladen.php" },
					{ text: "<?= getUebersetzung("Farbtabelle") ?>", url: "<?=$root ?>/backoffice/designBearbeiten/farbtabelle.php" },
					],
				"<?= getUebersetzung("Automatische e-Mails") ?>": [
					{ text: "<?= getUebersetzung("Reservierungsbestätigung") ?>", url: "<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=BUCHUNGS_BESTAETIGUNG?>=true" },
				{ text: "<?= getUebersetzung("Reservierung-Absage") ?>", url: "<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=BUCHUNGS_ABLEHNUNG?>=true" },
					{ text: "<?= getUebersetzung("Buchungs-Anfrage") ?>", url: "<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=ANFRAGE_BESTAETIGUNG?>=true" },
					{ text: "<?= getUebersetzung("E-mails senden") ?>", url: "<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=NEWSLETTER?>=true" },
					]
			};
              	this.getItem(0).cfg.setProperty("submenu", { id: "reservierungen", itemdata: oSubmenuData["<?= getUebersetzung("Reservierungen") ?>"] });
               this.getItem(2).cfg.setProperty("submenu", { id: "tischkarten", itemdata: oSubmenuData["<?= getUebersetzung("Tischkarten") ?>"] });
               this.getItem(3).cfg.setProperty("submenu", { id: "gaeste", itemdata: oSubmenuData["<?= getUebersetzung("Gäste") ?>"] });
               this.getItem(4).cfg.setProperty("submenu", { id: "benutzerdaten", itemdata: oSubmenuData["<?= getUebersetzung("Benutzerdaten") ?>"] });
			this.getItem(5).cfg.setProperty("submenu", { id:"raum", itemdata: oSubmenuData["<?= getUebersetzung("Raum") ?>"] });
			this.getItem(6).cfg.setProperty("submenu", { id:"tisch", itemdata: oSubmenuData["<?= getUebersetzung("Tisch") ?>"] });
			this.getItem(8).cfg.setProperty("submenu", { id:"divEinstellungen", itemdata: oSubmenuData["<?= getUebersetzung("Diverse Einstellungen") ?>"] });
			this.getItem(9).cfg.setProperty("submenu", { id:"design", itemdata: oSubmenuData["<?= getUebersetzung("Design") ?>"] });
			this.getItem(10).cfg.setProperty("submenu", { id:"eMails", itemdata: oSubmenuData["<?= getUebersetzung("Automatische e-Mails") ?>"] });
 			});
		oMenu.render();
	});
</script>
<div id="nav_sub"">
	<div class="bd"">
		<ul class="first-of-type">	 <?php
			//prüfen ob benutzer das recht hat den folgenden link auszuführen:
			if ($benutzerrechte >= 1 && $anzahlVorhandenerMietobjekte > 0) { ?>
				<li><a href="<?=$root ?>/backoffice/reservierung/index.php"><?php echo(getUebersetzung("Reservierungen")); ?></a></li>
				<li><a href="<?=$root ?>/backoffice/anfragenBearbeiten/index.php"><?php echo(getUebersetzung("Anfragen")); ?></a></li>
				<li><a href="<?=$root ?>/backoffice/tischkarten/index.php"><?= getUebersetzung("Tischkarten") ?></a></li>
				<li><a href="<?=$root ?>/backoffice/mieterBearbeiten/index.php"><?php echo(getUebersetzung("Gäste")); ?></a></li><?php		
			} //ende benutzerrechte >= 1
			if ($benutzerrechte == 1) {?>
				<li><a><?php echo(getUebersetzung("Benutzerdaten bearbeiten")); ?></a></li><?php	
			}
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren: 
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?=$root ?>/backoffice/benutzerBearbeiten/index.php"><?php echo(getUebersetzung("Benutzerdaten")); ?></a></li>
				<li><a href="<?=$root ?>/backoffice/raumBearbeiten/index.php"><?php echo(getUebersetzung("Raum")); ?></a></li><?php 
				//tisch bearbeiten nur wenn raum vorhanden:
				if (getAnzahlVorhandeneRaeume($gastro_id) > 0){	 ?>
					<li><a href="<?=$root ?>/backoffice/tischBearbeiten/index.php"><?php echo(getUebersetzung("Tisch")); ?></a></li><?php	
		 		} //ende genug tische	
			} 
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?=$root ?>/backoffice/vermieter/index.php"><?php echo(getUebersetzung("Stammdaten")); ?></a></li> <?php		
			} else if ($benutzerrechte == 1) { ?>
				<li><a><?php echo(getUebersetzung("Stammdaten bearbeiten")); ?></a></li><?php		
			} 
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?=$root ?>/backoffice/divEinstellungen/index.php"><?php echo(getUebersetzung("Diverse Einstellungen")); ?></a></li><?php		
			} else if ($benutzerrechte == 1) {  ?>
				<li><a><?php echo(getUebersetzung("Diverse Einstellungen")); ?></a></li><?php		
			}
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?=$root ?>/backoffice/designBearbeiten/index.php"><?php echo(getUebersetzung("Design")); ?></a></li> <?php		
			} else if ($benutzerrechte == 1) { ?>
				<li><a><?php echo(getUebersetzung("Design bearbeiten")); ?></a></li> <?php		
	  		}
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?=$root ?>/backoffice/autoResponse/index.php"><?php echo(getUebersetzung("Automatische e-Mails")); ?></a></li><?php		
			} else if ($benutzerrechte == 1) { ?>
				<li><a><?php echo(getUebersetzung("Automatische e-Mails")); ?></a></li><?php		
			} //ende if benutzerrechte <= 2 
			?>
		</ul>
    </div>        
</div> <!--end nav_sub-->