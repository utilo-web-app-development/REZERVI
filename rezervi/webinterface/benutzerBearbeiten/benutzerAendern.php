<html>
	<head>
<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi
			author utilo.eu
			benutzer aendern
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$id = $_POST["id"];
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");	
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<script language="JavaScript" type="text/javascript" src="./benutzerDaten.php">
</script>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
	
	//daten des ausgewählten benutzers auslesen:
	$name = getUserName($id,$link);
	$pass = getPassword($id,$link);
	$rechte = getUserRights($id,$link);
	$testuser = "false";
	if ($name == "test"){
		$testuser = "true";
	}
?>
</head>
 <body>
 <h2><?php echo(getUebersetzung("Benutzer bearbeiten",$sprache,$link)); ?></h2>
 

<div class="panel panel-default">
  <div class="panel-body">
  	<a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-body">
  
	<form action="./benutzerAendernDurchfuehren.php" method="post" name="benutzer" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
		
<!-- <form action="./benutzerAendernDurchfuehren.php" method="post" name="benutzer" id="benutzer" target="_self" onSubmit="return chkFormular()"> -->
  <input name="id" type="hidden" value="<?php echo($id); ?>">
  <input name="testuser" type="hidden" value="<?php echo $testuser ?>">

  	<?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.",$sprache,$link)); ?> <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!",$sprache,$link)); ?>
  
    
    <div class="form-group">
				<label for="name" class="col-sm-2 control-label"><?php echo(getUebersetzung("Benutzername",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<input name="name" type="text" id="name" value="<?php if (isset($name)) {echo($name);} ?>" class="form-control">
				</div>
	</div>	
	   
    <div class="form-group">
				<label for="pass" class="col-sm-2 control-label"><?php echo(getUebersetzung("Passwort",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<input name="pass" type="password" id="pass" value="<?php if (isset($pass)) {echo($pass);} ?>" class="form-control">
				</div>
	</div>	
    
    <div class="form-group">
				<label for="pass2" class="col-sm-2 control-label"><?php echo(getUebersetzung("Passwort wiederholen",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<input name="pass2" type="password" id="pass2" value="<?php if (isset($pass)) {echo($pass);} ?>" class="form-control">
				</div>
	</div>	
	
    <div class="form-group">
				<label for="rechte" class="col-sm-2 control-label"><?php echo(getUebersetzung("Benutzerrechte",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<select name="rechte" type="text" id="rechte" class="form-control">
					<option value="1" <?php if ($rechte == 1) echo(" selected"); ?>><?php echo(getUebersetzung("Benutzer",$sprache,$link)); ?></option>
          			<option value="2" <?php if ($rechte == 2) echo(" selected"); ?>><?php echo(getUebersetzung("Administrator",$sprache,$link)); ?></option> 
          			</select>
				</div>
	</div>	
    

 <div class="form-group">
 		<div class="col-sm-2">	
 		</div>		 
	<div class="col-sm-10">
		<input name="Submit" type="submit" id="Submit" class="btn btn-success" value="<?php echo(getUebersetzung("Benutzer Ändern",$sprache,$link)); ?>">
	</div>
</div>	

</form>
</div>
</div>

<!-- <table  border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table> -->

<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>

</html>
