;(function($, application, window) {

    application.CommunicationLayer = function (  ) {
        var self = this;

        /**
         * @param $form
         */
        self.validateForm = function( $form ){
            // Add some validation
            return true;
        };

        /**
         * @param $form
         * @param callback
         */
        self.postForm = function( $form, callback ){
            $form.trigger( 'form.ajaxBegin', $form );

            var jqXHR = $.ajax({
                  url:        $form.prop( 'action' )
                , type:       $form.prop( 'method' )
                , data:       $form.serialize()
                , cache:      false
                , beforeSend: function( xhr, settings ) {
                    var xhrObject = {
                          'xhr': xhr
                        , 'settings': settings
                    };

                    $form.trigger( 'form.beforeSend', xhrObject );
                }
            })
            .done(function( data, textStatus, jqXHR ) {
                $form.trigger( 'form.done', [ data, textStatus, jqXHR ] );
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                $form.trigger( 'form.fail', [ jqXHR, textStatus, errorThrown ] );
            })
            .always(function( jqXHR, textStatus ) {
                callback( jqXHR, textStatus, $form );
                $form.trigger( 'form.always', [ jqXHR, textStatus, $form ] );
            });
        };

        return self;
    };

    application.performBinding = function (app, selector) {
        // Handle all HTML-specific code here

        var $wrapper = $(selector || window.document),
            subscribeFormSel = "form[role='subscribe']";

        $wrapper
            .on('submit', '.-ajax', function( e ) {
                e.preventDefault();

                var $form = $(this)
                  , $button = $form.find("[type='submit']");

                if ( $form.length > 0 && app.validateForm($form) ) {
                    $button.button('loading');

                    app.postForm( $form, function( jqXHR, textStatus, $form ){
                        //$form.get(0).reset();
                        $button.button( 'reset' );
                    });
                }
            })
            .on('form.beforeSend', subscribeFormSel, function( event, xhrObject ) {
                xhrObject.settings.dataType = 'json';
                xhrObject.settings.contentType = "application/json; charset=utf-8";
            })
            .on('form.always', subscribeFormSel, function( event, jqXHR, textStatus, $form ) {
                var tooltipOpts = {
                      placement: 'left'
                    , title: 'caca'
                    , container: 'body'
                };

                $form.get(0).reset();

                console.log($(this).find('input'));
//                    .tooltip('show');
            })
        ;
    };

})(jQuery, window.lkApp || (window.lkApp = {}), window);