<script>

    var rezervi = angular.module('rezerviApp', ['use', 'ngMessages']);

    //rezervi.directive('equals', compareTo);

    rezervi.controller('MainController', function($scope,$http) {

    $scope.sprache = "<?php echo $sprache; ?>";
    $scope.pass = "";
    $scope.pass2 = "";

    $scope.name = "";

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
    $scope.rechte = $scope.roles[0].id;

    if($scope.sprache == "de"){

}
    else{

}
});


</script>