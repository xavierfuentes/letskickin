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
            $form.trigger( 'form.postBegin', $form );

            var jqXHR = $.ajax({
                  url:        $form.prop( 'action' )
                , type:       $form.prop( 'method' )
                , data:       $form.serialize()
                , cache:      false
                , beforeSend: function( xhr, settings ) {
                    console.log( 'beforeSend' );
                    $form.trigger( 'form.beforeSend', xhr );
                }
                /*, error: function( jqXHR, textStatus, errorThrown ) {
                    // ...
                }*/
                /*, success: function( data, textStatus, jqXHR ) {
                 // ...
                 }*/
            })
            .done(function( data, textStatus, jqXHR ) {
                $form.trigger( 'form.done', data );
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                $form.trigger( 'form.fail', errorThrown );
            })
            .always(function( jqXHR, textStatus ) {
                callback( textStatus, $form, jqXHR );
                $form.trigger( 'form.always', jqXHR );
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

                    app.postForm( $form, function( textStatus, $form, jqXHR ){
                        //$form.get(0).reset();
                        $button.button( 'reset' );
                    });
                }
            })
            .on('form.beforeSend', subscribeFormSel, function( event, xhrObject ) {
                xhrObject.overrideMimeType( "application/json; charset=utf-8" );
            })
            .on('form.done', subscribeFormSel, function( event, data ) {
                console.log( 'succes!' );
                console.log( data );
            })
            .on('form.fail', subscribeFormSel, function( event, errorThrown ) {
                console.log( 'error!' );
                console.log( errorThrown );
            })
            .on('form.always', subscribeFormSel, function( event, jqXHR ) {
                console.log( 'always' );
                console.log( event );
            })
        ;
    };

})(jQuery, window.lkApp || (window.lkApp = {}), window);