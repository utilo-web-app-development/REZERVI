<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Installation Rezervi Generic</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
	<!--
	function checkForm(){
		 if(document.formConfig.firma_name.value == ""){
		 	
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
						"Bitte geben sie den Namen ihrer Organisation oder Firma ein!"
						<?php
				  }
				  else{
						?>
						"Please fill in the name of your organisation or business!"
						<?php
				  }
				  ?>);
				  
	     	return false;
		 }
		 
		 if(document.formConfig.mietobjekt_ez.value == ""){
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
						"Bitte geben sie den Namen ihres Mietobjektes ein (Einzahl)!"
						<?php
				  }
				  else{
						?>
						"Please fill in the name of your object to rent (singular)!"
						<?php
				  }
				  ?>);
	     	return false;
		 }
		 
		 if(document.formConfig.mietobjekt_mz.value == ""){
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
						"Bitte geben sie den Namen ihres Mietobjektes ein (Mehrzahl)!"
						<?php
				  }
				  else{
						?>
						"Please fill in the name of your object to rent (plural)!"
						<?php
				  }
				  ?>);
	     	return false;
		 }

		return true;
	}
	-->
</script>
</head>

<body>
<p class="ueberschrift">					    
<?php
  if ($_POST["sprache"] == "de"){
		?>
		Rezervi Generic Buchungssystem
		<?php
  }
  else{
		?>
		Rezervi Generic booking system
		<?php
  }
?>		
</p>			    
<p <?php if ($fehler == true) echo("class=\"belegt\""); else echo("class=\"frei\""); ?>><?php echo($antwort); ?></p>
<form action="install.php" method="post" id="formConfig" name="formConfig" target="_self" onSubmit="return checkForm();">
	<input type="hidden" name="sprache" value="<?php echo $_POST["sprache"] ?>" />
	<table  border="0" cellpadding="0" cellspacing="3" class="table"> 	
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Name ihrer Organisation oder Firma
						<?php
				  }
				  else{
						?>
						Name of your organisation or business
						<?php
				  }
				  ?></td>
				  	<td>
						<input type="text" name="firma_name" />*
					</td>
			</tr>
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Bezeichnung ihres Mietobjektes - Einzahl (z. B. Zimmer, Tennisplatz) 
						<?php
				  }
				  else{
						?>
						Name of your object to rent - singular (eg. room, tennis court)
						<?php
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
						Bezeichnung ihres Mietobjektes - Mehrzahl (z. B. Zimmer, Tennisplätze) 
						<?php
				  }
				  else{
						?>
						Name of your object to rent - plural (eg. rooms, tennis courts)
						<?php
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
