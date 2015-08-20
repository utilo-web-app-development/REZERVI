<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Installation Rezervi</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
		<!--
	function checkForm(){
		 if(document.formConfig.unterkunft_name.value == ""){
		 	
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
							"Bitte geben sie den Namen ihrer Unterkunfte in!"
						<?
						}
						else{
						?>
							"Please fill in the name of your accomodation!"
						<?
						}
				  ?>);
				  
	     	return false;
		 }
		 
		 if(document.formConfig.mietobjekt_ez.value == ""){
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
							"Bitte geben sie den Namen ihres Mietobjektes ein (Einzahl)!"
						<?
						}
						else{
						?>
							"Please fill in the name of your object to rent (singular)!"
						<?
						}
				  ?>);
	     	return false;
		 }
		 
		 if(document.formConfig.mietobjekt_mz.value == ""){
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
							"Bitte geben sie den Namen ihres Mietobjektes ein (Mehrzahl)!"
						<?
						}
						else{
						?>
							"Please fill in the name of your object to rent (plural)!"
						<?
						}
				  ?>);
	     	return false;
		 }
		 
		 if(document.formConfig.art.value == ""){
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
							"Bitte geben sie den Art ihrer Unterkunft ein!"
						<?
						}
						else{
						?>
							"Please fill in the type of your accomodation!"
						<?
						}
				  ?>
					);
					return false;
					}

					return true;
					}
					-->
</script>
</head>

<body>

<p class="ueberschrift">Rezervi availability overview and guest database<br/>
					    Rezervi Belegungsplan und Kundendatenbank</p>
<p <?php
							if (isset($fehler) && $fehler == true)
								echo("class=\"belegt\"");
							else
								echo("class=\"frei\"");
 ?>><?php
							if (isset($antwort))
								echo($antwort);
 ?></p>
<form action="install.php" method="post" id="formConfig" name="formConfig" target="_self" onSubmit="return checkForm();">
	<input type="hidden" name="sprache" value="<?= $_POST["sprache"] ?>" />
	<table  border="0" cellpadding="0" cellspacing="3" class="table"> 	
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Name ihrer Unterkunft
						<?
						}
						else{
						?>
						Name of your accomodation
						<?
						}
				  ?></td>
				  	<td>
						<input type="text" name="unterkunft_name" />*
					</td>
			</tr>
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Art ihrer Unterkunft (z. B. Hotel) 
						<?
						}
						else{
						?>
						Type of your accomodation (eg. Hotel)
						<?
						}
				  ?></td>
				 	<td>
						<input name="art" type="text" />*
					</td>
			</tr>
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Bezeichnung ihres Mietobjektes - Einzahl (z. B. Zimmer, Appartement) 
						<?
						}
						else{
						?>
						Name of your object to rent - singular (eg. room, apartement)
						<?
						}
				  ?></td>
				 	<td>
						<input name="mietobjekt_ez" type="text" />*
					</td>
			</tr>
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Bezeichnung ihres Mietobjektes - Mehrzahl (z. B. Zimmer, Appartements) 
						<?
						}
						else{
						?>
						Name of your object to rent - plural (eg. rooms, apartements)
						<?
						}
				  ?></td>
				 	<td>
						<input name="mietobjekt_mz" type="text" />*
					</td>
			</tr>
		    <tr>
	          <td colspan="2">
	          	<input name="Submit" type="submit" class="button200pxA" value="ok">
	          </td>
	    	</tr>
	</table>   
</form>
</body>
</html>