<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
?>
<!-- zimmersuche starten: -->
<div class="panel panel-default">
  <div class="panel-body">
  	
  <form action="./suche/index.php" method="post" name="suche" target="kalender" class="form-horizontal">
    <input name="keineSprache" type="hidden" value="true">
    <div align="left">
      <input name="suche" type="submit" id="suche" value="<?php echo(getUebersetzung("Suchformular öffnen",$sprache,$link)); ?>" class="btn btn-primary">
      <input name="jahr" type="hidden" id="jahr" value="<?php echo($jahr); ?>">
      <input name="monat" type="hidden" id="monat" value="<?php echo($monat); ?>">		  
    </div>
  </form>
  
</div>
</div>