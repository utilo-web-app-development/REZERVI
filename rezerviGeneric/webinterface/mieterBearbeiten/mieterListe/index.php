<?php $root = "../../..";

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
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mieter Liste")); ?>.</p>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="3" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
        <tr>
          <th nowrap="nowrap"><div align="left"><?php echo getUebersetzung("Anrede") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Vorname") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Nachname") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Firma") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Straße/Hausnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("PLZ") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Ort") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Land") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("E-Mail-Adresse") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Telefonnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("2. Telefonnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Faxnummer") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Homepage") ?></div></th>
          <th nowrap="nowrap"><div align="left">| <?php echo getUebersetzung("Sprache") ?></div></th>
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
        		<hr class="<?php echo TABLE_STANDARD ?>"/>
        	</td>
        </tr>
        <tr>
          <td><?php echo $anrede ?></td>
          <td><?php echo $vorname ?></td>
          <td><?php echo $nachname ?></td>
		  <td><?php echo $firma ?></td>	          
          <td><?php echo $strasse ?></td>
          <td><?php echo $plz ?></td>
          <td><?php echo $ort ?></td>
          <td><?php echo $land ?></td>
          <td><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td>
          <td><?php echo $tel ?></td>
          <td><?php echo $tel2 ?></td>
          <td><?php echo $fax ?></td>
          <td><?php echo $url ?></td>
          <td><?php echo $speech ?></td>
        </tr>
        <tr>
          <td colspan="11">
		  <table border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><form action="./mieterBearbeiten/index.php" method="post" name="gastBearbeiten" target="_self">
                    <div align="right">
 					  <input name="index" type="hidden" value="<?php echo $index ?>"/>
                      <input name="mieter_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
                      <input name="gastBearbeiten" type="submit" id="gastBearbeiten" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       					onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo getUebersetzung("Mieter bearbeiten") ?>">
                    </div>
                  </form></td>
                <td><form action="./mieterInfos/index.php" method="post" name="gastInfos" target="_self">
                    <div align="right">
                      <input name="gastInfos" type="submit" id="gastInfos" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       					onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo getUebersetzung("Reservierungs-Informationen") ?>">
					  <input name="mieter_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
					  <input name="index" type="hidden" value="<?php echo $index ?>"/>
                    </div>
                  </form></td>
                <td><form action="./mieterLoeschen/index.php" method="post" name="gastLoeschen" target="_self" onSubmit="return sicher()">
                    <div align="right">
                      <input name="gastLoeschen" type="submit" id="gastLoeschen" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       					onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo getUebersetzung("Mieter löschen") ?>">
                      <input name="mieter_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
					  <input name="index" type="hidden" value="<?php echo $index ?>"/>
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
					<input name="index" type="hidden" value="<?php echo $index-LIMIT_MIETERLISTE ?>"/>
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
					<input name="index" type="hidden" value="<?php echo $index+LIMIT_MIETERLISTE ?>"/>
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
<table border="0" cellspacing="3" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
<form action="./export/csv.php" method="post" name="hauptmenue" id="hauptmenue">
  <tr>
    <td><select name="format" size="1" class="<?php echo BUTTON ?>">
      <option value="csv"><?php echo getUebersetzung("Text") ?> CSV</option>
    </select></td>
    <td><input name="exportieren" type="submit" class="<?php echo BUTTON ?>" 
			value="<?php echo getUebersetzung("exportieren") ?>"
			 onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		 onMouseOut="this.className='<?php echo BUTTON ?>';"></td>
    <td>&nbsp;</td>
  </tr>
 </form>
</table>
<br/>
	 <table  border="0" cellspacing="1" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
        <tr>
          <td><form action="../../mieterBearbeiten/index.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
              <input name="zurueck" type="submit" class="<?php echo BUTTON ?>" id="zurueck" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo getUebersetzung("zurück") ?>">
            </form></td>
        </tr>
      </table>
      <br/>
<?php	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
