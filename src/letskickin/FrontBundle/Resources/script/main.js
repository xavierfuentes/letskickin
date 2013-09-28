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
            $form.trigger( 'form.beforeSend', $form );

            var request = $.ajax({
                url:    $form.prop( 'action' ),
                type:   $form.prop( 'method' ),
                data:   $form.serialize(),
                cache:  false
            })
            .done(function( msg ) {
                $form.trigger( 'form.done', $form );
            })
            .fail(function( jqXHR, textStatus ) {
                $form.trigger( 'form.fail', textStatus );
            })
            .always(function( msg ) {
                callback( msg );
                $form.trigger( 'form.always', this );
            });
        };

        self.showAndDestroyTooltip = function ( $element, message ) {
            $element.tooltip({
                container: 'body',
                placement: 'auto bottom',
                title: message,
            }).tooltip('show');

            setTimeout(function() {
                $element.tooltip('destroy');
            }, 5000);
        };

        return self;
    };

    application.performBinding = function (app, selector) {
        //Handle all HTML-specific code here

        //DOM wrapper element, all event handlers are bound to this element
        var $wrapper = $(selector || window.document);

        //bind all events
        $wrapper
            //PRIMARY BINDINGS
            .on('submit', '.-ajax', function( e ) {
                e.preventDefault();

                var $form = $(this),
                    $button = $form.find("[type='submit']");

                if ( $form.length > 0 && app.validateForm($form) ) {
                    $button.button('loading');

                    app.postForm( $form, function( response ){
                        //app.showAndDestroyTooltip($button, response.msg);
                        //$form.get(0).reset();
                        $button.button( 'reset' );
                    });
                }
            })
        ;
    };

})(jQuery, window.lkApp || (window.lkApp = {}), window);