<? 
$root = "../..";
$ueberschrift = "Design bearbeiten";
$unterschrift = "Farbtabelle";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");	
$breadcrumps = erzeugenBC($root, "Design", "designBearbeiten/index.php",
							$unterschrift, "designBearbeiten/farbtabelle.php");							
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<table>
  <tr>
    <td><table  class="moduletable_line" width=200>
      <tr>
        <td  width=100 align=center><?php echo(getUebersetzung("Farb-Code")); ?></td>
        <td  WIDTH=100 align=center><?php echo(getUebersetzung("Farbe")); ?></td>
      </tr>
      <tr>
        <td>FFC6A5</td>
        <td bgcolor="#FFC6A5">&nbsp;</td>
      </tr>
      <tr>
        <td>FF9473</td>
        <td bgcolor="#FF9473">&nbsp;</td>
      </tr>
      <tr>
        <td>FF6342</td>
        <td bgcolor="#FF6342">&nbsp;</td>
      </tr>
      <tr>
        <td>FF3118</td>
        <td bgcolor="#FF3118">&nbsp;</td>
      </tr>
      <tr>
        <td>FF0000</td>
        <td bgcolor="#FF0000">&nbsp;</td>
      </tr>
      <tr>
        <td>D60000</td>
        <td bgcolor="#D60000">&nbsp;</td>
      </tr>
      <tr>
        <td>AD0000</td>
        <td bgcolor="#AD0000">&nbsp;</td>
      </tr>
      <tr>
        <td>840000</td>
        <td bgcolor="#840000">&nbsp;</td>
      </tr>
      <tr>
        <td>630000</td>
        <td bgcolor="#630000">&nbsp;</td>
      </tr>
      <tr>
        <td>FFE7C6</td>
        <td bgcolor="#FFE7C6">&nbsp;</td>
      </tr>
      <tr>
        <td>FFCE9C</td>
        <td bgcolor="#FFCE9C">&nbsp;</td>
      </tr>
      <tr>
        <td>FFB573</td>
        <td bgcolor="#FFB573">&nbsp;</td>
      </tr>
      <tr>
        <td>FF9C4A</td>
        <td bgcolor="#FF9C4A">&nbsp;</td>
      </tr>
      <tr>
        <td>FF8429</td>
        <td bgcolor="#FF8429">&nbsp;</td>
      </tr>
      <tr>
        <td>D66321</td>
        <td bgcolor="#D66321">&nbsp;</td>
      </tr>
      <tr>
        <td>AD4A18</td>
        <td bgcolor="#AD4A18">&nbsp;</td>
      </tr>
      <tr>
        <td>844D18</td>
        <td bgcolor="#844D18">&nbsp;</td>
      </tr>
      <tr>
        <td>632910</td>
        <td bgcolor="#632910">&nbsp;</td>
      </tr>
      <tr>
        <td>FFFFC6</td>
        <td bgcolor="#FFFFC6">&nbsp;</td>
      </tr>
      <tr>
        <td>FFFF9C</td>
        <td bgcolor="#FFFF9C">&nbsp;</td>
      </tr>
      <tr>
        <td>FFFF6B</td>
        <td bgcolor="#FFFF6B">&nbsp;</td>
      </tr>
      <tr>
        <td>FFFF42</td>
        <td bgcolor="#FFFF42">&nbsp;</td>
      </tr>
      <tr>
        <td>FFFF10</td>
        <td bgcolor="#FFFF10">&nbsp;</td>
      </tr>
      <tr>
        <td>D6C610</td>
        <td bgcolor="#D6C610">&nbsp;</td>
      </tr>
      <tr>
        <td>AD9410</td>
        <td bgcolor="AD9410">&nbsp;</td>
      </tr>
      <tr>
        <td>847308</td>
        <td bgcolor="#847308">&nbsp;</td>
      </tr>
      <tr>
        <td>635208</td>
        <td bgcolor="#635208">&nbsp;</td>
      </tr>
      <tr>
        <td>F7FFCE</td>
        <td bgcolor="#F7FFCE">&nbsp;</td>
      </tr>
      <tr>
        <td>EFEFAD</td>
        <td bgcolor="#EFEFAD">&nbsp;</td>
      </tr>
      <tr>
        <td>E7F784</td>
        <td bgcolor="#E7F784">&nbsp;</td>
      </tr>
      <tr>
        <td>DEF763</td>
        <td bgcolor="#DEF763">&nbsp;</td>
      </tr>
      <tr>
        <td>D6EF39</td>
        <td bgcolor="#D6EF39">&nbsp;</td>
      </tr>
      <tr>
        <td>B5BD31</td>
        <td bgcolor="#B5BD31">&nbsp;</td>
      </tr>
      <tr>
        <td>8C9429</td>
        <td bgcolor="#8C9429">&nbsp;</td>
      </tr>
      <tr>
        <td>6B6B21</td>
        <td bgcolor="#6B6B21">&nbsp;</td>
      </tr>
      <tr>
        <td>524818</td>
        <td bgcolor="#524818">&nbsp;</td>
      </tr>
      <tr>
        <td>C6EF83</td>
        <td bgcolor="#C6EF83">&nbsp;</td>
      </tr>
      <tr>
        <td>ADDE63</td>
        <td bgcolor="#ADDE63">&nbsp;</td>
      </tr>
    </table></td>
    <td><table  class="moduletable_line" width="200">
      <tr>
        <td  width=100 align=center><?php echo(getUebersetzung("Farb-Code")); ?></td>
        <td  WIDTH=100 align=center><?php echo(getUebersetzung("Farbe")); ?></td>
      </tr>
      <tr>
        <td>94D639</td>
        <td bgcolor="#94D639">&nbsp;</td>
      </tr>
      <tr>
        <td>7BC618</td>
        <td bgcolor="#7BC618">&nbsp;</td>
      </tr>
      <tr>
        <td>639C18</td>
        <td bgcolor="#639C18">&nbsp;</td>
      </tr>
      <tr>
        <td>527B10</td>
        <td bgcolor="#527B10">&nbsp;</td>
      </tr>
      <tr>
        <td>425A10</td>
        <td bgcolor="#425A10">&nbsp;</td>
      </tr>
      <tr>
        <td>314208</td>
        <td bgcolor="#314208">&nbsp;</td>
      </tr>
      <tr>
        <td>CEEFBD</td>
        <td bgcolor="#CEEFBD">&nbsp;</td>
      </tr>
      <tr>
        <td>A5DE94</td>
        <td bgcolor="#A5DE94">&nbsp;</td>
      </tr>
      <tr>
        <td>7BC66B</td>
        <td bgcolor="#7BC66B">&nbsp;</td>
      </tr>
      <tr>
        <td>52B552</td>
        <td bgcolor="#52B552">&nbsp;</td>
      </tr>
      <tr>
        <td>299C39</td>
        <td bgcolor="#299C39">&nbsp;</td>
      </tr>
      <tr>
        <td>218429</td>
        <td bgcolor="#218429">&nbsp;</td>
      </tr>
      <tr>
        <td>186321</td>
        <td bgcolor="#186321">&nbsp;</td>
      </tr>
      <tr>
        <td>184A18</td>
        <td bgcolor="#184A18">&nbsp;</td>
      </tr>
      <tr>
        <td>103910</td>
        <td bgcolor="#103910">&nbsp;</td>
      </tr>
      <tr>
        <td>C6E7DE</td>
        <td bgcolor="#C6E7DE">&nbsp;</td>
      </tr>
      <tr>
        <td>94D6CE</td>
        <td bgcolor="#94D6CE">&nbsp;</td>
      </tr>
      <tr>
        <td>63BDB5</td>
        <td bgcolor="#63BDB5">&nbsp;</td>
      </tr>
      <tr>
        <td>31ADA5</td>
        <td bgcolor="#31ADA5">&nbsp;</td>
      </tr>
      <tr>
        <td>089494</td>
        <td bgcolor="#089494">&nbsp;</td>
      </tr>
      <tr>
        <td>087B7B</td>
        <td bgcolor="#087B7B">&nbsp;</td>
      </tr>
      <tr>
        <td>006363</td>
        <td bgcolor="#006363">&nbsp;</td>
      </tr>
      <tr>
        <td>004A4A</td>
        <td bgcolor="#004A4A">&nbsp;</td>
      </tr>
      <tr>
        <td>003139</td>
        <td bgcolor="#003139">&nbsp;</td>
      </tr>
      <tr>
        <td>C6EFF7</td>
        <td bgcolor="#C6EFF7">&nbsp;</td>
      </tr>
      <tr>
        <td>94D6E7</td>
        <td bgcolor="#94D6E7">&nbsp;</td>
      </tr>
      <tr>
        <td>63C6DE</td>
        <td bgcolor="#63C6DE">&nbsp;</td>
      </tr>
      <tr>
        <td>31B5D6</td>
        <td bgcolor="#31B5D6">&nbsp;</td>
      </tr>
      <tr>
        <td>00A5C6</td>
        <td bgcolor="#00A5C6">&nbsp;</td>
      </tr>
      <tr>
        <td>0084A5</td>
        <td bgcolor="#0084A5">&nbsp;</td>
      </tr>
      <tr>
        <td>006B84</td>
        <td bgcolor="#006B84">&nbsp;</td>
      </tr>
      <tr>
        <td>005263</td>
        <td bgcolor="#005263">&nbsp;</td>
      </tr>
      <tr>
        <td>00394A</td>
        <td bgcolor="#00394A">&nbsp;</td>
      </tr>
      <tr>
        <td>BDC6DE</td>
        <td bgcolor="#BDC6DE">&nbsp;</td>
      </tr>
      <tr>
        <td>949CCE</td>
        <td bgcolor="#949CCE">&nbsp;</td>
      </tr>
      <tr>
        <td>6373B5</td>
        <td bgcolor="#6373B5">&nbsp;</td>
      </tr>
      <tr>
        <td>3152A5</td>
        <td bgcolor="#3152A5">&nbsp;</td>
      </tr>
      <tr>
        <td>083194</td>
        <td bgcolor="#083194">&nbsp;</td>
      </tr>
    </table></td>
    <td><table class="moduletable_line" width="200">
      <tr>
        <td  width=100 align=center><?php echo(getUebersetzung("Farb-Code")); ?></td>
        <td  WIDTH=100 align=center><?php echo(getUebersetzung("Farbe")); ?></td>
      </tr>
      <tr>
        <td>082984</td>
        <td bgcolor="#082984">&nbsp;</td>
      </tr>
      <tr>
        <td>08296B</td>
        <td bgcolor="#08296B">&nbsp;</td>
      </tr>
      <tr>
        <td>08215A</td>
        <td bgcolor="#08215A">&nbsp;</td>
      </tr>
      <tr>
        <td>00184A</td>
        <td bgcolor="#00184A">&nbsp;</td>
      </tr>
      <tr>
        <td>C6B5DE</td>
        <td bgcolor="#C6B5DE">&nbsp;</td>
      </tr>
      <tr>
        <td>9C7BBD</td>
        <td bgcolor="#9C7BBD">&nbsp;</td>
      </tr>
      <tr>
        <td>7B52A5</td>
        <td bgcolor="#7B52A5">&nbsp;</td>
      </tr>
      <tr>
        <td>522994</td>
        <td bgcolor="#522994">&nbsp;</td>
      </tr>
      <tr>
        <td>31007B</td>
        <td bgcolor="#31007B">&nbsp;</td>
      </tr>
      <tr>
        <td>29006B</td>
        <td bgcolor="#29006B">&nbsp;</td>
      </tr>
      <tr>
        <td>21005A</td>
        <td bgcolor="#21005A">&nbsp;</td>
      </tr>
      <tr>
        <td>21004A</td>
        <td bgcolor="#21004A">&nbsp;</td>
      </tr>
      <tr>
        <td>180042</td>
        <td bgcolor="#180042">&nbsp;</td>
      </tr>
      <tr>
        <td>DEBDDE</td>
        <td bgcolor="#DEBDDE">&nbsp;</td>
      </tr>
      <tr>
        <td>CE84C6</td>
        <td bgcolor="#CE84C6">&nbsp;</td>
      </tr>
      <tr>
        <td>B552AD</td>
        <td bgcolor="#B552AD">&nbsp;</td>
      </tr>
      <tr>
        <td>9C2994</td>
        <td bgcolor="#9C2994">&nbsp;</td>
      </tr>
      <tr>
        <td>8C007B</td>
        <td bgcolor="#8C007B">&nbsp;</td>
      </tr>
      <tr>
        <td>730063</td>
        <td bgcolor="#730063">&nbsp;</td>
      </tr>
      <tr>
        <td>5A0052</td>
        <td bgcolor="#5A0052">&nbsp;</td>
      </tr>
      <tr>
        <td>4A0042</td>
        <td bgcolor="#4A0042">&nbsp;</td>
      </tr>
      <tr>
        <td>390031</td>
        <td bgcolor="#390031">&nbsp;</td>
      </tr>
      <tr>
        <td>F7BDDE</td>
        <td bgcolor="#F7BDDE">&nbsp;</td>
      </tr>
      <tr>
        <td>E78CC6</td>
        <td bgcolor="#E78CC6">&nbsp;</td>
      </tr>
      <tr>
        <td>DE5AAD</td>
        <td bgcolor="#DE5AAD">&nbsp;</td>
      </tr>
      <tr>
        <td>D63194</td>
        <td bgcolor="#D63194">&nbsp;</td>
      </tr>
      <tr>
        <td>CE007B</td>
        <td bgcolor="#CE007B">&nbsp;</td>
      </tr>
      <tr>
        <td>A50063</td>
        <td bgcolor="#A50063">&nbsp;</td>
      </tr>
      <tr>
        <td>840052</td>
        <td bgcolor="#840052">&nbsp;</td>
      </tr>
      <tr>
        <td>6B0042</td>
        <td bgcolor="#6B0042">&nbsp;</td>
      </tr>
      <tr>
        <td>520031</td>
        <td bgcolor="#520031">&nbsp;</td>
      </tr>
      <tr>
        <td>FFFFFF</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td>E0E0E0</td>
        <td bgcolor="#E0E0E0">&nbsp;</td>
      </tr>
      <tr>
        <td>BFBFBF</td>
        <td bgcolor="#BFBFBF">&nbsp;</td>
      </tr>
      <tr>
        <td>A1A1A1</td>
        <td bgcolor="#A1A1A1">&nbsp;</td>
      </tr>
      <tr>
        <td>808080</td>
        <td bgcolor="#808080">&nbsp;</td>
      </tr>
      <tr>
        <td>616161</td>
        <td bgcolor="#616161">&nbsp;</td>
      </tr>
      <tr>
        <td>000000</td>
        <td bgcolor="#000000">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>
