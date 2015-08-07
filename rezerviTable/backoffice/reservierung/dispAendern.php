<?php

/*
 * Created on 10.12.2007
 * Author: LI Haitao
 *  
 */
 
if (isset($_POST["root"])){
	$root = $_POST["root"];
}else if(isset($_GET["root"])){
	$root = $_GET["root"];
}
if (isset($_POST["gastro_id"])){
	$gastro_id = $_POST["gastro_id"];
}else if(isset($_GET["gastro_id"])){
	$gastro_id = $_GET["gastro_id"];
}
if (isset($_POST["sprache"])){
	$sprache = $_POST["sprache"];
}else if(isset($_GET["sprache"])){
	$sprache = $_GET["sprache"];
}
if (isset($_POST["raum_id"])){
	$raum_id = $_POST["raum_id"];
}else if(isset($_GET["raum_id"])){
	$raum_id = $_GET["raum_id"];
}
if (isset($_POST["tisch_id"])){
	$tisch_id = $_POST["tisch_id"];
}else if(isset($_GET["tisch_id"])){
	$tisch_id = $_GET["tisch_id"];
}
if (isset($_POST["vonStunde"])){
	$vonStunde = $_POST["vonStunde"];
}else if(isset($_GET["vonStunde"])){
	$vonStunde = $_GET["vonStunde"];
}
if (isset($_POST["vonMinute"])){
	$vonMinute = $_POST["vonMinute"];
}else if(isset($_GET["vonMinute"])){
	$vonMinute = $_GET["vonMinute"];
}
if (isset($_POST["tag"])){
	$tag = $_POST["tag"];
}else if(isset($_GET["tag"])){
	$tag = $_GET["tag"];
}
if (isset($_POST["monate"])){
	$monate = $_POST["monate"];
}else if(isset($_GET["monate"])){
	$monate = $_GET["monate"];
}
if (isset($_POST["jahr"])){
	$jahr = $_POST["jahr"];
}else if(isset($_GET["jahr"])){
	$jahr = $_GET["jahr"];
}

include_once($root."/backoffice/templates/functions.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/templates/constants.inc.php");
$ansicht = "Tagesansicht";
if(isset($_POST["reservierung_id"])){
	$reservierung_id = $_POST["reservierung_id"];
}else{
	$resIds = getReservierungIDs($tisch_id,$vonMinute,$vonStunde,$tag,$monate,$jahr,$vonMinute,$vonStunde,$tag,$monate,$jahr);
	if($d = $resIds->FetchNextObject()){
		$reservierung_id = $d->RESERVIERUNG_ID;
		$timeVon = getTimeVonOfReservierung($reservierung_id);
		$vonStunde = getHourFromTime($timeVon);
		$vonMinute = getMinuteFromTime($timeVon);
		$timeBis = getTimeBisOfReservierung($reservierung_id);	
		$bisStunde = getHourFromTime($timeBis);
		$bisMinute = getMinuteFromTime($timeBis);
	}else{
		return;
	}
}
$gast_id = getMieterIdOfReservierung($reservierung_id);
if ($gast_id != ANONYMER_GAST_ID){
	$gastName = getMieterVorname($gast_id)." ".getNachnameOfMieter($gast_id);					
}else{
	$gastName = (getUebersetzung("Anonymer Gast"));
} 	
?>

<link href="<?= $root ?>/backoffice/templates/yui_panel.css" rel="stylesheet" type="text/css"><?php
if (isset($nachricht) && $nachricht != ""){ ?>

	<table>
		<tr><?php 
		if (isset($fehler) && $fehler == true) { ?>
			<td style="color: #FFFFFF;	background-color: #FF0000;	border: 1px ridge #000000;	text-align: center;">
	   		<?php echo(getUebersetzung($nachricht)); ?>
			</td>	<?php
		}else if(isset($info) && $info == true){?>
			<td style="color: #FFFFFF;	background-color: #009BFA;	border: 1px ridge #000000;	text-align: center;">
			<?php echo(getUebersetzung($nachricht)); ?>
			</td>	<?php
		}	?>
		</tr>
	</table>
	
<?php
}  
?>
<table>
	<tr>
		<td><?= getUebersetzung("Gastname: ") ?></td>
		<td><?= $gastName ?></td>
	</tr>
</table>
<hr/>
<table>
	<form action="index.php" method="post" name="zeitAendern" target="_parent">
		<input name="root" type="hidden" id="root" value="<?= $root  ?>"/>
		<input name="gastro_id" type="hidden" id="gastro_id" value="<?= $gastro_id ?>"/>
		<input name="sprache" type="hidden" id="sprache" value="<?= $sprache ?>"/>
		<input name="doChangeReservation" type="hidden" value="true"/>
		<tr>
			<td align="left"><?= getUebersetzung("Tisch") ?>:</td>
			<td><select name="table_id"  id="table_id"> <?
				$rooms = getRaeume($gastro_id);
				while($room = $rooms->FetchNextObject()){
					$tables = getTische($room->RAUM_ID);
					while($table = $tables->FetchNextObject()) { ?>
					<option value="<? echo $table->TISCHNUMMER  ?>"<? if ($tisch_id == $table->TISCHNUMMER) {echo(" selected=\"selected\"");} ?>>
							<?php echo($table->TISCHNUMMER); ?>
					</option> 
					<?  
					}
				} ?>
				</select>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td><?php echo(getUebersetzung("von")); ?>:</td>
		   	<td><select name="vonStunde"  id="vonStunde" onchange="javascript:refresh();"> <?php				
				for ($l=0; $l < 24; $l++){ 
					if ($l<10){
						$l="0".$l;
					} ?>
					<option value="<?php echo $l ?>"<?php if ($l == $vonStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option> <?php 
				} ?>
			   	</select>
			</td>
			<td>
			    <select name="vonMinute"  id="vonMinute"  onchange="javascript:refresh();"> <?php				
				for ($l=0; $l < 2; $l++){ 
					$min = $l * 30;
					if($min == 0){
						$min="0".$min;
					} ?>
			        <option value="<?php echo $min ?>"<?php if ($min <= $vonMinute) echo(" selected=\"selected\""); ?>><?php echo $min ?></option> <?php 
				} ?>
				</select> 
			</td>
			<td width=20>&nbsp;</td>
			<td align="left"><?php echo(getUebersetzung("bis")); ?>:</td>
		    <td>
		    	<select name="bisStunde"  id="bisStunde">
		    	<?php	
				$dauer_default = getGastroProperty(RESERVIERUNGSDAUER,$gastro_id);	
				if (isset($_POST["bisStunde"])){
					$bisStunde = $_POST["bisStunde"];
					$bisMinute = $_POST["bisMinute"];
					$dauer = ($bisStunde-$vonStunde)*60 + $bisMinute - $vonMinute;
					if($dauer-$dauer_default<0){
						$dauerStunde = (int)($dauer_default/60);
						$dauerMinute = $dauer_default - $dauerStunde*60;
						$bisStunde = $vonStunde + $dauerStunde;
						$bisMinute = $vonMinute + $dauerMinute;
						if($bisStunde>=24){
							$bisStunde = 23;
							$bisMinute = 59;
						}else if($bisStunde==23 && $bisMinute>=60){			            	
							$bisMinute = 59;
						}else if($bisMinute>=60){
							$bisStunde = $bisStunde + 1;
							$bisMinute = $bisMinute - 60;
						}
					}
				}
				for ($l=0; $l < 24; $l++){ 
					if ($l<10){
						$l="0".$l;
					}	?>
			       	<option value="<?php echo $l ?>"<?php if ($l == $bisStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option><?php 
				}?>
			    </select>
			</td>
			<td>
			   	<select name="bisMinute"  id="bisMinute"> 
				<?php				
				for ($l=0; $l < 2; $l++){ 
					$min = $l * 30;
					if($l==0){
						$min="0".$min;
					}?>
			        <option value="<?php echo $min ?>"<?php if ($min <= $bisMinute) echo(" selected=\"selected\""); ?>><?php echo $min ?></option> <?php 
			  	} ?>
			    </select>
			</td>
		</tr>
	</table>
	<hr/>
	<table>
		<tr>
			<td>
				<input name="reservierung_id" type="hidden" value="<?= $reservierung_id ?>"/>	
				<input name="raum_id" type="hidden" value="<?= $raum_id ?>"/>
				<input name="tisch_id" type="hidden" value="<?= $tisch_id ?>"/>
				<input name="tag" type="hidden" id="tag" value="<?= $tag ?>"/>
				<input name="monate" type="hidden" id="tonat" value="<?= $monate ?>"/>
				<input name="jahr" type="hidden" id="jahr" value="<?= $jahr ?>"/>
				<input name="datumVon" type="hidden" value="<?= $tag."/".$monate."/".$jahr ?>"/>
				<input type="submit" name="Submit"  class="button"
						value="<?php echo(getUebersetzung("speichern")); ?>"/>						
			</td>
		</tr>
	</form>
	<form action="./index.php" method="post" name="entf<?php echo($tag); ?>" target="_parent">
		<tr>
			<td>
				<input name="reservierung_id" type="hidden" value="<?= $reservierung_id ?>"/>
				<input name="doDeleteReservierung" type="hidden" value="true"/>	
				<input type="submit" name="Submit" class="button"
						value="<?php echo(getUebersetzung("Entfernen")); ?>"/>						
			</td>
		</tr>
	</form>
</table> 