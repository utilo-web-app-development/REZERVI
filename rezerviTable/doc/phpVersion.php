<!DOCTYPE html>
"
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;">
<meta charset="UTF-8"">
<title>PHP Version </title>
<link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
</head>

<body>
<span class="<?= STANDARD_SCHRIFT ?>">Hier sehen Sie eine Ausgabe Ihres PHP-Servers. Die PHP Version muss mindestens </span><span class="<?= STANDARD_SCHRIFT_BOLD ?>">PHP Version 4.2.3</span><span class="<?= STANDARD_SCHRIFT ?>"> sein und unter "Configuration - PHP Core" mu� "register_globals = ON" sein um Rezervi korrekt verwenden zu können. Ansonsten steht Ihnen auch die Möglichkeit der Miete zur Verfügung - besuchen sie dazu die Website <a href="http://belegungsplan.utilo.net" target="_parent">http://belegungsplan.utilo.net </a></span>
<p>
    <?php phpinfo(); ?>
 </p>
</body>
</html>
