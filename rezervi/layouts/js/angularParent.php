<script>

/**
 Directive
 Bei Klick Rueckfrage an user
 */
var ngConfirmClick = function(){
    return {
        link: function (scope, element, attr) {
            var msg = attr.ngConfirmClick || "Sind Sie Sicher?";
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
</script>