$(document).ready(function() {
    var galleryList = $(".gallery-list");
    var artSection = $("#arts-section");

    $(".load-more-art").click(function() {
            $(this).prop("disabled", true);
            var url = $(this).data("url");
            var start = $(this).data("start");
            if (url) {
                loadMoreArts($(this), url, start);
            } else {
                $(this).prop("disabled", false);
            }
        }
    ).click();

    function loadMoreArts(obj, url, start) {
        if (url) {
            $.ajax({
                url: url,
                data: {
                    start: start
                },
                success: function(data) {
                    if (!artSection.is("visible") && $(data).find("li").length) {
                        $("#arts-section").show();
                    }
                    galleryList.append($(data).html());
                    obj.data("start", start + 12);
                    obj.prop("disabled", false);
                    if ($(data).find("li").length < 12) {
                        obj.remove();
                    }
                }
            });
        }
    }
});
