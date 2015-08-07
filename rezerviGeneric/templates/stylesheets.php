<?php

include_once ($root."/include/cssFunctions.inc.php");

$res = getAllStylesFromVermieter($vermieter_id);

while ($d = mysql_fetch_array($res)){
	echo(".".$d["CLASSNAME"]." { ".$d["WERT"]." }");
}

?>