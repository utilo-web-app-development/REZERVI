<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			benutzer anlegen
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
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

<h2><?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?><br/>      
<h4><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.",$sprache,$link)); ?><br/>
    <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!",$sprache,$link)); ?>
</h4>

<div class="panel panel-default">
  <div class="panel-body">
    <a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
<form action="./benutzerEintragen.php" method="post" name="benutzer" id="benutzer" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
			
<!-- <form action="./benutzerEintragen.php" method="post" name="benutzer" id="benutzer" target="_self" onSubmit="return chkFormular()">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td colspan="2"><p class="standardSchriftBold"><?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.",$sprache,$link)); ?> 
          <br/>
          <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!",$sprache,$link)); ?></span></p></td>
    </tr> -->
    <!-- <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr> -->
    <!-- <tr>
      <td width="50%"><?php echo(getUebersetzung("Benutzername",$sprache,$link)); ?>*</td>
      <td width="50%"><input name="name" type="text" id="name" value="" maxlength="20"></td>
    </tr> -->
    <div class="form-group">
				<label for="name" class="col-sm-2 control-label"><?php echo(getUebersetzung("Benutzername",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<input name="name" type="text" id="name" value="" class="form-control"required="required">
				</div>
			</div>	
    <!-- <tr>
      <td><?php echo(getUebersetzung("Passwort",$sprache,$link)); ?>*</td>
      <td><input name="pass" type="password" id="pass" value="" maxlength="20"></td>
    </tr> -->
    <div class="form-group">
				<label for="pass" class="col-sm-2 control-label"><?php echo(getUebersetzung("Passwort",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<input name="pass"  id="pass" type="password" value="" class="form-control"required="required">
					
				</div>
	</div>
    <!-- <tr>
      <td><?php echo(getUebersetzung("Passwort wiederholen",$sprache,$link)); ?>*</td>
      <td><input name="pass2" type="password" id="pass2" value="" maxlength="20"></td>
    </tr> -->
     <div class="form-group">
				<label for="pass2" class="col-sm-2 control-label"><?php echo(getUebersetzung("Passwort wiederholen",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
					<input name="pass2" id="pass2" type="password" value="" class="form-control"required="required">
				</div>
	</div>
    <!-- <tr>
      <td height="30" colspan="2">&nbsp;</td>
    </tr> -->
    <!-- <tr>
      <td><?php echo(getUebersetzung("Benutzerrechte",$sprache,$link)); ?>*</td>
      <td><select name="rechte">
          <option value="1" selected><?php echo(getUebersetzung("Benutzer",$sprache,$link)); ?></option>
          <option value="2"><?php echo(getUebersetzung("Administrator",$sprache,$link)); ?></option>
        </select></td>
    </tr> -->
    <div class="form-group">
				<label for="rechte" class="col-sm-2 control-label"><?php echo(getUebersetzung("Benutzerrechte",$sprache,$link)); ?>*</label>
				<div class="col-sm-10">
	   <select name="rechte" type="text" id="rechte" value="" class="form-control">
		  <option value="1" selected><?php echo(getUebersetzung("Benutzer",$sprache,$link)); ?></option>
          <option value="2"><?php echo(getUebersetzung("Administrator",$sprache,$link)); ?>	   </option>
       </select>
				</div>
	</div>
    
     <input name="Submit" type="submit" id="Submit" class="btn btn-success"  
      value="<?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?>">
     
    

</form>
<!-- <table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td>
    	<a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
    	<form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form>
    </td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table> -->
</body>
</html>
