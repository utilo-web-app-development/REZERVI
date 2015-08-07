<?php

//gibt select-statements für farbtabelle aus:
	function getColorTable(){
		$hex = array("00", "33", "66", "99", "CC", "FF");
		for ($r=0; $r<count($hex); $r++){ //the red colors loop
		  for ($g=0; $g<count($hex); $g++){ //the green colors loop
			for ($b=0; $b<count($hex); $b++){ //iterate through the six blue colors
			  $col = $hex[$r].$hex[$g].$hex[$b];
			  //At this point we decide what font color to use
			  if ($hex[$r] <= "99" && $hex[$g] <= "99" && $hex[$b] <= "99"){
				// Use a white font if the color is going to be fairly dark
				//echo "<td width='100' bgcolor='#".$col."'><font color='#FFFFFF'><strong> ".$col." </strong></font></td>";
				?><option value="<?php echo(("#").($col)); ?>" class="x<?php echo($col); ?>"><?php echo(("#").($col)); ?></option>
						<?php
			  } else {
				// Use a black font on the lighter colors
				//echo "<td width='100' bgcolor='#".$col."'><font color='#000000'> ".$col." </font></td>";
				?><option value="<?php echo(("#").($col)); ?>" ><?php echo(("#").($col)); ?></option>
						<?php
			  }
			} //End of b-blue innermost loop
		  } //End of g-green loop
		} //End of r-red outermost loop
	}

?>