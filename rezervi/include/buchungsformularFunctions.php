<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
	Konstanten 
*/
define("ATTRIBUT_TYP_GAST", "gastAttribut"); 
define("ATTRIBUT_TYP_RESERVIERUNG", "resAttribut"); 
define("ATTRIBUT_ART_SELECT", "selectBox"); 
define("ATTRIBUT_ART_TEXTFIELD", "selectText");
define("ATTRIBUT_ART_TEXTAREA", "selectTextArea");

/**
	author: coster
	date: 10. 11. 2005
	fuegt ein neues attribut des buchungsformulars hinzu
*/
function setBuchungsformularAttribut($attribut,$art,$typ,$erforderlich){
		
		global $link;
		global $unterkunft_id;
		
		$query = "insert into
				  Rezervi_Buchungsformular
				  (Attribut,FK_Unterkunft_ID,Art,Erforderlich,Typ)
				  values
				  ('$attribut','$unterkunft_id','$art','$erforderlich','$typ')
				  WHERE
				  FK_Unterkunft_ID = '$unterkunft_id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		
		return mysql_insert_id($link);
		
}
/**
	author: coster
	date: 10. 11. 2005
	ändert ein attribut des buchungsformulars 
*/
function changeBuchungsformularAttribut($id,$attribut,$art,$typ,$erforderlich){
		
		global $link;
		
		$query = "update
				  Rezervi_Buchungsformular
				  set
				  Attribut = '$attribut',
				  Art = '$art',
				  Typ = '$typ',
				  Erforderich = '$erforderlich'
				  WHERE
				  PK_ID = '$id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		
		return true;
		
}
/**
	author: coster
	date: 10. 11. 2005
	löscht ein attribut des buchungsformulars 
*/
function deleteBuchungsformularAttribut($id){
		
		global $link;
		
		$query = "delete from
				  Rezervi_Buchungsformular
				  WHERE
				  PK_ID = '$id'
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		
		return true;
		
}
/**
	author: coster
	date: 10. 11. 2005
	gibt alle attribute einer unterkunft zurück
*/
function getBuchungsformularAttribute(){
		
		global $link;
		global $unterkunft_id;
		
		$query = "select
				  *
				  from
				  Rezervi_Buchungsformular
				  WHERE
				  FK_Unterkunft_ID = '$unterkunft_id'
				  
				 ";

  		$res = mysql_query($query, $link);
  		
  		if (!$res){
  			echo(mysql_error($link));
  			echo("Anfrage $query scheitert.");
  			return false;
  		}
		
		return $res;
		
}
?>
