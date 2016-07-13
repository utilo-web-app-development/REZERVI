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
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/templates/constants.inc.php");
 
$ansicht = "Tagesansicht";
if (isset($_POST["mieter_id"])){
	$mieter_id = $_POST["mieter_id"];
}else{
	$mieter_id = NEUER_MIETER;
}
$dauer_default = getGastroProperty(RESERVIERUNGSDAUER,$gastro_id);	

?>

<link href="<?php echo $root ?>/backoffice/templates/yui_panel.css" rel="stylesheet" type="text/css">

<?php
if (isset($nachricht) && $nachricht != ""){ 
?>
<table>
	<tr>
		<?php 
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
	
	<form method="post" name="zeitAendern" target="_parent">	  
		<tr>
			<td><?php echo(getUebersetzung("von")); ?>:</td>
		   	<td><select name="vonStunde"  id="vonStunde"> <?php				
				for ($l=0; $l < 24; $l++){ 
					if ($l<10){
						$l="0".$l;
					} ?>
					<option value="<?php echo $l ?>"<?php if ($l == $vonStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option> <?php 
				} ?>
			   	</select>
			    <select name="vonMinute"  id="vonMinute"> <?php				
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
			<td><?php echo(getUebersetzung("bis")); ?>:</td>
		    <td><select name="bisStunde"  id="bisStunde"><?php	
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
				}else{	
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
				for ($l=0; $l < 24; $l++){ 
					if ($l<10){
						$l="0".$l;
					}	?>
			       	<option value="<?php echo $l ?>"<?php if ($l == $bisStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option><?php 
				}?>
			    </select>
			   	<select name="bisMinute"  id="bisMinute"> <?php				
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
	</form>
</table>

<script type="text/javascript">
	
	function getDateForAno () {
	 
	  var vonM = document.forms["zeitAendern"].vonMinute.value
	  var bisM = document.forms["zeitAendern"].bisMinute.value
	  var vonH = document.forms["zeitAendern"].vonStunde.value
	  var bisH = document.forms["zeitAendern"].bisStunde.value
	  
	  document.forms["anonyForm"].vonMinute.value = vonM
	  document.forms["anonyForm"].bisMinute.value = bisM
	  document.forms["anonyForm"].vonStunde.value = vonH
	  document.forms["anonyForm"].bisStunde.value = bisH
	  	 
	  return true;
	  
	}
	
</script>

<table>
	<form action="./index.php" method="post" onSubmit="getDateForAno();" name="anonyForm" target="_parent">
		<tr>
	  		<td>
				<input name="speech" type="hidden" id="sprache" value="<?php echo $sprache  ?>">
				<input name="mieter_id" type="hidden" id="mieter_id" value="<?php echo ANONYMER_GAST_ID ?>">
				<input name="raum_id" type="hidden" id="vonJahr" value="<?php echo $raum_id  ?>">
				<input name="table_id" type="hidden" id="status" value="<?php echo $tisch_id ?>">
				<input name="vonTag" type="hidden" id="vonTag" value="<?php echo $tag ?>">
				<input name="bisTag" type="hidden" id="bisTag" value="<?php echo $tag ?>">
				<input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $monate ?>">
		    	<input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $monate ?>">
		     	<input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $jahr ?>">
		      	<input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $jahr ?>">
		      	<input name="vonMinute" type="hidden" id="vonMinute" value="<?php echo $vonMinute ?>">
		       	<input name="bisMinute" type="hidden" id="bisMinute" value="<?php echo $bisMinute ?>">
		      	<input name="bisStunde" type="hidden" id="bisStunde" value="<?php echo $bisStunde ?>">
		      	<input name="vonStunde" type="hidden" id="vonStunde" value="<?php echo $vonStunde ?>">
		  		<input name="anzahlRes" type="hidden" id="anzahlRes" value="<?php echo "0" ?>"/>
				<input name="doAddRes" type="hidden" value="true" />
		      	<input name="send" type="submit" class="button" id="send" 
					value="<?php echo(getUebersetzung("Anonymer Gast")); ?>">
		  	</td>
		</tr>
	</form>
</table>

<hr/>

<!-- begin yui Autocompletition -->
<link rel="stylesheet" type="text/css" href="<?php echo $root ?>/backoffice/templates/yui_autocomplete.css" />
<script type="text/javascript" src="<?php echo $root ?>/yui/build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo $root ?>/yui/build/autocomplete/autocomplete.js"></script>
<!--CSS file (default YUI Sam Skin) -->
<link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/autocomplete/assets/skins/sam/autocomplete.css">
<!-- Dependencies -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/datasource/datasource-min.js"></script>
<!-- Source file -->
<script type="text/javascript" src="http://yui.yahooapis.com/2.7.0/build/autocomplete/autocomplete-min.js"></script>

<style type="text/css">
#gaestelist { z-index:9001; } /* z-index needed on top instances for ie & sf absolute inside relative issue */
.autocomplete { padding-bottom:2em;width:80%; }/* set width of widget here*/
.autocomplete .yui-ac-highlight .quantity,
.autocomplete .yui-ac-highlight .result,
.autocomplete .yui-ac-highlight .query { color:#FFF; }
.autocomplete .quantity { float:right; display:none; } /* push right */
.autocomplete .result { color:#A4A4A4; }
.autocomplete .query { color:#000; }
</style>

<div class="yui-skin-sam">
	<div id="gaestelist" class="autocomplete">
		<input name="eingabe" id="eingabe" type="text" value="<?php echo NEUER_MIETER ?>" onClick="clear()" onkeydown="if(event.keyCode==13)getGastID()"/>
		<div id="gastSuche" onclick="getName()"></div>
	</div>
</div>

<script src="<?php echo$root?>/backoffice/templates/prototype.js"></script>

<script type="text/javascript">
YAHOO.example.ACFlatData = new function(){
    // Define a custom formatter function
    this.fnCustomFormatter = function(oResultItem, sQuery) {
        var sKey = oResultItem[0];
        var nQuantity = oResultItem[1];
        var sKeyQuery = sKey.substr(0, sQuery.length);
        var sKeyRemainder = sKey.substr(sQuery.length);
        var aMarkup = ["<div class='result'><div class='quantity'>",
            nQuantity,
            "</div><span class='query'>",
            sKeyQuery,
            "</span>",
            sKeyRemainder,
            "</div>"];
        return (aMarkup.join(""));
    };
        
    // Instantiate one XHR DataSource and define schema as an array:
    //     ["Record Delimiter",
    //     "Field Delimiter"]
    this.oACDS = new YAHOO.widget.DS_XHR("<?php echo $root ?>/backoffice/reservierung/mieterInfos/gaesteListHelper", ["\n", "\t"]);
    this.oACDS.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
    this.oACDS.maxCacheEntries = 60;
    this.oACDS.queryMatchSubset = true;

    // Instantiate first AutoComplete
    var myInput = document.getElementById('eingabe');
    var myContainer = document.getElementById('gastSuche');
    this.oAutoComp = new YAHOO.widget.AutoComplete(myInput,myContainer,this.oACDS);
    this.oAutoComp.queryDelay = 0;
    this.oAutoComp.autoHighlight = true;
    this.oAutoComp.formatResult = this.fnCustomFormatter;
    //this.oAutoComp.setHeader("<?php echo getUebersetzung(" neuer Mieter") ?>");
};
</script>

<script type="text/javascript">
  function clear(){
  	$('eingabe')="";
  }
  function getGastID(){
  	var infos = $('gastSuche').innerHTML;
  	var s1 = "yui-ac-highlight";
  	var s2 = "quantity\">";
  	var s3 = "</div>"
  	var pos = infos.indexOf(s1);
  	pos = infos.indexOf(s2, pos);
  	var id = infos.substring(pos+s2.length, infos.indexOf(s3, pos));
  	updateInfos(id);	
  }
  function getName(){
  	var nameID = $('eingabe').value;
  	if(nameID == 'neuerMieter'){
  		id = 'neuerMieter';
  	}else{
  		var pos = nameID.indexOf("ID:");
  		var id = nameID.substring(pos+3);
  	}
  	updateInfos(id);
  }
  function updateInfos(gast_id){  
  	var url="<?php echo $root ?>/backoffice/reservierung/mieterInfos/gaesteInfosHelper.php";
  	$('gast_id').value = gast_id;
	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&name=1', 
  			onComplete: function(originalRequest){
  				$('eingabe').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&anrede=1', 
  			onComplete: function(originalRequest){
  				$('anrede').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&vorname=1',
  			onComplete: function(originalRequest){
  				$('vorname').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&nachname=1',
  			onComplete: function(originalRequest){
  				$('nachname').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&firma=1',
  			onComplete: function(originalRequest){
  				$('firma').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&ort=1',
  			onComplete: function(originalRequest){
  				$('ort').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&email=1',
  			onComplete: function(originalRequest){
  				$('email').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&tel=1',
  			onComplete: function(originalRequest){
  				$('tel').value = originalRequest.responseText;
  				}
  			}
  		);
  	new Ajax.Request(
  		url, {method: 'get', 
  			parameters: 'gast_id='+gast_id+'&fax=1',
  			onComplete: function(originalRequest){
  				$('fax').value = originalRequest.responseText;
  				}
  			}
  		);
  } 
</script>
<!-- Ende von Autocompletition -->

<hr/>

<script type="text/javascript">
	
	function chkFormular() {
		
		if( (document.adresseForm.vorname.value == "")){
			alert("<?php echo(getUebersetzung("Bitte geben Sie den Vornamen ein!")); ?>");
			document.adresseForm.vorname.focus();
			return false;		
		}else if( (document.adresseForm.nachname.value == "")){
		       alert("<?php echo(getUebersetzung("Bitte geben Sie den Nachnamen ein!")); ?>");
		       document.adresseForm.nachname.focus();
		       return false;
		}else if( (document.adresseForm.email.value == "")){
		       alert("<?php echo(getUebersetzung("Bitte geben Sie die E-Mail-Adresse ein!")); ?>");
		       document.adresseForm.email.focus();
		       return false;
		} else if( (document.adresseForm.tel.value == "")){
		       alert("<?php echo(getUebersetzung("Bitte geben Sie die Telefonnummer ein!")); ?>");
		       document.adresseForm.tel.focus();
		       return false;
		}
		
		var vonM = document.forms["zeitAendern"].vonMinute.value
		var bisM = document.forms["zeitAendern"].bisMinute.value
		var vonH = document.forms["zeitAendern"].vonStunde.value
		var bisH = document.forms["zeitAendern"].bisStunde.value
		  
		document.forms["adresseForm"].vonMinute.value = vonM
		document.forms["adresseForm"].bisMinute.value = bisM
		document.forms["adresseForm"].vonStunde.value = vonH
		document.forms["adresseForm"].bisStunde.value = bisH
		
		return true;
		
	}	
	
</script>

<table>
	
 	<form action="./index.php" method="post" name="adresseForm" 
		target="_parent" id="adresseForm" onSubmit="return chkFormular();">   
		 
	<input name="gast_id" type="hidden" id="gast_id" value="<?php echo $mieter_id ?>">
	<tr> 
		<td><?php echo(getUebersetzung("Anrede")); ?></td>
		<td><input name="anrede" type="text" id="anrede" 
						value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1 ) { echo getMieterAnrede($mieter_id);}?>" /> 
		</td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Vorname")); ?></td>
		<td><input name="vorname" type="text" id="vorname"
						value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getMieterVorname($mieter_id)); } ?>" />*</td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Nachname")); ?></td>
		<td><input name="nachname" type="text" id="nachname"
	            		value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getNachnameOfMieter($mieter_id)); } ?>" />*</td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Firma")); ?></td>
		<td><input name="firma" type="text" id="firma"
	            		value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getMieterFirma($mieter_id)); } ?>" /></td>
	</tr>          
	<tr> 
		<td><?php echo(getUebersetzung("Ort")); ?></td>
		<td><input name="ort" type="text" id="ort"
	            		value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getMieterOrt($mieter_id)); } ?>" /></td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
		<td><input name="email" type="text" id="email"
	            		value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getEmailOfMieter($mieter_id)); } ?>" />*</td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
		<td><input name="tel" type="text" id="tel"
	            		value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getMieterTel($mieter_id)); } ?>" />*</td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Faxnummer")); ?></td>
		<td><input name="fax" type="text" id="fax"
	            		value="<?php if($mieter_id == NEUER_MIETER){
										echo("");
									}else if ($mieter_id != -1) { echo(getMieterFax($mieter_id)); } ?>" /></td>
	</tr>  
	<tr>
		<td>
			  <input name="speech" type="hidden" id="sprache" value="<?php echo $sprache  ?>"/>
			  <input name="anzahlRes" type="hidden" id="anzahlRes" value="0"/>
	          <input name="table_id" type="hidden" id="table_id" value="<?php echo $tisch_id ?>"/>
	          <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $tag ?>"/>
	          <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $tag ?>"/>
	          <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $monate ?>"/>
	          <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $monate ?>"/>
	          <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $jahr ?>"/>
	          <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $jahr ?>"/>
	          <input name="vonMinute" type="hidden" id="vonMinute" value="<?php echo $vonMinute ?>"/>
	          <input name="bisMinute" type="hidden" id="bisMinute" value="<?php echo $bisMinute ?>"/>
	          <input name="bisStunde" type="hidden" id="bisStunde" value="<?php echo $bisStunde ?>"/>
	          <input name="vonStunde" type="hidden" id="vonStunde" value="<?php echo $vonStunde ?>"/>
	          <input name="raum_id" type="hidden" id="raumid" value="<?php echo $raum_id  ?>"/>
			  <input name="doAddRes" type="hidden" value="true" />
	          <input name="send" type="submit" class="button" id="send" value="<?php echo(getUebersetzung("speichern")); ?>">	          
		</td>
	</tr>
	</form>
</table>   		