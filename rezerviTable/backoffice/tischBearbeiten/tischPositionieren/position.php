<?php 
$root = "../../..";
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Positionieren";

/**   
	date: 1.2.07
	author: christian osterrieder alpstein-austria	
	postitionierung eines tisches im raum.					
*/

//constante für default transparenz wert:
define("TRANSPARENZ",30);

include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");

if (isset($_POST["raum_id"]) && !isset($_POST["tisch_id"]) ){
	$raum_id = $_POST["raum_id"];
	$tisch_id = getFirstTischId($raum_id);
}else if(isset($_POST["tisch_id"])){
	$tisch_id = $_POST["tisch_id"];
	$raum_id  = getRaumOfTisch($tisch_id);
}
$tische  = getTische($raum_id);
$bilder_id  = getBildOfRaum($raum_id); 
$bildbreite = getBildBreite($bilder_id);
$bildhoehe  = getBildHoehe($bilder_id);

//position des tisches:
if (isset($_POST["top"]) && isset($_POST["left"])){
	$top = $_POST["top"];
	$left= $_POST["left"];
	updateTischPos($top,$left,$_POST["tisch_id_prev"]);
	$width = $_POST["breite"];
	$height= $_POST["hoehe"];
	updateTischSize($width,$height,$_POST["tisch_id_prev"]);	
}
//wurde auf speichern geklickt?
if (isset($_POST[getUebersetzung("speichern")])){
	$info = true;
	$nachricht = "Die Position des Tisches wurde erfolgreich gespeichert.";
	include_once("./index.php");
}

$top = getTopPosOfTisch($tisch_id);
$left=getLeftPosOfTisch($tisch_id);
$width=getWidthOfTisch($tisch_id);
$height=getHeightOfTisch($tisch_id);	
	
?>
<style type="text/css">
    #panelDiv {
        position:relative; 
        height: <?php echo $height ?>px; 
        width: <?php echo $width ?>px; 
        border:1px solid #333333;
        background-color: #f7f7f7;
        text-align: center;
    }

    #handleDiv {
        position: absolute; 
        bottom:0px; 
        right: 0px; 
        width:10px; 
        height:10px;
        background-color:blue;
        font-size: 1px;
    }

</style>
<?php //insert YUI drag'n drop tool with resize: ?>
<!-- Namespace source file -->  
<!-- Drag and Drop source file -->  
<script src = '<?php echo $root ?>/yui/build/dragdrop/dragdrop.js' ></script>
<script type="text/javascript" src="./DDResize.js" ></script>
<!-- transparenz für objekte -->
<script type="text/javascript" src='<?php echo $root ?>/templates/transobj.js' ></script>
<script type="text/javascript">

	var dd, dd2, dd3;
	var DOM = YAHOO.util.Dom;
	
	YAHOO.example.DDApp = function() {
	    
	    return {
	        init: function() {	
	        	
	        	//feststellen der positionen:
	        	var positionieren = document.getElementById("positionieren");
				var positionierenPos = DOM.getXY(positionieren);
				var positionierenPosX= positionierenPos[0];
				var positionierenPoxY= positionierenPos[1];
	        	
	 			dd = new YAHOO.example.DDResize("panelDiv", "handleDiv", "panelresize");
	            dd2 = new YAHOO.util.DD("panelDiv", "paneldrag");
	            dd2.addInvalidHandleId("handleDiv");
	            
	            //mitschreiben der position:
	            dd2.onDrag = function(e){
					var target = document.getElementById("panelDiv");					
					var x = DOM.getX(target);
					var y = DOM.getY(target);
					document.breiteHoehe.top.value = y-DOM.getY("positionieren");
    				document.breiteHoehe.left.value = x-DOM.getX("positionieren");
				};
				
				//setzen der richtigen position der bilder und tische:
				//raumbild setzen:
				DOM.setXY(raumbild,positionierenPos);
				DOM.setX(panelDiv,<?php echo $left ?>+DOM.getX("positionieren"));
				DOM.setY(panelDiv,<?php echo $top ?>+DOM.getY("positionieren"));
	        }
	    }
	} ();
	
	function tischPos(x,y,element){
		DOM.setX(element,x+DOM.getX("positionieren"));
		DOM.setY(element,y+DOM.getY("positionieren"));
	}
	
	YAHOO.util.Event.addListener(window, "load", YAHOO.example.DDApp.init);
    
</script>
<?php


include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischPositionieren/index.php",
								getRaumBezeichnung($raum_id), "");
include_once($root."/backoffice/templates/bodyStart.inc.php");
?>
<div name="positionieren" id="positionieren" style="height:<?php echo ($bildhoehe) ?>;">	<?php
//dann die tische anzeigen die bereits gesetzt sind oder noch zu setzen sind:
	$res  = getTische($raum_id);
	$zindex=7;
	while($d = $res->FetchNextObject()) {
		$id = $d->TISCHNUMMER;	
		if (!($id == $tisch_id)){	
			$lefts = getLeftPosOfTisch($id);
			$tops  = getTopPosOfTisch($id);
			$wi    = getWidthOfTisch($id);
			$hi    = getHeightOfTisch($id);
			$bild = getBildOfTisch($id);	?>
			<div id="tisch<?php echo $id ?>" 
				onmouseover="transparency(this,0)" 
				onMouseOut="transparency(this,<?php echo TRANSPARENZ ?>);"
				style="z-index:<?php echo $zindex++ ?>; background-color: red;
					border:1px solid; text-align: center;
					width:<?php echo $wi ?>px;height:<?php echo $hi ?>px;">
				Tisch <?php echo $id ?>
				<?php if ($bild) { ?>
					<img src="<?php echo $root."/templates/picture.php?bilder_id=".$bild ?>" 
						width="<?php echo $wi ?>" height="<?php echo $hi ?>" style="z-index:<?php echo $zindex ?>">
					</img>
				<?php } ?>
			</div>
			<!-- tisch positionieren: -->
			<script>tischPos(<?php echo $lefts ?>, <?php echo $tops ?>, 'tisch<?php echo $id ?>')</script>
			<!-- transparenz setzen: -->
			<script>transparency('tisch<?php echo $id ?>',<?php echo TRANSPARENZ ?>)</script>	<?php
		}
	} 		
	//fuer jeden tisch einen layer in anderer farbe:
	//zuerst den momentan ausgewaehlten tisch anzeigen:
	$res  = getTische($raum_id);
	$zindex++;
	while($d = $res->FetchNextObject()) {
		$id = $d->TISCHNUMMER;	
		if ($id == $tisch_id){	
			$width    = getWidthOfTisch($id);
			$height    = getHeightOfTisch($id);
			$left = getLeftPosOfTisch($id);
			$top  = getTopPosOfTisch($id); 
			$bild = getBildOfTisch($id);	?>
		    <div id="panelDiv" style="z-index:<?php echo $zindex ?>;">
		    	Tisch <?php echo $id ?>
		       	<div id="handleDiv" style="z-index:<?php echo $zindex ?>;"></div>
		       	<?php if ($bild) { ?>
				<img id="tischbild" src="<?php echo $root."/templates/picture.php?bilder_id=".$bild ?>" 
					width="<?php echo $width ?>" height="<?php echo $height ?>" style="z-index:<?php echo $zindex ?>">
				</img>
				<?php } else { ?>
				<img id="tischbild" src="<?php echo $root."/backoffice/templates/dummy.gif" ?>" 
					width="<?php echo $width ?>" height="<?php echo $height ?>" style="z-index:<?php echo $zindex ?>">
				</img>
				<?php } ?>	
			</div>
		    <script>transparency(panelDiv,<?php echo TRANSPARENZ ?>)</script>  <?php
			break;
		}
	}	?>			
	<img id="raumbild" src="<?php echo $root."/templates/picture.php?bilder_id=".$bilder_id ?>" 
		width="<?php echo $bildbreite ?>" height="<?php echo $bildhoehe ?>" style="z-index:0">
	</img>
</div><!-- ende position des tisches und auswahl tisch -->	
<table>
	<tr>
		<td>
		<div name="tischPosition" style="width:<?php echo ($bildbreite) ?>;">
		<form action="./position.php" method="post" name="breiteHoehe" target="_self">
		<input type="hidden"  name="tisch_id_prev" value="<?php echo $tisch_id ?>"/>
		<div name="tischWaehlen" id="tischWaehlen" 	style="float:left;width:<?php echo $bildbreite/5 ?>;">
			<p>	<?php echo getUebersetzung("Tisch wählen") ?>:	</p>					
			<select name="tisch_id" id="tisch_id" onchange="this.form.submit()"><?php	
			while($d = $tische->FetchNextObject()) {
				$ziArt = getUebersetzungGastro($d->TISCHNUMMER,$sprache,$gastro_id);
				$temp = getUebersetzung("Tisch").": ".$ziArt; ?>
				<option value="<?php echo $d->TISCHNUMMER ?>" <?php
				if($d->TISCHNUMMER == $tisch_id){?>
					selected="selected" <?php
					$first = false;
				} ?> ><?php echo $temp ?>
				</option><?php
			} //ende while
			?>
			</select>
		</div>
		<!-- aendern der groesse eines tisches: -->
		<div name="goesseanzeige" id="groesseanzeige" style="float:left;padding-left:10px;width:<?php echo $bildbreite/5 ?>;">	
			<p><?php echo getUebersetzung("Größe") ?>:</p>
			<table>
				<tr>
					<td><?php echo getUebersetzung("Höhe") ?></td>
					<td>
						<input type="text" name="hoehe" value="<?php echo $height ?>" size="3"/> px  
					</td>
				</tr>
			    <tr>
			    	<td><?php echo getUebersetzung("Breite") ?></td>
			    	<td>
			    		<input type="text" name="breite" value="<?php echo $width ?>" size="3"/> px  
			    	</td>
			    </tr>    
			</table> 								  			
		</div><!-- ende aendern der groesse eines tisches -->				
		<div name="positionsanzeige" id="positionsanzeige" 	style="float:left;padding-left:10px;width:<?php echo $bildbreite/5 ?>;">
			<p><?php echo getUebersetzung("Position") ?>:</p>	
			<table>
			    <tr>
			      <td><?php echo getUebersetzung("Links") ?></td>
			      <td>
					<input type="text" name="left" value="<?php echo $left ?>" size="3"/> px  
				  </td>
			    </tr>
			    <tr>
			      <td><?php echo getUebersetzung("Oben") ?></td>
			      <td>
					<input type="text" name="top" value="<?php echo $top ?>" size="3"/> px  
				  </td>
			    	</tr>    
				</table> 														  			
			</div>
		</div>
		</td>
	</tr>
	<tr>
		<td>	
		<input type="submit" name="speichern" class="button" 
			value="<?php echo getUebersetzung("speichern") ?>"/> 
		</form>
		</td>
	</tr>
</table>	
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
