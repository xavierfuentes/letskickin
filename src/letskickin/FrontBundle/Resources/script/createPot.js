;(function($, application, window) {

    application.CommunicationLayer = function (  ) {
        var self = this;

        self.someFunction = function(  ){
            // Add some code
            return true;
        };

        return self;
    };

    application.performBinding = function (app, selector) {
        //Handle all HTML-specific code here

        //DOM wrapper element, all event handlers are bound to this element
        var $wrapper = $(selector || window.document);

        var $modalComingSoon = $('#comingSoon');

        //bind all events
        $wrapper
            //PRIMARY BINDINGS
            .on('click', '#pot-guests-email-list', function( e ) {
                e.preventDefault();

                $modalComingSoon.modal('show');
            })
        ;
    };

})(jQuery, window.createPot || (window.createPot = {}), window);