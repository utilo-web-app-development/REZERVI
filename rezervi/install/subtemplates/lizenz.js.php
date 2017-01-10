<script>
    var rezervi = angular.module('rezerviApp', []);

    rezervi.controller('MainController', function($scope) {

    $scope.submitButtonDisable = true;
    $scope.optionsRadios1 = false;
    $scope.optionsRadios2 = true;
    $scope.sprache ="<?php echo($_POST['sprache']) ?>";

    if($scope.sprache == "de"){
    $scope.title = "Rezervi Belegungsplan und Kundendatenbank";
    $scope.lizenz_accept = "Lizenz gelesen und akzeptiert";
    $scope.lizenz_not_accept = "Lizenz nicht akzeptiert";

    $scope.button_Label = "Weiter";
}
    else{
    $scope.title = "Rezervi availability overview and guest database";
    $scope.lizenz_accept = "I accept the agreement";
    $scope.lizenz_not_accept = "I do not accept the agreement";

    $scope.button_Label = "Continue";
}

    $scope.isCheckboxSelected = function(index) {
    $scope.submitButtonDisable = index;


};
});
</script>