<?php 
/*
 * Created on 19.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Hauptseite von Backoffice
 *  
 */

	//oeffne session wenn noch nicht erledigt:
	$id = session_id();
	if (empty($id)){
		session_start();
	}		
	//root nicht verändern wenn von einer anderen seite aufgerufen!
	if (!isset($fehler) || !empty($fehler) || !$fehler){
		$root = "..";
	}
	include_once($root."/conf/conf.inc.php");
	include_once($root."/include/rdbmsConfig.inc.php");
	include_once($root."/include/uebersetzer.inc.php");	
 	include_once($root."/include/benutzerFunctions.inc.php");
 	include_once($root."/include/sessionFunctions.inc.php"); 
 	
	if (isset($_GET["gastro_id"])){
		$gastro_id = $_GET["gastro_id"];
	}else if (isset($_POST["gastro_id"])){
		$gastro_id = $_POST["gastro_id"];	
	}else if (getSessionWert(GASTRO_ID) != false){
		$gastro_id = getSessionWert(GASTRO_ID);
	}else{
		$gastro_id = 1;
	}
	 	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Wartungsseite Backoffice Bookline</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="author" content="Alpstein"/>
	<meta name="Generator" content="All coding done by hand"/>
	<meta name="robots" content="INDEX,FOLLOW"/>
	<meta name="publisher" content="Alpstein"/>
	<meta name="copyright" content="Alpstein"/>
	<meta name="audience" content="Alle"/>
	<meta name="geo.region" content="AUT"/>
	<meta name="geo.placename" content="Salzburg, Austria"/>
	<link href="./templates/template_css.css" rel="stylesheet" type="text/css">
</head>
<body  bgcolor="#ffffff">
<div id="container">
	<div id="header">
		<div id="topimage">
			<img src="./pic/new_Alpstein.jpg" alt="UTILO. Ihr Vorteil hat einen Namen."/>
			<div id="headertext">REZERVI TABLE</div>
		</div>
		<div id="logo">
			<a href="http://www.utilo.eu/">
				<img src="./pic/new_Logo_Alpstein.jpg" alt="UTILO. Ihr Vorteil hat einen Namen."/>
			</a>
		</div>
	</div> <!--header-->
	
	<div id="page_login"> <?php
		//passwort wurde falsch eingegeben:
		if (!(empty($fehlgeschlagen)) && $fehlgeschlagen) {	?>
			<div class="belegt"><?php echo(getUebersetzung("Der Benutzername und/oder das Passwort wurden falsch eingegeben, bitte wiederholen Sie Ihre Eingabe!")); ?></div>
			<br /> <?php
	  	} //ende if passwort falsch 
	  	?>
      	<p>Please login with your username and password:<br/>
			Bitte melden Sie sich mit Ihrem Benutzernamen und Passwort an:<br/><br/>     
			If you login for the first time please use 'test' for username and password. 
			Change the password after your first login!<br/>
			Verwenden sie den Benutzernamen und das Password 'test', 
			wenn sie sich das erste mal anmelden. Vergessen sie nicht diese Daten danach zu &Auml;ndern!
		</p>
							
       	<form action="<?= $root ?>/backoffice/anmelden.php" method="post" name="passwortEingabe" target="_self" id="passwortEingabe">
		<p><table>
			<tr>
				<td valign="middle">Username/Benutzername</td>
 				<td><input name="ben" type="text" id="ben"></td>
			</tr>
			<tr>
				<td valign="middle">Password/Passwort</td>
				<td><input name="pass" type="password" id="pass"></td>
			</tr>
			<tr>
				<td valign="middle">Language/Sprache</td>
 				<td>
					<select name="sprache"> <?php
						$res = getSprachen();
						while($d = $res->FetchNextObject()){
							$bezeichnung = $d->BEZEICHNUNG;
							$spracheID   = $d->SPRACHE_ID;
							$sprache = "en";
							$bezeichnung_en = getUebersetzung($bezeichnung); ?>
							<option class="standardschrift" value="<?php echo($spracheID); ?>" <?php if ($sprache == $spracheID) echo(" selected"); ?>>
								<?php echo($bezeichnung_en."/".$bezeichnung); ?>
							</option>  <?php
						} ?>
					</select>
				</td>
			</tr>
		</table></p>
		<p>
			<input  class="button" name="anmelden" type="submit" id="anmelden" value="login/anmelden"/>
		</p>
		</form>
	</div> <!--page_login-->
</div><!--container-->
<div id="footer">
	&copy; UTILO, <a href="http://www.utilo.eu" style="text-decoration:none">http://www.utilo.eu</a>
</div>
</body>
</html>
<?php
	include_once($root."/include/closeDB.inc.php");
?>
