<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
?>

    	<?php 
    	//laender ausgeben die in den einstellungen definiert wurden:
    	if (isEnglishShown($unterkunft_id,$link) && $sprache != "en"){
    	?>
   	
<div class="panel panel-default">
  <div class="panel-body">
 
        <img src="./fahneEN.gif" width="25" height="16">
       <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=en" target="_parent" class="standardSchrift"> &nbsp;&nbsp;English</a>
    <br>
        <?php
    	}
    	if (isFrenchShown($unterkunft_id,$link) && $sprache != "fr"){
        ?>
        
          <img src="./fahneFR.gif" width="25" height="16"> 
        <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=fr" target="_parent" class="standardSchrift">&nbsp;&nbsp;Francais</a>
     <br>   
        <?php
    	}
    	if (isGermanShown($unterkunft_id,$link) && $sprache != "de"){
        ?>
        
         <img src="./fahneDE.gif" width="25" height="16">
         <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=de" target="_parent" class="standardSchrift">&nbsp;&nbsp;Deutsch</a>
<br>
        <?php
    	}
    	if (isItalianShown($unterkunft_id,$link) && $sprache != "sp"){
        ?>
<br>      
         <img src="./fahneIT.gif" width="25" height="16">
         <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=it" target="_parent" class="standardSchrift">&nbsp;&nbsp;Italia</a>
        
        <?php
    	}
    	if (isNetherlandsShown($unterkunft_id,$link) && $sprache != "nl"){
        ?>
        
        <img src="./fahneNL.gif">
        <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=nl" target="_parent" class="standardSchrift">&nbsp;&nbsp;Nederlande</a>
        
        <?php
    	}
    	if (isEspaniaShown($unterkunft_id,$link) && $sprache != "sp"){
        ?>
       
          <img src="./fahneSP.gif" width="25" height="16">
         <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=sp" target="_parent" class="standardSchrift">&nbsp;&nbsp;España</a>
      
        <?php
        }
    	if (isEstoniaShown($unterkunft_id,$link) && $sprache != "es"){
        ?>
       
          <img src="./fahneES.gif">
         <a href="./start.php?unterkunft_id=<?php echo($unterkunft_id); ?>&zimmer_id=<?php echo($zimmer_id); ?>&sprache=es" target="_parent" class="standardSchrift">&nbsp;&nbsp;Estnia</a>
       
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
    	
    </div>
    </div>