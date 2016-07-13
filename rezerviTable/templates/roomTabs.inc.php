<?php
/**
 * Created on 22.01.2007
 *
 * @author coster alpstein-austria
 * 
 * zeigt alle raeume als karteireiter an
 */
 
 //alle raeume aus der datenbank holen:
 $rooms = getRaeume($gastro_id);
?>
<!-- tabs fuer raeume anzeigen -->
<div id="roomtabs" class="yui-navset">
	<ul class="yui-nav">
			<?php
			while ($o = $rooms->FetchNextObject()) {
				$bezeichnung = $o->BEZEICHNUNG;
				$id =  $o->RAUM_ID;
			?>
			    <li <?php if ($mietobjekt_id == $id) { ?>class="selected"<?php } ?>>
			    	<a href="<?php echo $root ?>/index.php?mietobjekt_id=<?php echo $id ?>">
			    		<em><?php echo $bezeichnung ?></em>
			    	</a>
			    </li>
	      <?php
			}
		  ?>
	</ul>
<!-- ende tabs fuer raeume -->