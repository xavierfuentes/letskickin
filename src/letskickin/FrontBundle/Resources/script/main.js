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
            var values = {};

            $.each( $form.serializeArray(), function(i, field) {
                values[field.name] = field.value;
            });

            $.ajax({
                type:           $form.prop( 'method' ),
                url:            $form.prop( 'action' ),
                data:           $form.serialize(),
                cache:          false,
                dataType:       'json',
                contentType:    "application/json; charset=utf-8",
                success: function(data) {
                    callback( data );
                }
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

                if ( $form.length > 0 ) {
                    if ( app.validateForm($form) ) {
                        $button.button('loading');

                        app.postForm( $form, function( response ){
                            //app.showAndDestroyTooltip($button, response.msg);
                            //$form.get(0).reset();
                            $button.button('reset');
                            console.log(response.msg);
                        });
                    }
                }
            })
        ;
    };

})(jQuery, window.lkApp || (window.lkApp = {}), window);