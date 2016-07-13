<?php 
$root = "../../..";
$ueberschrift = "Gäste bearbeiten";
$unterschrift = "Gästeliste";

/*   
	date: 14.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
if(isset($_POST["root"])){
	$root = $_POST["root"];
}
include($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Gäste", "mieterBearbeiten/index.php",
							$unterschrift, "mieterBearbeiten/mieterListe/index.php");
include($root."/backoffice/templates/bodyStart.inc.php"); 

if (isset($_POST["index"]) && $_POST["index"] != ""){
	$index = $_POST["index"];
}
else{
	$index = 0;
}

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 

?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    return confirm('<?php echo(getUebersetzung("Gast wirklich löschen?")); ?>'); 	    
	    }
	//-->
</script>
<h2><?php echo(getUebersetzung("Gästeliste")); ?></h2>
<table>
	<tr>
		<th align="left"> <?php echo getUebersetzung("Vorname") ?></th>
		<th align="left"> <?php echo getUebersetzung("Nachname") ?></th>
		<th align="left"> <?php echo getUebersetzung("E-Mail-Adresse") ?></th>
	</tr>   <?php
	$res = getMieterListWithLimitAndIndex($gastro_id,$index);
	if (getAnzahlMieter($gastro_id) < 1){	?>	
	<tr>
		<td colspan="3">
		<?php echo getUebersetzung("Sie haben noch keine Gäste in ihrer Datenbank.") ?>
		</td>
	</tr><?php
	}	
	while ($d = $res->FetchNextObject()){		
		$mieter_id = $d->GAST_ID;
		$vorname = $d->VORNAME;
		$nachname = $d->NACHNAME;
		$email = $d->EMAIL; ?>
	<tr>
		<td colspan="3"><hr/></td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;<?php echo $vorname ?></td>
		<td>&nbsp;&nbsp;<?php echo $nachname ?></td>
		<td>&nbsp;&nbsp;<a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td>
	</tr>
	<tr>
		<td colspan="3">
			<table>
				<tr>
					<td>
						<form action="<?php echo$root?>/backoffice/mieterBearbeiten/mieterListe/mieterBearbeiten/index.php" method="post" name="gastBearbeiten" target="_self">
						<div align="right">
						<input name="index" type="hidden" value="<?php echo $index ?>"/>
						<input name="mieter_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
						<input name="gastBearbeiten" type="submit" id="gastBearbeiten" class="button" value="<?php echo getUebersetzung("Gast bearbeiten") ?>">
	                    </div></form>
					</td>
					<td>
						<form action="<?php echo$root?>/backoffice/mieterBearbeiten/mieterListe/mieterInfos/index.php" method="post" name="gastInfos" target="_self">
	                    <div align="right">
						<input name="gastInfos" type="submit" id="gastInfos" class="button" value="<?php echo getUebersetzung("Reservierungs-Informationen") ?>">
						<input name="mieter_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
						<input name="index" type="hidden" value="<?php echo $index ?>"/>
	                    </div></form>
                   	</td>
					<td>
						<form action="<?php echo$root?>/backoffice/mieterBearbeiten/mieterListe/mieterLoeschen/index.php" method="post" name="gastLoeschen" target="_self" onSubmit="return sicher()">
	                    <div align="right">
						<input name="gastLoeschen" type="submit" id="gastLoeschen" class="button" value="<?php echo getUebersetzung("Gast löschen") ?>">
						<input name="mieter_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
						<input name="index" type="hidden" value="<?php echo $index ?>"/>
	                    </div></form>
                    </td>
				</tr>
			</table>
		</td>
	</tr> <?php 
	} //ende while
	?>
	<tr>
		<td colspan="3"><hr/></td>
	</tr>
  	<tr> 
      <td colspan="3">
		<table width="100%">
			<tr>
				<td>
					<div  align="right">
					<form action="<?php echo$root?>/backoffice/mieterBearbeiten/mieterListe/index.php" method="post" name="zurueck" target="_self" enctype="multipart/form-data"><?php
			if (($index - LIMIT_MIETERLISTE) > -1){ ?>					
					<input name="index" type="hidden" value="<?php echo $index-LIMIT_MIETERLISTE ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("zurückblättern"));
			}else{
				showSubmitButtonNo(getUebersetzung("zurückblättern"));
			}?>	
					</form>
					</div>
				</td>
				<td>
					<form action="<?php echo$root?>/backoffice/mieterBearbeiten/mieterListe/index.php" method="post" name="weiter" target="_self" enctype="multipart/form-data"><?php
			if (($index + LIMIT_MIETERLISTE) < getAnzahlMieter($gastro_id)){?>
					<input name="index" type="hidden" value="<?php echo $index+LIMIT_MIETERLISTE ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("weiterblättern"));
			}else{
				showSubmitButtonNo(getUebersetzung("weiterblättern"));
			}?>
					</form>
				</td>
			</tr>
		</table>		
    </td>
	</tr>
</table>
<br/>
<table>
	<form action="<?php echo$root?>/backoffice/mieterBearbeiten/mieterListe/export/csv.php" method="post" name="hauptmenue" id="hauptmenue">
  <tr>
    <td><select name="format" size="1" class="button">
      <option value="csv"><?php echo getUebersetzung("Text") ?> CSV</option>
    </select></td>
    <td><input name="exportieren" type="submit" class="button" 
			value="<?php echo getUebersetzung("exportieren") ?>"></td>
    <td>&nbsp;</td>
  </tr>
 </form>
</table>
<?php	  
include_once($root."/backoffice/templates/footer.inc.php");
?>
