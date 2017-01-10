<?php
// Set flag that this is a parent file
session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Installation Rezervi</title>
    <link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          crossorigin="anonymous">
    <!-- Bootstrap ende -->
    <!-- Angular js -->
    <script src="<?php echo($root) ?>/libs/angular/angular.min.js"></script>
    <script src="<?php echo($root) ?>/libs/angular/angular-animate.js"></script>
    <script src="<?php echo($root) ?>/libs/angular/angular-sanitize.js"></script>

    <?php include_once("subtemplates/lizenz.js.php"); ?>

</head>
<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:20px;">

    <div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">
        <div class="panel-heading">
            <h2>
                {{title}}
            </h2>
        </div>
        <div class="panel-body">

            <div class="col-md-8">
                    <textarea class="form-control" rows="20" cols="80" readonly>
                        <?php
                        if ($_POST["sprache"] == "de") {
                            include_once("../LIZENZ.txt");
                        } else {
                            include_once("../LICENCE.txt");
                        }
                        ?>
                    </textarea>
            </div>
            <div class="col-md-4">
                <form action="config.php" method="post" id="formLizenz" name="formLizenz" target="_self"
                      class="">
                    <input type="hidden" name="sprache" ng-model="sprache" value="<?php echo($_POST['sprache']) ?>"/>
                    <div class="radio">
                        <label>
                            <input type="radio" name="lizenz" id="optionsRadios1" ng-model="optionsRadios1"
                                   ng-click="isCheckboxSelected(false)" ng-value="true">
                            {{lizenz_accept}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="lizenz" id="optionsRadios2" ng-model="optionsRadios2"
                                   ng-checked="true" ng-click="isCheckboxSelected(true)" ng-value="false">
                            {{lizenz_not_accept}}
                        </label>
                    </div>

                    <button name="Submit" type="submit" class="btn btn-primary" ng-disabled="submitButtonDisable">
                        {{button_Label}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>