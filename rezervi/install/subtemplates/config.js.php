<script>
    var rezervi = angular.module('rezerviApp', []);

    rezervi.controller('MainController', function($scope,$http) {

    $scope.unterkunft_name = "";
    $scope.art = "";
    $scope.mietobjekt_ez = "";
    $scope.mietobjekt_mz = "";
    $scope.sprache = "<?php echo $_POST["sprache"]; ?>";
    $scope.title="";

    if($scope.sprache == "de"){
        $scope.title = "Rezervi Belegungsplan und Kundendatenbank";
        $scope.unterkunft_name_Label = "Name ihrer Unterkunft";
        $scope.art_Label = "Art ihrer Unterkunft (z. B. Hotel)";
        $scope.mietobjekt_ez_Label = "Bezeichnung ihres Mietobjektes - Einzahl (z. B. Zimmer, Appartement)";
        $scope.mietobjekt_mz_Label = "Bezeichnung ihres Mietobjektes - Mehrzahl (z. B. Zimmer, Appartements)";
        $scope.button_Label = "Weiter";
    }
    else{
        $scope.title = "Rezervi availability overview and guest database";
        $scope.unterkunft_name_Label = "Name of your accomodation";
        $scope.art_Label = "Type of your accomodation (eg. Hotel)";
        $scope.mietobjekt_ez_Label = "Name of your object to rent - singular (eg. room, apartement)";
        $scope.mietobjekt_mz_Label = "Name of your object to rent - plural (eg. rooms, apartements)";
        $scope.button_Label = "Continue";
    }
});
</script>