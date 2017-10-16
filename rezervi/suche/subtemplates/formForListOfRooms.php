<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>

<style>
    #imagelightbox {
        position: fixed;
        z-index: 9999;

        -ms-touch-action: none;
        touch-action: none;
    }
</style>
<noscript>
    <style>
        .es-carousel ul {
            display: block;
        }
    </style>
</noscript>

<form action="../anfrage/index.php"
      class="form-horizontal"
      method="post" name="reservierung"
      target="_self"
      id="reservierung">
    <input name="anzahlErwachsene"
           type="hidden"
           value="<?php echo($anzahlErwachsene); ?>"/>
    <input name="anzahlKinder"
           type="hidden"
           value="<?php echo($anzahlKinder); ?>"/>
    <input name="datumVon" type="hidden"
           value="<?php echo($datumDPv); ?>"/>
    <input name="datumBis" type="hidden"
           value="<?php echo($datumDPb); ?>"/>
    <input name="anzahlZimmer"
           type="hidden"
           value="<?php echo($anzahlZimmer); ?>"/>
    <input name="haustiere"
           type="hidden"
           value="<?php echo($haustiere); ?>"/>

    <div class="form-group">
        <div class="col-sm-12">
            <label>
                <?php echo(getUebersetzung(
                        "Freie",
                        $sprache,
                        $link
                    ) . " ");
                echo(getUebersetzungUnterkunft(
                    getZimmerart_MZ(
                        $unterkunft_id,
                        $link
                    ), $sprache,
                    $unterkunft_id,
                    $link
                ));
                echo(" "
                    . getUebersetzung(
                        "im gewünschten Zeitraum",
                        $sprache,
                        $link
                    ) . ":");
                ?>
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <?php
            if (count(
                    $freieZimmer
                ) > 1
            ) {
                echo(getUebersetzung(
                        "Bitte wählen Sie die gewünschten",
                        $sprache,
                        $link
                    ) . " ");
                echo(getUebersetzungUnterkunft(
                    getZimmerart_MZ(
                        $unterkunft_id,
                        $link
                    ), $sprache,
                    $unterkunft_id,
                    $link
                ));
                echo(" "
                    . getUebersetzung(
                        "aus",
                        $sprache,
                        $link
                    ) . ".");
            } else {
                echo(getUebersetzung(
                        "Bitte wählen Sie das gewünschte",
                        $sprache,
                        $link
                    ) . " ");
                echo(getUebersetzungUnterkunft(
                    getZimmerart_EZ(
                        $unterkunft_id,
                        $link
                    ), $sprache,
                    $unterkunft_id,
                    $link
                ));
                echo(" "
                    . getUebersetzung(
                        "aus",
                        $sprache,
                        $link
                    ) . ".");
            }
            ?>
        </div>
    </div>

    <div>
        <ul class="nav nav-tabs" role="tablist">
            <?php
            $index = 0;
            $zaehle = 0;
            $zaehleEinschraenkungen = 0;
            foreach ($freieZimmer as $zimmer_id) {
                if (isset($zimmerIdsParents) && count($zimmerIdsParents) > 0) {
                    foreach ($zimmerIdsParents as $par) {
                        if ($zimmer_id != $par) {
                            //echo("continue: freies zimmer:".$zimmer_id);
                            continue 2;
                        }
                    }
                }
                $zaehle++;
                ?>

                <li role="presentation" <?php if ($index < 1) echo 'class="active"'; ?>>

                    <a role="tab" data-toggle="tab"

                       href="#zimmer_<?php echo $zimmer_id; ?>"
                       aria-controls="zimmer_<?php echo $zimmer_id; ?>">
                        <?php
                        //checking if Link should be activated
                        $res = getPropertiesSuche(
                            $unterkunft_id, $link
                        ); //Methode in einstellungenFunctions.php definiert

                        while ($d = mysqli_fetch_array(
                            $res
                        )) {

                            if ($d["Name"] == LINK_SUCHE) {

                                $name = $d["Name"];

                                //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
                                $aktiviert
                                    = isPropertyShown(
                                    $unterkunft_id,
                                    $name, $link
                                ); //Methode in einstellungenFunctions.php definiert
                                if ($aktiviert == 'true') {

                                    $uri
                                        = getLink(
                                        $unterkunft_id,
                                        $zimmer_id,
                                        $link
                                    );
                                    if ($uri != "") {
                                        echo '<a href="' . $uri . '" target="_blank">' . getZimmerArt($unterkunft_id, $zimmer_id, $link) . ' ' . getZimmerNr($unterkunft_id, $zimmer_id, $link) . '</a>';
                                        echo((getZimmerArt(
                                                $unterkunft_id,
                                                $zimmer_id,
                                                $link
                                            )) . " "
                                            . (getZimmerNr(
                                                $unterkunft_id,
                                                $zimmer_id,
                                                $link
                                            )));
                                    } else {

                                        echo((getZimmerArt(
                                                $unterkunft_id,
                                                $zimmer_id,
                                                $link
                                            )) . " "
                                            . (getZimmerNr(
                                                $unterkunft_id,
                                                $zimmer_id,
                                                $link
                                            )));
                                    }
                                } else {
                                    echo((getZimmerArt(
                                            $unterkunft_id,
                                            $zimmer_id,
                                            $link
                                        )) . " "
                                        . (getZimmerNr(
                                            $unterkunft_id,
                                            $zimmer_id,
                                            $link
                                        )));
                                }
                            }
                        }

                        ?>
                    </a>


                </li>
                <?php
                //button nur anzeigen wenn es auch zimmer ohne einschraenkungen gibt:
                $index++;
            }
            ?>

        </ul>
        <div class="tab-content">
            <?php
            $index = 0;
            $zaehle = 0;
            $zaehleEinschraenkungen = 0;
            foreach ($freieZimmer as $zimmer_id) {
                if (isset($zimmerIdsParents) && count($zimmerIdsParents) > 0) {
                    foreach ($zimmerIdsParents as $par) {
                        if ($zimmer_id != $par) {
                            //echo("continue: freies zimmer:".$zimmer_id);
                            continue 2;
                        }
                    }
                }
                $zaehle++;
                ?>


                <div role="tabpanel" class="tab-pane  <?php if ($index < 1) echo 'active'; ?>"
                     id="zimmer_<?php echo $zimmer_id; ?>" style="padding: 10px;">
                    <div class="form-group" style="margin-top: 10px;">
                        <div class="col-sm-2">
                            <label>
                                <?php echo getUebersetzung("wahl die Zimmer", $sprache, $link); ?>
                            </label>
                        </div>
                        <div class="col-sm-10">
                            <?php
                            //pruefe ob fuer das zimmer eine buchungseinschraenkung besteht.
                            //wenn ja dann kann es nicht ausgewaehlt werden
                            //und es wird ein infotext ausgegeben.
                            if (isset($zi_temp)) {
                                unset($zi_temp);
                            }
                            $zi_temp
                                = array();
                            $zi_temp[0]
                                = $zimmer_id;

                            if (hasActualBuchungsbeschraenkungen($unterkunft_id)
                                && !checkBuchungseinschraenkung(
                                    $vonTag,
                                    $vonMonat,
                                    $vonJahr,
                                    $bisTag,
                                    $bisMonat,
                                    $bisJahr,
                                    $zi_temp
                                )
                            ) {
                                echo(getBuchungseinschraenkungText(
                                    $vonTag,
                                    $vonMonat,
                                    $vonJahr,
                                    $bisTag,
                                    $bisMonat,
                                    $bisJahr,
                                    $zi_temp
                                ));
                                echo(": ");
                                $zaehleEinschraenkungen++;
                            } else {
                                ?>

                                <input name="zimmer_ids" class="zimmer_id" id="zimmer_id_<?php echo $zimmer_id; ?>"
                                       onchange="checkboxChanged(this,'<?php echo $zimmer_id; ?>')"
                                       type="checkbox"/>

                            <?php } ?>

                        </div>
                    </div>
                    <?php
                    $index++;
                    //bilder anzeigen, falls vorhanden und gewünscht:
                    if (isPropertyShown($unterkunft_id, ZIMMER_THUMBS_ACTIV, $link)) {
                        ?>
                        <?php
                        if (hasZimmerBilder($zimmer_id, $link)) {
                            ?>
                            <!--                        <div class="form-group">-->
                            <!--                            <div class="col-md-offset-2 col-md-8" id="imageGallery--><?php //echo $zimmer_id; ?><!--">-->
                            <!--                            </div>-->
                            <!--                        </div>-->

                            <script>
                                $(function () {
                                    // ======================= imagesLoaded Plugin ===============================
                                    // https://github.com/desandro/imagesloaded

                                    // $('#my-container').imagesLoaded(myFunction)
                                    // execute a callback when all images have loaded.
                                    // needed because .load() doesn't work on cached images

                                    // callback function gets image collection as argument
                                    //  this is the container

                                    // original: mit license. paul irish. 2010.
                                    // contributors: Oren Solomianik, David DeSandro, Yiannis Chatzikonstantinou

                                    $.fn.imagesLoaded = function (callback) {
                                        var $images = this.find('img'),
                                            len = $images.length,
                                            _this = this,
                                            blank = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';

                                        function triggerCallback() {
                                            callback.call(_this, $images);
                                        }

                                        function imgLoaded() {
                                            if (--len <= 0 && this.src !== blank) {
                                                setTimeout(triggerCallback);
                                                $images.off('load error', imgLoaded);
                                            }
                                        }

                                        if (!len) {
                                            triggerCallback();
                                        }

                                        $images.on('load error', imgLoaded).each(function () {
                                            // cached images don't fire load sometimes, so we reset src.
                                            if (this.complete || this.complete === undefined) {
                                                var src = this.src;
                                                // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
                                                // data uri bypasses webkit log warning (thx doug jones)
                                                this.src = blank;
                                                this.src = src;
                                            }
                                        });

                                        return this;
                                    };

                                    // gallery container
                                    var $rgGallery = $('#rg-gallery<?php echo $zimmer_id; ?>'),
                                        // carousel container
                                        $esCarousel = $rgGallery.find('div.es-carousel-wrapper'),
                                        // the carousel items
                                        $items = $esCarousel.find('ul > li'),
                                        // total number of items
                                        itemsCount = $items.length;

                                    Gallery = (function () {
                                        // index of the current item
                                        var current = 0,
                                            // mode : carousel || fullview
                                            mode = 'carousel',
                                            // control if one image is being loaded
                                            anim = false,
                                            init = function () {

                                                // (not necessary) preloading the images here...
                                                $items.add('<img src="../libs/ResponsiveImageGallery/images/ajax-loader.gif"/><img src="../libs/ResponsiveImageGallery/images/black.png"/>').imagesLoaded(function () {
                                                    // add options
                                                    _addViewModes();

                                                    // add large image wrapper
                                                    _addImageWrapper();

                                                    // show first image
                                                    _showImage($items.eq(current));

                                                });

                                                // initialize the carousel
                                                if (mode === 'carousel')
                                                    _initCarousel();

                                            },
                                            _initCarousel = function () {

                                                // we are using the elastislide plugin:
                                                // http://tympanus.net/codrops/2011/09/12/elastislide-responsive-carousel/
                                                $esCarousel.show().elastislide({
                                                    imageW: 65,
                                                    onClick: function ($item) {
                                                        if (anim) return false;
                                                        anim = true;
                                                        // on click show image
                                                        _showImage($item);
                                                        // change current
                                                        current = $item.index();
                                                    }
                                                });

                                                // set elastislide's current to current
                                                $esCarousel.elastislide('setCurrent', current);

                                            },
                                            _addViewModes = function () {

                                                // top right buttons: hide / show carousel

                                                var $viewfull = $('<a href="#" class="rg-view-full"></a>'),
                                                    $viewthumbs = $('<a href="#" class="rg-view-thumbs rg-view-selected"></a>');

                                                $rgGallery.prepend($('<div class="rg-view"/>').append($viewfull).append($viewthumbs));

                                                $viewfull.on('click.rgGallery', function (event) {
                                                    if (mode === 'carousel')
                                                        $esCarousel.elastislide('destroy');
                                                    $esCarousel.hide();
                                                    $viewfull.addClass('rg-view-selected');
                                                    $viewthumbs.removeClass('rg-view-selected');
                                                    mode = 'fullview';
                                                    return false;
                                                });

                                                $viewthumbs.on('click.rgGallery', function (event) {
                                                    _initCarousel();
                                                    $viewthumbs.addClass('rg-view-selected');
                                                    $viewfull.removeClass('rg-view-selected');
                                                    mode = 'carousel';
                                                    return false;
                                                });

                                                if (mode === 'fullview')
                                                    $viewfull.trigger('click');

                                            },
                                            _addImageWrapper = function () {

                                                // adds the structure for the large image and the navigation buttons (if total items > 1)
                                                // also initializes the navigation events

                                                $('#img-wrapper-tmpl<?php echo $zimmer_id;?>').tmpl({itemsCount: itemsCount}).appendTo($rgGallery);

                                                if (itemsCount > 1) {
                                                    // addNavigation
                                                    var $navPrev = $rgGallery.find('a.rg-image-nav-prev'),
                                                        $navNext = $rgGallery.find('a.rg-image-nav-next'),
                                                        $imgWrapper = $rgGallery.find('div.rg-image');

                                                    $navPrev.on('click.rgGallery', function (event) {
                                                        _navigate('left');
                                                        return false;
                                                    });

                                                    $navNext.on('click.rgGallery', function (event) {
                                                        _navigate('right');
                                                        return false;
                                                    });

                                                    // add touchwipe events on the large image wrapper
                                                    $imgWrapper.touchwipe({
                                                        wipeLeft: function () {
                                                            _navigate('right');
                                                        },
                                                        wipeRight: function () {
                                                            _navigate('left');
                                                        },
                                                        preventDefaultEvents: false
                                                    });

                                                    $(document).on('keyup.rgGallery', function (event) {
                                                        if (event.keyCode == 39)
                                                            _navigate('right');
                                                        else if (event.keyCode == 37)
                                                            _navigate('left');
                                                    });

                                                }

                                            },
                                            _navigate = function (dir) {

                                                // navigate through the large images

                                                if (anim) return false;
                                                anim = true;

                                                if (dir === 'right') {
                                                    if (current + 1 >= itemsCount)
                                                        current = 0;
                                                    else
                                                        ++current;
                                                }
                                                else if (dir === 'left') {
                                                    if (current - 1 < 0)
                                                        current = itemsCount - 1;
                                                    else
                                                        --current;
                                                }

                                                _showImage($items.eq(current));

                                            },
                                            _showImage = function ($item) {

                                                // shows the large image that is associated to the $item

                                                var $loader = $rgGallery.find('div.rg-loading').show();

                                                $items.removeClass('selected');
                                                $item.addClass('selected');

                                                var $thumb = $item.find('img'),
                                                    largesrc = $thumb.data('large'),
                                                    title = $thumb.data('description');

                                                $('<img/>').load(function () {

                                                    $rgGallery.find('div.rg-image').empty().append('<img src="' + largesrc + '"/>');

                                                    if (title)
                                                        $rgGallery.find('div.rg-caption').show().children('p').empty().text(title);

                                                    $loader.hide();

                                                    if (mode === 'carousel') {
                                                        $esCarousel.elastislide('reload');
                                                        $esCarousel.elastislide('setCurrent', current);
                                                    }

                                                    anim = false;

                                                }).attr('src', largesrc);

                                            },
                                            addItems = function ($new) {

                                                $esCarousel.find('ul').append($new);
                                                $items = $items.add($($new));
                                                itemsCount = $items.length;
                                                $esCarousel.elastislide('add', $new);

                                            };

                                        return {
                                            init: init,
                                            addItems: addItems
                                        };

                                    })();

                                    Gallery.init();

                                    /*
                                     Example to add more items to the gallery:

                                     var $new  = $('<li><a href="#"><img src="images/thumbs/1.jpg" data-large="images/1.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" /></a></li>');
                                     Gallery.addItems( $new );
                                     */
                                });
                            </script>
                            <script id="img-wrapper-tmpl<?php echo $zimmer_id; ?>" type="text/x-jquery-tmpl">
                            <div class="rg-image-wrapper">
                                {{if itemsCount > 1}}
                                    <div class="rg-image-nav">
                                        <a href="#" class="rg-image-nav-prev">Previous Image</a>
                                        <a href="#" class="rg-image-nav-next">Next Image</a>
                                    </div>
                                {{/if}}
                                <div class="rg-image"></div>
                                <div class="rg-loading"></div>
                                <div class="rg-caption-wrapper">
                                    <div class="rg-caption" style="display:none;">
                                        <p></p>
                                    </div>
                                </div>
                            </div>



                            </script>
                            <div id="rg-gallery<?php echo $zimmer_id; ?>" class="rg-gallery">
                                <div class="rg-thumbs">
                                    <!-- Elastislide Carousel Thumbnail Viewer -->
                                    <div class="es-carousel-wrapper">
                                        <div class="es-nav">
                                            <span class="es-nav-prev">Previous</span>
                                            <span class="es-nav-next">Next</span>
                                        </div>
                                        <div class="es-carousel">
                                            <ul id="es-carousel-list<?php echo $zimmer_id; ?>">
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- End Elastislide Carousel Thumbnail Viewer -->
                                </div><!-- rg-thumbs -->
                            </div><!-- rg-gallery -->

                            <script>

                                var lightboxImagesHTML = "";
                                var i = 1;
                                <?php
                                $result = getBilderOfZimmer($zimmer_id, $link);
                                $i = 1;
                                while ($z = mysqli_fetch_array($result)) {

                                $pfad = $z["Pfad"];
                                $pfad_thumbs = $z["Pfad_Thumbnail"];
                                if (!isset($pfad_thumbs))
                                    $pfad_thumbs = $pfad;
                                $beschreibung = $z["Beschreibung"];
                                //                            $pfad = substr(
                                //                                $pfad, 3,
                                //                                strlen($pfad)
                                //                            );
                                $width
                                    = $z["Width"];
                                $height
                                    = $z["Height"];
                                ?>

                                lightboxImagesHTML += '<li><a href="#" img-alt="<?php echo $beschreibung; ?>" data-imagelightbox="f<?php echo $zimmer_id;?>">' +
                                    '<img src="<?php echo($pfad_thumbs); ?>" data-large="<?php echo($pfad); ?>" alt="<?php echo $beschreibung; ?>" data-description="<?php echo $beschreibung; ?>" />' +
                                    '</a></li>';

                                <?php
                                $i++;
                                }
                                ?>
                                $('#es-carousel-list<?php echo $zimmer_id; ?>').html(lightboxImagesHTML);
                            </script>

                            <?php
                        }
                        ?>

                        <?php
                    }
                    ?>

                </div>


                <?php
                //button nur anzeigen wenn es auch zimmer ohne einschraenkungen gibt:
            }
            ?>
        </div>
    </div>
</form>
<script>
    function checkboxChanged(el, id) {
        $.each($('.zimmer_id'), function () {
            if ($(this).attr('id') != "zimmer_id_" + id) {
                $(this).prop('checked', false);
            }
        })
    }
</script>


<form action="./index.php"
      method="post"
      name="sucheWiederholen"
      id="sucheWiederholen"
      target="_self">
    <div class="form-group">
        <div class="col-sm-12" style="text-align: right;">
            <input name="anzahlErwachsene"
                   type="hidden"
                   value="<?php echo($anzahlErwachsene); ?>"/>
            <input name="anzahlKinder"
                   type="hidden"
                   value="<?php echo($anzahlKinder); ?>"/>
            <input name="datumVon"
                   type="hidden"
                   value="<?php echo($datumDPv); ?>"/>
            <input name="datumBis"
                   type="hidden"
                   value="<?php echo($datumDPb); ?>"/>
            <input name="anzahlZimmer"
                   type="hidden"
                   value="<?php echo($anzahlZimmer); ?>"/>
            <input name="haustiere"
                   type="hidden"
                   value="<?php echo($haustiere); ?>"/>
            <input name="keineSprache"
                   type="hidden"
                   value="true"/>
            <?php
            if (isset($zimmerIdsParents)
                && count(
                    $zimmerIdsParents
                ) > 0
            ) {
                ?>
                <input name="zimmerIdsParents"
                       type="hidden"
                       value="<?php
                       foreach (
                           $zimmerIdsParents
                           as
                           $ziidpa
                       ) {
                           echo($ziidpa
                               . ",");
                       }
                       ?>"/>
                <?php
            }
            ?>

        </div>
    </div>
</form>

<?php
if ($zaehleEinschraenkungen < $zaehle) {
    ?>
    <div class="form-group">
        <div class="col-sm-12" style="text-align: right;">
            <button
                    name="reservierungAbsenden"
                    type="submit"
                    class="btn btn-success"
                    id="reservierungAbsenden"
                    onclick="submitReservierungForm();"
            >
                <?php echo(getUebersetzung(
                    "Reservierung starten...",
                    $sprache,
                    $link
                )); ?>
            </button>

            <button type="submit" name="Submit" class="btn btn-default" onclick="submitSucheWiederholenForm();">
                <?php echo(getUebersetzung(
                    "Suche wiederholen",
                    $sprache,
                    $link
                )); ?>
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </div>
    </div>
    <script>
        function submitReservierungForm() {
            $('#reservierung').submit();
        }

        function submitSucheWiederholenForm() {
            $('#sucheWiederholen').submit();
        }
    </script>
    <?php
} else {
    $freieZimmer[0] = -1;
}
?>
