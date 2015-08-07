<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
?>
	<form action="./anfrage/index.php" method="post" name="reservierung" target="kalender" id="reservierung">
        <p class="standardSchriftBold"><?php echo(getUebersetzung("Anfrage",$sprache,$link)); ?>: <br/>
                  
        <!-- zimmer auswaehlen: -->
        <table border="0" cellspacing="0" cellpadding="0">  
          <tr>
          	<td><span class="standardSchriftBold"><?php echo(getUebersetzung("von",$sprache,$link)); ?>:</span></td>
          	<td></td>
          </tr>
          <tr>
          	<td colspan="2"><script>DateInput('datumVon', true, 'DD/MM/YYYY','<?php echo($startdatumDP); ?>')</script></td>
          </tr>
          <tr>
          	<td><span class="standardSchriftBold"><?php echo(getUebersetzung("bis",$sprache,$link)); ?>:</span></td>
          	<td></td>
          </tr>
          <tr>
          	<td colspan="2"><script>DateInput('datumBis', true, 'DD/MM/YYYY','<?php echo($enddatumDP); ?>')</script></td>
          </tr>
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
                <select name="zimmer_id" class="tableColor" id="zimmer_id">
                  <?
					$res = getZimmer($unterkunft_id,$link);
	 				while($d = mysql_fetch_array($res)) { ?>
	                  	<option <? if ($zimmer_id == $d["PK_ID"]) {echo("selected");} ?> value="<? echo $d["PK_ID"] ?>">
	                  	<?php
					  		$temp = $d["Zimmernr"]; 
					  		echo(getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link)); ?>
	                  	</option>
                  <? } ?>
                </select>
              </div>
            </td>
          </tr>
        </table>
        <!-- ende zimmer auswählen -->          
          
        </p>
        
        <div align="left">
          <input name="reservierungAbsenden" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="reservierungAbsenden" value="<?php echo(getUebersetzung("Anfrage absenden...",$sprache,$link)); ?>">
        </div>
      </form>

      <div align="left">
        <form action="./anfrage/anfragePerEMail.php" method="post" name="e_mail_form" target="kalender">
			<input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
			<input name="jahr" type="hidden" value="<?php echo($jahr); ?>">
			<input name="monat" type="hidden" value="<?php echo($monat); ?>">			
          <input name="eMail" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" id="eMail" value="<?php echo(getUebersetzung("Anfrage per E-Mail",$sprache,$link)); ?>">
        </form>
      </div>