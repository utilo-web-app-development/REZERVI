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
    #imagelightbox
    {
        position: fixed;
        z-index: 9999;

        -ms-touch-action: none;
        touch-action: none;
    }
</style>
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
            }
            else {
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
    <?php
    $zaehle                 = 0;
    $zaehleEinschraenkungen = 0;
    foreach ($freieZimmer as $zimmer_id) {
        if (isset($zimmerIdsParents) && count($zimmerIdsParents) > 0 ) {
            foreach (  $zimmerIdsParents as $par) {
                if ($zimmer_id  != $par  ) {
                    //echo("continue: freies zimmer:".$zimmer_id);
                    continue 2;
                }
            }
        }
        $zaehle++;
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>

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
                    if ($aktiviert
                    == 'true'
                    ) {
                    ?>

                    <?php
                    $uri
                        = getLink(
                        $unterkunft_id,
                        $zimmer_id,
                        $link
                    );
                    if ($uri
                    != "")
                    {
                    ?>
                    <a href="<?php echo($uri); ?>"
                       class="standardSchrift">
                        <?php
                        }
                        ?>
                        <?php
                        echo((getZimmerArt(
                                $unterkunft_id,
                                $zimmer_id,
                                $link
                            ))
                            . " "
                            . (getZimmerNr(
                                $unterkunft_id,
                                $zimmer_id,
                                $link
                            ))); ?>
                        <?php
                        if ($uri
                        != "") {
                        ?>
                    </a>
                <?php
                }
                ?>

                    <?php
                    }
                    else {
                        ?>

                        <?php
                        echo((getZimmerArt(
                                $unterkunft_id,
                                $zimmer_id,
                                $link
                            )) . " "
                            . (getZimmerNr(
                                $unterkunft_id,
                                $zimmer_id,
                                $link
                            ))); ?>

                        <?php
                    }
                    }
                    }
                    ?>
                    </h5>
                <span style="float: right;"></span>
            </div>

            <div class="panel-body">
                <?php
                //bilder anzeigen, falls vorhanden und gewünscht:
                if (isPropertyShown( $unterkunft_id,  ZIMMER_THUMBS_ACTIV, $link )) {
                    ?>
                    <?php
                    if (hasZimmerBilder(  $zimmer_id, $link )) {
                        ?>
                        <div class="form-group" >
                            <div class="col-md-offset-2 col-md-8" id="imageGallery<?php echo $zimmer_id; ?>">
                            </div>
                        </div>
                        <script>
                            //    $( function()
                            //    {
                            //        $( 'a<?php //echo $zimmer_id; ?>//' ).imageLightbox();
                            //    });


                            $( function()
                            {
                                var
                                        /* ACTIVITY INDICATOR */

                                    activityIndicatorOn = function()
                                    {
                                        $( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
                                    },
                                    activityIndicatorOff = function()
                                    {
                                        $( '#imagelightbox-loading' ).remove();
                                    },


                                        /* OVERLAY*/

                                    overlayOn = function()
                                    {
                                        $( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
                                    },
                                    overlayOff = function()
                                    {
                                        $( '#imagelightbox-overlay' ).remove();
                                    },


                                        /* CLOSE BUTTON */

                                    closeButtonOn = function( instance )
                                    {
                                        $( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
                                    },
                                    closeButtonOff = function()
                                    {
                                        $( '#imagelightbox-close' ).remove();
                                    },


                                        /* CAPTION */

                                    captionOn = function()
                                    {
                                        var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
                                        console.log(description);
                                        if( description.length > 0 )
                                            $( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
                                    },
                                    captionOff = function()
                                    {
                                        $( '#imagelightbox-caption' ).remove();
                                    },


                                        /* NAVIGATION */

                                    navigationOn = function( instance, selector )
                                    {
                                        var images = $( selector );
                                        if( images.length )
                                        {
                                            var nav = $( '<div id="imagelightbox-nav"></div>' );
                                            for( var i = 0; i < images.length; i++ )
                                                nav.append( '<button type="button"></button>' );

                                            nav.appendTo( 'body' );
                                            nav.on( 'click touchend', function(){ return false; });

                                            var navItems = nav.find( 'button' );
                                            navItems.on( 'click touchend', function()
                                            {
                                                var $this = $( this );
                                                if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
                                                    instance.switchImageLightbox( $this.index() );

                                                navItems.removeClass( 'active' );
                                                navItems.eq( $this.index() ).addClass( 'active' );

                                                return false;
                                            })
                                                .on( 'touchend', function(){ return false; });
                                        }
                                    },
                                    navigationUpdate = function( selector )
                                    {
                                        var items = $( '#imagelightbox-nav button' );
                                        items.removeClass( 'active' );
                                        items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
                                    },
                                    navigationOff = function()
                                    {
                                        $( '#imagelightbox-nav' ).remove();
                                    },


                                        /* ARROWS */

                                    arrowsOn = function( instance, selector )
                                    {
                                        var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

                                        $arrows.appendTo( 'body' );

                                        $arrows.on( 'click touchend', function( e )
                                        {
                                            e.preventDefault();

                                            var $this	= $( this ),
                                                $target	= $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
                                                index	= $target.index( selector );

                                            if( $this.hasClass( 'imagelightbox-arrow-left' ) )
                                            {
                                                index = index - 1;
                                                if( !$( selector ).eq( index ).length )
                                                    index = $( selector ).length;
                                            }
                                            else
                                            {
                                                index = index + 1;
                                                if( !$( selector ).eq( index ).length )
                                                    index = 0;
                                            }

                                            instance.switchImageLightbox( index );
                                            return false;
                                        });
                                    },
                                    arrowsOff = function()
                                    {
                                        $( '.imagelightbox-arrow' ).remove();
                                    };


                                /*	WITH ACTIVITY INDICATION */

                                $( 'a[data-imagelightbox="a"]' ).imageLightbox(
                                    {
                                        onLoadStart:	function() { activityIndicatorOn(); },
                                        onLoadEnd:		function() { activityIndicatorOff(); },
                                        onEnd:	 		function() { activityIndicatorOff(); }
                                    });


                                /*	WITH OVERLAY & ACTIVITY INDICATION */

                                $( 'a[data-imagelightbox="b"]' ).imageLightbox(
                                    {
                                        onStart: 	 function() { overlayOn(); },
                                        onEnd:	 	 function() { overlayOff(); activityIndicatorOff(); },
                                        onLoadStart: function() { activityIndicatorOn(); },
                                        onLoadEnd:	 function() { activityIndicatorOff(); }
                                    });


                                /*	WITH "CLOSE" BUTTON & ACTIVITY INDICATION */

                                var instanceC = $( 'a[data-imagelightbox="c"]' ).imageLightbox(
                                    {
                                        quitOnDocClick:	false,
                                        onStart:		function() { closeButtonOn( instanceC ); },
                                        onEnd:			function() { closeButtonOff(); activityIndicatorOff(); },
                                        onLoadStart: 	function() { activityIndicatorOn(); },
                                        onLoadEnd:	 	function() { activityIndicatorOff(); }
                                    });


                                /*	WITH CAPTION & ACTIVITY INDICATION */

                                $( 'a[data-imagelightbox="d"]' ).imageLightbox(
                                    {
                                        onLoadStart: function() { captionOff(); activityIndicatorOn(); },
                                        onLoadEnd:	 function() { captionOn(); activityIndicatorOff(); },
                                        onEnd:		 function() { captionOff(); activityIndicatorOff(); }
                                    });


                                /*	WITH ARROWS & ACTIVITY INDICATION */

                                var selectorG = 'a[data-imagelightbox="g"]';
                                var instanceG = $( selectorG ).imageLightbox(
                                    {
                                        onStart:		function(){ arrowsOn( instanceG, selectorG ); },
                                        onEnd:			function(){ arrowsOff(); activityIndicatorOff(); },
                                        onLoadStart: 	function(){ activityIndicatorOn(); },
                                        onLoadEnd:	 	function(){ $( '.imagelightbox-arrow' ).css( 'display', 'block' ); activityIndicatorOff(); }
                                    });


                                /*	WITH NAVIGATION & ACTIVITY INDICATION */

                                var selectorE = 'a[data-imagelightbox="e"]';
                                var instanceE = $( selectorE ).imageLightbox(
                                    {
                                        onStart:	 function() { navigationOn( instanceE, selectorE ); },
                                        onEnd:		 function() { navigationOff(); activityIndicatorOff(); },
                                        onLoadStart: function() { activityIndicatorOn(); },
                                        onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
                                    });


                                /*	ALL COMBINED */

                                var selectorF = 'a[data-imagelightbox="f<?php echo $zimmer_id; ?>"]';
                                var instanceF = $( selectorF ).imageLightbox(
                                    {
                                        onStart:		function() { overlayOn(); closeButtonOn( instanceF ); arrowsOn( instanceF, selectorF ); },
                                        onEnd:			function() { overlayOff(); captionOff(); closeButtonOff(); arrowsOff(); activityIndicatorOff(); },
                                        onLoadStart: 	function() { captionOff(); activityIndicatorOn(); },
                                        onLoadEnd:	 	function() { captionOn(); activityIndicatorOff(); $( '.imagelightbox-arrow' ).css( 'display', 'block' ); }
                                    });


                                /*	DYNAMICALLY ADDED ITEMS */

                                var instanceH = $( 'a[data-imagelightbox="h"]' ).imageLightbox(
                                    {
                                        quitOnDocClick:	false,
                                        onStart:		function() { closeButtonOn( instanceH ); },
                                        onEnd:			function() { closeButtonOff(); activityIndicatorOff(); },
                                        onLoadStart: 	function() { activityIndicatorOn(); },
                                        onLoadEnd:	 	function() { activityIndicatorOff(); }
                                    });

                                $( '.js--add-dynamic ' ).on( 'click', function( e )
                                {
                                    e.preventDefault();
                                    var items = $( '.js--dynamic-items' );
                                    instanceH.addToImageLightbox( items.find( 'a' ) );
                                    $( '.js--dynamic-place' ).append( items.find( 'li' ).detach() );
                                    $( this ).remove();
                                    items.remove();
                                });

                            });

                            function checkboxChanged(el, id) {
                                $.each($('.zimmer_id'),function () {
                                    if($(this).attr('id') != "zimmer_id_"+id){
                                        $(this).prop('checked',false);
                                    }
                                })
                            }
                        </script>
                        <script>
                            $(document).on('click', '[data-toggle="lightbox<?php echo $zimmer_id;?>"]', function(event) {
                                //event.preventDefault();
                                //$(this).ekkoLightbox();
                            });

                            var lightboxImagesHTML = "";
                            var i = 1;
                            <?php
                            $result = getBilderOfZimmer( $zimmer_id, $link);
                            $i = 1;
                            while ($z  = mysqli_fetch_array(  $result )) {
                            if($i % 3 == 1){
                            ?>
                            lightboxImagesHTML +='<div class="row" style="margin-bottom: 15px;">';
                            <?php
                            }
                            ?>
                            <?php

                            $pfad = $z["Pfad"];
                            $beschreibung = $z["Beschreibung"];
                            $pfad = substr(
                                $pfad, 3,
                                strlen($pfad)
                            );
                            $width
                                = $z["Width"];
                            $height
                                = $z["Height"];
                            ?>
//                            lightboxImagesHTML +='<a href="<?php //echo($pfad); ?>//" data-toggle="lightbox<?php //echo $zimmer_id; ?>//" data-gallery="gallery<?php //echo $zimmer_id; ?>//" class="col-sm-4">'+
//                             '<img style="max-width:100%; height:auto;" src="<?php //echo($pfad); ?>//" class="img-fluid">'+
//                             '</a>';

                            lightboxImagesHTML +='<a href="<?php echo($pfad); ?>" img-alt="<?php echo $beschreibung; ?>" data-imagelightbox="f<?php echo $zimmer_id;?>" class="col-sm-4">'+
                                '<img style="max-width:100%; height:auto;" src="<?php echo($pfad); ?>" alt="<?php echo $beschreibung; ?>" class="img-fluid">'+
                                '</a>';

                            <?php
                            if($i % 3 == 0){
                            ?>
                            lightboxImagesHTML +='</div>';
                            <?php
                            }
                            ?>
                            <?php
                            $i++;
                            }
                            ?>
                            $('#imageGallery<?php echo $zimmer_id; ?>').html(lightboxImagesHTML);
                        </script>
                        <?php
                    }
                    ?>

                    <?php
                }
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
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

                        if (hasActualBuchungsbeschraenkungen( $unterkunft_id )
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
                        }
                        else {
                            ?>

                            <input name="zimmer_ids" class="zimmer_id" id="zimmer_id_<?php echo $zimmer_id; ?>" onchange="checkboxChanged(this,'<?php echo $zimmer_id;?>')" type="checkbox"/>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

        <?php
        //button nur anzeigen wenn es auch zimmer ohne einschraenkungen gibt:
    }
    ?>

</form>


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
if ($zaehleEinschraenkungen < $zaehle ) {
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
}
else {
    $freieZimmer[0] = -1;
}
?>
