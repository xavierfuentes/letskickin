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
        var $wrapper = $(selector || window.document),
            newParticipantFormClass = ".-new-participant-form",
            newParticipantButtonClass = ".-btn-add-new-participant",
            notParticipateButtonClass = ".-not-participate",
            $amountInput = $("#createParticipant_amount");

        $wrapper
            .on('submit', newParticipantFormClass, function() {
                var $button = $(newParticipantButtonClass);

                $button.button('loading');
            })
            .on('click', notParticipateButtonClass, function( event ) {
                event.preventDefault();

                $amountInput.val('0');
                $(newParticipantClass).trigger('not.participate');
            })
            .on('not.participate', newParticipantClass, function (){
                // validate and submit the form
                $(newParticipantFormClass).find('[type="submit"]').trigger('click');
            })
        ;
    };

})(jQuery, window.showPot || (window.showPot = {}), window);