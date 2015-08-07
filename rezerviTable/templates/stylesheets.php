<?php

include_once ($root."/include/cssFunctions.inc.php");

$res = getAllStylesFromVermieter($gastro_id);

while ($d = $res->FetchNextObject()){
	echo(".".$d->CLASSNAME." { ".$d->WERT." }");
}

?>