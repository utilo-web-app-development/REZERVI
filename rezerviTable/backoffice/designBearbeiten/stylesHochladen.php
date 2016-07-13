<?php
$root = "../..";
$ueberschrift = "Design bearbeiten";
$unterschrift = "Stylesheet hochladen";
/*
 * Created on 07.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");	
$breadcrumps = erzeugenBC($root, "Design", "designBearbeiten/index.php",
							$unterschrift, "designBearbeiten/stylesHochladen.php");		
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php");
?>
<h2><?php echo(getUebersetzung("Eine externe Stylesheet Datei verwenden")) ?></h2>
<table>
	<form action="./stylesHochladenHelper.php" method="post" target="_self" enctype="multipart/form-data">
    <tr>
    	<td><?php echo getUebersetzung("Stylesheet Datei") ?>:</td>
    	<td><input name="stylesheet" type="file"/></td>
    </tr>
    <tr>
    	<td>
    		<?php showSubmitButton(getUebersetzung("Hochladen"));?>
		</td>
    </tr>   
	</form>
	<form action="./stylesHochladen.php" method="post" target="_self">
    <tr>
    	<td>
    		<?php showSubmitButton(getUebersetzung("Beispieldefinitionen"));?>
		</td>
    </tr>   
	</form>
</table>
<table>
	<?php
	if(isset($_POST[getUebersetzung("Beispieldefinitionen")]) || !empty($fehler)){
		$res = getAllStylesFromVermieter($gastro_id);?>
  		<tr>
    		<td> <?php echo getUebersetzung("Sie können folgende Klassen definieren:");	?></td>
    	</tr>
    	<tr>
    		<td> <?php
    		while($d = $res->FetchNextObject()){ 		
				echo $d->CLASSNAME;
				if($res->CurrentRow() != $res->RowCount()){
					echo ", ";
				}
			} ?>
			</td>
		</tr>
		<tr>
    		<td><?php echo getUebersetzung("Beispiel: ") ?>
			</td>
		</tr> <?php
		$res = getAllStylesFromVermieter($gastro_id);
		while($d = $res->FetchNextObject()){ ?>
		<tr>
  			<td colspan="2"><?php
				echo "<B>".$d->CLASSNAME."</B>"."{".$d->WERT."}";?>
  			</td>
    	</tr> 
		<?php  	
		} 
	}
	?>	
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>