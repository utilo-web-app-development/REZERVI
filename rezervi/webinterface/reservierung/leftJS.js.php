<script language="JavaScript" type="text/javascript">
    function updateReservierung(vonTagIndex, vonMonatIndex, vonJahrIndex, bisTagIndex, bisMonatIndex, bisJahrIndex, zimmer_idValue
    ){

    document.reservierung.zimmer_id.value = zimmer_idValue;
    document.reservierung.vonTag.selectedIndex = vonTagIndex;
    document.reservierung.vonMonat.selectedIndex = vonMonatIndex;
    document.reservierung.vonJahr.selectedIndex = vonJahrIndex;
    document.reservierung.bisTag.selectedIndex = bisTagIndex;
    document.reservierung.bisMonat.selectedIndex = bisMonatIndex;
    document.reservierung.bisJahr.selectedIndex = bisJahrIndex;

}

    function chkDays(sel){

    //sel == 0 ist das von datum
    //sel == 1 ist das bis datum
    var selektierterIndexBis = document.reservierung.bisTag.selectedIndex;
    var selektierterIndexVon = document.reservierung.vonTag.selectedIndex;
    var Stop = 31; //anzahl der tage f?r das jeweilige monat
    if (sel == 1){
    //zuerst alles aus der selection l?schen:
    for (var i=0; i < document.reservierung.bisTag.length; i++) {
    document.reservierung.bisTag[i] = null;
}
    //selectiertes monat und jahr auslesen:
    var Monat = document.reservierung.bisMonat.value;
    var Jahr  = document.reservierung.bisJahr.value;
}
    else if (sel == 0) {
    for (var i=0; i < document.reservierung.vonTag.length; i++) {
    document.reservierung.vonTag[i] = null;
}
    var Monat = document.reservierung.vonMonat.value;
    var Jahr  = document.reservierung.vonJahr.value;
}

    //schaltjahre ber?cksichtigen:
    if(Monat == 4 || Monat == 6 || Monat == 9 || Monat==11) --Stop;
    if(Monat == 2) {
    Stop = Stop - 3;
    if(Jahr%4==0) Stop++;
    if(Jahr%100==0) Stop--;
    if(Jahr%400==0) Stop++;
}

    //selection neu aufbauen:
    for (var i=0; i < Stop; i++) {
    if (sel == 1)
    document.reservierung.bisTag[i] = new Option(i+1);
    else if (sel == 0)
    document.reservierung.vonTag[i] = new Option(i+1);
}
    //vorher selektieren index wieder herstellen:
    if (selektierterIndexBis <= document.reservierung.bisTag.length){
    document.reservierung.bisTag.selectedIndex = selektierterIndexBis;
}
    if (selektierterIndexVon <= document.reservierung.vonTag.length){
    document.reservierung.vonTag.selectedIndex = selektierterIndexVon;
}
}

    function changeZimmer(){

    document.reservierung.zimmer_id.value = document.ZimmerNrForm.zimmer_id.value;
    document.jahresuebersicht.zimmer_id.value = document.ZimmerNrForm.zimmer_id.value;
    document.ZimmerNrForm.submit();

}

    //
    // liefert den ausgew ? hlten tag aus dem
    // von - select
    //
    function getSelectedTagVon(){

    return document.reservierung.vonTag.selectedIndex;;

}

    function getJahrIndex(jahrValue){

    var val = "";

    for(var i=0; i < document.ZimmerNrForm.jahr.length; i++){
    val = document.ZimmerNrForm.jahr[i].value;
    if (val == jahrValue)
    return i;
}

    return 0;

}

    function getMonatIndex(monatValue){

    var val = "";

    for(var i=0; i < document.ZimmerNrForm.monat.length; i++){
    val = document.ZimmerNrForm.monat[i].value;
    if (val == monatValue)
    return i;
}

    return 0;

}

    function getZimmer_idIndex(zimmer_idValue){

    var val = "";

    for(var i=0; i < document.ZimmerNrForm.zimmer_id.length; i++){
    val = document.ZimmerNrForm.zimmer_id[i].value;
    if (val == zimmer_idValue)
    return i;
}

    return 0;

}

    function updateKalender(monatValue, jahrValue, zimmer_idValue
    ){

    //werte auslesen:
    var jahrIndex = getJahrIndex(jahrValue);
    var monatIndex = getMonatIndex(monatValue);
    var zimmer_idIndex = getZimmer_idIndex(zimmer_idValue);
    var zimmer_idValue = document.ZimmerNrForm.zimmer_id.value;
    var tagIndex = document.reservierung.vonTag.selectedIndex;

    //werte setzen:
    updateZimmerNrForm(jahrIndex,monatIndex,zimmer_idIndex);
    updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue);
    //updateSuche(jahrValue,monatValue);
    updateReservierung(tagIndex,monatIndex,jahrIndex,tagIndex,monatIndex,jahrIndex,zimmer_idValue);

}

    function zimmerNrFormJahrChanged(){
    //werte auslesen:
    var jahrIndex = document.ZimmerNrForm.jahr.selectedIndex;
    var jahrValue = document.ZimmerNrForm.jahr.value;
    var monatIndex = document.ZimmerNrForm.monat.selectedIndex;
    var monatValue = document.ZimmerNrForm.monat.value;
    var zimmer_idValue = document.ZimmerNrForm.zimmer_id.value;
    var tagIndex = document.reservierung.vonTag.selectedIndex;
    //andere forms updaten:
    updateJahresuebersicht(jahrValue,monatValue,zimmer_idValue);
    //updateSuche(jahrValue,monatValue);
    updateReservierung(tagIndex,monatIndex,jahrIndex,tagIndex,monatIndex,jahrIndex,zimmer_idValue);
    //formular absenden
    document.ZimmerNrForm.submit();
}

    function showReservierungAendernDialog() {

    var html = `
    <form action="./resAendern/resAendern.php" method="post"  name="reservierung" target="_blank"
                  class="form-horizontal"
                  id="reservierung">
                <?php
    //status = 0: frei
    //status = 1: reserviert
    //status = 2: belegt
    ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-danger active">
                                <input type="radio" name="status" id="belegt" autocomplete="off" value="2" > <?php echo(getUebersetzung("belegt", $sprache, $link)); ?>
                            </label>
                            <?php
    if ($showReservation) {
    ?>
                                <label class="btn btn-success">
                                    <input type="radio" name="status" id="reserviert" autocomplete="off" value="1"> <?php echo(getUebersetzung("reserviert", $sprache, $link)); ?>
                                </label>
                                <?php
    }
    ?>
                            <label class="btn btn-primary">
                                <input type="radio" name="status" id="frei" autocomplete="off" value="0" checked> <?php echo(getUebersetzung("frei", $sprache, $link)); ?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2"><?php echo(getUebersetzung("von", $sprache, $link)); ?>
                        : </label>
                    <div class="col-sm-3">
                        <!--  heutigen tag selectiert anzeigen: -->
                        <select name="vonTag" class="form-control " id="vonTag">
                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                <option
                                    value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo(" selected"); ?>><?php echo($i); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <!--  heutiges monat selectiert anzeigen: -->
                        <select name="vonMonat" class="form-control" id="vonMonat" onChange="chkDays(0)">
                            <option
                                value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar", $sprache, $link)); ?></option>
                            <option
                                value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar", $sprache, $link)); ?></option>
                            <option
                                value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März", $sprache, $link)); ?></option>
                            <option
                                value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April", $sprache, $link)); ?></option>
                            <option
                                value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai", $sprache, $link)); ?></option>
                            <option
                                value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni", $sprache, $link)); ?></option>
                            <option
                                value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli", $sprache, $link)); ?></option>
                            <option
                                value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August", $sprache, $link)); ?></option>
                            <option
                                value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September", $sprache, $link)); ?></option>
                            <option
                                value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober", $sprache, $link)); ?></option>
                            <option
                                value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November", $sprache, $link)); ?></option>
                            <option
                                value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember", $sprache, $link)); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <!--  heutiges jahr selectiert anzeigen: -->
                        <select name="vonJahr" class="form-control "  id="vonJahr" onChange="chkDays(0)">
                            <?php
    for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++) { ?>
                                <option
                                    value="<?php echo $l ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo $l ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>


                <div class="form-group">
                    <label class="control-label col-sm-2"><?php echo(getUebersetzung("bis", $sprache, $link)); ?>
                        : </label>
                    <div class="col-sm-3">
                        <select name="bisTag" class="form-control" id="bisTag">
                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                <option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo " selected"; ?>><?php echo($i); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <!--  heutiges monat selectiert anzeigen: -->
                        <select name="bisMonat"  class="form-control" id="bisMonat"  onChange="chkDays(1)">
                            <option
                                value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar", $sprache, $link)); ?></option>
                            <option
                                value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar", $sprache, $link)); ?></option>
                            <option
                                value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März", $sprache, $link)); ?></option>
                            <option
                                value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April", $sprache, $link)); ?></option>
                            <option
                                value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai", $sprache, $link)); ?></option>
                            <option
                                value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni", $sprache, $link)); ?></option>
                            <option
                                value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli", $sprache, $link)); ?></option>
                            <option
                                value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August", $sprache, $link)); ?></option>
                            <option
                                value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September", $sprache, $link)); ?></option>
                            <option
                                value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober", $sprache, $link)); ?></option>
                            <option
                                value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November", $sprache, $link)); ?></option>
                            <option
                                value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember", $sprache, $link)); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <!--  heutiges jahr selectiert anzeigen: -->
                        <select name="bisJahr" class="form-control" id="bisJahr" onChange="chkDays(1)">
                            <?php
    for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++) { ?>
                                <option
                                    value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-offset-6 col-sm-6" style="text-align: right;">
                        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                        <button name="reservierungAendern" type="submit" class="btn btn-primary"
                                id="reservierungAbsenden2">
                            <span class="glyphicon glyphicon-wrench"></span>
                            <?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>
                        </button>
                    </div>
                </div>

            </form>
    `;

    bootbox.dialog({
        title: "<?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>",
        message: html,
        callback: function (result) {
            console.log(result);
        }
    });
}

    //Angular-Start
    var rezervi = angular.module('rezervierungApp', []
    )
    ;

    rezervi.controller('rezervierungController', function ($scope, $http
    ){

    $scope.show = true;
    $scope.showweiteryear=true;
    $scope.showzurueckyear=true;
    $scope.view = 0;

    //getting years
    var i=0;
    var yearsArray=[];
    for(var year = (new Date().getFullYear())-4;year< ((new Date().getFullYear())+4);year++)
{
    yearsArray[i]={"year":year };
    i++;
}
    $scope.years = yearsArray;
    $scope.year = new Date().getFullYear();

    $scope.yearChanged=function () {
    $scope.jahr_left = $scope.year;
    $scope.jahr_right = $scope.year;
    var FormData = {
    'month' : $scope.month,
    'year' : $scope.year,
    'zimmer_id':$scope.zimmer_id,
    'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
    'sprache':'<?php echo($sprache);?>'
};
    if($scope.view == 0)
{
    url="<?php echo $URL; ?>webinterface/reservierung/updateRightView.php";
}
    else
{
    url="<?php echo $URL; ?>webinterface/reservierung/jahresuebersicht.php";
}
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
    return zimmer.zimmerid == $scope.zimmer_id;
})[0].zimmerartnr;

    var head="";
    if($scope.view == 0)
{
    head = "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+zimmerName;
}
    else
{
    head = "Belegungsplan "+$scope.year+", für "+$scope.zimmer_id;
}
    $http.post(url,FormData)
    .then(function(response){

    //var head= "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+$scope.zimmer_id;
    // $('#rightView').hide('slow');
    $('#rightView').children('.panel-heading').html(head);
    $('#monthView').html(response.data);
    //$('#rightView').show('slow');
});

};


    //Getting months
    var monthsArray=[];

	<?php for ($i = 1; $i <= 12; $i++) { ?>
    monthsArray[<?php echo $i - 1?>]={"monthIndex": <?php echo $i ?> ,"month": "<?php echo(getUebersetzung(parseMonthName($i, "de"), $sprache, $link)); ?>" };
	<?php } ?>

    $scope.months = monthsArray;
    $scope.month = new Date().getMonth()+1;

    $scope.monthChanged=function () {
    $scope.monat_left = $scope.month;
    $scope.monat_right = $scope.month;
    var FormData = {
    'month' : $scope.month,
    'year' : $scope.year,
    'zimmer_id':$scope.zimmer_id,
    'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
    'sprache':'<?php echo($sprache);?>'
};
    if($scope.view == 0)
{
    url="<?php echo $URL; ?>webinterface/reservierung/updateRightView.php";
}
    else
{
    url="<?php echo $URL; ?>webinterface/reservierung/jahresuebersicht.php";
}

    var head="";
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
    return zimmer.zimmerid == $scope.zimmer_id;
})[0].zimmerartnr;
    if($scope.view == 0)
{
    head = "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+zimmerName;
}
    else
{
    head = "Belegungsplan "+$scope.year+", für "+zimmerName;
}
    $http.post(url,FormData)
    .then(function(response){

    //var head= "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+$scope.zimmer_id;
    //$('#rightView').hide('slow');
    $('#rightView').children('.panel-heading').html(head);
    $('#monthView').html(response.data);
    // $('#rightView').show('slow');
});
};


    //Zimmer
    var zimmers=[];
    var i=0;
    var selectedZimmer=0;
	<?php
	$query = "
                select
                Zimmernr, PK_ID, Zimmerart
                from
                Rezervi_Zimmer
                where
                FK_Unterkunft_ID = '$unterkunft_id'" .
		" order by Zimmernr ";
	$res = mysqli_query($link, $query);
	if (!$res)
		echo("Anfrage $query scheitert.");
	while ($d = mysqli_fetch_array($res)) { ?>
    zimmers[i]={"zimmerid":<?php echo $d["PK_ID"] ?>,"zimmerartnr":"<?php echo(getUebersetzungUnterkunft($d["Zimmerart"], $sprache, $unterkunft_id, $link));?>-<?php echo(getUebersetzungUnterkunft($d["Zimmernr"], $sprache, $unterkunft_id, $link)); ?>"};
	<?php if ($zimmer_id == $d["PK_ID"]) { ?>
    //    selectedZimmer="<?php //echo(getUebersetzungUnterkunft($d["Zimmerart"], $sprache, $unterkunft_id, $link));?>
    //<?php //echo(getUebersetzungUnterkunft($d["Zimmernr"], $sprache, $unterkunft_id, $link)); ?>//";
    selectedZimmer=<?php  echo $d["PK_ID"]; ?>;
	<?php } ?>
    i++;
	<?php } ?>

    $scope.zimmers=zimmers;
    $scope.zimmer_id=selectedZimmer;

    $scope.zimmer_idChanged=function(zimmer_id){

    $scope.zimmer_id_left=$scope.zimmer_id;
    $scope.zimmer_id_right=$scope.zimmer_id;
    console.log(zimmer_id);
    var FormData = {
        'month' : $scope.month,
        'year' : $scope.year,
        'zimmer_id':zimmer_id,
        'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
        'sprache':'<?php echo($sprache);?>'
    };

        if($scope.view == 0)
    {
        url="<?php echo $URL;?>webinterface/reservierung/updateRightView.php";
    }
        else
    {
        url="<?php echo $URL;?>webinterface/reservierung/jahresuebersicht.php";
    }

        var head="";
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
        return zimmer.zimmerid == zimmer_id;
    })[0].zimmerartnr;
    if($scope.view == 0)
    {
        head = "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+zimmerName;
    }
        else
    {
        head = "Belegungsplan "+$scope.year+", für "+zimmerName;
    }
        $http.post(url,FormData).then(function(response) {
        console.log(response);
        $('#rightView').children('.panel-heading').html(head);
        $('#monthView').html(response.data);
    });
};
    $scope.nextMonth=function () {

    if( ($scope.month+1) > 12)
{
    $scope.month=1;
    $scope.year =   $scope.year +1;

}
    else
{
    $scope.month = $scope.month+1;
}

    $scope.monat_left =   $scope.month;
    $scope.monat_right =   $scope.month;

    $scope.jahr_left =   $scope.year;
    $scope.jahr_right =   $scope.year;
    var FormData = {
    'month' : $scope.month,
    'year' : $scope.year,
    'zimmer_id':$scope.zimmer_id,
    'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
    'sprache':'<?php echo($sprache);?>'
};
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
    return zimmer.zimmerid == $scope.zimmer_id;
})[0].zimmerartnr;
    $http.post("<?php echo $URL; ?>webinterface/reservierung/updateRightView.php",FormData).then(function(response){
    var head = "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+zimmerName;
    // $('#rightView').hide('slow');
    $('#rightView').children('.panel-heading').html(head);
    $('#monthView').html(response.data);
    //$('#rightView').show('slow');
});

};

    $scope.previousMonth = function (){
    if( ($scope.month-1) < 1)
{
    $scope.month=12;
    $scope.year =   $scope.year - 1;

}
    else
{
    $scope.month = $scope.month-1;
}

    $scope.monat_left =   $scope.month;
    $scope.monat_right =   $scope.month;

    $scope.jahr_left =   $scope.year;
    $scope.jahr_right =   $scope.year;
    var FormData = {
    'month' : $scope.month,
    'year' : $scope.year,
    'zimmer_id':$scope.zimmer_id,
    'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
    'sprache':'<?php echo($sprache);?>'
};
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
    return zimmer.zimmerid == $scope.zimmer_id;
})[0].zimmerartnr;
    $http.post("http://localhost/rezervi/rezervi/webinterface/reservierung/updateRightView.php",FormData)
    .then(function(response){
    var head= "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+zimmerName;
    // $('#rightView').hide('slow');
    $('#rightView').children('.panel-heading').html(head);
    $('#monthView').html(response.data);
    //$('#rightView').show('slow');
});

};

    //Month and Year View
    $scope.changeView = function (view)
    {
        var url ="";
        if(view == 0)
    {
        url="http://localhost/rezervi/rezervi/webinterface/reservierung/updateRightView.php";
    }
        else
    {
        url="http://localhost/rezervi/rezervi/webinterface/reservierung/jahresuebersicht.php";
    }
        var FormData = {
        'month' : $scope.month,
        'year' : $scope.year,
        'zimmer_id':$scope.zimmer_id,
        'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
        'sprache':'<?php echo($sprache);?>'
    };
        var zimmerName = $.grep($scope.zimmers,function(zimmer){
        return zimmer.zimmerid == $scope.zimmer_id;
    })[0].zimmerartnr;
        $http.post(url,FormData).then(function(response){

        var head= "";
        if(view == 0)
    {
        head = "Belegungsplan "+$scope.month+"-"+$scope.year+", für "+zimmerName;
        $scope.show=true;
        $scope.view=0;
    }
        else
    {
        head = "Belegungsplan "+$scope.year+", für "+zimmerName;
        $scope.show=false;
        $scope.view=1;
    }
        // $('#rightView').hide('slow');
        $('#rightView').children('.panel-heading').html(head);
        $('#monthView').html(response.data);
        //$('#rightView').show('slow');
    });
    };

    $scope.nextYear = function () {

    $scope.showzurueckyear = true;

    if( ($scope.year+1) >= (new Date().getFullYear() + 3))
{
    $scope.showweiteryear=false;
}
    else
{

}
    $scope.year =   $scope.year+1;

    $scope.monat_left =   $scope.month;
    $scope.monat_right =   $scope.month;

    $scope.jahr_left =   $scope.year;
    $scope.jahr_right =   $scope.year;
    var FormData = {
    'month' : $scope.month,
    'year' : $scope.year,
    'zimmer_id':$scope.zimmer_id,
    'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
    'sprache':'<?php echo($sprache);?>'
};
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
    return zimmer.zimmerid == $scope.zimmer_id;
})[0].zimmerartnr;
    $http.post("<?php echo $URL; ?>webinterface/reservierung/jahresuebersicht.php",FormData)
    .then(function(response){

    var head= "Belegungsplan "+$scope.year+", für "+zimmerName;
    // $('#rightView').hide('slow');
    $('#rightView').children('.panel-heading').html(head);
    $('#monthView').html(response.data);
    //$('#rightView').show('slow');
});
};

    $scope.previousYear = function (){

    $scope.showweiteryear = true;

    if( ($scope.year-1) <= (new Date().getFullYear() - 4))
{
    $scope.showzurueckyear=false;
}
    else
{

}
    $scope.year =   $scope.year -1;
    $scope.monat_left =   $scope.month;
    $scope.monat_right =   $scope.month;

    $scope.jahr_left =   $scope.year;
    $scope.jahr_right =   $scope.year;
    var FormData = {
    'month' : $scope.month,
    'year' : $scope.year,
    'zimmer_id':$scope.zimmer_id,
    'unterkunft_id':<?php echo(getSessionWert(UNTERKUNFT_ID));?>,
    'sprache':'<?php echo($sprache);?>'
};
    var zimmerName = $.grep($scope.zimmers,function(zimmer){
    return zimmer.zimmerid == $scope.zimmer_id;
})[0].zimmerartnr;
    $http.post("<?php echo $URL; ?>webinterface/reservierung/jahresuebersicht.php",FormData)
    .then(function(response){



    var head= "Belegungsplan "+$scope.year+", für "+zimmerName;
    // $('#rightView').hide('slow');
    $('#rightView').children('.panel-heading').html(head);
    $('#monthView').html(response.data);
    //$('#rightView').show('slow');
});

};
    });
</script>
