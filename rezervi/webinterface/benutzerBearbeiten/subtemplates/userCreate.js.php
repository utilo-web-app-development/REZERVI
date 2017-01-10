<script>

    var rezervi = angular.module('rezerviApp', ['use', 'ngMessages']);

    //rezervi.directive('equals', compareTo);

    rezervi.controller('MainController', function($scope,$http) {

        $scope.sprache = "<?php echo $sprache; ?>";
        $scope.pass = "";
        $scope.pass2 = "";

        $scope.name = "";

        $scope.roles = [
            {id: '0', role: '<?php echo(getUebersetzung("Benutzer", $sprache, $link)); ?>'},
            {id: '1', role: '<?php echo(getUebersetzung("Administrator", $sprache, $link)); ?>'}
        ];
        $scope.rechte = $scope.roles[0].id;

        if($scope.sprache == "de"){

        }
        else{

        }
    });


</script>