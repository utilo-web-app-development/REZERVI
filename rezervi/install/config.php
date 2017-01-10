<?php
session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/conf/rdbmsConfig.php");
include_once($root . "/layouts/header.php");

?>
<title>Installation Rezervi</title>
<?php include_once("subtemplates/config.js.php"); ?>
<?php include_once($root . "/layouts/headerEnd.php"); ?>

<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:20px;">
    <div class="panel panel-default"  ng-app="rezerviApp" ng-controller="MainController">

        <div class="panel-heading">
            <h2>
                {{title}}
            </h2>
        </div>
        <div class="panel-body">

            <form action="install.php" method="post" class="form-horizontal" name="formConfig" id="formConfig"
                  target="_self" novalidate>
                <input type="hidden" name="sprache" ng-model="sprache" value="<?php echo $_POST["sprache"]; ?>">

                <div class="form-group">
                    <label for="unterkunft_name" class="col-sm-4">
                        {{unterkunft_name_Label}}
                    </label>
                    <div class="col-sm-8">
                        <input name="unterkunft_name" id="unterkunft_name" ng-model="unterkunft_name" type="text" class="form-control"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="art" class="col-sm-4">
                        {{art_Label}}
                    </label>
                    <div class="col-sm-8">
                        <input name="art" id="art" type="text" ng-model="art" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mietobjekt_ez" class="col-sm-4">
                        {{mietobjekt_ez_Label}}

                    </label>
                    <div class="col-sm-8">
                        <input name="mietobjekt_ez" id="mietobjekt_ez" ng-model="mietobjekt_ez" type="text" class="form-control"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mietobjekt_mz" class="col-sm-4">
                        {{mietobjekt_mz_Label}}
                    </label>
                    <div class="col-sm-8">
                        <input name="mietobjekt_mz" id="mietobjekt_mz" ng-model="mietobjekt_mz" type="text" class="form-control"
                               required>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" ng-model="submit" ng-disabled="formConfig.$invalid">
                        {{button_Label}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>