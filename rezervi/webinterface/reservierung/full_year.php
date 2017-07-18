<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

?>

<?php
//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$sprache       = getSessionWert(SPRACHE);

if (isset($_POST["zimmer_id"])) {
    $zimmer_id = $_POST["zimmer_id"];
}
else {
    $zimmer_id = getFirstRoom($unterkunft_id, $link);
}
if (isset($_POST["monat"])) {
    $monat = $_POST["monat"];
}
else {
    $monat = parseMonthNumber(getTodayMonth());
}
if (isset($_POST["jahr"])) {
    $jahr = $_POST["jahr"];
}
else {
    $jahr = getTodayYear();
}
//ich brauche für jahr einen integer:
$jahr += 1;
$jahr -= 1;
//und fürs monat einen integer
$monat -= 1;
$monat += 1;

$sprache = getSessionWert(SPRACHE);


setSessionWert(ZIMMER_ID, $zimmer_id);
?>

<div class="panel panel-default" id="fullyearView">
    <div class="panel-heading">
        <?php echo(getUebersetzung("Belegungsplan", $sprache, $link)); ?>
        <?php echo(getUebersetzung(
            "für", $sprache, $link
        )); ?> <?php echo(getUebersetzungUnterkunft(
            getZimmerArt($unterkunft_id, $zimmer_id, $link), $sprache,
            $unterkunft_id, $link
        )); ?>
        -<?php echo(getUebersetzungUnterkunft(
            getZimmerNr($unterkunft_id, $zimmer_id, $link), $sprache,
            $unterkunft_id, $link
        )); ?>
    </div>
    <div class="panel-body">
        <div id="calendar"></div>
    </div>
</div>

<script>

        var selectedYear = new Date().getFullYear();
        var selectedZimmer = '<?php echo $zimmer_id; ?>';

        loadFullYearCalendar();
        setReservationInfo(null);


    function setReservationInfo(zimmerid){
        if(!zimmerid)
            selectedZimmer = $('#zimmer_id').val();
        else
            selectedZimmer = zimmerid;
        var currentYear = selectedYear;

        var data = {
            'year': currentYear,
            'zimmer_id': selectedZimmer,
            'unterkunft_id': $('#unterkunft_id').val(),
            'saAktiviert': $('#saAktiviert').val(),
        };
        var dataSource = [];

        $.post("<?php echo $URL; ?>webinterface/reservierung/subtemplates/full_year_helper.php", data, function (response) {

            $.each(response, function (index, value) {

                var dateFromArray = value.date_from.split('-');
                var dateFrom = new Date(dateFromArray[0], parseInt(dateFromArray[1]-1), dateFromArray[2]);
                var dateTorray = value.date_to.split('-');
                var dateTo = new Date(dateTorray[0], parseInt(dateTorray[1]-1), dateTorray[2]);

                var row = {
                    id:index,
                    startDate:dateFrom,
                    endDate:dateTo,
                    guest_id:value.guest_id,
                    name: value.vorname + " " + value.nachname,
                    phone: value.tel,
                    location: value.strasse + " " + value.plz + " " + value.ort,
                    zimmer: value.zimmerArt + " " + value.zimmernr

                };
                dataSource.push(row);
            });

            $('#calendar').data('calendar').setDataSource(dataSource);
        });
    }

    function loadFullYearCalendar() {

        $('#calendar').calendar({
            language: '<?php echo $sprache;?>',
            displayWeekNumber: true,
            enableContextMenu: false,
            enableRangeSelection: true,
            contextMenuItems: [
                {
                    text: '<?php echo getUebersetzung("Aktulisieren",$sprache,$link)?>',
                    click: function () {

                    }
                },
                {
                    text: '<?php echo getUebersetzung("Löschen",$sprache,$link)?>',
                    click: function () {

                    }
                }
            ],

            selectRange: function (e) {

                var startDate = e.startDate;
                var startDateDay = startDate.getDate();
                var startDateMonth = startDate.getMonth()+1;
                var startDateYear = startDate.getFullYear();

                var endDate = e.endDate;
                var endDateDay = endDate.getDate();
                var endDateMonth = endDate.getMonth()+1;
                var endDateYear = endDate.getFullYear();

                console.log(e);

                console.log($('#calendar').data('calendar').getDataSource());

                showReservierungAendernDialog(startDateDay,startDateMonth,startDateYear,endDateDay,endDateMonth,endDateYear);
            },
            mouseOnDay: function (e) {
                if (e.events.length > 0) {
                    var content = '';
                    for (var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                            + '<div class="event-name" style="color:' + e.events[i].color + '"><a href="'+e.events[i].guest_id+'" target="_blank">' + e.events[i].name + '</a></div>'
                            + '<div class="event-phone">' + e.events[i].phone + '</div>'
                            + '<div class="event-location">' + e.events[i].location + '</div>'
                            + '<div class="event-zimmer">' + e.events[i].zimmer + '</div>'
                            + '</div>';
                    }

                    $(e.element).popover({
                        trigger: 'manual',
                        container: 'body',
                        html: true,
                        content: content
                    });

                    $(e.element).popover('show');
                }
            },
            mouseOutDay: function (e) {
                if (e.events.length > 0) {
                    $(e.element).popover('hide');
                }
            },
            dayContextMenu: function (e) {
                $(e.element).popover('hide');
            },
            renderEnd:function (e) {
                if(e.currentYear != selectedYear){
                    selectedYear = e.currentYear;
                    setReservationInfo();
                }
            }
        });
    }

</script>
