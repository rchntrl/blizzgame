function DataObject(data) {
    for (var key in data) {
        this[key] = data[key];
    }
}

var PageDetails = (function() {
    var instance;
    function init() {
        var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));
        var url = pageContainer.data("pageUrl");
        var baseUrl = document.querySelector("base").getAttribute("href");
        var absoluteUrl = location.origin + url;

        return {
            baseUrl: baseUrl,
            url: url,
            absoluteUrl: absoluteUrl,
            path: absoluteUrl.replace(baseUrl , "/"),
            pageId: pageContainer.data("pageId"),
            title: pageContainer.data("title"),
            titlePattern: pageContainer.data("titlePattern"),
            setTitle: function(title) {
                var titleNode = document.querySelector("title");
                titleNode.innerHTML = this.titlePattern.replace(/__title__/, title);
            }
        }
    }
    return {
        getInstance: function() {
            if (!instance) {
                instance = init();
            }
            return instance;
        }
    }
})();