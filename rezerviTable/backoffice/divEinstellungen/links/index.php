<? 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Links";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/links/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 

$sucheAktiv = getGastroProperty(SUCHFUNKTION_AKTIV,$gastro_id);
if ($sucheAktiv == "true"){
	$sucheAktiv = true;
}
else{
	$sucheAktiv = false;
}

$res = getRaeume($gastro_id);
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
<h2><?php echo(getUebersetzung("Anzeigen aller Links zu ihren Räumen")); ?>.</h2>
<table>
  <?php
	while ($d=$res->FetchNextObject()){
		$bezeichnung = $d->BEZEICHNUNG;
		$bezeichnung = getUebersetzungGastro($bezeichnung,$sprache,$gastro_id);
		$mietobjekt_id = $d->RAUM_ID;
  ?>
	  <tr>
	  	<td>
	  		<?= $bezeichnung ?>
	  	</td>
	  <tr>
	  <tr>
	  	<td>
	  		<table>
	  		<?php
	  		$sprachen = getActivtedSprachenOfVermieter($gastro_id);
	  		while ($s = $sprachen->FetchNextObject()){
	  			$sprache_id = $s->SPRACHE_ID;
	  			$spr_bezeichnung = getBezeichnungOfSpracheID($sprache_id);	
	  			$spr_bezeichnung = getUebersetzung($spr_bezeichnung);  		
	  		?>
	  			<tr>
	  				<td>
	  					<?= $spr_bezeichnung ?>: 
	  				</td>	  			
	  				<td>
	  					<?= $url ?>index.php?gastro_id=<?= $gastro_id ?>&mietobjekt_id=<?= $mietobjekt_id ?>&sprache=<?= $sprache_id ?>
	  				</td>
	  			</tr>
	  		<?php
			}
			?>
	  		</table>
	  	</td>
	  </tr>
	  <?php
	  }
	  if($sucheAktiv){
	  ?>
	  <tr>
	  	<td>
	  		<?= getUebersetzung("Suchfunktion: ") ?>
	  	</td>
	  <tr>	
	  <tr>
	  	<td>
	  		<table>
	  		<?php
	  		$sprachen = getActivtedSprachenOfVermieter($gastro_id);
	  		while ($s = mysql_fetch_array($sprachen)){
	  			$sprache_id = $s["SPRACHE_ID"];
	  			$spr_bezeichnung = getBezeichnungOfSpracheID($sprache_id);	
	  			$spr_bezeichnung = getUebersetzung($spr_bezeichnung);  		
	  		?>
	  			<tr>
	  				<td>
	  					<?= $spr_bezeichnung ?>: 
	  				</td>	  			
	  				<td>
	  					<?= $url ?>belegungsplan/suche.php?vermieter_id=<?= $gastro_id ?>&sprache=<?= $sprache_id ?>
	  				</td>
	  			</tr>
	  		<?php
			}
			?>
	  		</table>
	  	</td>
	  </tr>
	  <?php
	  }
	  ?>
	  <tr><td>&nbsp;</td></tr>
	  <tr>
	  	<td>
	  		<?= getUebersetzung("Backoffice: ") ?>
	  	</td>
	  </tr>	
	  <tr>
	  	<td>
	  		<table>
	  			<tr>  			
	  				<td>
	  					<?= $url ?>backoffice/index.php
	  				</td>
	  			</tr>
	  		</table>
	  	</td>
	  </tr>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>