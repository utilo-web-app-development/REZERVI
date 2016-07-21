
'use strict';

function checkForm(formId) {
    var invalid=false;
    $("input").each(function () {
        if ($(this).val() == '') {
            invalid=true;
            $(this).focus();
            alert("Füllen Sie bitte alle Fields");
            return false;

        }
    });
    $("select").each(function () {
        if ($(this).val() == '') {
            invalid=true;
            $(this).focus();
            alert("Füllen Sie bitte alle Fields");
            return false;
        }
    });
    $("textarea").each(function () {
        if ($(this).val() == '') {
            invalid=true;
            $(this).focus();
            alert("Füllen Sie bitte alle Fields");
            return false;
        }
    });
    //all filled up
    if(!invalid)
    {
        $('#'+formId).submit();
    }

};

var rezervi = angular.module('rezerviApp', []);

rezervi.controller('MainController', function($scope,$http) {

    $scope.sicher=function (formId) {
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
    }])