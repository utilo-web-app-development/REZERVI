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
<link href="<?php echo $root ?>/backoffice/templates/yui_menu.css" rel="stylesheet" type="text/css">
<!-- Menu source file -->
<script type="text/javascript" src="<?php echo $root ?>/yui/build/menu/menu.js"></script>
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
				"<?php echo getUebersetzung("Reservierungen") ?>": [
					{ text: "<?php echo getUebersetzung("Tagesansicht") ?>", url: "<?php echo$root ?>/backoffice/reservierung/index.php?ansicht=Tagesansicht" },
					{ text: "<?php echo getUebersetzung("Listenansicht") ?>", url: "<?php echo$root ?>/backoffice/reservierung/index.php?ansicht=Listenansicht" },
					],				
				"<?php echo getUebersetzung("Tischkarten") ?>": [
					{ text: "<?php echo getUebersetzung("Design") ?>", url: "<?php echo$root ?>/backoffice/tischkarten/design/index.php" },
					{ text: "<?php echo getUebersetzung("Drucken") ?>", url: "<?php echo$root ?>/backoffice/tischkarten/print/index.php" },
					{ text: "<?php echo getUebersetzung("Übersicht") ?>", url: "<?php echo$root ?>/backoffice/tischkarten/resUebersicht/index.php" },
                       ],
				"<?php echo getUebersetzung("Gäste") ?>": [
					{ text: "<?php echo getUebersetzung("Anlegen") ?>", url: "<?php echo$root ?>/backoffice/mieterBearbeiten/mieterAnlegen/index.php" },
					{ text: "<?php echo getUebersetzung("Gästeliste") ?>", url: "<?php echo$root ?>/backoffice/mieterBearbeiten/mieterListe/index.php" },
					<?php /*
					{ text: "<?php echo getUebersetzung("Gruppen") ?>", url: "<?php echo$root ?>/backoffice/mieterBearbeiten/mieterGruppen/index.php" },
					*/ ?>
					],
				"<?php echo getUebersetzung("Benutzerdaten") ?>": [
					{ text: "<?php echo getUebersetzung("Ändern") ?>", url: "<?php echo$root ?>/backoffice/benutzerBearbeiten/benutzerAendern/index.php" },
					{ text: "<?php echo getUebersetzung("Löschen") ?>", url: "<?php echo$root ?>/backoffice/benutzerBearbeiten/benutzerLoeschen/index.php" },
					{ text: "<?php echo getUebersetzung("Anlegen") ?>", url: "<?php echo$root ?>/backoffice/benutzerBearbeiten/benutzerAnlegen_2/index.php" },
					],
				"<?php echo getUebersetzung("Raum") ?>": [
					{ text: "<?php echo getUebersetzung("Ändern") ?>", url: "<?php echo$root ?>/backoffice/raumBearbeiten/raumAendern/index.php" },
					{ text: "<?php echo getUebersetzung("Löschen") ?>", url: "<?php echo$root ?>/backoffice/raumBearbeiten/raumLoeschen/index.php" },
					{ text: "<?php echo getUebersetzung("Anlegen") ?>", url: "<?php echo$root ?>/backoffice/raumBearbeiten/raumAnlegen/index.php" },
					],
				"<?php echo getUebersetzung("Tisch") ?>": [
					<?php if (getAnzahlVorhandeneTische($gastro_id) > 0) { ?>
					{ text: "<?php echo getUebersetzung("Ändern") ?>", url: "<?php echo$root ?>/backoffice/tischBearbeiten/tischAendern/index.php" },
					{ text: "<?php echo getUebersetzung("Löschen") ?>", url: "<?php echo$root ?>/backoffice/tischBearbeiten/tischLoeschen/index.php" },
					{ text: "<?php echo getUebersetzung("Positionieren") ?>", url: "<?php echo$root ?>/backoffice/tischBearbeiten/tischPositionieren/index.php" },
					<?php /* 
					{ text: "<?php echo getUebersetzung("Gruppen") ?>", url: "<?php echo$root ?>/backoffice/tischBearbeiten/tischGruppen/index.php" },
					*/ ?>
					<?php } ?>
					{ text: "<?php echo getUebersetzung("Anlegen") ?>", url: "<?php echo$root ?>/backoffice/tischBearbeiten/tischAnlegen/index.php" },
					],
				"<?php echo getUebersetzung("Diverse Einstellungen") ?>": [
					{ text: "<?php echo getUebersetzung("Sprachen") ?>", url: "<?php echo$root ?>/backoffice/divEinstellungen/sprachen/sprachen.php" },
					{ text: "<?php echo getUebersetzung("Übersetzungen") ?>", url: "<?php echo$root ?>/backoffice/divEinstellungen/uebersetzungen/index.php" },
					{ text: "<?php echo getUebersetzung("Bilder") ?>", url: "<?php echo$root ?>/backoffice/divEinstellungen/bilder/index.php" },
					{ text: "<?php echo getUebersetzung("Links") ?>", url: "<?php echo$root ?>/backoffice/divEinstellungen/links/index.php" },
					{ text: "<?php echo getUebersetzung("Reservierungen") ?>", url: "<?php echo$root ?>/backoffice/divEinstellungen/buchung/index.php" },
					{ text: "<?php echo getUebersetzung("Registrierungen") ?>", url: "<?php echo$root ?>/backoffice/divEinstellungen/register/index.php" },
					],
				"<?php echo getUebersetzung("Design") ?>": [
					{ text: "<?php echo getUebersetzung("Frei/Belegt Symbole") ?>", url: "<?php echo$root ?>/backoffice/designBearbeiten/freiBelegtTisch.php" },
					{ text: "<?php echo getUebersetzung("Stile") ?>", url: "<?php echo$root ?>/backoffice/designBearbeiten/styles.php" },
					{ text: "<?php echo getUebersetzung("Standardwerte") ?>", url: "<?php echo$root ?>/backoffice/designBearbeiten/standardWerte.php" },
					{ text: "<?php echo getUebersetzung("Hochladen") ?>", url: "<?php echo$root ?>/backoffice/designBearbeiten/stylesHochladen.php" },
					{ text: "<?php echo getUebersetzung("Farbtabelle") ?>", url: "<?php echo$root ?>/backoffice/designBearbeiten/farbtabelle.php" },
					],
				"<?php echo getUebersetzung("Automatische e-Mails") ?>": [
					{ text: "<?php echo getUebersetzung("Reservierungsbestätigung") ?>", url: "<?php echo$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?php echoBUCHUNGS_BESTAETIGUNG?>=true" },
				{ text: "<?php echo getUebersetzung("Reservierung-Absage") ?>", url: "<?php echo$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?php echoBUCHUNGS_ABLEHNUNG?>=true" },
					{ text: "<?php echo getUebersetzung("Buchungs-Anfrage") ?>", url: "<?php echo$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?php echoANFRAGE_BESTAETIGUNG?>=true" },
					{ text: "<?php echo getUebersetzung("E-mails senden") ?>", url: "<?php echo$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?php echoNEWSLETTER?>=true" },
					]
			};
              	this.getItem(0).cfg.setProperty("submenu", { id: "reservierungen", itemdata: oSubmenuData["<?php echo getUebersetzung("Reservierungen") ?>"] });
               this.getItem(2).cfg.setProperty("submenu", { id: "tischkarten", itemdata: oSubmenuData["<?php echo getUebersetzung("Tischkarten") ?>"] });
               this.getItem(3).cfg.setProperty("submenu", { id: "gaeste", itemdata: oSubmenuData["<?php echo getUebersetzung("Gäste") ?>"] });
               this.getItem(4).cfg.setProperty("submenu", { id: "benutzerdaten", itemdata: oSubmenuData["<?php echo getUebersetzung("Benutzerdaten") ?>"] });
			this.getItem(5).cfg.setProperty("submenu", { id:"raum", itemdata: oSubmenuData["<?php echo getUebersetzung("Raum") ?>"] });
			this.getItem(6).cfg.setProperty("submenu", { id:"tisch", itemdata: oSubmenuData["<?php echo getUebersetzung("Tisch") ?>"] });
			this.getItem(8).cfg.setProperty("submenu", { id:"divEinstellungen", itemdata: oSubmenuData["<?php echo getUebersetzung("Diverse Einstellungen") ?>"] });
			this.getItem(9).cfg.setProperty("submenu", { id:"design", itemdata: oSubmenuData["<?php echo getUebersetzung("Design") ?>"] });
			this.getItem(10).cfg.setProperty("submenu", { id:"eMails", itemdata: oSubmenuData["<?php echo getUebersetzung("Automatische e-Mails") ?>"] });
 			});
		oMenu.render();
	});
</script>
<div id="nav_sub"">
	<div class="bd"">
		<ul class="first-of-type">	 <?php
			//prüfen ob benutzer das recht hat den folgenden link auszuführen:
			if ($benutzerrechte >= 1 && $anzahlVorhandenerMietobjekte > 0) { ?>
				<li><a href="<?php echo$root ?>/backoffice/reservierung/index.php"><?php echo(getUebersetzung("Reservierungen")); ?></a></li>
				<li><a href="<?php echo$root ?>/backoffice/anfragenBearbeiten/index.php"><?php echo(getUebersetzung("Anfragen")); ?></a></li>
				<li><a href="<?php echo$root ?>/backoffice/tischkarten/index.php"><?php echo getUebersetzung("Tischkarten") ?></a></li>
				<li><a href="<?php echo$root ?>/backoffice/mieterBearbeiten/index.php"><?php echo(getUebersetzung("Gäste")); ?></a></li><?php		
			} //ende benutzerrechte >= 1
			if ($benutzerrechte == 1) {?>
				<li><a><?php echo(getUebersetzung("Benutzerdaten bearbeiten")); ?></a></li><?php	
			}
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren: 
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?php echo$root ?>/backoffice/benutzerBearbeiten/index.php"><?php echo(getUebersetzung("Benutzerdaten")); ?></a></li>
				<li><a href="<?php echo$root ?>/backoffice/raumBearbeiten/index.php"><?php echo(getUebersetzung("Raum")); ?></a></li><?php 
				//tisch bearbeiten nur wenn raum vorhanden:
				if (getAnzahlVorhandeneRaeume($gastro_id) > 0){	 ?>
					<li><a href="<?php echo$root ?>/backoffice/tischBearbeiten/index.php"><?php echo(getUebersetzung("Tisch")); ?></a></li><?php	
		 		} //ende genug tische	
			} 
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?php echo$root ?>/backoffice/vermieter/index.php"><?php echo(getUebersetzung("Stammdaten")); ?></a></li> <?php		
			} else if ($benutzerrechte == 1) { ?>
				<li><a><?php echo(getUebersetzung("Stammdaten bearbeiten")); ?></a></li><?php		
			} 
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?php echo$root ?>/backoffice/divEinstellungen/index.php"><?php echo(getUebersetzung("Diverse Einstellungen")); ?></a></li><?php		
			} else if ($benutzerrechte == 1) {  ?>
				<li><a><?php echo(getUebersetzung("Diverse Einstellungen")); ?></a></li><?php		
			}
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?php echo$root ?>/backoffice/designBearbeiten/index.php"><?php echo(getUebersetzung("Design")); ?></a></li> <?php		
			} else if ($benutzerrechte == 1) { ?>
				<li><a><?php echo(getUebersetzung("Design bearbeiten")); ?></a></li> <?php		
	  		}
			//pruefen ob benutzer das recht hat den folgenden link auszufuehren:
			if ($benutzerrechte >= 2) { ?>
				<li><a href="<?php echo$root ?>/backoffice/autoResponse/index.php"><?php echo(getUebersetzung("Automatische e-Mails")); ?></a></li><?php		
			} else if ($benutzerrechte == 1) { ?>
				<li><a><?php echo(getUebersetzung("Automatische e-Mails")); ?></a></li><?php		
			} //ende if benutzerrechte <= 2 
			?>
		</ul>
    </div>        
</div> <!--end nav_sub-->