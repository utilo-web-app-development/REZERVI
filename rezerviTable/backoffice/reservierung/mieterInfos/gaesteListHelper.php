<?php

/*
 * Created on 10.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 *  
 */
 
	header('Content-type: text/plain');
	$search_queries = initArray();
	$query = $_GET['query'];
	$results = search($search_queries, $query);
	sendResults($query,$results);

function search($search_queries, $query) {
	if (strlen($query) == 0){
		return;
	}
	$query = strtolower($query);
	$firstChar = $query[0];
	if (!preg_match('/[a-z]/',$firstChar,$matches)){
		return;
	}
	$charQueries = $search_queries[$firstChar];
	$results = array();
	for($i = 0; $i < count($charQueries); $i++) {
		if (strcasecmp(substr($charQueries[$i],0,strlen($query)),$query) == 0)
			$results[] = $charQueries[$i];
	}
	return $results;
}

function sendResults($query,$results) {
	for ($i = 0; $i < count($results); $i++)
		print "$results[$i]\n";
}

function initArray() {
	$root = "../../..";
	global $db;
	global $gastro_id;
	include_once($root."/include/rdbmsConfig.inc.php");
	include_once($root."/include/mieterFunctions.inc.php");
	$res = getAllMieterFromVermieter(1);
	$liste_a = array();
	$liste_b = array();
	$liste_c = array();
	$liste_d = array();
	$liste_e = array();
	$liste_f = array();
	$liste_g = array();
	$liste_h = array();
	$liste_i = array();
	$liste_j = array();
	$liste_k = array();
	$liste_l = array();
	$liste_m = array();
	$liste_n = array();
	$liste_o = array();
	$liste_p = array();
	$liste_q = array();
	$liste_r = array();
	$liste_s = array();
	$liste_t = array();
	$liste_u = array();
	$liste_v = array();
	$liste_w = array();
	$liste_x = array();
	$liste_y = array();
	$liste_z = array();
	array_push($liste_n, "neuerMieter	neuerMieter");
	while ($d = $res->FetchNextObject()){
		$firstChar = substr(strtolower($d->NACHNAME), 0, 1);
		if($firstChar == 'a'){
			array_push($liste_a, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID)));
		}else if($firstChar == 'b'){ 
			array_push($liste_b, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'c'){ 
			array_push($liste_c, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'd'){ 
			array_push($liste_d, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'e'){ 
			array_push($liste_e, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'f'){ 
			array_push($liste_f, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'g'){ 
			array_push($liste_g, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'h'){ 
			array_push($liste_h, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'i'){ 
			array_push($liste_i, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'j'){ 
			array_push($liste_j, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'k'){ 
			array_push($liste_k, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'l'){ 
			array_push($liste_l, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'm'){ 
			array_push($liste_m, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'n'){
			array_push($liste_n, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'o'){ 
			array_push($liste_o, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'p'){ 
			array_push($liste_p, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'q'){ 
			array_push($liste_q, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'r'){ 
			array_push($liste_r, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 's'){ 
			array_push($liste_s, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 't'){ 
			array_push($liste_t, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'u'){ 
			array_push($liste_u, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'v'){ 
			array_push($liste_v, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'w'){ 
			array_push($liste_w, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'x'){ 
			array_push($liste_x, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'y'){ 
			array_push($liste_y, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}else if($firstChar == 'z'){ 
			array_push($liste_z, strtoupper($d->NACHNAME)." ".ucfirst(strtolower($d->VORNAME))." ID:".ucfirst(strtolower($d->GAST_ID))."	".ucfirst(strtolower($d->GAST_ID))); 
		}
	}
	return array(
		'a' => $liste_a,
		'b' => $liste_b,
		'c' => $liste_c,
		'd' => $liste_d,
		'e' => $liste_e,
		'f' => $liste_f,
		'g' => $liste_g,
		'h' => $liste_h,
		'i' => $liste_i,
		'j' => $liste_j,
		'k' => $liste_k,
		'l' => $liste_l,
		'm' => $liste_m,
		'n' => $liste_n,
		'o' => $liste_o,
		'p' => $liste_p,
		'q' => $liste_q,
		'r' => $liste_r,
		's' => $liste_s,
		't' => $liste_t,
		'u' => $liste_u,
		'v' => $liste_v,
		'w' => $liste_w,
		'x' => $liste_x,
		'y' => $liste_y,
		'z' => $liste_z
		);	
}
?>
