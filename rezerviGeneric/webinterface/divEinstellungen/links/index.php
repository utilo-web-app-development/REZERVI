<?php $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 

$sucheAktiv = getVermieterEigenschaftenWert(SUCHFUNKTION_AKTIV,$vermieter_id);
if ($sucheAktiv == "true"){
	$sucheAktiv = true;
}
else{
	$sucheAktiv = false;
}

$res = getMietobjekte($vermieter_id);
$url = $URL;
$url = str_replace("\\","/",$url);
/*
 * strrpos --  Sucht letztes Vorkommen des gesuchten Zeichens und liefert die Position
 * Beschreibung:
 * int strrpos ( string haystack, char needle )
 * */
 $posSlash = strrpos($url,"/")+1;
 $cou = strlen($url);
 if ($posSlash != $cou){
 	$url.="/";
 }
 /*
  * strstr -- Sucht erstes Vorkommen des Suchstrings und liefert den Reststring
	Beschreibung
	string strstr ( string haystack, string needle )
	Falls needle nicht gefunden wird, ist das Ergebnis FALSE.
  * */
  $posHttp = strstr($url,"http://");
 if ($posHttp == FALSE){
	$url="http://".$url;
 }

?>
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Anzeigen aller Links zu ihren Mietobjekten")); ?>.</p>
<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
  <?php
	while ($d=mysql_fetch_array($res)){
		$bezeichnung = $d["BEZEICHNUNG"];
		$bezeichnung = getUebersetzungVermieter($bezeichnung,$sprache,$vermieter_id);
		$mietobjekt_einzahl = getMietobjekt_EZ($vermieter_id);
		$mietobjekt_einzahl = getUebersetzungVermieter($mietobjekt_einzahl,$sprache,$vermieter_id);
		$str = $mietobjekt_einzahl." ".$bezeichnung;
		$mietobjekt_id = $d["MIETOBJEKT_ID"];
  ?>
	  <tr>
	  	<td class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
	  		<?php echo $str ?>
	  	<td>
	  <tr>
	  <tr>
	  	<td>
	  		<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
	  		<?php
	  		$sprachen = getActivtedSprachenOfVermieter($vermieter_id);
	  		while ($s = mysql_fetch_array($sprachen)){
	  			$sprache_id = $s["SPRACHE_ID"];
	  			$spr_bezeichnung = getBezeichnungOfSpracheID($sprache_id);	
	  			$spr_bezeichnung = getUebersetzung($spr_bezeichnung);  		
	  		?>
	  			<tr>
	  				<td>
	  					<?php echo $spr_bezeichnung ?>: 
	  				</td>	  			
	  				<td>
	  					<?php echo $url ?>start.php?vermieter_id=<?php echo $vermieter_id ?>&mietobjekt_id=<?php echo $mietobjekt_id ?>&sprache=<?php echo $sprache_id ?>
	  				</td>
	  			</tr>
	  		<?php
			}
			?>
	  		</table>
	  	<td>
	  </tr>
	  <?php
	  }
	  if($sucheAktiv){
	  ?>
	  <tr>
	  	<td class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
	  		<?php echo getUebersetzung("Suchfunktion: ") ?>
	  	<td>
	  <tr>	
	  <tr>
	  	<td>
	  		<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
	  		<?php
	  		$sprachen = getActivtedSprachenOfVermieter($vermieter_id);
	  		while ($s = mysql_fetch_array($sprachen)){
	  			$sprache_id = $s["SPRACHE_ID"];
	  			$spr_bezeichnung = getBezeichnungOfSpracheID($sprache_id);	
	  			$spr_bezeichnung = getUebersetzung($spr_bezeichnung);  		
	  		?>
	  			<tr>
	  				<td>
	  					<?php echo $spr_bezeichnung ?>: 
	  				</td>	  			
	  				<td>
	  					<?php echo $url ?>belegungsplan/suche.php?vermieter_id=<?php echo $vermieter_id ?>&sprache=<?php echo $sprache_id ?>
	  				</td>
	  			</tr>
	  		<?php
			}
			?>
	  		</table>
	  	<td>
	  </tr>
	  <?php
	  }
	  ?>
	  <tr>
	  	<td class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
	  		<?php echo getUebersetzung("Webinterface: ") ?>
	  	<td>
	  <tr>	
	  <tr>
	  	<td>
	  		<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
	  			<tr>  			
	  				<td>
	  					<?php echo $url ?>webinterface/index.php
	  				</td>
	  			</tr>
	  		</table>
	  	<td>
	  </tr>
</table>
<br/>
<?php 
//-----buttons um zurück zum menue zu gelangen: 
showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
include_once($root."/webinterface/templates/footer.inc.php");
?>