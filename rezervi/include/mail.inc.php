<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
	
	versenden von mails
	author:coster
	date: 5.2.06
*/

//require_once($root."/include/phpmailer/phpmailer.inc.php");
require_once($root."/include/phpmailer/class.phpmailer.php");

/**
	author: http://at.php.net/manual/de/function.phpversion.php
	date. 5.2.06
# Compares versions of software
# versions must must use the format ' x.y.z... '
# where (x, y, z) are numbers in [0-9]
*/
function check_version($currentversion, $requiredversion)
{
   list($majorC, $minorC, $editC) = explode('[/.-]', $currentversion);
   list($majorR, $minorR, $editR) = explode('[/.-]', $requiredversion);
  
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
date:7.5.06
sendet ein mail, mail wird nicht gesendet, falls programm im demo mode.
*/
function sendMail($from,$to,$subject,$message,$gastName){

    $mail = new PHPMailer; //From email address and name
    $mail->From = $from;
    $mail->FromName = $gastName; //To address and name
    //$mail->addAddress("recepient1@example.com", "Recepient Name");//Recipient name is optional
    $mail->addAddress($to); //Address to which recipient will reply
    //$mail->addReplyTo("reply@yourdomain.com", "Reply"); //CC and BCC
    //$mail->addCC("cc@example.com");
    //$mail->addBCC("bcc@example.com"); //Send HTML or Plain Text email
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = "<i>" . $message . "</i>";
    $mail->AltBody = "This is the plain text version of the email content";
    if(!$mail->send())
    {
        return false;
        //echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
        return true;
        //echo "Message has been sent successfully";
    }
}
function sendMailOld($from,$to,$subject,$message){
		
	if (DEMO != true && !empty($from)){	
	
		$to = remove_headers( $to );
	    $message = remove_headers( $message );
		$subject = remove_headers( $subject );
		$from = remove_headers( $from );
		
		//add <br/> after \n
		$message = nl2br($message);
		//initialize php mailer to send html messages:
		$mailer = new phpmailer();
		$mailer->CharSet = "iso-8859-1";
		$mailer->From = $from;
		$mailer->FromName = $from;
		$mailer->Subject = $subject;
		$mailer->Body = $message;
		$mailer->WordWrap = true;
		$mailer->IsHTML(true);
		$mailer->AddAddress($to);
		$result = $mailer->send();
		echo $result;
		return $result;
		
		//mail($to, unhtmlentities($subject), $message, "From: $from\nReply-To: $from\nX-Mailer: PHP/" . phpversion());
	}
	return false;
	
}
?>