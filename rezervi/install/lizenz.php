<?php 
	// Set flag that this is a parent file
	define( '_JEXEC', 1 );
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Installation Rezervi</title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Bootstrap ende -->
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

<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:70px;">
<div class="panel panel-default">
  <div class="panel-body">
  	
<h1>Rezervi availability overview and guest database<br/>
					    Rezervi Belegungsplan und Kundendatenbank</h1>
					    
					    <!-- Neues Design -->
<p<?php if (isset($fehler) && $fehler == true) echo("class=\"belegt\""); else echo("class=\"frei\""); ?>>
<?php 
if (isset($antwort)) echo($antwort); ?></p>
<form action="config.php" method="post" id="formLizenz" name="formLizenz" target="_self" class="form-horizontal" onSubmit="return checkLicence();">
	<input type="hidden" name="sprache" value="<?php echo($_POST["sprache"]) ?>" />
	

	
<div class=	"col-md-8">        
		<textarea class="form-control" rows="20" cols="80">
	          
	          <?php
	          if ($_POST["sprache"] == "de"){
	          		include_once("../LIZENZ.txt");
	          }
	          else{
	          		include_once("../LICENCE.txt");
	          }
	          ?>
	     </textarea>  
</div>
  
						
<div class="radio" "col-md-4">
 	   	<label>
   			<input type="radio" name="lizenz" id="optionsRadios1" value="true">
   			 
  				  <?php
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
				  ?>
 		 </label>
</div>
<div class="radio">
  				<label>
    				<input type="radio" name="lizenz" id="optionsRadios2" value="false"checked>
    		
				 <?php
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
				  ?>
 	 			</label>
</div>
		
		
		    <input name="Submit" type="submit" class="btn btn-success" value="ok">
	    
	   
					    <!-- Ende Neues Design -->
					    
 <!-- <?php if (isset($fehler) && $fehler == true) echo("class=\"belegt\""); else echo("class=\"frei\""); ?>
<?php 
if (isset($antwort)) echo($antwort); ?>
</p>
<form action="config.php" method="post" id="formLizenz" name="formLizenz" target="_self" class="form-horizontal" onSubmit="return checkLicence();">
	<input type="hidden" name="sprache" value="<?php echo($_POST["sprache"]) ?>" />
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
	          <td><input name="Submit" type="submit" class="btn-btn-success" value="ok"></td>
	            
	    </tr>
	</table>    -->
</form>
</div>
</div>
</div>
</body>
</html>