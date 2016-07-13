<?php

/**
	
	versenden von mails
	author:coster
	date: 5.2.06
*/

/**
 * @author coster
 * datum: 8. Apr. 2006
 * prueft ob eine e-mail adresse korrekt angegeben wurde
*/
function checkMailAdress($email) {
	if (eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email))
	{ return true; }
	else 
	{ return false; } 
}

/**
	author: http://at.php.net/manual/de/function.phpversion.php
	date. 5.2.06
# Compares versions of software
# versions must must use the format ' x.y.z... '
# where (x, y, z) are numbers in [0-9]
*/
function check_version($currentversion, $requiredversion)
{
   list($majorC, $minorC, $editC) = split('[/.-]', $currentversion);
   list($majorR, $minorR, $editR) = split('[/.-]', $requiredversion);
  
   if ($majorC > $majorR) return true;
   if ($majorC < $majorR) return false;
   // same major - check ninor
   if ($minorC > $minorR) return true;
   if ($minorC < $minorR) return false;
   // and same minor
   if ($editC  >= $editR)  return true;
   return true;
}
/**
	html_entity_decode für benutzer der php version < 4.3.0
	bzw. wird in der funktion geprüft, welche php funktion 
	verwendet wird.
	author: http://at.php.net/html_entity_decode
	changes: coster
	date: 5.2.06
*/
// For users prior to PHP 4.3.0 you may do this:
function unhtmlentities($string){

   if (check_version(PHP_VERSION,"4.3.0")){
   		return html_entity_decode($string);
   }
   else{
	   // replace numeric entities
	   $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
	   $string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
	   // replace literal entities
	   $trans_tbl = get_html_translation_table(HTML_ENTITIES);
	   $trans_tbl = array_flip($trans_tbl);
	   return strtr($string, $trans_tbl);
   }
}
/*
* Mail header removal
* @see http://www.digital-web.com/articles/bulletproof_contact_form_with_php/
*/
function remove_headers($string) { 
  $headers = array(
    "/to\:/i",
    "/from\:/i",
    "/bcc\:/i",
    "/cc\:/i",
    "/Content\-Transfer\-Encoding\:/i",
    "/Content\-Type\:/i",
    "/Mime\-Version\:/i" 
  ); 
  return preg_replace($headers, '', $string); 
}
/**
author:coster
date:5.2.06, change: 7.5.06
sendet ein mail, mail wird nicht gesendet, falls programm im demo mode.
*/
function sendMail($from,$to,$subject,$message){
	if (DEMO != true && !empty($from)){	
			$to = remove_headers( $to );
		    $message = remove_headers( $message );
		    $subject = remove_headers( $subject );
		    $from = remove_headers( $from );   
			mail($to, unhtmlentities($subject), unhtmlentities($message), "From: $from\nReply-To: $from\nX-Mailer: PHP/" . phpversion());
	}
}
?>