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

<div class="panel panel-default">
  <div class="panel-body">
  	
<h4><?php echo(getUebersetzung("Belegungsplan für:",$sprache,$link)); ?></h4>
<br/>
  <!-- <form action="./ansichtWaehlen.php" method="post" name="ZimmerNrForm" target="kalender"> -->
   
   <form action="./ansichtWaehlen.php" method="post" name="ZimmerNrForm" target="kalender" class="form-horizontal">
			
			<div class="form-group">
				<label for="Jahr" class="col-sm-2 control-label"><?php echo(getUebersetzung("Jahr",$sprache,$link)); ?></label>
				<div class="col-sm-11">
					<select name="jahr" type="text" id="jahr" value="" class="form-control" onchange="zimmerNrFormJahrChanged()" >
						<?php				
			for ($l=getTodayYear(); $l < (getTodayYear()+4); $l++){ ?>
              <option value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
              <?php } ?>
            </select>
				</div>
			</div>		
        <!-- <span class="standardSchriftBold"><?php echo(getUebersetzung("Jahr",$sprache,$link)); ?></span></td>
        <<div align="right">
            <select name="jahr" class="tableColor" id="jahr" onchange="zimmerNrFormJahrChanged()">
              <?php				
			for ($l=getTodayYear(); $l < (getTodayYear()+4); $l++){ ?>
              <option value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
              <?php } ?>
            </select>
          </div></td>
      </tr> -->
      
			<div class="form-group">
				<label for="Jahr" class="col-sm-2 control-label"><?php echo(getUebersetzung("Monat",$sprache,$link)); ?></label>
				<div class="col-sm-11">
					<select name="monat" class="form-control" id="monat" onchange="zimmerNrFormJahrChanged()">
              <?php
			for ($i=1; $i<=12; $i++) { ?>
              <option value="<?php echo($i); ?>" <?php if ($i == parseMonthNumber(getTodayMonth())) echo("selected"); ?>><?php echo(getUebersetzung(parseMonthName($i),$sprache,$link)); ?></option>
              <?php } ?>
            </select>
				</div>
			</div>		
      <!-- <tr>
        <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Monat",$sprache,$link)); ?></span></td>
        <td><div align="right">
            <select name="monat" class="tableColor" id="monat" onchange="zimmerNrFormJahrChanged()">
              <?php
			for ($i=1; $i<=12; $i++) { ?>
              <option value="<?php echo($i); ?>" <?php if ($i == parseMonthNumber(getTodayMonth())) echo("selected"); ?>><?php echo(getUebersetzung(parseMonthName($i),$sprache,$link)); ?></option>
              <?php } ?>
            </select>
          </div></td>
      </tr> -->
      <?php
      //auswahl der zimmer:
      if ($showSelectRooms){
      ?>
      
      
      <div class="form-group">
				<label for="Jahr" class="col-sm-2 control-label"> <h4>				
				<?php
				if (getAnzahlZimmer($unterkunft_id,$link) > 1){
					echo(getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
				}
				else{
					echo(getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
				}
				?> 
          </h4></label>
				<div class="col-sm-11">
					<select name="zimmer_id" class="form-control" id="zimmer_id" onchange="zimmerNrFormJahrChanged()">
              <?php
				$res = getZimmer($unterkunft_id,$link);
 				while($d = mysqli_fetch_array($res)) { ?>
              <option <?php if ($zimmer_id == $d["PK_ID"]) {echo("selected");} ?> 
              	value="<?php echo $d["PK_ID"] ?>">
              <?php
			  		$temp = $d["Zimmernr"]; 
			  		echo(getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link)); ?>
              </option>
              <?php } ?>
            </select>
				</div>
			</div>		
			   
        <!-- </td>
        <td>
        	<div align="right">
            <select name="zimmer_id" class="tableColor" id="zimmer_id" onchange="zimmerNrFormJahrChanged()">
              <?php
				$res = getZimmer($unterkunft_id,$link);
 				while($d = mysqli_fetch_array($res)) { ?>
              <option <?php if ($zimmer_id == $d["PK_ID"]) {echo("selected");} ?> 
              	value="<?php echo $d["PK_ID"] ?>">
              <?php
			  		$temp = $d["Zimmernr"]; 
			  		echo(getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link)); ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </td>
      </tr> -->
      <?php
      }
      ?>

   
  </form>
       </div>
     </div>