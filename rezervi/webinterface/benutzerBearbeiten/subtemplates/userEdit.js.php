<script>

    var rezervi = angular.module('rezerviApp', ['use', 'ngMessages']);

    //rezervi.directive('equals', compareTo);

    rezervi.controller('MainController', function($scope,$http) {

    $scope.sprache = "<?php echo $sprache; ?>";
    $scope.id = "<?php echo($id); ?>";
    $scope.testuser = "<?php echo($testuser); ?>"
    $scope.pass = "";
    $scope.pass2 = "";

    $scope.name = "<?php if (isset($name)) {echo($name);} ?>";

    $scope.roles = [
        {id: '0', role: '<?php echo(getUebersetzung("Benutzer", $sprache, $link)); ?>'},
        {id: '1', role: '<?php echo(getUebersetzung("Administrator", $sprache, $link)); ?>'}
    ];
    var recht = parseInt("<?php echo $rechte; ?>");

    $scope.rechte = $scope.roles[recht].id;

});

</script>