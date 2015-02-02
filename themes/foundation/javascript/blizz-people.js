$(document).ready(function() {

    if ($(".gallery-list li").length > 1) {
        $("#arts-section").show();
        $(".load-more-art")
            .click(function() {
                var that = $(this);
                that.prop("disabled", true);
                var url = $(this).data("url");
                var start = $(this).data("start");
                if (url && start) {
                    $.ajax({
                        url: url,
                        data: {
                            start: start
                        },
                        success: function(data) {
                            $(".gallery-list").append($(data).html());
                            that.data("start", start + 12);
                            that.prop("disabled", false);

                            if ($(data).find("li").length < 12) {
                                that.remove();
                            }
                        }
                    });
                } else {
                    that.prop("disabled", false);
                }
        });
    }
});
