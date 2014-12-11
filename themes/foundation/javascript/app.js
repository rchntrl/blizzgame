// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation({
    tab: {
        callback : function (tab) {
            console.log(tab);
        }
    }
});

// trigger for joyride demo in KitchenSink demo
$('#start-jr').on('click', function() {
	$(document).foundation('joyride','start');
});

$(document).ready(function() {

});

