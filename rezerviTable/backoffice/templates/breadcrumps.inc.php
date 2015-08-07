<?php
/*
 * Created on 09.11.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Breadcrumps erzeugen
 *  
 */

include_once($root."/include/uebersetzer.inc.php");

function erzeugenBC($root, $menu0, $links0, $menu1="", $links1="", $menu2="", $links2="", $menu3="", $links3=""	){
	$anfang= "href=\"".$root."/backoffice/";
 	$link = "<a class=\"breadcrumps_link\" ".$anfang.$links0."\">".getUebersetzung($menu0)."</a>";
 	if($menu1!=""){
 		if($links1==""){
 			$link = $link." "."<a class=\"breadcrumps_link\">".getUebersetzung($menu1)."</a>";				
 		}else{
 			$link = $link." "."<a class=\"breadcrumps_link\" ".$anfang.$links1."\">".getUebersetzung($menu1)."</a>";		
 		}
 		if($menu2!=""){ 			
 			if($links2==""){
 				$link = $link." "."<a class=\"breadcrumps_link\">".getUebersetzung($menu2)."</a>";				
 			}else{
 				$link = $link." "."<a class=\"breadcrumps_link\" ".$anfang.$links2."\">".getUebersetzung($menu2)."</a>";
 			}
 			if($menu3!=""){
 				if($links3==""){
 					$link = $link." "."<a class=\"breadcrumps_link\">".getUebersetzung($menu3)."</a>";				
 				}else{
 					$link = $link." "."<a class=\"breadcrumps_link\" ".$anfang.$links3."\">".getUebersetzung($menu3)."</a>";
 				}
		 	}
 		}
 	} 	
 	return $link;
 }
?>
