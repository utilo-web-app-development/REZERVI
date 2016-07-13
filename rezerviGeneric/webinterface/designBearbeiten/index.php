<?php $root = "../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/cssFunctions.inc.php"); 
?>
			
<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm("<?php echo(getUebersetzung("Alle �nderungen verwerfen und auf Standardwerte zur�cksetzen?")); ?>"); 	    
	    }
	    //-->
</script>

<?php
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
?>

<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
  <tr valign="top">
    <td width="1">
    <form action="./styles.php" method="post" target="_self">
	   <input name="hintergrund" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Hintergrund")); ?>">
	   <input name="font_family" type="hidden" value="0">
	   <input name="font_size" type="hidden" value="0">
	   <input name="font_style" type="hidden" value="0">
	   <input name="font_weight" type="hidden" value="0">
	   <input name="text_align" type="hidden" value="0">
	   <input name="color" type="hidden" value="0">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo BACKGROUND_COLOR ?>">
    </form></td>
    <td><?php echo(getUebersetzung("�ndern der Hintergrundfarbe")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="resEingebenAendern" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Schrift")); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo STANDARD_SCHRIFT ?>">
    </form></td>
    <td><?php echo(getUebersetzung("�ndern der Standard-Schrift")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="ueberschrift" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("�berschrift")); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo UEBERSCHRIFT ?>">
    </form></td>
    <td><?php echo(getUebersetzung("�ndern der �berschriften")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="markierteSchrift" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("markierte Schrift")); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo STANDARD_SCHRIFT_BOLD ?>">
    </form></td>
    <td><?php echo(getUebersetzung("�ndern der markierten Schrift")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="buttonA" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Button")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="1">
	   <input name="width" type="hidden" value="1">
	   <input name="stylesheet" type="hidden" value="<?php echo BUTTON ?>">
    </form></td>
    <td><?php echo(getUebersetzung("�ndern des Buttons")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
		<input name="buttonB" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Button rollover")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="1">
	   <input name="width" type="hidden" value="1">
	   <input name="stylesheet" type="hidden" value="<?php echo BUTTON_HOVER ?>">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("�ndern des Buttons der angezeigt wird, wenn die Maus dar�ber bewegt wird")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
		<input name="tabelle" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Tabelle")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo TABLE_STANDARD ?>">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("�ndern der Tabellen")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="tabelleColor" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("f�rbige Tabelle")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo TABLE_COLOR ?>">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("�ndern der f�rbigen Tabellen")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="belegt" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("belegt")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo BELEGT ?>">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("�ndern der Farbe der belegt-Anzeige")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./styles.php" method="post" target="_self">
	<input name="frei" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("frei")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo FREI ?>">
	   </form>
    </td>
    <td><?php echo(getUebersetzung("�ndern der Farbe der frei-Anzeige")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./standardWerte.php" method="post" target="_self" onSubmit="return sicher()">
        <input name="standardwerte" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" id="resEingebenAendern" value="<?php echo(getUebersetzung("Standardwerte setzen")); ?>">
        </form></td>
    <td><?php echo(getUebersetzung("Alle �nderungen werden auf die Rezervi-Standard-Werte zur�ckgesetzt.")); ?></td>
  </tr>
  <tr valign="top">
    <td><form action="./farbtabelle.php" method="post" target="_self">
	<input name="farbtabelle" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" 
	   id="farbtabelle" value="<?php echo(getUebersetzung("Farbtabelle anzeigen")); ?>"></td>
    </form><td><?php echo(getUebersetzung("Zeigt eine Tabelle mit Farbcodes an, die im Design verwendet werden k�nnen")); ?></td>
  </tr>
</table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>
