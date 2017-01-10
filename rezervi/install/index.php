<?php
session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/conf/rdbmsConfig.php");
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Installation Rezervi</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Bootstrap ende -->

    <!-- Angular js -->
    <script src="<?php echo ($root)?>/libs/angular/angular.min.js"></script>
    <script src="<?php echo ($root)?>/libs/angular/angular-animate.js"></script>
    <script src="<?php echo ($root)?>/libs/angular/angular-sanitize.js"></script>
</head>

<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:20px;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
                Rezervi availability overview and guest database</br>
                Rezervi Belegungsplan und Kundendatenbank
            </h2>
        </div>

        <div class="panel-body">
            <h4>Please check your changings in the 'conf/rdbmsConfig.php' file:<br/>
                Bitte prüfen sie ihre Eingaben in der 'conf/rdbmsConfig.php' Datei.</h4>
        </div>

        <div class="panel-body">
            <table class="table">
                <tbody>
                <tr>
                    <td>
                        URL for your MySQL database e.g. "localhost"
                        <br />
                        URL zur MySQL Datenbank, z. B. "localhost"
                    </td>
                    <td  style="vertical-align: middle; text-align: center;"><strong><?php echo $DBMS_URL ?></strong></td>
                </tr>
                <tr>
                    <td>
                        Name of the MySQL database
                        <br />
                        Name der MySQL Datenbank"
                    </td>
                    <td  style="vertical-align: middle; text-align: center;"><strong><?php echo $DB_NAME ?></strong></td>
                </tr>
                <tr>
                    <td>
                        Username of the MySQL database
                        <br />
                        Benutzername der MySQL Datenbank
                    </td>
                    <td  style="vertical-align: middle; text-align: center;"><strong><?php echo $USERNAME ?></strong></td>
                </tr>
                <tr>
                    <td>
                        Password of the MySQL database
                        <br/>
                        Passwort der MySQL Datenbank
                    </td>
                    <td  style="vertical-align: middle; text-align: center;"><strong><?php echo $PASS ?></strong></td>
                </tr>
                <tr>
                    <td>
                        URL of your homepage/your availibilty overview e.g. $URL =
                        "http://www.my-domainname.com"<br/>
                        If you installed Rezervi on a special folder on your webserver, you must also fill in this path.
                        e.g. $URL = "http://www.my-domainname.com/rezerviStable/<br/>
                        <br/>
                        URL ihrer Homepage/ihres Belegungsplanes z. B. $URL = "http://www.mein-domainname.com"<br/>
                        falls Rezervi in einem speziellen Verzeichnis ihres Webservers installiert wurde, geben sie
                        bitte auch diesen Pfad mit in der URL an.<br/>
                        z. B. $URL = "http://www.mein-domainname.com/rezerviStable/"<br/>
                    </td>
                    <td  style="vertical-align: middle; text-align: center;"><strong><?php echo $URL ?></strong></td>
                </tr>
                <tr>
                    <td>
                        E-mail address
                        <br/>
                        E-Mail-Adresse
                    </td>
                    <td  style="vertical-align: middle; text-align: center;"><strong><?php echo $EMAIL ?></strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
        <div class="panel-body">
            <form action="lizenz.php" method="post" id="form1" name="form1" target="_self"
                  onSubmit="return checkConf();">
                <!-- Radio Button -->
                <div class="radio">
                    <label>
                        <input type="radio" name="config" id="optionsRadios1" ng-model="optionsRadios1" ng-click="isCheckboxSelected(false)" ng-value="true">
                        The file entries are correct.<br/>
                        Die Eintragungen im File sind korrekt.
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="config" id="optionsRadios2" ng-model="optionsRadios2" ng-checked="true" ng-click="isCheckboxSelected(true)" ng-value="false">
                        The file entries are not correct.<br/>
                        Die Eintragungen im File sind nicht korrekt.
                    </label>
                </div>
                <p>Please select your language.<br/>
                    Bitte wählen sie ihre Sprache.</p>
                <div class="form-group">
                    <select name="sprache" type="text" id="sprache" value="" class="form-control">&gt;
                        <option value="de">Deutsch</option>
                        <option value="en">Englisch</option>
                    </select>
                </div>
                <input name="Submit" type="submit" class="btn btn-primary" ng-disabled="submitButtonDisable" value="Continue / Weiter">
            </form>
        </div>
    </div>

</div>
<script>
    var rezervi = angular.module('rezerviApp', []);

    rezervi.controller('MainController', function($scope) {

        $scope.submitButtonDisable = true;
        $scope.optionsRadios1 = false;
        $scope.optionsRadios2 = true;

        $scope.isCheckboxSelected = function(index) {
           $scope.submitButtonDisable = index;
        };
    });
</script>
</body>
</html>
