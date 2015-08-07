<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
?>
<!-- zimmersuche starten: -->
  <form action="./suche/index.php" method="post" name="suche" target="kalender">
    <input name="keineSprache" type="hidden" value="true">
    <div align="left">
      <input name="suche" type="submit" id="suche" value="<?php echo(getUebersetzung("Suchformular öffnen",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
	   onMouseOut="this.className='button200pxA';">
      <input name="jahr" type="hidden" id="jahr" value="<? echo($jahr); ?>">
      <input name="monat" type="hidden" id="monat" value="<? echo($monat); ?>">		  
    </div>
  </form>