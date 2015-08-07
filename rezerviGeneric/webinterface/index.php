<?php
	
	//root nicht ver�ndern wenn von einer anderen seite aufgerufen!
	if (!isset ($fehler) || $fehler == true){
		$root = "..";
	}
	include_once($root."/conf/rdbmsConfig.inc.php");
	include_once($root."/include/uebersetzer.inc.php");	
 	include_once($root."/include/benutzerFunctions.inc.php");
	 	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Wartungsseite Reservierungsplan UTILO.eu Belegungsplan und Kundendatenbank Rezervi Generic</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?= $root ?>/templates/stylesheets.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="95%" height="90%" border="0" align="center" cellpadding="0" cellspacing="3" class="table">
  <tr> 
    <td align="center" valign="middle"><table  border="0" align="center" cellpadding="0" cellspacing="2" class="table">
      <tr>
        <td class="ueberschrift" align="right">Welcome at the
          webinterface of 'Rezervi Generic'
           <a href="http://www.UTILO.eu/" target="_blank" class="ueberschrift">&copy; UTILO.eu</a>
        </td>
        <td><a href="http://www.UTILO.eu" target="_blank"><img src="<?= $root ?>/webinterface/utilologo200px.gif" border="0"></a></td>
        <td class="ueberschrift">Willkommen auf der Wartungsseite 
          von
          'Rezervi Generic' 
           <a href="http://www.rezervi.com/" target="_blank" class="ueberschrift">&copy; UTILO.eu</a>
        </td>
      </tr>
    </table>    
    <p class="ueberschrift">
      <?php
		//passwort wurde falsch eingegeben:
		if (!(empty($fehlgeschlagen)) && $fehlgeschlagen) {
		?>
      </p>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="belegt">
        <tr>
          <td><div align="center"><?php echo(getUebersetzung("Der Benutzername und/oder das Passwort wurden falsch eingegeben, bitte wiederholen Sie Ihre Eingabe!")); ?></div></td>
        </tr>
      </table>
      <br />		
      <?php
	  	} //ende if passwort falsch
		?>
      <table  border="0" align="center" cellpadding="0" cellspacing="2" class="table">
        <tr>
          <td><p align="center" class="standardSchrift">
		Please login with your username and password:<br/>
		Bitte melden Sie sich mit Ihrem Benutzernamen und Passwort an:<br/><br/>     
		If you login for the first time please use 'test' for username and password. 
		Change the password after your first login!<br/>
		Verwenden sie den Benutzernamen und das Password 'test', 
		wenn sie sich das erste mal anmelden. Vergessen sie nicht diese Daten danach zu &auml;ndern!</p>
        <form action="<?= $root ?>/webinterface/inhalt.php" method="post" name="passwortEingabe" target="_self" id="passwortEingabe">
              <table width="10" border="0" align="center" cellpadding="0" cellspacing="5" class="table">
                <tr>
                  <td valign="middle">Username/Benutzername</td>
                  <td><input name="ben" type="text" class="table" id="ben">
                  </td>
                </tr>
                <tr>
                  <td valign="middle">Password/Passwort</td>
                  <td><input name="pass" type="password" class="table" id="pass"></td>
                </tr>
                <tr>
                  <td valign="middle">Language/Sprache</td>
                  <td><select name="sprache">
                  <?php
                  	$res = getSprachen($link);
                  	while($d = mysql_fetch_array($res)){
                  		$bezeichnung = $d["BEZEICHNUNG"];
                  		$spracheID   = $d["SPRACHE_ID"];
                  		$sprache = "en";
        				$bezeichnung_en = getUebersetzung($bezeichnung);
                   ?>
	                    <option value="<?php echo($spracheID); ?>" <?php if ($sprache == $spracheID) echo(" selected"); ?>>
							<?php
	        					echo($bezeichnung_en."/".$bezeichnung);
	        				?>
	        			</option>
                    <?php
                  	}
                  	?>
                  </select></td>
                </tr>
              </table>
              <p align="center">
                <input name="anmelden" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       				onMouseOut="this.className='button200pxA';" id="anmelden" value="login/anmelden"/>
              </p>
            </form>
          <span class="standardSchriftBold"></span></td>
        </tr>
      </table>
  </tr>
  <tr> 
    <td align="center" valign="middle"><font size="1">&copy; UTILO.eu, 
      2005 - <? $timestamp = time();  
			 	$datum = date("Y",$timestamp); 
				 echo($datum); ?></font></td>
  </tr>
</table>
</body>
</html>
<?php
	include_once($root."/include/closeDB.inc.php");
?>