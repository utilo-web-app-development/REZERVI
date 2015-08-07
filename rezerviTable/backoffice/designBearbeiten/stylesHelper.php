<?php
 
//gibt select-statements für farbtabelle aus:
	function getColorTable($vorher){
		$hex = array("00", "33", "66", "99", "CC", "FF");
		for ($r=0; $r<count($hex); $r++){ //the red colors loop
		  for ($g=0; $g<count($hex); $g++){ //the green colors loop
			for ($b=0; $b<count($hex); $b++){ //iterate through the six blue colors
			  $col = $hex[$r].$hex[$g].$hex[$b];
			  //At this point we decide what font color to use
			  if ($hex[$r] <= "99" && $hex[$g] <= "99" && $hex[$b] <= "99"){
				// Use a white font if the color is going to be fairly dark
				//echo "<td width='100' bgcolor='#".$col."'><font color='#FFFFFF'><strong> ".$col." </strong></font></td>";
				?><option value="<?php echo(("#").($col)); ?>" class="x<?php echo($col); ?>" <?php if (("#").($col) == $vorher) echo(" selected"); ?>><?php echo(("#").($col)); ?></option>
						<?php
			  } else {
				// Use a black font on the lighter colors
				//echo "<td width='100' bgcolor='#".$col."'><font color='#000000'> ".$col." </font></td>";
				?><option value="<?php echo(("#").($col)); ?>" class="x<?php echo($col); ?>" <?php if (("#").($col) == $vorher) echo(" selected"); ?>><?php echo(("#").($col)); ?></option>
						<?php
			  }
			} //End of b-blue innermost loop
		  } //End of g-green loop
		} //End of r-red outermost loop
	}
	
//funktionen zum auslesen von styles aus eines string:
function getFontFamily($style){
	$fontFamily = "";
	//font-family: Arial, Helvetica, sans-serif;
	//also von "font-family: " bis ";"
	$rest = strstr($style, "font-family: ");
	//nun finde erste vorkommen von ";":
	$pos = strpos($rest, ";");
	//nun gib den string ohne ; aus:
	$fontFam = substr($rest, 0, $pos);
	//mixed str_replace ( mixed search, mixed replace, mixed subject)
	//Diese Funktion ersetzt alle Vorkommen von search innerhalb der Zeichenkette subject durch den String replace
	$fontFamily = str_replace("font-family: ","",$fontFam);
//	echo($fontFamily);
	return $fontFamily;
}

function getSubstring($style,$bez){
	$fontFamily = "";
	//font-family: Arial, Helvetica, sans-serif;
	//also von "font-family: " bis ";"
	$rest = strstr($style, $bez);
	//nun finde erste vorkommen von ";":
	$pos = strpos($rest, ";");
	//nun gib den string ohne ; aus:
	$fontFam = substr($rest, 0, $pos);
	//mixed str_replace ( mixed search, mixed replace, mixed subject)
	//Diese Funktion ersetzt alle Vorkommen von search innerhalb der Zeichenkette subject durch den String replace
	$fontFamily = str_replace($bez,"",$fontFam);
	//echo($fontFamily);
	return $fontFamily;
}

function getFontSize($style){
	return getSubstring($style,"font-size: ");
}

function getFontStyle($style){
	return getSubstring($style,"font-style: ");
}

function getFontWeight($style){
	return getSubstring($style,"font-weight: ");
}

function getFontVariant($style){
	return getSubstring($style,"text-align: ");
}

function getColor($style){
	return getSubstring($style,"color: ");
}

function getBorder($style){
	//border: 1px ridge #6666FF;
	$rest = getSubstring($style,"border: ");
	//nun finde erste vorkommen von " ridge":
	$pos = strpos($rest, " ridge");
	//nun gib den string ohne " ridge" aus:
	return substr($rest, 0, $pos);
}

function getBorderColor($style){
	//border: 1px ridge #6666FF;
	$rest = getSubstring($style,"border: ");
	//nun finde erste vorkommen von " ridge":
	$pos = strpos($rest, "#");
	//nun gib den string ohne " ridge" aus:
	return substr($rest, $pos);
}

function getBackgroundColor($style){
	return getSubstring($style,"background-color: ");
}

function getHeight($style){
	return getSubstring($style,"height: ");
}

function getWidth($style){
	return getSubstring($style,"width: ");
}

?>