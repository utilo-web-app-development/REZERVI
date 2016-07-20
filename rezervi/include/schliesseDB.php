<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

// Verbindung zur Datenbank trennen:
if (isset($link)){
	mysqli_close($link);
}

?>