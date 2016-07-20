<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			rezervi
			daten des gastes aufnehmen
			author: christian osterrieder utilo.eu					
			
			dieser seite muss übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
			Zimmer PK_ID ($zimmer_id)
			Datum: $vonTag,$vonMonat,$vonJahr
				   $bisTag,$bisMonat,$bisJahr			
			
			die seite verwendet anfrage/send.php um das ausgefüllte
			formular zu versenden
*/ 	 

	//Unterkunft-funktionen einbeziehen:
	include_once($root."/include/unterkunftFunctions.php");
	//zimmer-funktionen einbeziehen:
	include_once($root."/include/zimmerFunctions.php");
	//datum-funktionen einbeziehen:
	include_once($root."/include/datumFunctions.php");
	//reservierungs-funktionen
	include_once($root."/include/reservierungFunctions.php");
	//uebersetzer:
	include_once($root."/include/uebersetzer.php");
	include_once($root."/suche/sucheFunctions.php");
	include_once($root."/include/propertiesFunctions.php");
	include_once($root."/include/buchungseinschraenkung.php");
	include_once($root."/include/priceFunctions.inc.php");
	
	//variablen initialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$sprache = getSessionWert(SPRACHE);
	//von left.php und suche/sucheDurchfuehren.php:
	$datumDPv = $_POST["datumVon"];
	$datumDPb = $_POST["datumBis"];
	$datumVAr = convertDatePickerDate($datumDPv);
	$datumBAr = convertDatePickerDate($datumDPb);
	$vonTag = $datumVAr[0];
	$vonMonat = $datumVAr[1];
	$vonJahr = $datumVAr[2];
	$bisTag = $datumBAr[0];
	$bisMonat = $datumBAr[1];
	$bisJahr = $datumBAr[2];

	if (isset($_POST["haustiere"])){
		$haustiere = $_POST["haustiere"];
	}
	else{
		$haustiere = false;
	}
	
	//von suche/sucheDurchfuehren.php:
	if (isset($_POST["anzahlErwachsene"])){
		$anzahlErwachsene = $_POST["anzahlErwachsene"];
	}
	if (isset($_POST["anzahlKinder"])){
		$anzahlKinder = $_POST["anzahlKinder"];
	}
	if (isset($_POST["anzahlZimmer"])){
		$anzahlZimmer = $_POST["anzahlZimmer"];	
	}
	if (isset($_POST["zimmer_ids"])){
		$zimmer_ids = $_POST["zimmer_ids"];
		$vonSuche = true;
	}
	else{
		//von left.php:
		$zimmer_id = $_POST["zimmer_id"];
		if (isset($zimmer_ids)){
			unset($zimmer_ids);
		}
		$anzahlErwachsene = false;
		$vonSuche = false;
	}
	//trotzdem array mit zimmer-ids mitführen, auch wenns nur eines:
	$zi_ids = array();
	if (isset($zimmer_ids) && count($zimmer_ids)>0){
		$zi_ids = $zimmer_ids;
	}
	else{
		$zi_ids[] = $zimmer_id;
	}
	
	$anzahlTage = numberOfDays($vonMonat,$vonTag,$vonJahr,$bisMonat,$bisTag,$bisJahr);
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!-- checken ob formular korrekt ausgefüllt wurde: -->
<script language="JavaScript" type="text/javascript" src="./indexJS.php">
</script>
<?php include_once("../templates/headerB.php"); 

//wenn anfrage über suche kommt, prüfen ob genug zimmer angeklickt wurden:
//if ($vonSuche == true && ($anzahlZimmer > count($zimmer_ids))){
if(false){
	?>
	<table border="0" class="table">
  		<tr>
    		<td><?php echo(getUebersetzung("Sie haben eine Anfrage für ",$sprache,$link));
					  echo($anzahlZimmer);
					  echo(getUebersetzung(" Zimmer gestellt, jedoch nur ",$sprache,$link));
					  echo(count($zimmer_ids));
					  echo(getUebersetzung(" Zimmer ausgewählt. Bitte korrigieren Sie Ihre Anfrage!",$sprache,$link)); ?>
			</td>
  		</tr>
		<tr>
			<td>
				<input name="Submit" type="submit" class="button200pxA" 
				onMouseOver="this.className='button200pxB';"
				onMouseOut="this.className='button200pxA';" 
				onClick="history.back()"
				value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
			</td>
		</tr>
	</table>
	<?php
}
else {
?>
<?php
 	//zuerst mal prüfen ob datum und so passt:
	//variableninitialisierungen:
	$datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
	$datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);
		
	//wenn nicht ok:
	//1. zimmer ist zu dieser zeit belegt:
	$taken = false;
	if (!isset($zimmer_ids)){
		$taken = isRoomTaken($zimmer_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link);
		//if the room is a parent room, check if the child rooms are taken:
		if (!$taken && hasChildRooms($zimmer_id)){
			$childs = getChildRooms($zimmer_id);
			while ($c = mysqli_fetch_array($childs)){
				$child_zi_id = $c['PK_ID'];
				$taken =  isRoomTaken($child_zi_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link);
				if ($taken){
					break;
				}
			}
		}
	}
	
	if ($taken){

?>
	<table border="0" cellpadding="0" cellspacing="0" class="tableColor">
	  <tr>
	    <td><p class="standardSchriftBold"><?php echo(getUebersetzung("Zu dieser Zeit ist es belegt!",$sprache,$link)); ?></p>
	        <p class="standardSchriftBold"><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?></p>
		</td>
	  </tr>
	</table>
	<br/>
    <form action="../ansichtWaehlen.php" method="post" name="form1" target="_self">	
			<input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
			<input name="jahr" type="hidden" value="<?php echo($vonJahr); ?>">
			<input name="monat" type="hidden" value="<?php echo($vonMonat); ?>">			
        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
    </form>  

<?php
	}
	//2. das datum ist nicht korrekt, das von-datum "höher" als bis-datum
	//mit einem schmäh eine typkonvertierung mit dem +_operator durchführen:
	elseif (isDatumEarlier($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr) == FALSE) {				
?>
	<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td><p class="standardSchriftBold"><?php echo(getUebersetzung("Das Reservierungs-Datum wurde nicht korrekt angegeben!",$sprache,$link)); ?></p>
		  <p class="standardSchriftBold"><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?></p>
	</td>
	  </tr>
	</table>
<?php
	}//ende if datum
	else if ($anzahlTage < 1){
	?>
	<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td><p class="standardSchriftBold"><?php echo(getUebersetzung("Es ist mindestens eine Übernachtung erforderlich",$sprache,$link)); ?>!</p>
		  <p class="standardSchriftBold"><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?></p>
		</td>
	  </tr>
	</table>
	<?php
	}
	else if (isDatumAbgelaufen($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr)){
	?>
	<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td><p class="standardSchriftBold"><?php echo(getUebersetzung("Das gewählte Datum ist bereits abgelaufen.",$sprache,$link)); ?></p>
		  <p class="standardSchriftBold"><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?></p>
		</td>
	  </tr>
	</table>
	<?php
	}
	else if ($vonSuche == false && hasActualBuchungsbeschraenkungen($unterkunft_id) 
					&& !checkBuchungseinschraenkung($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zi_ids)){
	?>
	<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td><p class="standardSchriftBold"><?php echo getBuchungseinschraenkungText($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$zi_ids); ?></p>
		  <p class="standardSchriftBold"><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum Ihrer Anfrage!",$sprache,$link)); ?></p>
		</td>
	  </tr>
	</table>
	<?php
	}
	//wenn datum ok:
	else{
		
	//berechne den preis falls Überhaupt welche definiert wurden:
	$preis = 0;
	if(isset($zimmer_ids)){
		foreach($zimmer_ids as $zi_id){
			$preis += calculatePrice($zi_id,$datumVon,$datumBis);
		}
	}
	else{
		$preis = calculatePrice($zimmer_id,$datumVon,$datumBis);
	}
	
?>
<form action="./send.php" method="post" name="adresseForm" target="_self" 
	id="adresseForm" onSubmit="return chkFormular()">
<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <tr>
    <td><?php
    
    		function removeChildRooms($zimmer_ids){ 
    			$newArr = array();
    			//is room with child rooms in array?
    			$parentInArray = false;
    			foreach($zimmer_ids as $id){
    				if (hasChildRooms($id)){
    					$parentInArray = true;
    				}    				
    			}
    			if ($parentInArray){
	    			foreach($zimmer_ids as $id){
	 
	    				if (hasRoomParentRooms($id) && in_array($id, $zimmer_ids)){
	    					//tu nix    					
	    				}
	    				else{
	    					
	    					$newArr[] = $id;
	    				}
	    			}
	    			return $newArr;
    			}
    			return $zimmer_ids;
    		}
    		$zimmer_ids = removeChildRooms($zimmer_ids);
			//wenn aus suche aufgerufen:
			if(isset($zimmer_ids)){ 

				echo(getUebersetzung("Reservierungs-Anfrage für ",$sprache,$link));
				
				foreach($zimmer_ids as $zi_id){
				?>
				<br/>
				<input name="zimmer_ids[]" type="checkbox" value="<?php echo($zi_id); ?>" checked="checked">	
				<?php				
					echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zi_id,$link),$sprache,$unterkunft_id,$link)." ".(getUebersetzungUnterkunft(getZimmernr($unterkunft_id,$zi_id,$link),$sprache,$unterkunft_id,$link)));
				}
			}
			else{			
				//aus belegungsplan aufgerufen: 
				echo(getUebersetzung("Reservierungs-Anfrage für ",$sprache,$link)." "); 
				$ziA = getZimmerArt($unterkunft_id,$zimmer_id,$link);
				echo(getUebersetzungUnterkunft($ziA,$sprache,$unterkunft_id,$link));
				
			  ?>: <?php echo(getUebersetzungUnterkunft(getZimmernr($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link));
		  }//ende von belegungsplan aufgerufen.
		  ?>
		  <br/>
      <?php echo(getUebersetzung("von",$sprache,$link)); ?>:<span class="standardSchriftBold"> <?php echo($vonTag); ?>.<?php echo($vonMonat); ?>.<?php echo($vonJahr); ?></span><br/>
      							  <?php echo(getUebersetzung("bis",$sprache,$link)); ?>:<span class="standardSchriftBold"> <?php echo($bisTag); ?>.<?php echo($bisMonat); ?>.<?php echo($bisJahr); ?> </span> </td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><p><?php echo(getUebersetzung("Wir benötigen noch folgende Daten von Ihnen",$sprache,$link)); ?>:</p>
         <table border="0" cellspacing="0" cellpadding="3">
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td> <select name="anrede" id="anrede">
                <option><?php echo(getUebersetzung("Familie",$sprache,$link)); ?></option>
                <option><?php echo(getUebersetzung("Frau",$sprache,$link)); ?></option>
                <option><?php echo(getUebersetzung("Herr",$sprache,$link)); ?></option>
                <option><?php echo(getUebersetzung("Firma",$sprache,$link)); ?></option>
              </select> </td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?>*</td>
            <td><input name="vorname" type="text" id="vorname"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?>*</td>
            <td><input name="nachname" type="text" id="nachname"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Straße/Hausnummer",$sprache,$link)); ?>*</td>
            <td><input name="strasse" type="text" id="strasse"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("PLZ",$sprache,$link)); ?>*</td>
            <td><input name="plz" type="text" id="plz"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Ort",$sprache,$link)); ?>*</td>
            <td><input name="ort" type="text" id="ort"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td><input name="land" type="text" id="land"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?>*</td>
            <td><input name="email" type="text" id="email"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td><input name="tel" type="text" id="tel"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td><input name="fax" type="text" id="fax"></td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Anmerkungen/Fragen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkung" id="anmerkung"></textarea></td>
          </tr>
		  <?php
				//wenn die anfrage aus der suche kommt, hier keine Auswahl mehr erlauben:
				if (isset($anzahlErwachsene) && $anzahlErwachsene != false && $anzahlErwachsene > -1){
					?>
					<input name="anzahlErwachsene" type="hidden" value="<?php echo($anzahlErwachsene); ?>">
					<tr class="standardSchrift"> 
					<td><?php echo(getUebersetzung("Anzahl Erwachsene",$sprache,$link)); ?>
					</td>
					<td><?php echo($anzahlErwachsene); ?></td>
					</tr>					
					<?php
				}
				else{
		  		?>
				  <tr class="standardSchrift"> 
					<td><?php echo(getUebersetzung("Anzahl Erwachsene",$sprache,$link)); ?></td>
					<td>
					<select name="anzahlErwachsene" id="anzahlErwachsene">
						<?php 
							//es können nur soviele ausgewählt werden wie betten im zimmer
							//vorhanden sind:
							$anzahlBetten = getBetten($unterkunft_id,$zimmer_id,$link);
							$anzahlBetten+=1;$anzahlBetten-=1; //integer!
					  	    $anzahlKinderBetten = getBettenKinder($unterkunft_id,$zimmer_id,$link);
					  	    $st = 1;	
					  	    if ($anzahlKinderBetten > 0){
					  	    	 $st = 0;
					  	    }							
						for ($i = $st; $i <= $anzahlBetten; $i++){ ?>
								<option value="<?php echo($i); ?>" <?php if ($i == 2) echo("selected"); ?>><?php echo($i); ?></option>
						<?php 
							} //ende for schleife
						?>
					  </select>
					  </td>
				  </tr>
		  		<?php
			  	} //ende else anfrage kommt aus suche
				//KINDER
			  $res = getPropertiesSuche($unterkunft_id, $link); //Methode in einstellungenFunctions.php definiert
  	          while($d = mysqli_fetch_array($res))
	          {
  	            if($d["Name"] == 'Kinder')
				{
				  $name = $d["Name"];
	              //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
  	              $aktiviert = isPropertyShown($unterkunft_id,$name,$link); //Methode in einstellungenFunctions.php definiert               
                 
				  if($aktiviert == 'true')			
				  {	
				    if (isset($anzahlKinder))
					{
					  //anfrage kommt aus suche:
					  if ($anzahlKinder > -1)
					  {
					    ?>
					    <input name="anzahlKinder" type="hidden" value="<?php echo($anzahlKinder); ?>">
					    <tr class="standardSchrift"> 
					      <td><?php echo(getUebersetzung("Anzahl Kinder unter",$sprache,$link)); ?> <?php echo(getKindesalter($unterkunft_id,$link)); ?> 
					        <?php echo(getUebersetzung("Jahren",$sprache,$link)); ?>
					      </td>
					      <td><?php echo($anzahlKinder); ?></td>
					    </tr>					
					    <?php
					  }
				    }
				    else
				    {	
					   if ($anzahlKinderBetten > 0)
					   {
		  		          ?>
				          <tr class="standardSchrift"> 
					        <td><?php echo(getUebersetzung("Anzahl Kinder unter",$sprache,$link)); ?> <?php echo(getKindesalter($unterkunft_id,$link)); ?> 
					          <?php echo(getUebersetzung("Jahren",$sprache,$link)); ?></td>
					        <td>
						      <select name="anzahlKinder" id="anzahlKinder">
						        <?php
						        for ($i = 0; $i <= ($anzahlKinderBetten); $i++)
						        { 
						           ?>
							       <option value="<?php echo($i); ?>" <?php if ($i == 0) echo("selected"); ?>><?php echo($i); ?></option>
						           <?php 
						        }//ende for schleife
						        ?>
					          </select>
						    </td>
				          </tr>
		                  <?php
		  	            } //ende if ($anzahlKinderBetten > 0)
					}//ende else-loop
				  }//ende if($d["Name"] == 'Kinder')
				}//ende if($aktiviert)
		      }//end while 		  
		      
			  //HAUSTIERE
			  $res = getPropertiesSuche($unterkunft_id, $link); //Methode in einstellungenFunctions.php definiert
  	          while($d = mysqli_fetch_array($res))
	          {
  	            if($d["Name"] == 'Haustiere')
				{
				  $name = $d["Name"];
	              //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
  	              $aktiviert = isPropertyShown($unterkunft_id,$name,$link); //Methode in einstellungenFunctions.php definiert               
                 
				  if($aktiviert)
				  { 
		            if (isset($haustiere))
		            {
                      //anfrage kommt aus suche:
		              if ($haustiere == 'true')
		              {?>
		                  <input name="Haustiere" type="hidden" value="<?php echo($haustiere); ?>">
		                  <tr class="standardSchrift"> 
			                <td>
				              <?php
							  	echo(getUebersetzung("Haustiere",$sprache,$link));
				              ?> 
				            </td>
				            <td>ja</td>
			              </tr>					
			              <?php
					  }
		            }
                    else
		            {
                      //anfrage kommt aus belegungsplan:  ?>
                      <tr class="standardSchrift">
                        <td>
	                      <?php echo(getUebersetzung($name,$sprache,$link));
	                      ?>
		                </td>
					    <td>
					      <input name="<?php echo($name); ?>" type="checkbox" id="<?php echo($name); ?>" value="true" >
		                </td>
                      </tr>
				      <?php
				  } //end else-loop
				}//end if($aktiviert)
			  }//end if($d["Name"] == 'Haustiere')
			}//end while-loop
		  ?>
  			<?php 
  			if (getPropertyValue(PENSION_UEBERNACHTUNG,$unterkunft_id,$link) == "true"){
  			?>
              <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Übernachtung",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Uebernachtung" checked="checked"/>
                </td>
              </tr>
              <?php
  			  }
  			  if (getPropertyValue(PENSION_FRUEHSTUECK,$unterkunft_id,$link) == "true"){
              ?>
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Frühstück",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Fruehstueck" checked="checked"/>
                </td>
              </tr>
              <?php
  			  }
  			  if (getPropertyValue(PENSION_HALB,$unterkunft_id,$link) == "true"){
              ?>
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Halbpension",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Halbpension" checked="checked"/>
                </td>
              </tr>
              <?php
  			  }
  			  if (getPropertyValue(PENSION_VOLL,$unterkunft_id,$link) == "true"){
              ?>                      
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Vollpension",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Vollpension" checked="checked"/>
                </td>
              </tr>
			  <?php
  			  }
  			  //PREIS anzeigen falls einer vorhanden ist:
  			  if ($preis > 0){
              ?>                      
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Gesamtpreis",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <?php echo $preis ?> <?php echo getWaehrung($unterkunft_id) ?>
			      <input type="hidden" name="preis" value="<?php echo $preis ?>"/>
                </td>
              </tr>
			  <?php
  			  }
  			  ?>  			  
        </table>
        <p>(<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder müssen ausgefüllt werden!",$sprache,$link)); ?>) 
		  <?php if(!isset($zimmer_ids)){ 
		  ?>
          	<input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
		  <?php }
		  ?>
          <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
          <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
        </p>
        <p><?php echo(getUebersetzung("Hinweis: Es handelt sich hierbei um eine Reservierungs-Anfrage.",$sprache,$link));
			     echo(getUebersetzung("Der Vermieter wird sich mit Ihnen in Verbindung setzen um gegebenenfalls die Reservierung zu bestätigen.",$sprache,$link)); ?></p>
        </td>
  </tr>
</table>
  <br/>
  <table border="0" cellspacing="3" cellpadding="0" class="table">
    <tr>
      <td><p>
          <input name="send" type="submit" class="button200pxA" 
		  	onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="send" 
			value="<?php echo(getUebersetzung("Absenden",$sprache,$link)); ?>">        
        </p>     
    </td>
    </tr>
  </table>
</form>
      <?php 
	  
	} //ende else - datum ok 
}//ende else zu wenig zimmer ausgewaehlt
?>
</body>
</html>