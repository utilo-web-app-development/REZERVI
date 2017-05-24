<script>

    var rezervi = angular.module('rezerviApp', []);

    rezervi.directive('ngConfirmClick', ngConfirmClick);

    rezervi.controller('MainController', function($scope,$http) {

    $scope.delete = function(id){

        window.open("./benutzerLoeschen.php?user_"+id+"="+id,"_self");

    };

    $scope.sprache = "<?php echo $sprache; ?>";
    $scope.usersArray = [
    <?php
    //benutzer auslesen:
    $query = "select 
                        PK_ID, Name, Rechte
                        from 
                        Rezervi_Benutzer
                        where
                        FK_Unterkunft_ID = '$unterkunft_id'
                        ORDER BY 
                        Name";

    $res = mysqli_query($link, $query);
    if (!$res) {
        echo("die Anfrage $query scheitert.");
    } else {
    //benutzer ausgeben:
    $i = 0;
    while ($d = mysqli_fetch_array($res)) { ?>
        {id: '<?php echo($d["PK_ID"]); ?>', name: '<?php echo($d["Name"]); ?>', role:'<?php echo( getRoleName($d["Rechte"],$link)); ?>'},
    <?php
        } //ende while
    } //ende else
    //ende benutzer ausgeben
    ?>
    ];
    console.log($scope.usersArray);
    $scope.users = $scope.usersArray[0].id;

});


</script>