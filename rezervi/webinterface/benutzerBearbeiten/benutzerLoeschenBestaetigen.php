<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			bestätigung zum löschen 
			author utilo.eu
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
//$id = $_POST["id"];
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
<?php include_once("../templates/bodyA.php"); ?>
<!-- <p class="standardSchriftBold"><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></p> -->
<h1><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></h1>
<!-- <form action="./benutzerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" id="zimmerLoeschen"> -->
	
	
	
<div class="panel panel-default">
  	<div class="panel-body">
  		  <a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
  	</div>
</div>
	

	<div class="panel panel-default">		
  <div class="panel-body">
	<form action="./benutzerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
  
      <h4><?php echo(getUebersetzung("Folgende Benutzer werden aus der Datenbank entfernt",$sprache,$link)); ?>:</h4>
        
        <?php 
        
        $benutzer_id = getUserId($benutzername,$passwort,$link);
        
		//benutzer auslesen:
		$query = "select 
				  PK_ID, Name
				  from 
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY 
				  Name";
	
		 $res = mysql_query($query, $link);
		 if (!$res){
			echo("die Anfrage $query scheitert.");
		 }
		 else{     
		  
		   while($d = mysql_fetch_array($res)) {
	 		
			if ($d["PK_ID"] == $benutzer_id) continue;
			if ($d["PK_ID"] == 1 && DEMO == true) continue;
			
	  	?>
	  	
		  <div class="checkbox">
		    <label>
		      <input type="checkbox" name="user_<?php echo($d["PK_ID"]); ?>"> <?php echo(getUserName($d["PK_ID"],$link)); ?>
		    </label>
		  </div>
	  	
	  	<?php }
	  	}
	  	?>
                
        <input name="retour" type="submit" class="btn btn-danger"  id="retour"  value="<?php echo(getUebersetzung("löschen",$sprache,$link)); ?>">
  
</form>
<br/>

  
    	<!-- <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
        <input name="zurueck" type="submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form> -->

   

<br/>
<!-- <table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="hauptmenue" type="submit" class="button200pxA" id="hauptmenue" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table> -->
</body>
</html>
