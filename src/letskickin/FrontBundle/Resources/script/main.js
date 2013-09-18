"use strict";

(function($, application, window) {

    application.CommunicationLayer = function (  ) {
        var self = this;

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
        },

        self.sayHi = function (  ) {
            console.log( 'Hi!' );
        };

        return self;
    };

    application.performBinding = function (app, selector) {
        //Handle all HTML-specific code here

        //DOM wrapper element, all event handlers are bound to this element
        var $wrapper = $(selector || window.document);

        //bind all events
//        $wrapper
//            //PRIMARY BINDINGS
//            .on('click', '.-fb-login', function() {
//                //user clicked delete
//                //handle UI changes
//                //get necessary data
//                //call appropriate method on app
//                // console.log('fetching friends...');
//                app.fbLogin(function(status){
//                    console.log(status);
//                });
//            })
//        ;
    };

})(jQuery, window.lkApp || (window.lkApp = {}), window);