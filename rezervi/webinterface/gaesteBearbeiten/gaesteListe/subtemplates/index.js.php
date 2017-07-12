<script>

	var rezervi = angular.module('rezerviApp', []);

	rezervi.directive('ngConfirmClick', ngConfirmClick);

	rezervi.controller('MainController', function($scope,$http) {

    /**submit deleting form if confirm true*/
    $scope.delete = function(formId){

		$('#'+formId).submit();

    };

});


</script>