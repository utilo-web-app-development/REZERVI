<script>

    var rezervi = angular.module('rezerviApp', ['use', 'ngMessages']);

    //rezervi.directive('equals', compareTo);

    rezervi.controller('MainController', function($scope,$http) {

    $scope.sprache = "<?php echo $sprache; ?>";
    $scope.id = "<?php echo($id); ?>";
    $scope.testuser = "<?php echo($testuser); ?>"
    $scope.pass = "";
    $scope.pass2 = "";

    console.log($scope.id );
    console.log($scope.testuser );

    $scope.name = "<?php if (isset($name))
{
	echo($name);
} ?>";

    $scope.roles = [
        <?php
        $query = "select 
                *
            from 
            Rezervi_Role
            ";
        $res = mysqli_query($link, $query);
        if (!$res)
        {
            echo("die Anfrage $query scheitert.");
        }
        else
        {
            while ($d = mysqli_fetch_array($res)) {
            ?>
                {id: '<?php echo($d["FK_Role_ID"]); ?>', role: '<?php echo($d["Name"]); ?>'},
            <?php
            }
        }
        ?>
    ];
    var recht ="<?php echo $rechte; ?>";

    $scope.rechte = recht;

});

</script>