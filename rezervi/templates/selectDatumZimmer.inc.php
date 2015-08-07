<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
 //die zimmerauswahl wird nicht angezeigt, wenn nur die gesamtansicht
 //angezeigt werden soll:
 $showGesamtansicht = getPropertyValue(SHOW_GESAMTANSICHT,$unterkunft_id,$link);
 $showSelectRooms = true;
 if ($showGesamtansicht == "true"){
	 $showMonatsansicht = getPropertyValue(SHOW_MONATSANSICHT,$unterkunft_id,$link);
	 $showJahresansicht = getPropertyValue(SHOW_JAHRESANSICHT,$unterkunft_id,$link);
	 if ($showMonatsansicht != "true" && $showJahresansicht != "true"){
	 	$showSelectRooms = false;
	 }
 }
 
?>
<span class="standardSchriftBold"><?php echo(getUebersetzung("Belegungsplan für:",$sprache,$link)); ?></span>
<br/>
  <form action="./ansichtWaehlen.php" method="post" name="ZimmerNrForm" target="kalender">
    <table border="0" cellspacing="3" cellpadding="0">
      <tr>
        <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Jahr",$sprache,$link)); ?></span></td>
        <td><div align="right">
            <select name="jahr" class="tableColor" id="jahr" onchange="zimmerNrFormJahrChanged()">
              <?php				
			for ($l=getTodayYear(); $l < (getTodayYear()+4); $l++){ ?>
              <option value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
              <?php } ?>
            </select>
          </div></td>
      </tr>
      <tr>
        <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Monat",$sprache,$link)); ?></span></td>
        <td><div align="right">
            <select name="monat" class="tableColor" id="monat" onchange="zimmerNrFormJahrChanged()">
              <?php
			for ($i=1; $i<=12; $i++) { ?>
              <option value="<? echo($i); ?>" <? if ($i == parseMonthNumber(getTodayMonth())) echo("selected"); ?>><? echo(getUebersetzung(parseMonthName($i),$sprache,$link)); ?></option>
              <? } ?>
            </select>
          </div></td>
      </tr>
      <?php
      //auswahl der zimmer:
      if ($showSelectRooms){
      ?>
      <tr>
        <td>
          <span class="standardSchriftBold">				
				<?php
				if (getAnzahlZimmer($unterkunft_id,$link) > 1){
					echo(getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
				}
				else{
					echo(getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
				}
				?> 
          </span>
        </td>
        <td>
        	<div align="right">
            <select name="zimmer_id" class="tableColor" id="zimmer_id" onchange="zimmerNrFormJahrChanged()">
              <?
				$res = getZimmer($unterkunft_id,$link);
 				while($d = mysql_fetch_array($res)) { ?>
              <option <? if ($zimmer_id == $d["PK_ID"]) {echo("selected");} ?> 
              	value="<? echo $d["PK_ID"] ?>">
              <?php
			  		$temp = $d["Zimmernr"]; 
			  		echo(getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link)); ?>
              </option>
              <? } ?>
            </select>
          </div>
        </td>
      </tr>
      <?php
      }
      ?>
    </table>
  </form>