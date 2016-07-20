
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

}