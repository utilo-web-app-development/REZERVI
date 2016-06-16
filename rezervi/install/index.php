<?php $root="..";
	// Set flag that this is a parent file
	define( '_JEXEC', 1 );
	include_once($root."/conf/rdbmsConfig.php");
?>
<!DOCTYPE HTML>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Installation Rezervi</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Bootstrap ende -->
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
	<!--
	function checkConf(){
		 if(document.form1.config[0].checked){
	       return true;
	     }
	     else{
			alert("Please change the file rdbmsConfig.php in the folder conf! \n Bitte ändern sie die Datei rdbmsConfig.php im Ordner conf!");
	     	return false;
	     }
	}
	-->
</script>
</head>

<body>
	



<h1>Rezervi availability overview and guest database</br>
					    Rezervi Belegungsplan und Kundendatenbank</h1>

<!-- ist die conf datei richtig? -->					    
<p>Please check your changings in the 'conf/rdbmsConfig.php' file:<br/>
Bitte prüfen sie ihre Eingaben in der 'conf/rdbmsConfig.php' Datei.</p>

<div class="panel panel-default">
  <div class="panel-body">


<form action="lizenz.php" method="post" id="form1" name="form1" target="_self" onSubmit="return checkConf();"class="form-horizontal">
	
	  <div class="form-group">
		<div class="col-sm-8">URL for your MySQL database e.g. "localhost" <br/>
				  URL zur MySQL Datenbank, z. B. "localhost"</div>
				  <div class="col-sm-4"><?=$DBMS_URL ?></div>
		
		</div>
		<div class="form-group">
		<div class="col-sm-8">Name of the MySQL database <br/>
				  Name der MySQL Datenbank"</div>
				  <div class="col-sm-4"><?=$DB_NAME ?></div>
		
		</div>
		<div class="form-group">
		<div class="col-sm-8">Username of the MySQL database<br/>
				  Benutzername der MySQL Datenbank</div>
				  <div class="col-sm-4"><?=$USERNAME ?></div>
		
		</div>
		<div class="form-group">
		<div class="col-sm-8">Password of the MySQL database<br/>
				  Passwort der MySQL Datenbank</div>
				  <div class="col-sm-4"><?=$PASS ?></div>
		
		</div>
		<div class="form-group">
		<div class="col-sm-8">URL of your homepage/your availibilty overview e.g. $URL = "http://www.my-domainname.com"<br/>
					If you installed Rezervi on a special folder on your webserver, you must also fill in this path. e.g. $URL = "http://www.my-domainname.com/rezerviStable/<br/>
					<br/>
				  URL ihrer Homepage/ihres Belegungsplanes z. B. $URL = "http://www.mein-domainname.com"<br/>
				  falls Rezervi in einem speziellen Verzeichnis ihres Webservers installiert wurde, geben sie bitte auch diesen Pfad mit in der URL an.<br/>
				  z. B. $URL = "http://www.mein-domainname.com/rezerviStable/"<br/>
				 </div>
				  <div class="col-sm-4"><?=$URL ?></div>
		
		</div>
		<div class="form-group">
		<div class="col-sm-8">E-mail address<br/>
				  E-Mail-Adresse</div>
				  <div class="col-sm-4"><?=$EMAIL ?></div>
				
		</div>
		
		<!-- Radio Button -->
	<div class="radio">
  <label>
    <input type="radio" name="config" id="optionsRadios1" value="true">
    The file entries are correct.<br/>
						Die Eintragungen im File sind korrekt.
  </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="config" id="optionsRadios2" value="false"checked>
   The file entries are not correct.<br/>
				  	  Die Eintragungen im File sind nicht korrekt.
  </label>
</div>
</br>
</br>
<div class= "col-md-12">Please select your language.<br/>
Bitte wählen sie ihre Sprache.</p>
</div>
<div class=	"col-md-12">
	      
     <select name="speech" type="text" id="speech" value="" class="form-control">&gt;
	          	<option value="de" selected="">deutsch</option>
				<option value="en">Englisch</option> 					
	</select>
</div>	  
<div class=	"col-md-12">        
	         <input name="Submit" type="submit" class="btn btn-default" value="ok">
</div>	
</div>
</div>


  
	 <table  border="0" cellpadding="0" cellspacing="3" class="table">
		<tr>
	          <td>URL for your MySQL database e.g. "localhost" <br/>
				  URL zur MySQL Datenbank, z. B. "localhost"
			  </td>
			  <td valign="bottom"><?=$DBMS_URL ?></td>
	    </tr>
		 <tr>
	          <td>Name of the MySQL database <br/>
				  Name der MySQL Datenbank
			  </td>
			  <td valign="bottom"><?=$DB_NAME ?></td>
	    </tr> 
		 <tr>
	          <td>Username of the MySQL database<br/>
				  Benutzername der MySQL Datenbank
			  </td>
			  <td valign="bottom"><?=$USERNAME ?></td>
	    </tr>	
	 <tr>
	          <td>Password of the MySQL database<br/>
				  Passwort der MySQL Datenbank
			  </td>
			  <td valign="bottom"><?=$PASS ?></td>
	    </tr> 
		<tr>
	          <td>URL of your homepage/your availibilty overview<br/>
					e.g. $URL = "http://www.my-domainname.com"<br/>
					If you installed Rezervi on a special folder on your<br/>
					webserver, you must also fill in this path.<br/>
					e.g. $URL = "http://www.my-domainname.com/rezerviStable/<br/>
					<br/><br/>
				  URL ihrer Homepage/ihres Belegungsplanes<br/>
					z. B. $URL = "http://www.mein-domainname.com"<br/>
					falls Rezervi in einem speziellen Verzeichnis ihres Webservers<br/>
					installiert wurde, geben sie bitte auch diesen Pfad mit in der URL an.<br/>
					z. B. $URL = "http://www.mein-domainname.com/rezerviStable/"<br/>
			  </td>
			  <td valign="bottom"><?=$URL ?></td>
	    </tr>	
		 <tr>
	          <td>E-mail address<br/>
				  E-Mail-Adresse
			  </td>
			  <td valign="bottom"><?=$EMAIL ?></td>
	    </tr>	      	 	        
	</table> 
	<br/>
	<table class="table">   	
			<tr>
				  <td>
						The file entries are correct.<br/>
						Die Eintragungen im File sind korrekt.
						
					</td><td>
						<input type="radio" name="config" value="true"></td>
			</tr>
			<tr>
				  <td>The file entries are not correct.<br/>
				  	  Die Eintragungen im File sind nicht korrekt.
					</td><td>
						<input name="config" type="radio" value="false" checked></td>
			</tr>
		</table>					    
<!-- ende ist die conf datei richtig? -->
					    
 sprache waehlen 
<p >Please select your language.<br/>
Bitte wählen sie ihre Sprache.</p>
	<table  border="0" cellpadding="0" cellspacing="3" class="table">
		<tr>
	          <td><select name="sprache">
	                <option value="en">English</option>
	                <option value="de">Deutsch</option>    
	          </select></td>
	    </tr>
	    <tr>
	          <td>&nbsp;</td>
	    </tr>
	    <tr>
	          <td><input name="Submit" type="submit" class="btn btn-default" value="ok"></td>
	    </tr>
	</table> 

<!-- ende sprache waehlen -->

</form>
</body>
</html>
