<script>
    var rezervi = angular.module('rezerviApp', []);

    rezervi.controller('MainController', function($scope,$http) {


    $scope.sprache = "<?php echo $_POST["sprache"]; ?>";
    $scope.title="";

    if($scope.sprache == "de"){
        $scope.title = "Installation Rezervi Belegungsplan und Kundendatenbank";
        $scope.installation = "Installation wird durchgeführt...";
    }
    else{
        $scope.title = "Installation of Rezervi availability overview and guest database";
        $scope.installation = "Doing the installation ...";

    }
});
</script>