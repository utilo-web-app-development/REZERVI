<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi			
			author: christian osterrieder utilo.eu				

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
<?php include_once("../templates/bodyA.php"); ?>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 	
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Design auf Standardwerte zurücksetzen",$sprache,$link)); ?></p>

  <table width="100%" border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><table border="0" cellspacing="2" cellpadding="0">         
          <tr>            
            <td><?php 
				$array = array(
						'backgroundColor' => 'background-color: #F1F1F7;',
						'standardSchrift' => 'font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												line-height: normal;
												font-weight: normal;
												font-variant: normal;
												color: #000000;',
						'belegt' => 'font-family: Arial, Helvetica, sans-serif;
										font-size: 12px;
										font-style: normal;
										font-weight: normal;
										font-variant: normal;
										background-color: #FF0000;
										border: 1px ridge #000000;
										text-align: center;',
						'frei' => 'font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
									font-style: normal;
									font-weight: normal;
									font-variant: normal;
									background-color: #009BFA;
									border: 1px ridge #000000;
									text-align: center;',
						'samstagBelegt' => 'font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												font-weight: normal;
												font-variant: normal;
												background-color: pink;
												border: 1px ridge #000000;
												text-align: center;',
						'samstagFrei' => 'font-family: Arial, Helvetica, sans-serif;
											font-size: 12px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: yellow;
											border: 1px ridge #000000;
											text-align: center;',
						'standardSchriftBold' => 'font-family: Arial, Helvetica, sans-serif;
													font-size: 12px;
													font-style: normal;
													line-height: normal;
													font-weight: bold;
													font-variant: normal;
													color: #000000;',
						'ueberschrift' => 'font-family: Arial, Helvetica, sans-serif;
											font-size: 14px;
											font-style: normal;
											font-weight: bold;
											font-variant: normal;',
						'tableStandard' => 'font-family: Arial, Helvetica, sans-serif;
												font-size: 12px;
												font-style: normal;
												font-weight: normal;
												font-variant: normal;
												background-color: #F1F1F7;
												border: 0 ridge #6666FF;',
						'tableColor' => 'font-family: Arial, Helvetica, sans-serif;
											font-size: 12px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											border: 1 ridge #6666FF;',
						'button200pxA' => 'font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #FFFFFF;
											height: 20px;
											width: 170px;
											border: 1px ridge #6666FF;',
						'button200pxB' => 'font-family: Arial, Helvetica, sans-serif;
											font-size: 11px;
											font-style: normal;
											font-weight: normal;
											font-variant: normal;
											background-color: #0023DC;
											height: 20px;
											width: 170px;
											color: #FFFFFF;
											border: 1px ridge #FFFFCC;'
						);

				
	foreach($array as $feld => $wert){
		//stylesheet in datenbank eintragen:
		$query = trim("UPDATE Rezervi_CSS SET $feld = '$wert'
				   WHERE
				   FK_Unterkunft_ID = $unterkunft_id;");		
		
		//query absetzen:
		$res = mysql_query($query, $link);
		if (!$res) {
			echo("Anfrage $query scheitert.");
		}
	}
	?>
	<span class="frei"><?php echo(getUebersetzung("Das Design wurde erfolgreich geändert",$sprache,$link)); ?>!</span></td>
			</tr>
		 </table></td>
    </tr>
  </table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="./index.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
<?php } //ende else
 ?>
</body>
</html>