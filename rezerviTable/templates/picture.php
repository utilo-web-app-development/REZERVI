<?php
/**
 * Created on 05.04.2006
 *
 * author: Christian Osterrieder alpstein-austria
 * 
 * this page needs the BILDER_ID from the table BOOKLINE_BILDER
 * as an GET Variable (bilder_id)
 */

$root = "..";
$bilder_id = $_GET["bilder_id"];
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/bildFunctions.inc.php");
$res = getBild($bilder_id);
$mime = $res->fields["MIME"];

//header erzeugen:
header("Content-type: image/".$mime);

//bild ausgeben:
echo($res->fields["BILD"]);

?>
