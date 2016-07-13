<?php $root = "../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php");

?>
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo getUebersetzung("Diverse Einstellungen") ?></p>
<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
  <form action="./sprachen/sprachen.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Sprachen")); ?></td>
    <td><?php echo getUebersetzung("ändern der zur Auswahl stehenden Sprachen ihres Belegungsplanes") ?>.</td>
  </tr>
  </form>
  <?php if (MIETE == false){ ?>
	  <form action="./uebersetzungen/index.php" method="post" target="_self">
		  <tr>
		    <td><?php showSubmitButton(getUebersetzung("übersetzungen")); ?></td>
		    <td><?php echo getUebersetzung("Ändern der verwendeten übersetzungen") ?>.</td>
		  </tr>
	  </form>
  <?php } ?>
  <form action="./standardansicht/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Ansicht")); ?></td>
	    <td><?php echo getUebersetzung("ändern der Ansichten ihres Belegungsplanes") ?>.</td>
	  </tr>
   </form>
   <form action="./bilder/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Bilder")); ?></td>
	    <td><?php echo getUebersetzung("Einstellungen für Bilder der Mietobjekte") ?>.</td>
	  </tr>
    </form>
    <form action="./suche/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Suche")); ?></td>
	    <td><?php echo getUebersetzung("Einstellungen zur Suche nach Mietobjekten") ?>.</td>
	  </tr>
    </form>
    <form action="./links/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Links")); ?></td>
	    <td><?php echo getUebersetzung("Anzeigen aller Links zu ihren Mietobjekten") ?>.</td>
	  </tr>
    </form> 
    <!-- 
    <form action="./buchung/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Buchungseinschränkungen")); ?></td>
	    <td><?php echo getUebersetzung("Buchungen nur zu bestimmten Zeiten erlauben") ?>.</td>
	  </tr>
    </form>
    -->        
</table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>