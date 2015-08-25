<?php 
	header ("Location: http://www.utilo.eu/joomla15/index.php?option=com_content&view=category&id=19&Itemid=45");  
	exit;  	
?>
<?php

ereg ("(de|de-at|de-de|de-li|de-lu|de-ch)", $_SERVER["HTTP_ACCEPT_LANGUAGE"], $regs);
if (isset($regs)){
	header ("Location: http://www.rezervi.com/www/german/index.php");  /* Umleitung des Browsers
                                             zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
          Code ausgeführt wird. */
}
else{
	header ("Location: http://www.rezervi.com/www/english/index.php");  /* Umleitung des Browsers
                                             zur PHP-Web-Seite. */
	exit;  /* Sicher stellen, das nicht trotz Umleitung nachfolgender
          Code ausgeführt wird. */
}

?> 