
'use strict';

function checkForm(formId) {
    console.log("checkForm(" + formId + ")");
    var invalid = false;
    $("input").each(function () {
        if ($(this).val() == '' && $(this).attr('required')) {
            invalid = true;
            $(this).focus();
            return false;

        }
    });
    $("select").each(function () {
        if ($(this).val() == '' && $(this).attr('required')) {
            invalid = true;
            $(this).focus();
            return false;
        }
    });
    $("textarea").each(function () {
        if ($(this).val() == '' && $(this).attr('required')) {
            invalid = true;
            $(this).focus();
            return false;
        }
    });
    //all filled up
    if(!invalid)
    {
        $('#'+formId).submit();
    }
    else
    {
        bootbox.alert(
            "Füllen Sie bitte alle Fields"
        );
    }

};

/**
 Directive
 Bei Klick Rueckfrage an user
 */
var ngConfirmClick = function(){
    return {
        link: function (scope, element, attr) {
            var msg = attr.ngConfirmClick || "Are you sure?";
            var clickAction = attr.confirmedClick;
            element.bind('click',function (event) {
//						bootbox.confirm({
//							title: "Alert",
//							message: msg,
//							callback: function (result) {
//								console.log("Confirm result: " + result);
//								if (result) {
//									scope.$eval(clickAction);
//								}
//							}
//						});
                bootbox.confirm(msg, function(result) {
                    console.log("Confirm result: "+result);
                    if (result){
                        scope.$eval(clickAction);
                    }
                });

            });
        }
    };
};

/**
 Directive
 vergleicht 2 input felder, z. B. fuer Passwort Validation
 userApp.directive('equals', compareTo);
 */
var compareTo = function() {
    return {
        restrict: 'A', // only activate on element attribute
        require: '?ngModel', // get a hold of NgModelController
        link: function(scope, elem, attrs, ngModel) {
            if(!ngModel) return; // do nothing if no ng-model

            // watch own value and re-validate on change
            scope.$watch(attrs.ngModel, function() {
                validate();
            });

            // observe the other value and re-validate on change
            attrs.$observe('equals', function (val) {
                validate();
            });

            var validate = function() {
                // values
                var val1 = ngModel.$viewValue;
                var val2 = attrs.equals;

                // set validity
                ngModel.$setValidity('equals', ! val1 || ! val2 || val1 === val2);
            };
        }
    }
};

/**
 Directive um in einem Textfeld uppercase zu erzwingen
 myApp.directive('uppercase', uppercase);
 */
var uppercase = function(){

    return {
        require: 'ngModel',
        link: function(scope, element, attrs, modelCtrl) {
            var capitalize = function(inputValue) {
                if(inputValue == undefined) inputValue = '';
                var capitalized = inputValue.toUpperCase();
                if(capitalized !== inputValue) {
                    modelCtrl.$setViewValue(capitalized);
                    modelCtrl.$render();
                }
                return capitalized;
            }
            modelCtrl.$parsers.push(capitalize);
            capitalize(scope[attrs.ngModel]);  // capitalize initial value
        }
    };

}
/*
var rezervi = angular.module('rezerviApp', []);

rezervi.controller('MainController', function($scope,$http) {

    $scope.sicher = function (formId) {
        $('#'+formId).submit();
    }
});

rezervi.directive('ngConfirmClick', [
    function(){
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Sind Sie sicher?";
                var clickAction = attr.confirmedClick;
                element.bind('click',function (event) {
                    bootbox.confirm({
                        size: 'small',
                        message: msg,
                        callback: function (result) {

                            if (result) {
                                //bootbox.alert('result ' + result);
                                scope.$eval(clickAction)
                            }
                        }
                    });
                });
            }
        };
    }]);*/
