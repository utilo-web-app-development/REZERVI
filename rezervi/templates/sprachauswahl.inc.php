<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
?>
<table  border="0" cellpadding="0" cellspacing="0" class="tableColor">
    	<?php 
    	//laender ausgeben die in den einstellungen definiert wurden:
    	if (isEnglishShown($unterkunft_id,$link) && $sprache != "en"){
    	?>
        <tr>
          <td width="1"><img src="./fahneEN.gif" width="25" height="16"></td>
          <td><div align="left"> <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=en" target="_parent" class="standardSchrift"> &nbsp;&nbsp;English</a></div></td>
        </tr>
        <?php
    	}
    	if (isFrenchShown($unterkunft_id,$link) && $sprache != "fr"){
        ?>
        <tr>
          <td width="1"><img src="./fahneFR.gif" width="25" height="16"></td>
          <td><div align="left"><a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=fr" target="_parent" class="standardSchrift">&nbsp;&nbsp;Francais</a></div></td>
        </tr>
        <?php
    	}
    	if (isGermanShown($unterkunft_id,$link) && $sprache != "de"){
        ?>
        <tr>
          <td width="1"><img src="./fahneDE.gif" width="25" height="16"></td>
          <td><div align="left"><a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=de" target="_parent" class="standardSchrift">&nbsp;&nbsp;Deutsch</a></div></td>
        </tr>
        <?php
    	}
    	if (isItalianShown($unterkunft_id,$link) && $sprache != "sp"){
        ?>
        <tr>
          <td width="1"><img src="./fahneIT.gif" width="25" height="16"></td>
          <td><div align="left"><a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=it" target="_parent" class="standardSchrift">&nbsp;&nbsp;Italia</a></div></td>
        </tr>
        <?php
    	}
    	if (isNetherlandsShown($unterkunft_id,$link) && $sprache != "nl"){
        ?>
        <tr>
          <td width="1"><img src="./fahneNL.gif" width="25" height="16"></td>
          <td><div align="left"><a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=nl" target="_parent" class="standardSchrift">&nbsp;&nbsp;Nederlande</a></div></td>
        </tr>
        <?php
    	}
    	if (isEspaniaShown($unterkunft_id,$link) && $sprache != "sp"){
        ?>
        <tr>
          <td width="1"><img src="./fahneSP.gif" width="25" height="16"></td>
          <td><div align="left"><a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=sp" target="_parent" class="standardSchrift">&nbsp;&nbsp;Espa�a</a></div></td>
        </tr>
        <?php
        }
    	if (isEstoniaShown($unterkunft_id,$link) && $sprache != "es"){
        ?>
        <tr>
          <td width="1"><img src="./fahneES.gif" width="25" height="16"></td>
          <td><div align="left"><a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=es" target="_parent" class="standardSchrift">&nbsp;&nbsp;Estnia</a></div></td>
        </tr>
        <?php
    	}
    	?>
    	<tr>
    		<td colspan="2">
				<?php
				  //bei reseller - reseller-link anzeigen:
				  if ($isReseller){
				  ?>
					<div align="left">
						<font size="2">
							<a href="<?php echo($resellerUrl); ?>" target="_top">Rezervi V 3.4.1<br/> 
					      		<?php echo($resellerName); ?>
					      	</a>
					     </font>
					</div>
				  <?php
				  }
				  else{
				  ?>
					<div align="left">
						<font size="2">
							<a href="http://www.rezervi.com/" target="_top">Rezervi V 3.4.1 &copy; </a>
							<a href="http://www.utilo.eu/" target="_top">UTILO</a>
						</font>
					</div>
				  <?php
				  }
				  ?>
    		</td>
    	</tr>
      </table>