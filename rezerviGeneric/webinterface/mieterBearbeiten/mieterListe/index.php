<? $root = "../../..";

/*   
	date: 14.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include($root."/webinterface/templates/header.inc.php");
include($root."/webinterface/templates/bodyStart.inc.php"); 

if (isset($_POST["index"]) && $_POST["index"] != ""){
	$index = $_POST["index"];
}
else{
	$index = 0;
}

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 

?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    return confirm('<?php echo(getUebersetzung("Mieter wirklich löschen?")); ?>'); 	    
	    }
	//-->
</script>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mieter Liste")); ?>.</p>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
        <tr>
          <th nowrap="nowrap"><div align="left"><?= getUebersetzung("Anrede") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Vorname") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Nachname") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Firma") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Straße/Hausnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("PLZ") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Ort") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Land") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("E-Mail-Adresse") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Telefonnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("2. Telefonnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Faxnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Homepage") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?= getUebersetzung("Sprache") ?></div></th>
        </tr>
    
    <?php 

	$res = getMieterListWithLimitAndIndex($vermieter_id,$index);
		
	while ($d = mysql_fetch_array($res)){
		
		$mieter_id = $d["MIETER_ID"];
		$vorname = $d["VORNAME"];
		$nachname = $d["NACHNAME"];
		$strasse = $d["STRASSE"];
		$plz = $d["PLZ"];
		$ort = $d["ORT"];
		$land = $d["LAND"];
		$email = $d["EMAIL"];
		$tel = $d["TELEFON"];
		$tel2 = $d["TELEFON2"];
		$fax = $d["FAX"];
		$anrede = $d["ANREDE"];
		$url = $d["URL"];
		$speech_id = $d["SPRACHE_ID"];
		$speech = getBezeichnungOfSpracheID($speech_id);
		$firma = $d["FIRMA"];
	
	?>
        <tr>
        	<td colspan="14">
        		<hr class="<?= TABLE_STANDARD ?>"/>
        	</td>
        </tr>
        <tr>
          <td><?= $anrede ?></td>
          <td><?= $vorname ?></td>
          <td><?= $nachname ?></td>
		  <td><?= $firma ?></td>	          
          <td><?= $strasse ?></td>
          <td><?= $plz ?></td>
          <td><?= $ort ?></td>
          <td><?= $land ?></td>
          <td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
          <td><?= $tel ?></td>
          <td><?= $tel2 ?></td>
          <td><?= $fax ?></td>
          <td><?= $url ?></td>
          <td><?= $speech ?></td>
        </tr>
        <tr>
          <td colspan="11">
		  <table border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><form action="./mieterBearbeiten/index.php" method="post" name="gastBearbeiten" target="_self">
                    <div align="right">
 					  <input name="index" type="hidden" value="<?= $index ?>"/>
                      <input name="mieter_id" type="hidden" id="gast_id" value="<?= $mieter_id ?>">
                      <input name="gastBearbeiten" type="submit" id="gastBearbeiten" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       					onMouseOut="this.className='<?= BUTTON ?>';" value="<?= getUebersetzung("Mieter bearbeiten") ?>">
                    </div>
                  </form></td>
                <td><form action="./mieterInfos/index.php" method="post" name="gastInfos" target="_self">
                    <div align="right">
                      <input name="gastInfos" type="submit" id="gastInfos" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       					onMouseOut="this.className='<?= BUTTON ?>';" value="<?= getUebersetzung("Reservierungs-Informationen") ?>">
					  <input name="mieter_id" type="hidden" id="gast_id" value="<?= $mieter_id ?>">
					  <input name="index" type="hidden" value="<?= $index ?>"/>
                    </div>
                  </form></td>
                <td><form action="./mieterLoeschen/index.php" method="post" name="gastLoeschen" target="_self" onSubmit="return sicher()">
                    <div align="right">
                      <input name="gastLoeschen" type="submit" id="gastLoeschen" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       					onMouseOut="this.className='<?= BUTTON ?>';" value="<?= getUebersetzung("Mieter löschen") ?>">
                      <input name="mieter_id" type="hidden" id="gast_id" value="<?= $mieter_id ?>">
					  <input name="index" type="hidden" value="<?= $index ?>"/>
                    </div>
                  </form></td>
              </tr>
            </table></td>
        </tr>
      <?php } //ende while
	?>
	      </table>
      <br/>
    </td>
  </tr>
  	<tr> 
      <td>
		<table>
			<tr>
			<?php
			if (($index - LIMIT_MIETERLISTE) > -1){
			?>
				<td>
					<form action="./index.php" method="post" name="zurueck" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?= $index-LIMIT_MIETERLISTE ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("zurückblättern"));
					?>
					</form>
				</td>
			<?php
			}
			if (($index + LIMIT_MIETERLISTE) < getAnzahlMieter($vermieter_id)){
			?>
				<td><form action="./index.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?= $index+LIMIT_MIETERLISTE ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("weiterblättern"));
					?>
					</form>
				</td>
			<?php
			}
			?>
			</tr>
		</table>
      </td>
    </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
<form action="./export/csv.php" method="post" name="hauptmenue" id="hauptmenue">
  <tr>
    <td><select name="format" size="1" class="<?= BUTTON ?>">
      <option value="csv"><?= getUebersetzung("Text") ?> CSV</option>
    </select></td>
    <td><input name="exportieren" type="submit" class="<?= BUTTON ?>" 
			value="<?= getUebersetzung("exportieren") ?>"
			 onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		 onMouseOut="this.className='<?= BUTTON ?>';"></td>
    <td>&nbsp;</td>
  </tr>
 </form>
</table>
<br/>
	 <table  border="0" cellspacing="1" cellpadding="0" class="<?= TABLE_STANDARD ?>">
        <tr>
          <td><form action="../../mieterBearbeiten/index.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
              <input name="zurueck" type="submit" class="<?= BUTTON ?>" id="zurueck" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?= BUTTON ?>';" value="<?= getUebersetzung("zurück") ?>">
            </form></td>
        </tr>
      </table>
      <br/>
<?php	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
