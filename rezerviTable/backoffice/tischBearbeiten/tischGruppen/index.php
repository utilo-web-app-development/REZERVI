<?php
$root = "../../.."; 
$ueberschrift = "Tischgruppen bearbeiten";
$unterschrift = "Gruppen";

/*
 * Created on 20.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 *  
 */
 //header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/templates/constants.inc.php");	

if(isset($_POST["gruppenname"])){
	$gruppenname = $_POST["gruppenname"];	
}else{
	$gruppenname = "";
}
if(isset($_POST["name"])){
	$name = $_POST["name"];
}
if(isset($_POST["beschreibung"])){
	$beschreibung = $_POST["beschreibung"];
}
if(isset($_POST["status"])){
	$status = $_POST["status"];
}
if(isset($_POST["aendern"])){
	$result = updateTischGruppe($name, $gruppenname, $beschreibung, $status, $gastro_id);
	if($result){
		$info = true;
		$nachricht = getUebersetzung("Die Gruppe ".$name." wurde erfolgreicht geändern!");	
	}else{
		$fehler = true;
		$nachricht = getUebersetzung("Die Gruppe ".$gruppenname." wurde nicht erfolgreicht geändern!");
	}
}
if(isset($_POST["anlegen"])){
	$result = insertTischGruppe($name, $beschreibung, $status, $gastro_id);
	if($result){
		$info = true;
		$nachricht = getUebersetzung("Eine neue Gruppe ".$name." wurde erfolgreicht angelegt!");
		$gruppenname = $name;
	}else{
		$fehler = true;
		$nachricht = getUebersetzung("Die Gruppe ".$name." ist schon vorhanden!");
	}
}
if(isset($_POST["loeschen"])){
	if($gruppenname == $name){
		deleteTischGruppe($gruppenname, $gastro_id);
		$info = true;
		$nachricht = getUebersetzung("Die Gruppe ".$gruppenname." wurde erfolgreicht gelöscht!");
		$gruppenname = "";
	}else{
		$fehler = true;
		$nachricht = getUebersetzung("Bitte der Gruppenname ".$gruppenname." noch einmal bestätigen!");
	}
}
if($gruppenname != ""){
	$name = $gruppenname;
	$beschreibung = getBeschreibungOfTischGruppe($gruppenname, $gastro_id);
	$status = getStatusOfTischGruppe($gruppenname, $gastro_id);
}else{
	$res = getTischGruppen($gastro_id);
   	if ($d = $res->FetchNextObject()){
   		$gruppenname = $d->GRUPPENBEZEICHNUNG;
   		$name = $gruppenname;
   		$beschreibung = $d->BESCHREIBUNG;
   		$status = $d->STATUS;
   	}
}
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischGruppen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<table>
    <h2><?php echo(getUebersetzung("Tischgruppen ändern/anlegen/löschen")); ?></h2>
	<form action="./index.php" method="post" name="gruppe">
	<tr>
		<td>      	
		  <select name="gruppenname"  onchange="submit()"><?php 
			$res = getTischGruppen($gastro_id);
   			while ($d = $res->FetchNextObject()){
   				$temp = $d->GRUPPENBEZEICHNUNG;   ?>
		    	<option value="<?php echo $temp ?>" <?php if($gruppenname == $temp) { 
		    		echo("selected='selected'"); } ?>><?php echo $temp ?>
		    	</option>    <?php
		    }    ?>
		  </select>  
		</td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Gruppenname")); ?></td>
		<td><input name="name" type="text" value="<?php echo $name ?>" maxlength="20">
	   	</td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Beschreibung")); ?> </td>
		<td><textarea name="beschreibung"><?php echo $beschreibung ?></textarea></td>
	</tr>
	<tr> 
		<td><?php echo(getUebersetzung("Status")); ?></td>
		<td>      	
		  <select name="status">   <?php 
		  	foreach ($gruppe_array as $stat){    ?>
		    	<option value="<?php echo $stat ?>" <?php if($status == $stat) { 
		    		echo("selected='selected'"); } ?>><?php echo $stat ?>
		    	</option>    <?php
		    }   ?>
		  </select>  
      </td>
    </tr>
	<tr> 
		<td colspan=2><input name="aendern" type="submit" id="aendern" class="button" value="<?php echo(getUebersetzung("Ändern")); ?>">&nbsp;
			<input name="loeschen" type="submit" id="loeschen" class="button" value="<?php echo(getUebersetzung("Löschen")); ?>">&nbsp;
			<input name="anlegen" type="submit" id="anlegen" class="button" value="<?php echo(getUebersetzung("Anlegen")); ?>">
		</td>
    </tr>
	</form>	  
</table> <?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
