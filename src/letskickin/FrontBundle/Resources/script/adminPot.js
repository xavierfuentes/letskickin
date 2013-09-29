;(function($, application, window) {

    application.CommunicationLayer = function (  ) {
        var self = this;

        self.confirmParticipant = function( $form ){
            //
        };

        return self;
    };

    application.performBinding = function (app, selector) {
        //Handle all HTML-specific code here

        //DOM wrapper element, all event handlers are bound to this element
        var $wrapper = $(selector || window.document),
            participantClass = ".-participant-form",
            actionsClass = ".-participant-actions",
            statusInputSelector = "[name='createParticipant[status]']";

        //bind all events
        $wrapper
            //PRIMARY BINDINGS
            .on('form.postBegin', participantClass, function( event, form ) {
                var $form = $(form),
                    participantId = $form.prop('id').replace('form_','');

                if( $form.hasClass( '-participant-form-waiting' ) || $form.hasClass( '-participant-form-cannot' ) ) {
                    $form
                        .find( statusInputSelector )
                        .val( '2' );
                    $( '#' + participantId )
                        .removeClass( 'waiting' )
                        .removeClass( 'cannot' )
                        .addClass( 'confirmed' );
                }
            })
        ;

        // Mouse events
//        $(participantClass).hover(
//        function() {
//            console.log('caca');
//            $( this ).siblings(actionsClass).show();
//        },
//        function() {
//            console.log('de vaca');
//            $( this ).siblings(actionsClass).hide();
//        });
    };

})(jQuery, window.adminPot || (window.adminPot = {}), window);