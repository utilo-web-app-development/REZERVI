<?php
/**
 * @author coster
 * Zeigt die Lizenzbestimmungen von Bookline
 */
 if (!isset($fehler)){
 	$fehler = false;
 	$antwort = "";
 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html">
<meta charset="UTF-8">
<title>Installation Bookline Lizenz</title>
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
						<?php
				  }
				  else{
						?>
						"Please read and accept the agreement!"
						<?php
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
		Installation Bookline
		<?php
  }
  else{
		?>
		Bookline installation
		<?php
  }
?>		
</p>
<?php 
if ($antwort != ""){
?>
}
	<p <?php if ($fehler == true) echo("class=\"belegt\""); else echo("class=\"frei\""); ?>><?php echo($antwort); ?></p>
<?php
}
?>
<form action="config.php" method="post" id="formLizenz" name="formLizenz" target="_self" onSubmit="return checkLicence();">
	<input type="hidden" name="sprache" value="<?php echo $_POST["sprache"] ?>" />
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
						<?php
				  }
				  else{
						?>
						I accept the agreement
						<?php
				  }
				  ?></td><td>
						<input type="radio" name="lizenz" value="true"></td>
			</tr>
			<tr>
				  <td><?php
				  if ($_POST["sprache"] == "de"){
						?>
						Lizenz nicht akzeptiert
						<?php
				  }
				  else{
						?>
						I do not accept the agreement
						<?php
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
