<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

//einstiegsseite wenn nicht direkt ein Zimmer ausgewaehlt wurde
//dem benutzer wird vorab die Möglichkeit geboten ein Zimmer auszuwählen.
//uebergebene variable ist die sprache und unterkunft_id

//variablen initialisieren:
$keineSprache = $_POST["keineSprache"];
//wenn keineSprache = true ist dann wurde die suche aus left.php aufgerufen
//also daten aus der session holen:
if ($keineSprache == true){
	$sprache = getSessionWert(SPRACHE);
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);		
} //sonst aus get holen:
else{
	$unterkunft_id = $_GET["unterkunft_id"];		
	$sprache = $_GET["sprache"];
}

//datenbank öffnen:
include_once("../conf/rdbmsConfig.php");
//unterkunft-funktionen
include_once("../include/unterkunftFunctions.php");
include_once("../include/zimmerFunctions.php");
include_once("../include/datumFunctions.php");
//spezielle funktionen fuer suche:
include_once("./sucheFunctions.php");
include_once("../include/propertiesFunctions.php");
include_once("../include/einstellungenFunctions.php");
//uebersetzer einfügen:
include_once("../include/uebersetzer.php");
include_once($root."/include/buchungseinschraenkung.php");

//testdaten falls keine unterkunft uebergeben wurde:
if (!isset($unterkunft_id) || $unterkunft_id == ""){
   $unterkunft_id = "1";
 }
 
//wenn keine sprache Übergeben, deutsch nehmen:	
if (!isset($sprache) || $sprache == ""){
	$sprache = "de";						
}

//sprache und unterkunft in session speichern:
setSessionWert(SPRACHE,$sprache);
setSessionWert(UNTERKUNFT_ID,$unterkunft_id);

$startdatumDP = getTodayDay()."/".parseMonthNumber(getTodayMonth())."/".getTodayYear();	
$enddatumDP   = $startdatumDP;
if (isset($_POST['datumVon']) && !empty($_POST['datumVon'])){
	$startdatumDP = $_POST['datumVon'];
}
if (isset($_POST['datumBis']) && !empty($_POST['datumBis'])){
	$enddatumDP = $_POST['datumBis'];
}
		
//headerA einfügen:
include_once("../templates/headerA.php");
//stylesheets einfgen:
?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script type="text/javascript" src="<?php echo($root); ?>/templates/calendarDateInput.php">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Bootstrap ende -->
<div class="container" style="margin-top:70px;">	
<?php
//headerB einfügen:
include_once("../templates/headerB.php");
?>


<div class="panel panel-default">
  <div class="panel-body">


   	<p>
        <?php 
		 //$zimmerart = getUebersetzungUnterkunft(getZimmerArten($unterkunft_id,$link),$sprache,$unterkunft_id,$link);
		 $zimmerart_mz = getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link);
		 echo(getUebersetzung("Sie können den Belegungsplan betrachten, indem Sie eine Auswahl treffen und auf [Belegungsplan anzeigen] klicken...",$sprache,$link));
		 ?>
  	</p>
  

<?php
	if (isset($keineSprache) && ($keineSprache == "true")){ ?>
<form action="../start.php" method="post" name="form1" target="_parent">
<?php } else{ ?>
<form action="../start.php" method="post" name="form1" target="_self">
  <?php } ?>
  <input name="keineSprache" type="hidden" value="true">
  <input name="monat" type="hidden" value="<?php echo(parseMonthNumber(getTodayMonth())); ?>">
  <input name="jahr" type="hidden" value="<?php echo(getTodayYear()); ?>">

   <!--Belegungsplan-->
      <b><?php	echo(getUebersetzung("Belegungsplan für:",$sprache,$link)); ?></b>
     </br>
    </br>
  
   <!-- Select Box  -->
     
      <?php   
      
        //es sollte die liste auf keinen fall groesser als 10 werden:
	    $zimmeranzahl = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
		if ($zimmeranzahl > 10) $zimmeranzahl = 10; ?>
        <select  class="form-control" name="zimmer_id" size="<?php echo($zimmeranzahl); ?>>
          <?php 
			$res = getZimmer($unterkunft_id,$link);
			$zaehler = 0;
			while ($d = mysqli_fetch_array($res)){

				$zaehler++;
				$temp =  $d["Zimmerart"]; 
				$temp2 = $d["Zimmernr"];
				$temp3 = getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link);
				$temp4 = getUebersetzungUnterkunft($temp2,$sprache,$unterkunft_id,$link);
				$zimmerbezeichnung = ($temp3).(" ").($temp4);
				$von = "";
	            $bis = "";
				$hallo = getZimmerBuchungseinschraenkung($d["PK_ID"]);
			    while ($ergebnis = mysqli_fetch_array($hallo)){
				  $von = $ergebnis["Tag_von"];
				  $bis = $ergebnis["Tag_bis"];
				  $monatVon = $ergebnis["Datum_von"];
				  $monatBis = $ergebnis["Datum_bis"];
				  
				  $uebersetzung1 = getUebersetzung("Im Zeitraum von",$sprache,$link);
				  $uebersetzung2 = getUebersetzung("bis",$sprache,$link);
				  $uebersetzung3 = getUebersetzung("buchbar von",$sprache,$link);
				  
			?>
		          <option value="<?php echo($d["PK_ID"]); ?>"<?php if ($zaehler == 1) echo("selected");?>><?php echo($zimmerbezeichnung); ?><!-- <?php echo(" (" . $uebersetzung1 . " " . $monatVon . " " . $uebersetzung2 . " " . $monatBis . " " . $uebersetzung3 . " " . $von . " " . $uebersetzung2 . " " . $bis . ".)"); ?> --></option>
            <?php 
		        }//end while-loop
		        if ($von == "" && $bis == ""){?>
		          <option value="<?php echo($d["PK_ID"]); ?>"<?php if ($zaehler == 1) echo("selected");?>><?php echo($zimmerbezeichnung); ?></option>
		  <?php }//end if-loop
		  }//end while-loop
		?>
        </select>
		<!-- Button -->
     
   </br>
   </br>
   
      <input type="submit" name="Submit" class="btn btn-default" value="<?php echo(getUebersetzung("Belegungsplan anzeigen",$sprache,$link)); ?>">
  
</form>

<!-- Ende Button -->
</br>
</br>

  
   <p>
      <?php 
		echo(getUebersetzung("...oder eine automatische Suche durchführen, indem sie unterstehende Daten angeben und [Suche starten] klicken.",$sprache,$link)); 
	  ?>
   </p>
  
</br>

<form action="../suche/sucheDurchfuehren.php" method="post" name="suchen" target="_self" id="suchen">
 
  <!-- Kalender  --> 
      <b>
          <?php echo(getUebersetzung("Freie",$sprache,$link)." "); 
		  		echo($zimmerart_mz); 
				echo(" ".getUebersetzung("suchen",$sprache,$link));
			?>
          <b><?php echo(getUebersetzung("von",$sprache,$link)); ?>: <br/>
          </b>
          <script>DateInput('datumVon', true, 'DD/MM/YYYY','<?php echo($startdatumDP); ?>')</script>
          <b><?php echo(getUebersetzung("bis",$sprache,$link)); ?>:</b><br/>
          <script>DateInput('datumBis', true, 'DD/MM/YYYY','<?php echo($enddatumDP); ?>')</script>
        </b>
       
     
        <!-- Ende Kalender -->
        
    
    <?php
  //wenn die anzahl der zimmer mehr als 1 ist, nur dann anzeigen:
  if ($zimmeranzahl > 1) {
  	if (hasParentRooms($unterkunft_id) && getPropertyValue(SEARCH_SHOW_PARENT_ROOM,$unterkunft_id,$link) == "true"){
  		$parentsRes = getParentRooms();
  		while ($p = mysqli_fetch_array($parentsRes)){
  				$temp  = $p["Zimmerart"];
				$temp2 = $p["Zimmernr"];
				$temp3 = getUebersetzungUnterkunft($temp,$sprache,$unterkunft_id,$link);
				$temp4 = getUebersetzungUnterkunft($temp2,$sprache,$unterkunft_id,$link);
				$zimmerbezeichnung = ($temp3).("&nbsp;").($temp4);
  ?>
  	
  		<b>
  			<?php echo $zimmerbezeichnung ?>
  		</b>
  		
  			<input type="checkbox" name="parent_room_<?php echo $p["PK_ID"] ?>" value="true" 
  				<?php
  					if (isset($_POST['zimmerIdsParents']) && !empty($_POST['zimmerIdsParents'])){
  						$parArr = explode(",",$_POST['zimmerIdsParents']);
  						foreach($parArr as $paItem){
  							if ($paItem == $p["PK_ID"]){
  								?>
  									checked="checked"
  								<?php
  							}
  						}
  					}
  				?>
  			
  		

  	<?php
  		} //end while parents
  	} //end if parents 
  	?>
  	
  </br>
  </br>
  <!-- Anzahl Zimmer -->
  
      <b><?php echo(getUebersetzung("Anzahl der ",$sprache,$link).getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link));
   ?></b>
      <select name="anzahlZimmer">
          <?php 
		  $anz_zi = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
		  //without parent rooms (eg. houses)
		 $anz_zi = $anz_zi - countParentRooms($unterkunft_id);
		 for ($i = 1; $i <= $anz_zi ; $i++){
		 ?>
          <option value="<?php echo($i); ?>" <?php 
          	if ($_POST['anzahlZimmer'] && !empty($_POST['anzahlZimmer']) && $_POST['anzahlZimmer'] == $i){
          		?>
          		selected="selected"
          		<?php
          	}
          ?>><?php echo($i); ?></option>
          <?php
	}
	?>
        </select>
    
    <?php
  }
  else{
  ?>
    <input name="anzahlZimmer" type="hidden" value="1">
    <?php
  }
  $erwachseneAnzahl = getAnzahlErwachsene($unterkunft_id,$link);
  if ($erwachseneAnzahl > 0){
  ?>
  </br>
  
  <!-- Ende Anzahl Zimmer -->
   
   <!-- Anzahl Erwachsene -->
   
      <b><?php echo(getUebersetzung("Anzahl Erwachsene ",$sprache,$link)); ?></b>
        </br><select  class="form-control" name="anzahlErwachsene">
          <?php
		for ($i = 1; $i <= $erwachseneAnzahl; $i++){
		?>
          <option value="<?php echo($i); ?>" <?php 
          	if (isset($_POST['anzahlErwachsene']) && !empty($_POST['anzahlErwachsene']) && $_POST['anzahlErwachsene'] == $i){
          		?>
          		selected="selected"
          		<?php
          	}
          	else if ( ( !isset($_POST['anzahlErwachsene']) || empty($_POST['anzahlErwachsene']) ) && $i == 2){
          		?>
          		selected="selected"
          		<?php
          	}
          ?>><?php echo($i); ?></option>
          <?php
		}
		?>
        </select>
  
    <?php
  }
    else{
  ?>

    <input name="anzahlErwachsene" type="hidden" value="-1">
    <?php
  }
  //Check which opportunities were chosen in the webinterface
  //if(getInformationKinder($unterkunft_id,$link)=='true')
  if (getPropertyValue(KINDER_SUCHE,$unterkunft_id,$link) == "true")
  {
    $kinderAnzahl = getAnzahlKinder($unterkunft_id,$link);
    if ($kinderAnzahl > 0)
    {
      ?>
      
      <!-- Ende Anzahl Erwachsene -->
      <!-- Anzahl Kinder -->
     </br>
    </br>
	    <b><?php echo(getUebersetzung("Anzahl Kinder unter",$sprache,$link)); ?> <?php echo(getKindesalter($unterkunft_id,$link)); ?> <?php echo(getUebersetzung("Jahren",$sprache,$link)); ?></b>
        <select  class="form-control" name="anzahlKinder">
        <?php
		for ($i = 0; $i <= $kinderAnzahl; $i++)
		{
		  ?>
          <option value="<?php echo($i); ?>" <?php 
          	if (isset($_POST['anzahlKinder']) && !empty($_POST['anzahlKinder']) && $_POST['anzahlKinder'] == $i){
          		?>
          		selected="selected"
          		<?php
          	}
          	else if ( ( !isset($_POST['anzahlKinder']) || empty($_POST['anzahlKinder']) ) && $i == 0){
          		?>
          		selected="selected"
          		<?php
          	}
          ?>><?php echo($i); ?></option>
          <?php
		}
		?>
        </select>
      
      <?php
    }
    else
	{
      ?>
      <input name="anzahlKinder" type="hidden" value="-1">
      <?php
    }
     //echo("<td><h3>getInformationKinder() ist 'true'</h3></td>");
  }//end if-loop Kinder
  
  //the option "show children" is deactivated by the user
  else
  {
  }

//Check which opportunities were chosen in the webinterface
  //function getInformationKinder() defined in sucheFunctions.php
  //if(getInformationHaustiere($unterkunft_id,$link)=='true')
  if (getPropertyValue(HAUSTIERE_ALLOWED,$unterkunft_id,$link) == "true")
  {?>
  	
  <!-- Ende Anzahl Kinder -->
  
  <!-- Haustiere -->
  </br>
  </br>  
	  <b>
        <?php echo(getUebersetzung("Haustiere",$sprache,$link)); ?>
	  </b>
      
	    <input name="haustiere" type="checkbox" value="true">	
	
  <?php
     //echo("<td><h3>getInformationHaustiere() ist 'true'</h3></td>");
  }//end if-loop Haustiere
  
  //the option "show haustiere" is deactivated by the user
  else
  {?>
    <input name="haustiere" type="hidden" value="-1">	
 <?php
   }
 ?>
 <!-- Ende Haustiere -->
 
 <!-- Button Suche starten -->
 </br>
</br>
      <b><input name="sucheStarten" type="submit" class="btn btn-default" id="sucheStarten" value="<?php echo(getUebersetzung("Suche starten...",$sprache,$link)); ?>"></b>

<!-- Ende Button -->
  
</form>
 <!-- Flaggen Sprachen -->
</br>

	<?php 
	if (isset($keineSprache) && ($keineSprache == "true")){
		//es soll die sprachauswahl nicht angezeigt werden, wenn
		//keineSprache == True uebergeben wird
	}
	else{
	?>
		<table border="0" align="left" cellpadding="0" cellspacing="0" class="tableColor">
		<?php 
			//laender ausgeben die in den einstellungen definiert wurden:
			if (isEnglishShown($unterkunft_id,$link) && $sprache != "en"){
		?>
		  <tr>
		    <td width="1"><img src="../fahneEN.gif" width="25" height="16"></td>
		    <td><div align="left"> <a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=en" target="_self" class="standardSchrift">&nbsp;&nbsp;English</a></div></td>
				  </tr>
				<?php
							}
							if (isFrenchShown($unterkunft_id,$link) && $sprache != "fr"){
				?>
		  <tr>
		    <td width="1"><img src="../fahneFR.gif" width="25" height="16"></td>
		    <td><div align="left"><a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=fr" target="_self" class="standardSchrift">&nbsp;&nbsp;Francais</a></div></td>
					  </tr>
			<?php
							}
							if (isGermanShown($unterkunft_id,$link) && $sprache != "de"){
				?>
		  <tr>
		    <td width="1"><img src="../fahneDE.gif" width="25" height="16"></td>
		    <td><div align="left"><a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=de" target="_self" class="standardSchrift">&nbsp;&nbsp;Deutsch</a></div></td>
					  </tr>
					<?php
						}
						if (isItalianShown($unterkunft_id,$link) && $sprache != "it"){
				?>
		  <tr>
		    <td width="1"><img src="../fahneIT.gif" width="25" height="16"></td>
		    <td><div align="left"><a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=it" target="_self" class="standardSchrift">&nbsp;&nbsp;Italia</a></div></td>
					  </tr>
				  <?php
						}
						if (isNetherlandsShown($unterkunft_id,$link) && $sprache != "nl"){
				?>
		  <tr>
		    <td width="1"><img src="../fahneNL.gif" width="25" height="16"></td>
		    <td><div align="left"><a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=nl" target="_self" class="standardSchrift">&nbsp;&nbsp;Nederlands</a></div></td>
					  </tr>
				  <?php
						}						
						if (isEspaniaShown($unterkunft_id,$link) && $sprache != "sp"){
				?>
		  <tr>
		    <td width="1"><img src="../fahneSP.gif" width="25" height="16"></td>
			    <td><div align="left"><a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=sp" target="_self" class="standardSchrift">&nbsp;&nbsp;España</a></div></td>
				  </tr>
				  <?php
						}
						if (isEstoniaShown($unterkunft_id,$link) && $sprache != "es"){
				?>
		  <tr>
		    <td width="1"><img src="../fahneES.gif" width="25" height="16"></td>
			    <td><div align="left"><a href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=es" target="_self" class="standardSchrift">&nbsp;&nbsp;Estnia</a></div></td>
				  </tr>
				  <?php
							} //ende estonia
							?>
				</table>
  <?php
} //ende sprache soll angezeigt werden
?>
</div>
</div>
</body>
</html>