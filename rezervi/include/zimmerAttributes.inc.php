<?php

/**
 * Created on 31.08.2006
 *
 * @author coster
 * 
 * function to manipulate the Rezervi_Zimmer_Attribute table
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @author coster
 * @date 31.8.06
 * get all attributes from a accomodation as a mysql result set
*/
function getAttributes(){
	
	global $link;
	global $unterkunft_id;
	
	$query = "select 
			  *
			  from
			  Rezervi_Zimmer_Attribute
			  where
			  FK_Unterkunft_ID = '$unterkunft_id'
			  ORDER BY
			  Bezeichnung
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo(mysqli_error($link));
  			exit;
  		}
		else{		
			return $res;
		}	
			
} //ende getAttributes

/**
 * @author coster
 * @date 31.8.06
 * get all attributes from a accomodation as a mysql result set
*/
function setAttribute($bezeichnung,$beschreibung){
	
	global $link;
	global $unterkunft_id;
	
	$query = "insert into 
			  Rezervi_Zimmer_Attribute
			  (FK_Unterkunft_ID,BEZEICHNUNG,BESCHREIBUNG)
			  values 
			  ('$unterkunft_id','$bezeichnung','$beschreibung')
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo(mysqli_error($link));
  			exit;
  		}
		else{		
			return true;
		}	
			
} //ende setAttribute
/**
 * @author coster
 * @date 31.8.06
 * get all attributes from a accomodation as a mysql result set
*/
function changeAttribut($id,$bezeichnung,$beschreibung){
	
	global $link;
	global $unterkunft_id;
	
	$query = "update 
			  Rezervi_Zimmer_Attribute
			  set " .
			  		"BEZEICHNUNG = '$bezeichnung', " .
			  		"BESCHREIBUNG = '$beschreibung' " .
			  		"where PK_ID = '$id'
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo(mysqli_error($link));
  			exit;
  		}
		else{		
			return true;
		}	
			
} //ende setAttribute
/**
 * @author coster
 * @date 31.8.06
 * löscht ein attribut 
*/
function deleteAttribut($pk_id){
	
	global $link;
	
	$query = "delete from
			  Rezervi_Zimmer_Attribute
			  where
			  PK_ID = '$pk_id'
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo(mysqli_error($link));
  			exit;
  		}
		else{		
			return true;
		}	
			
} //ende setAttribute
/**
 * @author coster
 * @date 31.8.06
 * gibt einen attribut wert aus
*/
function getAttributValue($att_id,$zi_id){

	global $link;
	
	$query = "select 
			  *
			  from
			  Rezervi_Zimmer_Attribute_Wert
			  where
			  FK_Attribut_ID = '$att_id'
			  and
			  FK_Zimmer_Id = '$zi_id'" .
			  		" limit 1
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo(mysqli_error($link));
  			exit;
  		}
		else{	
			$d = mysqli_fetch_array($res);
			return $d["Wert"];
		}	
}
/**
 * @author coster
 * @date 31.8.06
 * setzt einen attribut wert
*/
function setAttributWert($zimmer_id,$att_id,$wert){
	
	global $link;
	
	$query = "replace into 
			  Rezervi_Zimmer_Attribute_Wert
			  (FK_Zimmer_ID,FK_ATTRIBUT_ID,WERT)
			  values 
			  ('$zimmer_id','$att_id','$wert')
			 ";

  		$res = mysqli_query($link, $query);
  		if (!$res){
  			echo(mysqli_error($link));
  			exit;
  		}
		else{		
			return true;
		}
}
?>
