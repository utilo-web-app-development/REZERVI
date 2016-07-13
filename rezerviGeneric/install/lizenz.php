<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Installation Rezervi Generic</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
	<!--
	function checkLicence(){
		 if(document.formLizenz.lizenz[0].checked){
	       return true;
	     }
	     else{
	     	alert(<?php
				  if ($_POST["sprache"] == "de"){
						?>
						"Sie müssen die Lizenz lesen und akzeptieren!"
						<?
				  }
				  else{
						?>
						"Please read and accept the agreement!"
						<?
				  }
				  ?>);
	     	return false;
	     }
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
		<?
  }
  else{
		?>
		Rezervi Generic booking system
		<?
  }
?>		
</p>
<p <?php if ($fehler == true) echo("class=\"belegt\""); else echo("class=\"frei\""); ?>><?php echo($antwort); ?></p>
<form action="config.php" method="post" id="formLizenz" name="formLizenz" target="_self" onSubmit="return checkLicence();">
	<input type="hidden" name="sprache" value="<?= $_POST["sprache"] ?>" />
	<table  border="0" cellpadding="0" cellspacing="3" class="table">
		<tr>
	          <td>
	          <textarea rows="20" cols="80">
	          <?php
	          if ($_POST["sprache"] == "de"){
	          		include_once("../LIZENZ.txt");
	          }
	          else{
	          		include_once("../LICENCE.txt");
	          }
	          ?>
	          </textarea>	        
	          </td>
	    </tr>
	    <tr>
	          <td>&nbsp;</td>
	    </tr>
		<tr><td>
		<table>   	
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Lizenz gelesen und akzeptiert
						<?
				  }
				  else{
						?>
						I accept the agreement
						<?
				  }
				  ?></td><td>
						<input type="radio" name="lizenz" value="true"></td>
			</tr>
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Lizenz nicht akzeptiert
						<?
				  }
				  else{
						?>
						I do not accept the agreement
						<?
				  }
				  ?></td><td>
						<input name="lizenz" type="radio" value="false" checked></td>
			</tr>
		</table>
		</td></tr>
		    <tr>
	          <td><input name="Submit" type="submit" class="button200pxA" value="ok"></td>
	    </tr>
	</table>   
</form>
</body>
</html>
