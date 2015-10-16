<?php 
/**
 * Created on 19.01.2007
 *
 * @author coster
 * preise hinzuf�gen l�schen �ndern
 */

session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/conf/rdbmsConfig.php");
include_once($root."/include/uebersetzer.php");
include_once($root."/include/zimmerFunctions.php");
include_once($root."/include/unterkunftFunctions.php");
include_once($root."/include/benutzerFunctions.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/include/datumFunctions.php");

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername = getSessionWert(BENUTZERNAME);
$passwort = getSessionWert(PASSWORT);
$sprache = getSessionWert(SPRACHE);

$house = false;
if (isset($_POST['house']) && !empty($_POST['house'])){
	$house = $_POST['house'];
}

if ( isset($_POST['aendern']) && $_POST['aendern'] == getUebersetzung("speichern",$sprache,$link) ){
	//andern button ausgeloest
	include_once('./aendern.inc.php');
}

include_once($root."/webinterface/templates/headerA.php"); 
?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php 
include_once($root."/webinterface/templates/headerB.php"); 
include_once($root."/webinterface/templates/bodyA.php"); 

//wurde irgend eine zuweisung gel�scht?
$res = getAllRoomsWithChilds($unterkunft_id);
while ( $d = mysql_fetch_array($res) ){
	$zimmer_id = $d['Parent_ID'];
	if (
		isset( $_POST['loeschen_'.$zimmer_id] ) && 
		$_POST['loeschen_'.$zimmer_id] == getUebersetzung("l�schen",$sprache,$link)
		){
			deleteChildRooms($zimmer_id);
		}
}

//passwortpr�fung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
	
?>
<div class="panel panel-default">
  <div class="panel-body">
  	<a class="btn btn-primary" href="../index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
 </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
  	
<h1>
	<?= getUebersetzung("Zimmer zusammenfassen",$sprache,$link) ?>.
</h1>
<h4>
	<?php
	$text = "Falls Sie ein Haus mit mehreren Zimmern vermieten und die Zimmer des ".
                       "Hauses und das Haus selbst vermieten wollen, können Sie hier die Zimmer zum Haus ".
                       "festlegen. Das Haus und die Zimmer müssen vorher angelegt worden sein."
	?>
	<?= getUebersetzung($text,$sprache,$link) ?>
</h4>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table border="0" cellpadding="0" cellspacing="3" class="table">
	  <tr>
		<td <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); } 
			else {echo("class=\"belegt\"");} ?>>
				<?= $nachricht ?>
		</td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<form action="./index.php" method="post" target="_self">

<?php
if (hasParentRooms($unterkunft_id)){
?>
<table border="0" cellpadding="0" cellspacing="3" class="table">
	<tr>
		<td colspan="2">
			<?php $text = "Bestehende Zuweisungen:"; ?>
			<?= getUebersetzung($text,$sprache,$link) ?>
		</td>	
		<td>
		</td>
	</tr>
	<?php
		$res = getAllRoomsWithChilds($unterkunft_id);
		while ($d = mysql_fetch_array($res)){
			$zimmer_id = $d['Parent_ID'];			
			$ziArt = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			$ziNr  = getUebersetzungUnterkunft(getZimmerNr( $unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
	?>
		<tr>
			<td>
				<?= $ziArt." ".$ziNr ?>
			</td>
			<td>
				<?php
					$res2 = getChildRooms($zimmer_id);
					while ($r = mysql_fetch_array($res2)){
						$ziArt = getUebersetzungUnterkunft($r["Zimmerart"],$sprache,$unterkunft_id,$link);
						$ziNr  = getUebersetzungUnterkunft($r["Zimmernr"],$sprache,$unterkunft_id,$link);
					?>
						<?= $ziArt." ".$ziNr ?>
						<br/>
					<?php					
					}
				?>
			</td>		
			<td>
				<input 
	  				name="loeschen_<?= $zimmer_id ?>" type="submit" id="aendern" 
	  				class="button200pxA" onMouseOver="this.className='button200pxB';"
	   				onMouseOut="this.className='button200pxA';" 
	   				value="<?php echo(getUebersetzung("löschen",$sprache,$link)); ?>" />
			</td>
		</tr>
	<?php
		}
	?>
</table>
<br/>
<?php
}
?>
<table border="0" cellpadding="0" cellspacing="3" class="table">
	<tr>
		<td colspan="2">
			<?php $text = "Neue Zuweisungen:"; ?>
			<?= getUebersetzung($text,$sprache,$link) ?>
		</td>	
		<td>
		</td>
	</tr>
	<tr>
		<td>
			<?= getUebersetzung("Haus",$sprache,$link) ?>
		</td>
		<td>
			<select name="house" onChange="submit()">
			      <?php
			      $res = getZimmer($unterkunft_id,$link);			 
				  while($g = mysql_fetch_array($res)) {
				  	$ziArt = getUebersetzungUnterkunft($g["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"],$sprache,$unterkunft_id,$link);
				  ?>
					<option value="<?= $g['PK_ID'] ?>"
						<?php
							if ($house == $g['PK_ID']){
							?>
								selected="selected"
							<?php
							}
						?>
					><?= $ziArt." ".$ziNr ?></option>
				  <?php
				  }
				  ?>
			</select>
		</td>		
		<td>
		</td>
	</tr>
	<tr>
		<td colspan = "2"><?php	$text = "Folgende Zimmer gehören zum ausgewählten Haus"
	?>
	<?= getUebersetzung($text,$sprache,$link) ?>:</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><?php
			      $res = getZimmer($unterkunft_id,$link);			 
				  while($g = mysql_fetch_array($res)) {
				  	$ziArt = getUebersetzungUnterkunft($g["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"],$sprache,$unterkunft_id,$link);
					if ($house == $g['PK_ID']){
						continue;
					}
				  ?>
				  	<?= $ziArt." ".$ziNr ?> <input type="checkbox" value="<?= $g['PK_ID'] ?>" name="zimmer[]"/> <br/>
				  <?php
				  }
			?></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="3">
			<input 
  				name="aendern" type="submit" id="aendern" 
  				class="btn btn-success" 
   				value="<?php echo(getUebersetzung("speichern",$sprache,$link)); ?>" />
		</td>
	</tr>	
</table>
<br/>
</form>

    	
    	<!-- <form action="../index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
		<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
		 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>">
 		</form> -->
 
<!-- <table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
	<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>">
  </form></td>
  </tr>
</table> -->
<?php
}
else {
	echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
}
?>   
</body>
</html>
