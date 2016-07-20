<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
?>
<div class="panel panel-default">
  <div class="panel-body">
  	
	<form action="./anfrage/index.php" method="post" name="reservierung" target="kalender" id="reservierung" class="form-horizontal">
        <h4><?php echo(getUebersetzung("Anfrage",$sprache,$link)); ?>: </h4>
                  
        <!-- zimmer auswaehlen: -->
        
        <!-- <table border="0" cellspacing="0" cellpadding="0" class="table">  
          <tr>
          	<td><h5><?php echo(getUebersetzung("von",$sprache,$link)); ?>:</h5></td>
          	<td></td>
          </tr>
          <tr>
          	<td colspan="2"><script>DateInput('datumVon', true, 'DD/MM/YYYY','<?php echo($startdatumDP); ?>')</script></td>
          </tr>
          <tr>
          	<td><h5><?php echo(getUebersetzung("bis",$sprache,$link)); ?>:</h5></td>
          	<td></td>
          </tr>
          <tr>
          	<td colspan="2"><script>DateInput('datumBis', true, 'DD/MM/YYYY','<?php echo($enddatumDP); ?>')</script></td>
          </tr>
          </table> -->
        
            <div class="form-group">
				<label for="pass" class="col-sm-2 control-label"><h5><?php echo(getUebersetzung("von",$sprache,$link)); ?>:</h5></label>
				<div class="col-sm-10 control lable">
				<label><script>DateInput('datumBis', true, 'DD/MM/YYYY','<?php echo($enddatumDP); ?>')</script></label>
					
				</div>
	</div>
	
	<div class="form-group">
				<label for="pass" class="col-sm-2 control-label"><h5><?php echo(getUebersetzung("bis",$sprache,$link)); ?>:</h5></label>
				<div class="col-sm-10 control lable">
				<label><script>DateInput('datumVon', true, 'DD/MM/YYYY','<?php echo($startdatumDP); ?>')</script></label>
					
				</div>
	</div>
	
	
        
          <!-- <tr>
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
                  <?php
					$res = getZimmer($unterkunft_id,$link);
	 				while($d = mysqli_fetch_array($res)) { ?>
	                  	<option <?php if ($zimmer_id == $d["PK_ID"]) {echo("selected");} ?> value="<?php echo $d["PK_ID"] ?>">
	                  	<?php
					  		$temp = $d["Zimmernr"]; 
					  		echo(getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link)); ?>
	                  	</option>
                  <?php } ?>
                </select>
              </div>
            </td>
          </tr> -->
          
                <div class="form-group">
	<label for="Jahr" class="col-sm-2 control-label"> 				
				<h4><?php
				if (getAnzahlZimmer($unterkunft_id,$link) > 1){
					echo(getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
				}
				else{
					echo(getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
				}
				?>         
              </h4>
     </label>

				<div class="col-sm-10">
					<select name="zimmer_id" class="form-control" id="zimmer_id">
                  <?php
					$res = getZimmer($unterkunft_id,$link);
	 				while($d = mysqli_fetch_array($res)) { ?>
	                  	<option <?php if ($zimmer_id == $d["PK_ID"]) {echo("selected");} ?> value="<?php echo $d["PK_ID"] ?>">
	                  	<?php
					  		$temp = $d["Zimmernr"]; 
					  		echo(getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link)); ?>
	                  	</option>
                  <?php } ?>
                </select>
				</div>
				     </div>	
				
			
        
        <!-- ende zimmer auswählen -->          
      
          
     
        
        <div align="left">
          <input name="reservierungAbsenden" type="submit" class="btn btn-success"  id="reservierungAbsenden" value="<?php echo(getUebersetzung("Anfrage absenden...",$sprache,$link)); ?>">
        </div>
      </form>
<br>
      <div align="left">
        <form action="./anfrage/anfragePerEMail.php" method="post" name="e_mail_form" target="kalender" class="form-horizontal">
			<input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
			<input name="jahr" type="hidden" value="<?php echo($jahr); ?>">
			<input name="monat" type="hidden" value="<?php echo($monat); ?>">			
          <input name="eMail" type="submit" class="btn btn-primary" id="eMail" value="<?php echo(getUebersetzung("Anfrage per E-Mail",$sprache,$link)); ?>">
        </form>
       </div>
      </div>
      </div>