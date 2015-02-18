$(document).ready(function() {
    var content = $("#content");
    var children = $("#children-pages");
    if (children.length && content.height() >= children.height()) {
        content.addClass("large-9 column");
        children.addClass("large-3 column");
    }
});
