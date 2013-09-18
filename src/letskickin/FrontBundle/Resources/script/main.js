;(function($, application, window) {

    application.CommunicationLayer = function (  ) {
        var self = this;

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
                type        : $form.prop( 'method' ),
                url         : $form.prop( 'action' ),
                data        : values,
                success     : function(data) {
                    callback( data );
                }
            });
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

                var cb = $(this).data('cb');

                app.postForm( $(this), function( response ){
                    cb();
                });

                return false;
            })
        ;
    };

})(jQuery, window.lkApp || (window.lkApp = {}), window);