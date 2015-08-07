<?php
	
	/**
	 * @author coster
	 * open database
	 */

	if ( !isset( $DBMS_DRIVER ) ){
		include($root."/conf/conf.inc.php");
	}
	include($root."/adodb/adodb.inc.php");
 	$db = NewADOConnection($DBMS_DRIVER);
 	$db->Connect($HOST, $USERNAME, $PASS, $DB_NAME);
 	//liefert die db ergebnisse als assoziatives array aus:
 	$db->SetFetchMode(ADODB_FETCH_ASSOC);	
  	
  	
  	if (!$db || empty($db)) {
  			echo("The database $DB_NAME does not exist or the username or password or the database host is not correct.<br/>
			  	  You need a MySQL database to install Bookline!<br/>" .
			  	 "Please edit the file '\\conf\\rdbmsConfig.inc.php'<br/><br/>" .
			  	 "If you need help for the installation, " .
			  	 "please contact <a href=\"mailto:office@alpstein-austria\">office@utilo.net</a><br/><br/>");
    		echo("Die Datenbank $DB_NAME existiert nicht, der benutzername das passwort oder der host sind nicht korrekt.<br/>
				  Sie ben�tigen eine MySQL Datenbank um Bookline installieren zu k�nnen.<br/>" .
				 "Bitte editieren sie dazu den File '\\conf\\rdbmsConfig.inc.php'<br/><br/>" .
			  	 "Wenn sie Hilfe bei der Installation benötigen können sie sich gerne an " .
			  	 "<a href=\"mailto:office@utilo.net\">office@utilo.net</a> wenden.<br/><br/>");
  			exit;
    }
	
	if (!isset($doInstall) || $doInstall != true){
		//pruefe ob Bookline bereits installiert wurde:
		$query = ("SELECT 
						   *
						   FROM
						   BOOKLINE_GASTRO
						   WHERE
						   GASTRO_ID = '1'
			   			  ");           
	
		$res = $db->Execute($query);
		
		if (!$res || (count($res)<=0)){
			  	echo("Bookline was not correctly installed. Please go to the page '\\install\\index.php' and do the installation.<br/><br/>" .
				  	 "If you need help for the installation, " .
				  	 "please contact <a href=\"mailto:office@utilo.eu\">office@utilo.eu</a><br/><br/>");
	    		echo("Bookline wurde noch nicht korrekt installiert. Bitte rufen sie die Seite '\\install\\index.php' auf und installieren sie Bookline<br/><br/>" .
				  	 "Wenn sie Hilfe bei der Installation benötigen können sie sich gerne an " .
				  	 "<a href=\"mailto:office@utilo.eu\">office@utilo.eu</a> wenden.<br/><br/>");
	  			exit;
		}
	}

?>