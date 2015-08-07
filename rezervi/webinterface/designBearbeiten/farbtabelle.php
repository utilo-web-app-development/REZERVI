<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	  $unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	  $sprache = getSessionWert(SPRACHE);
	  
	  //uebersetzer einfuegen:
	  include_once("../../include/uebersetzer.php");
	  //datenbank öffnen:
	  include_once("../../conf/rdbmsConfig.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Farbtabelle</title>
</head>
<body>
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table border="1" cellpadding="2" cellspacing="2" width=200 bgcolor=#FFFFFF>
      <tr>
        <td bgcolor="#CC6600" width=100 align=center><font face="verdana,arial,helvetica" size=2 color="FFFFFF"><b><?php echo(getUebersetzung("Farb-Code",$sprache,$link)); ?></b></font></td>
        <td bgcolor="#CC6600" WIDTH=100 align=center><font face="verdana,arial,helvetica" size=2 color="FFFFFF"><b><?php echo(getUebersetzung("Farbe",$sprache,$link)); ?></b></font></td>
      </tr>
      <tr>
        <td height=5></td>
        <td height=5></td>
      </tr>
      <tr>
        <td><font face="verdana,arial,helvetica" size=1>FFC6A5</font></td>
        <td bgcolor="#FFC6A5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FF9473</font></td>
        <td bgcolor="#FF9473">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FF6342</font></td>
        <td bgcolor="#FF6342">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FF3118</font></td>
        <td bgcolor="#FF3118">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FF0000</font></td>
        <td bgcolor="#FF0000">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>D60000</font></td>
        <td bgcolor="#D60000">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>AD0000</font></td>
        <td bgcolor="#AD0000">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>840000</font></td>
        <td bgcolor="#840000">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>630000</font></td>
        <td bgcolor="#630000">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFE7C6</font></td>
        <td bgcolor="#FFE7C6">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFCE9C</font></td>
        <td bgcolor="#FFCE9C">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFB573</font></td>
        <td bgcolor="#FFB573">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FF9C4A</font></td>
        <td bgcolor="#FF9C4A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FF8429</font></td>
        <td bgcolor="#FF8429">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>D66321</font></td>
        <td bgcolor="#D66321">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>AD4A18</font></td>
        <td bgcolor="#AD4A18">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>844D18</font></td>
        <td bgcolor="#844D18">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>632910</font></td>
        <td bgcolor="#632910">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFFFC6</font></td>
        <td bgcolor="#FFFFC6">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFFF9C</font></td>
        <td bgcolor="#FFFF9C">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFFF6B</font></td>
        <td bgcolor="#FFFF6B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFFF42</font></td>
        <td bgcolor="#FFFF42">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFFF10</font></td>
        <td bgcolor="#FFFF10">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>D6C610</font></td>
        <td bgcolor="#D6C610">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>AD9410</font></td>
        <td bgcolor="AD9410">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>847308</font></td>
        <td bgcolor="#847308">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>635208</font></td>
        <td bgcolor="#635208">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>F7FFCE</font></td>
        <td bgcolor="#F7FFCE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>EFEFAD</font></td>
        <td bgcolor="#EFEFAD">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>E7F784</font></td>
        <td bgcolor="#E7F784">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>DEF763</font></td>
        <td bgcolor="#DEF763">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>D6EF39</font></td>
        <td bgcolor="#D6EF39">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>B5BD31</font></td>
        <td bgcolor="#B5BD31">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>8C9429</font></td>
        <td bgcolor="#8C9429">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>6B6B21</font></td>
        <td bgcolor="#6B6B21">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>524818</font></td>
        <td bgcolor="#524818">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>C6EF83</font></td>
        <td bgcolor="#C6EF83">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>ADDE63</font></td>
        <td bgcolor="#ADDE63">&nbsp;</td>
      </tr>
    </table></td>
    <td><table border="1" cellpadding="2" cellspacing="2" width="200">
      <tr>
        <td bgcolor="#CC6600" width=100 align=center><font face="verdana,arial,helvetica" size=2 color="FFFFFF"><b><?php echo(getUebersetzung("Farb-Code",$sprache,$link)); ?></b></font></td>
        <td bgcolor="#CC6600" WIDTH=100 align=center><font face="verdana,arial,helvetica" size=2 color="FFFFFF"><b><?php echo(getUebersetzung("Farbe",$sprache,$link)); ?></b></font></td>
      </tr>
      <tr>
        <td height=5></td>
        <td height=5></td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>94D639</font></td>
        <td bgcolor="#94D639">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>7BC618</font></td>
        <td bgcolor="#7BC618">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>639C18</font></td>
        <td bgcolor="#639C18">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>527B10</font></td>
        <td bgcolor="#527B10">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>425A10</font></td>
        <td bgcolor="#425A10">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>314208</font></td>
        <td bgcolor="#314208">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>CEEFBD</font></td>
        <td bgcolor="#CEEFBD">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>A5DE94</font></td>
        <td bgcolor="#A5DE94">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>7BC66B</font></td>
        <td bgcolor="#7BC66B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>52B552</font></td>
        <td bgcolor="#52B552">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>299C39</font></td>
        <td bgcolor="#299C39">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>218429</font></td>
        <td bgcolor="#218429">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>186321</font></td>
        <td bgcolor="#186321">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>184A18</font></td>
        <td bgcolor="#184A18">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>103910</font></td>
        <td bgcolor="#103910">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>C6E7DE</font></td>
        <td bgcolor="#C6E7DE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>94D6CE</font></td>
        <td bgcolor="#94D6CE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>63BDB5</font></td>
        <td bgcolor="#63BDB5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>31ADA5</font></td>
        <td bgcolor="#31ADA5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>089494</font></td>
        <td bgcolor="#089494">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>087B7B</font></td>
        <td bgcolor="#087B7B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>006363</font></td>
        <td bgcolor="#006363">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>004A4A</font></td>
        <td bgcolor="#004A4A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>003139</font></td>
        <td bgcolor="#003139">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>C6EFF7</font></td>
        <td bgcolor="#C6EFF7">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>94D6E7</font></td>
        <td bgcolor="#94D6E7">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>63C6DE</font></td>
        <td bgcolor="#63C6DE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>31B5D6</font></td>
        <td bgcolor="#31B5D6">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>00A5C6</font></td>
        <td bgcolor="#00A5C6">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>0084A5</font></td>
        <td bgcolor="#0084A5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>006B84</font></td>
        <td bgcolor="#006B84">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>005263</font></td>
        <td bgcolor="#005263">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>00394A</font></td>
        <td bgcolor="#00394A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>BDC6DE</font></td>
        <td bgcolor="#BDC6DE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>949CCE</font></td>
        <td bgcolor="#949CCE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>6373B5</font></td>
        <td bgcolor="#6373B5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>3152A5</font></td>
        <td bgcolor="#3152A5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>083194</font></td>
        <td bgcolor="#083194">&nbsp;</td>
      </tr>
    </table></td>
    <td><table border="1" cellpadding="2" cellspacing="2" width="200">
      <tr>
        <td bgcolor="#CC6600" width=100 align=center><font face="verdana,arial,helvetica" size=2 color="FFFFFF"><b><?php echo(getUebersetzung("Farb-Code",$sprache,$link)); ?></b></font></td>
        <td bgcolor="#CC6600" WIDTH=100 align=center><font face="verdana,arial,helvetica" size=2 color="FFFFFF"><b><?php echo(getUebersetzung("Farbe",$sprache,$link)); ?></b></font></td>
      </tr>
      <tr>
        <td height=5></td>
        <td height=5></td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>082984</font></td>
        <td bgcolor="#082984">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>08296B</font></td>
        <td bgcolor="#08296B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>08215A</font></td>
        <td bgcolor="#08215A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>00184A</font></td>
        <td bgcolor="#00184A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>C6B5DE</font></td>
        <td bgcolor="#C6B5DE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>9C7BBD</font></td>
        <td bgcolor="#9C7BBD">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>7B52A5</font></td>
        <td bgcolor="#7B52A5">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>522994</font></td>
        <td bgcolor="#522994">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>31007B</font></td>
        <td bgcolor="#31007B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>29006B</font></td>
        <td bgcolor="#29006B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>21005A</font></td>
        <td bgcolor="#21005A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>21004A</font></td>
        <td bgcolor="#21004A">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>180042</font></td>
        <td bgcolor="#180042">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>DEBDDE</font></td>
        <td bgcolor="#DEBDDE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>CE84C6</font></td>
        <td bgcolor="#CE84C6">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>B552AD</font></td>
        <td bgcolor="#B552AD">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>9C2994</font></td>
        <td bgcolor="#9C2994">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>8C007B</font></td>
        <td bgcolor="#8C007B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>730063</font></td>
        <td bgcolor="#730063">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>5A0052</font></td>
        <td bgcolor="#5A0052">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>4A0042</font></td>
        <td bgcolor="#4A0042">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>390031</font></td>
        <td bgcolor="#390031">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>F7BDDE</font></td>
        <td bgcolor="#F7BDDE">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>E78CC6</font></td>
        <td bgcolor="#E78CC6">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>DE5AAD</font></td>
        <td bgcolor="#DE5AAD">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>D63194</font></td>
        <td bgcolor="#D63194">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>CE007B</font></td>
        <td bgcolor="#CE007B">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>A50063</font></td>
        <td bgcolor="#A50063">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>840052</font></td>
        <td bgcolor="#840052">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>6B0042</font></td>
        <td bgcolor="#6B0042">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>520031</font></td>
        <td bgcolor="#520031">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>FFFFFF</font></td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>E0E0E0</font></td>
        <td bgcolor="#E0E0E0">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>BFBFBF</font></td>
        <td bgcolor="#BFBFBF">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>A1A1A1</font></td>
        <td bgcolor="#A1A1A1">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>808080</font></td>
        <td bgcolor="#808080">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>616161</font></td>
        <td bgcolor="#616161">&nbsp;</td>
      </tr>
      <tr>
        <td><font face="Verdana, Helvetica, Sans-serif" size=1>000000</font></td>
        <td bgcolor="#000000">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<p><font face="Verdana, Helvetica, Sans-serif" size=1><a href="#" onClick="javascript:self.close()"><?php echo(getUebersetzung("Fenster schließen",$sprache,$link)); ?></a></font></p>
<p>&nbsp;</p>
</body>
</html>
