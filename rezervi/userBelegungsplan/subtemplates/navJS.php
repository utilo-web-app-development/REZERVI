<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

?>

<script>


    function showReservierungAendernDialog(fromDay,fromMonth,fromYear,toDay,toMonth,toYear) {

        var zimmer_id = $('#zimmer_id').val();
        var html =
        '<form action="./resAendern/resAendern.php" method="post"  name="reservierung" target="_blank"  class="form-horizontal" id="reservierung">' +
        <?php
        //status = 0: frei
        //status = 1: reserviert
        //status = 2: belegt
        ?>
        '<div class="form-group">' +
        '<div class="col-sm-12">' +
        '<div class="btn-group" data-toggle="buttons">' +
        '<label class="btn btn-danger">' +
        '<input type="radio" name="status" id="belegt" autocomplete="off" value="2">'+
        '<?php echo(getUebersetzung("belegt", $sprache, $link)); ?>'+
        '</label>' +
        <?php
        if ($showReservation) {
        ?>
        '<label class="btn btn-success">'+
        '<input type="radio" name="status" id="reserviert" autocomplete="off" value="1">' +
        '<?php echo(getUebersetzung("reserviert", $sprache, $link)); ?>'+
        '</label>'+
        <?php
        }
        ?>
        '<label class="btn btn-primary active">'+
        '<input type="radio" name="status" id="frei" autocomplete="off" value="0" checked>' +
        '<?php echo(getUebersetzung("frei", $sprache, $link)); ?>'+
        '</label>' +
        '</div>' +
        '</div>' +
        '</div>' +

        '<div class="form-group">' +
        '<label class="control-label col-sm-2">'+
        '<?php echo(getUebersetzung("von", $sprache, $link)); ?>'+ ':'+
        '</label>' +
        '<div class="col-sm-3">' +

        '<select name="vonTag" class="form-control " id="vonTag">' +
        <?php for ($i = 1; $i <= 31; $i++) { ?>
        '<option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) {
            echo(" selected");
        } ?>>' +
        '<?php echo($i); ?>'+
        '</option>' +
        <?php } ?>
        '</select>' +
        '</div>' +
        '<div class="col-sm-4">' +
        <!--  heutiges monat selectiert anzeigen: -->
        '<select name="vonMonat" class="form-control" id="vonMonat">' +
        ' <option value="1"<?php if (getTodayMonth() == "Januar") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Januar", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="2"<?php if (getTodayMonth() == "Februar") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Februar", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="3"<?php if (getTodayMonth() == "März") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("März", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="4"<?php if (getTodayMonth() == "April") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("April", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="5"<?php if (getTodayMonth() == "Mai") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Mai", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="6"<?php if (getTodayMonth() == "Juni") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Juni", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="7"<?php if (getTodayMonth() == "Juli") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Juli", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="8"<?php if (getTodayMonth() == "August") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("August", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="9"<?php if (getTodayMonth() == "September") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("September", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="10"<?php if (getTodayMonth() == "Oktober") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Oktober", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="11"<?php if (getTodayMonth() == "November") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("November", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="12"<?php if (getTodayMonth() == "Dezember") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Dezember", $sprache, $link)); ?>'+
        '</option>' +
        '</select>' +
        '</div>' +
        '<div class="col-sm-3">' +
        <!--  heutiges jahr selectiert anzeigen: -->
        '<select name="vonJahr" class="form-control "  id="vonJahr">' +
        <?php for ($l = getTodayYear() - 4; $l <= (getTodayYear()
            + 4); $l++) { ?>
        '<option value="<?php echo $l ?>"<?php if ($l == $jahr) {
            echo(" selected");
        } ?>>' +
        '<?php echo $l ?>'+
        '</option>' +
        <?php } ?>
        '</select>' +
        '</div>' +
        '</div>' +
        '<div class="form-group">' +
        '<label class="control-label col-sm-2">' +
        '<?php echo(getUebersetzung("bis", $sprache, $link)); ?>'+ ':'+
        '</label>' +
        '<div class="col-sm-3">' +
        '<select name="bisTag" class="form-control" id="bisTag">' +
        <?php for ($i = 1; $i <= 31; $i++) { ?>
        '<option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) {
            echo " selected";
        } ?>>' +
        '<?php echo($i); ?>'+
        '</option>' +
        <?php } ?>
        '</select>' +
        '</div>' +
        '<div class="col-sm-4">' +
        <!--  heutiges monat selectiert anzeigen: -->
        '<select name="bisMonat"  class="form-control" id="bisMonat" >' +
        '<option  value="1"<?php if (getTodayMonth() == "Januar") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Januar", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="2"<?php if (getTodayMonth() == "Februar") {
            echo " selected";
        } ?>>' +
        '<?php echo(getUebersetzung("Februar", $sprache, $link)); ?>'+
        '</option>' +
        '<option  value="3"<?php if (getTodayMonth() == "März") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("März", $sprache, $link)); ?>'+
        '</option>'+
        '<option  value="4"<?php if (getTodayMonth() == "April") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("April", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="5"<?php if (getTodayMonth() == "Mai") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("Mai", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="6"<?php if (getTodayMonth() == "Juni") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("Juni", $sprache, $link)); ?>'+
        '</option>' +
        '<option  value="7"<?php if (getTodayMonth() == "Juli") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("Juli", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="8"<?php if (getTodayMonth() == "August") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("August", $sprache, $link)); ?>'+
        '</option>' +
        '<option  value="9"<?php if (getTodayMonth() == "September") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("September", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="10"<?php if (getTodayMonth() == "Oktober") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("Oktober", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="11"<?php if (getTodayMonth() == "November") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("November", $sprache, $link)); ?>'+
        '</option>' +
        '<option value="12"<?php if (getTodayMonth() == "Dezember") {
            echo " selected";
        } ?>>'+
        '<?php echo(getUebersetzung("Dezember", $sprache, $link)); ?>'+
        '</option>' +
        '</select>' +
        '</div>' +
        '<div class="col-sm-3">' +
        <!--  heutiges jahr selectiert anzeigen: -->
        '<select name="bisJahr" class="form-control" id="bisJahr" >' +
        <?php for ($l = getTodayYear() - 4; $l <= (getTodayYear()
            + 4); $l++) { ?>
        '<option value="<?php echo($l); ?>"<?php if ($l == $jahr) {
            echo(" selected");
        } ?>>' +
        '<?php echo($l); ?>'+
        '</option>' +
        <?php } ?>
        '</select>' +
        '</div>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-sm-offset-6 col-sm-6" style="text-align: right;">' +
        '<input name="zimmer_id" type="hidden" id="zimmer_id_dialog" value="'+zimmer_id+'">' +
        '<button name="reservierungAendern" type="submit" class="btn btn-primary" id="reservierungAbsenden2">' +
        '<span class="glyphicon glyphicon-wrench"></span> ' +
        '<?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>'+
        '</button>' +
        '</div>' +
        '</div>' +
        '</form>';

        bootbox.dialog({
            title: "<?php echo(getUebersetzung(
                "Reservierung ändern", $sprache, $link
            )); ?>",
            onEscape:true,
            backdrop:true,
            message: html,
            callback: function (result) {
                console.log(result);
            }
        });
        $('#vonTag').val(fromDay);
        $('#vonMonat').val(fromMonth);
        $('#vonJahr').val(fromYear);

        $('#bisTag').val(toDay);
        $('#bisMonat').val(toMonth);
        $('#bisJahr').val(toYear);
    }

    function zimmer_idChanged(zimmer_id, zimmer_name) {

        var head = "Belegungsplan für " + zimmer_name;
        $('#fullyearView').children('.panel-heading').html(head);

        $('#zimmer_id').val(zimmer_id);
        setReservationInfo(zimmer_id);
    }

    $("#unterkunft_id").val('<?php echo $unterkunft_id;?>');
    $("#saAktiviert").val('<?php echo $saAktiviert;?>');

    var zimmers = [];

    var i = 0;
    var selectedZimmer = '<?php echo $zimmer_id;?>';
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
    if (!$res) {
        echo("Anfrage $query scheitert.");
    }
    while ($d = mysqli_fetch_array($res)) { ?>
    zimmers[i] = {
        "zimmerid":<?php echo $d["PK_ID"] ?>,
        "zimmerartnr": "<?php echo(getUebersetzungUnterkunft(
            $d["Zimmerart"], $sprache, $unterkunft_id, $link
        ));?>-<?php echo(getUebersetzungUnterkunft(
            $d["Zimmernr"], $sprache, $unterkunft_id, $link
        )); ?>"
    };
    <?php
    if ($zimmer_id == $d["PK_ID"]) { ?>
        selectedZimmer =<?php  echo $d["PK_ID"]; ?>;
    <?php } ?>
    i++;
    <?php } ?>

    var zimmerListHTML = "";
    $.each(zimmers,function (index, value) {

        zimmerListHTML += "<li><a onclick='zimmer_idChanged(\"" + value.zimmerid +"\",\"" +value.zimmerartnr +"\");'>" + value.zimmerartnr + "</a></li>";

    });
    $('#zimmers').html(zimmerListHTML);


</script>

