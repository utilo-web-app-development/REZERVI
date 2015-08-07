<?php 
/*
 * Created on 24.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Hauptseite von Backoffice
 *  
 */
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");
?>
<body  bgcolor="#ffffff">
<div id="container">
	<div id="header">
		<div id="topimage">
			<img src="<?=$root ?>/backoffice/pic/new_Alpstein.jpg" alt="UTILO. Ihr Vorteil hat einen Namen."/>
			<div id="headertext">REZERVI TABLE</div>
		</div>
		<div id="logo">
			<a href="http://www.utilo.eu/">
				<img src="<?=$root ?>/backoffice/pic/new_Logo_Alpstein.jpg" alt="UTILO. Ihr Vorteil hat einen Namen."/>
			</a>
		</div>
		<div id="navigation">
			<div id="nav_main">
				<table>
					<tr>
						<td>
							<ul id="mainlevel-nav">
								<li><a href="http://www.utilo.eu/joomla15/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=35" class="mainlevel-nav">News</a></li>

								<li><a href="http://www.utilo.eu/joomla15/index.php?option=com_contact&view=contact&id=1&Itemid=30" class="mainlevel-nav">Kontakt/Impressum</a></li>
								<!--
								<li><a href="http://www.alpstein.info/" class="mainlevel-nav">Hilfe/Help</a></li>
								-->
							</ul>
						</td>
					</tr>
				</table>
			</div> <!--nav_main-->
			<div id="nav_lang">
				<table>
					<tr>
						<td>
							<ul id="mainlevel-nav"> <?php		
								if ($benutzerrechte >= 1) { ?>
								<li><a href="<?=$root ?>/backoffice/abmelden.php" class="mainlevel-nav"><?php echo(getUebersetzung("Abmelden")); ?></a></li>
								<?php }	?>
							</ul>
						</td> 
						<td>
							<form action="" method="post" name="aendernSprache">
							<ul id="mainlevel-nav">
								<li><?= getUebersetzung("Sprache") ?><a class="mainlevel-nav">
									<select name="standardSprache" onchange="javascript:refresh();"><?php
										$res = getSprachen();
										while($d = $res->FetchNextObject()){
											$spracheID   = $d->SPRACHE_ID; ?>
											<option class="standardschrift" value="<?php echo($spracheID); ?>" <?php if ($sprache == $spracheID) echo(" selected"); ?>>
												<?php echo($spracheID); ?>
											</option>  <?php
										} ?>
									</select>
								</a></li>
							</ul>
							</form>
						</td> 
						<td>
							<?php echo(getUebersetzung("Angemeldeter Benutzer").": ".getUserName($benutzer_id)); ?>
						</td>
					</tr>
				</table>
			</div><!--nav_lang-->
		</div> <!--navigation-->
	</div> <!--header-->
	
	<div id="page">	
		<div id="left">	<?php 
			//menue einfuegen
			include_once($root."/backoffice/templates/menue.inc.php"); ?>
		</div> <!--left-->
		<div id="breadcrumps">
			<?= $breadcrumps ?>
		</div> <!--breadcrumps-->	
		<div id="content">		
			<table width="97%">
			   <tr><td align="left"><h1><?= getUebersetzung($ueberschrift) ?></h1></td></tr>
			   <tr hight=3><td>&nbsp;</td></tr>
		   <?php
		   //einfuegen von Fehlermeldung oder Info
		   if (isset($nachricht) && $nachricht != ""){
		   ?>
		  	   <tr>
			   	<?php if (isset($fehler) && $fehler == true) { ?>
				   	<td class="belegt">
				   		<?php echo(getUebersetzung($nachricht)); ?>
				   	</td>	<?php
			   		}else if(isset($info) && $info == true){?>
				   	<td class="frei">
				   		<?php echo(getUebersetzung($nachricht)); ?>
				   	</td>	<?php
			   		}	?>
			   </tr>
			   <tr><td>&nbsp;</td></tr>
		     <?php
		   }
		   	//start content:
		   	?>
		   	</table>