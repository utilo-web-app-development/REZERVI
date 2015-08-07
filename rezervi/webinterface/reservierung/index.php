<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	include_once("../../include/einstellungenFunctions.php");
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Zimmerreservierungsplan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
	//framegroessen auslesen:;
  	$framesizeLeftWI = getFramesizeLeftWI($unterkunft_id,$link);
  	$framesizeRightWI= getFramesizeRightWI($unterkunft_id,$link);
  	$framesizeLeftWIUnit = getFramesizeLeftWIUnit($unterkunft_id,$link);
  	$framesizeRightWIUnit= getFramesizeRightWIUnit($unterkunft_id,$link);
  	if ($framesizeLeftWIUnit == "%"){
  		$framesizeLeftWI.=$framesizeLeftWIUnit;
  	}	
  	if ($framesizeRightWIUnit == "%"){
  		$framesizeRightWI.=$framesizeRigthWIUnit;
  	}	
?>
<frameset cols="<?php echo($framesizeLeftWI); ?>,<?php echo($framesizeRightWI); ?>" framespacing="1" frameborder="yes" border="1" bordercolor="#000000">
  <frame src="left.php" name="reservierung" frameborder="yes" id="reservierung">
  <frame src="ansichtWaehlen.php" name="kalender" frameborder="no" id="kalender">
</frameset>
<noframes><body class="backgroundColor">
<p>Diese Seite verwendet Frames - bitte aktualisieren Sie Ihren Browser!</p>
<p><a href="http://www.utilo.eu" target="_parent">http://www.utilo.eu</a></p>
</body></noframes>
</html>