<?php
/**
 * @author coster
 * Eingabe von Pflichtwerten zur Installation von Bookline
 */
 if (!isset($fehler)){
 	$fehler = false;
 	$antwort = "";
 }
?>
<!DOCTYPE html">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html">
 <meta charset="UTF-8">
<title>Installation Bookline Konfiguration</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
	<!--
	function checkForm(){
		
		 if(document.formConfig.firma_name.value == ""){
		 	
		 	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
						"Bitte geben sie den Namen ihres Gastronomiebetriebes ein!"
						<?
				  }
				  else{
						?>
						"Please fill in the name of your gastronomy!"
						<?
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
		Installation Bookline
		<?
  }
  else{
		?>
		Bookline installation
		<?
  }
?>		
</p>			    
<p <?php if ($fehler == true) echo("class=\"belegt\""); else echo("class=\"frei\""); ?>><?php echo($antwort); ?></p>
<form action="install.php" method="post" id="formConfig" name="formConfig" target="_self" onSubmit="return checkForm();">
	<input type="hidden" name="sprache" value="<?= $_POST["sprache"] ?>" />
	<table  border="0" cellpadding="0" cellspacing="3" class="table"> 	
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Name ihres Gastronomiebetriebes
						<?
				  }
				  else{
						?>
						Name of your gastronomy
						<?
				  }
				  ?></td>
				  	<td>
						<input type="text" name="firma_name" />*
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
