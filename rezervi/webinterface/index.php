<?php
$root = ".."; 
// Set flag that this is a parent file
define( '_JEXEC', 1 );
	include_once($root."/include/sessionFunctions.inc.php");
	include_once($root."/include/uebersetzer.php");	
	include_once($root."/include/benutzerFunctions.php");
	include_once($root."/include/unterkunftFunctions.php");
	include_once($root."/include/reseller/reseller.php");
	
	$noLanguage = false;
	
	//sprache auslesen:
	//entweder aus übergebener url oder aus session
	if (isset($_POST["sprache"])){
		$sprache = $_POST["sprache"];
	}
	else if (isset($_GET["sprache"])){
		$sprache = $_GET["sprache"];
	}
	else if (getSessionWert(SPRACHE)!=false){
		$sprache = getSessionWert(SPRACHE);
	}
	if (!isset($sprache) || $sprache == ""){
		// Sprache aus datenbank holen:
		if (isset( $_POST["unterkunft_id"])){
			$unterkunft_id = $_POST["unterkunft_id"];
		}
		else if (isset($_GET["unterkunft_id"])){
			$unterkunft_id = $_GET["unterkunft_id"];
		}
		if (isset($unterkunft_id) && $unterkunft_id != ""){
			include_once("../include/einstellungenFunctions.php");
			$sprache = getStandardSprache($unterkunft_id,$link);
		}
	}
	//keine sprache von irgendwo -> mehrsprachig anzeigen:
	if (!isset($sprache) || $sprache == ""){
		$noLanguage = true;
		$sprache = "de";
	}
	if (!isset($unterkunft_id)){
		$unterkunft_id = 1;
	}
 	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Wartungsseite Reservierungsplan utilo.eu Belegungsplan und Kundendatenbank Rezervi</title>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
//pruefen ob installation schon durchgeführt wurde:
if (!isInstalled($unterkunft_id)){
?>
	Please install Rezervi first! <br/>
	Bitte insallieren sie Rezervi zuerst! <br/>
	<a href="../install/index.php">--> Install</a>
<?php
}
else{
?>
<table width="95%" height="90%" border="0" align="center" cellpadding="0" cellspacing="3" class="table">
  <tr> 
    <td align="center" valign="middle"><table  border="0" align="center" cellpadding="0" cellspacing="2" class="table">
      <tr>
        <?php
        //keine sprache -> auch englisch anzeigen:
        if ($noLanguage){
        ?>
        <td class="ueberschrift" align="right">Welcome at the
          webinterface of your personal
          availability overview und guest database 'Rezervi'
          <?php
          if ($isReseller){
          ?>
           from <a href="<?php echo $resellerUrl ?>" target="_blank" class="ueberschrift"><?php echo $resellerName ?></a>
          <?php
          }
          else{
          ?>
           <a href="http://www.utilo.eu/" target="_blank" class="ueberschrift">&copy; utilo.eu</a>
           <?php
			}
           ?>
        </td>
        <?php
        }
        ?>
        <td>
          <?php
          if ($isReseller){
          ?>
        	<a href="<?php echo $resellerUrl ?>" target="_blank">
        		<img src="<?php echo $root.$resellerLogo ?>" border="1" hspace="10"/>
        	</a>
          <?php
		  }
		  else{
		  ?>
		    <a href="http://www.utilo.eu" target="_blank">
        		<img src="utilologo200px.gif" hspace="10"  border="0"/>
        	</a>
		  <?php
		  }
		  ?>
        </td>
        <td class="ueberschrift"><?php echo(getUebersetzung("Willkommen auf der Wartungsseite",$sprache,$link)); ?> 
          <?php echo(getUebersetzung("ihres persönlichen Belegungsplanes",$sprache,$link)); ?> 
          <?php echo(getUebersetzung("und Ihrer Gästedatenbank Rezervi",$sprache,$link)); ?> 
          <?php
          	if ($isReseller){
          ?>
           von <a href="<?php echo $resellerUrl ?>" target="_blank" class="ueberschrift"><?php echo $resellerName ?></a>
          <?php
          	}
          else{
          ?>
           <a href="http://www.utilo.eu/" target="_blank" class="ueberschrift">&copy; utilo.eu</a>
          <?php
			}
		  ?>
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
          <td><div align="center"><?php echo(getUebersetzung("Der Benutzername und/oder das Passwort wurden falsch eingegeben, bitte wiederholen Sie Ihre Eingabe!",$sprache,$link)); ?></div></td>
        </tr>
      </table>
      <br />		
      <?php
	  	} //ende if passwort falsch
		?>
      <table  border="0" align="center" cellpadding="0" cellspacing="2" class="table">
        <tr>
          <td><p align="center" class="standardSchrift"><?php 
        //keine sprache -> auch englisch anzeigen:
        if ($noLanguage){
        	echo("Please login with your username and password:<br/>");
        }   
        
        echo(getUebersetzung("Bitte melden Sie sich hier mit Ihrem Benutzernamen und Passwort an",$sprache,$link)); ?>:<br/></p>
        <?php
        //keine sprache -> auch englisch anzeigen:
        if ($noLanguage){
        	echo("If you login for the first time please use 'test' for username and password. Change that after your first login!<br/>");
        }        
        echo(getUebersetzung("Verwenden sie den Benutzernamen und das Password ",$sprache,$link)); ?>
        <?php echo("'test', "); ?>
        <?php echo(getUebersetzung("wenn sie sich das erste mal anmelden. Vergessen sie nicht diese Daten danach zu Ändern!",$sprache,$link));
        ?>    
        <form action="./inhalt.php" method="post" name="passwortEingabe" target="_self" id="passwortEingabe">
              <table width="10" border="0" align="center" cellpadding="0" cellspacing="5" class="table">
                <tr>
                  <td valign="middle"><?php 
                    //keine sprache -> auch englisch anzeigen:
        			if ($noLanguage){
        				echo("Username<br/>");
        			}  
                  echo(getUebersetzung("Benutzername",$sprache,$link)); ?></td>
                  <td><input name="ben" type="text"  id="ben">
                  </td>
                </tr>
                <tr>
                  <td valign="middle"><?php 
                    //keine sprache -> auch englisch anzeigen:
        			if ($noLanguage){
        				echo("Password<br/>");
        			} 
                  echo(getUebersetzung("Passwort",$sprache,$link)); ?></td>
                  <td><input name="pass" type="password"  id="pass"></td>
                </tr>
                <tr>
                  <td valign="middle"><?php 
                    //keine sprache -> auch englisch anzeigen:
        			if ($noLanguage){
        				echo("Language<br/>");
        			} 
                  echo(getUebersetzung("Sprache",$sprache,$link)); ?></td>
                  <td><select name="sprache">
                  <?php
                  	$res = getSprachenForWebinterface($link);
                  	while($d = mysql_fetch_array($res)){
                  		$bezeichnung = $d["Bezeichnung"];
                  		$spracheID   = $d["Sprache_ID"];
                  		if ($noLanguage){
        					$bezeichnung_en = getUebersetzung($bezeichnung,"en",$link);
        				} 
                  ?>
                    <option value="<?php echo($spracheID); ?>" <?php if ($sprache == $spracheID) echo(" selected"); ?>>
                    	<?php if ($noLanguage){
        						echo($bezeichnung_en."/");
        					   } 
        					   echo($bezeichnung);
        				?></option>
                    <?php
                  	}
                  	?>
                  </select></td>
                </tr>
              </table>
              <p align="center">
                <input name="anmelden" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       				onMouseOut="this.className='button200pxA';" id="anmelden" value="<?php 
       				//keine sprache -> auch englisch anzeigen:
        			if ($noLanguage){
        				echo("login/");
        			} 
       				echo(getUebersetzung("anmelden",$sprache,$link)); ?>">
              </p>
            </form>
          <span class="standardSchriftBold"></span></td>
        </tr>
      </table>
      <p><span class="standardSchriftBold"><?php 
        //keine sprache -> auch englisch anzeigen:
		if ($noLanguage){
			echo("You have no Rezervi for your accommodation?<br/>");
		} 
      echo(getUebersetzung("Sie haben noch keinen Belegungs-/Reservierungsplan für Ihre Unterkunft?",$sprache,$link)); ?></span><br/>
    <a href="http://belegungsplan.utilo.eu" target="_blank"><?php 
        //keine sprache -> auch englisch anzeigen:
		if ($noLanguage){
			echo("&gt;&gt; Klick here to get more informations!<br/>");
		} 
		echo("&gt;&gt; ");
		echo(getUebersetzung("Klicken Sie hier um mehr Informationen zu erhalten!",$sprache,$link)); ?></a></p></td>
  </tr>
  <tr> 
    <td align="center" valign="middle">
        <?php if ($isReseller) { ?>
        	<font size="1">Rezervi by <?php echo $resellerName ?> 2008</font>
        <?php } else { ?>
    		<font size="1">&copy; UTILO, 2002 - 2008</font>
    	<?php } ?>
    </td>
  </tr>
</table>
<?php
}
?>
</body>
</html>
