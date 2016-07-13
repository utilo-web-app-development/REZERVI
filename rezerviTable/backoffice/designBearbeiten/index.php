<?php 
$root = "../..";
$ueberschrift = "Design";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/cssFunctions.inc.php"); 
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "designBearbeiten/index.php");
?>
			
<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm("<?php echo(getUebersetzung("Alle Änderungen verwerfen und auf Standardwerte zurücksetzen?")); ?>"); 	    
	    }
	    //-->
</script>

<?php
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<table>
	<tr height="30">
		<td><a href="<?php echo$root ?>/backoffice/designBearbeiten/freiBelegtTisch.php"><?php echo getUebersetzung("Frei/belegt Symbole") ?></a></td>
    	<td> - </td>
		<td><?php echo getUebersetzung("Ändern der Symbole für freie und belegte Tische") ?></td>
	</tr>
	<tr height="30">
		<td><a href="<?php echo$root ?>/backoffice/designBearbeiten/styles.php"><?php echo getUebersetzung("Stile ändern") ?></a></td>
    	<td> - </td>
		<td><?php echo getUebersetzung("Ändern der Symbole für freie und belegte Tische") ?> </td>
	</tr>
	<tr height="30">
		<td><a href="<?php echo$root ?>/backoffice/designBearbeiten/standardWerte.php"><?php echo getUebersetzung("Standardwerte setzen") ?></a></td>
    	<td> - </td>
		<td><?php echo(getUebersetzung("Alle Änderungen werden auf die Standard-Werte zurückgesetzt.")); ?></td>
	</tr>
	<tr height="30">
		<td><a href="<?php echo$root ?>/backoffice/designBearbeiten/stylesHochladen.php"><?php echo getUebersetzung("Stylesheet hochladen") ?></a></td>
    	<td> - </td>
		<td><?php echo(getUebersetzung("Kann auch eine externe Stylesheet Datei verwendet werden.")); ?></td>
	</tr>
	<tr height="30">
		<td><a href="<?php echo$root ?>/backoffice/designBearbeiten/farbtabelle.php"><?php echo getUebersetzung("Farbtabelle anzeigen") ?></a></td>
    	<td> - </td>
		<td><?php echo(getUebersetzung("Zeigt eine Tabelle mit Farbcodes an, die im Design verwendet werden können")); ?></td>
	</tr>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>
