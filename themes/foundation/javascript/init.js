function DataObject(data) {
    if (data) {
        for (var key in data) {
            this[key] = data[key];
        }
    }
}

function DataList(list) {
    if (typeof list  == "object") {
        this.items = list;
    } else {
        this.items = [];
    }
}
DataList.prototype.add = function(obj) {
    this.items.push(obj);
};
DataList.prototype.count = function() {
    return this.items.length;
};
DataList.prototype.get = function(index) {
    if (index > -1 && index < this.items.length) {
        return this.items.length[index];
    }
};
DataList.prototype.indexOf = function(obj, startIndex) {
    var i = startIndex;
    while(i < this.items.length) {
        if (this.items[i] == obj) {
            return i;
        }
        i++;
    }
    return -1;
};
DataList.prototype.removeAt = function(index) {
    this.items.splice(index, 1);
};

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
            siteTitle: pageContainer.data("siteTitle"),
            titlePattern: pageContainer.data("titlePattern"),
            breadcrumbs: pageContainer.data("breadcrumbs"),
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

function BreadcrumbsService() {
    return {
        items: [],
        add: function(data) {
            this.items.push(data);
        },
        remove: function() {

        },
        set: function(data) {
            this.items.length = 0;
            for (var key in data) {
                this.add(data[key]);
            }
        }
    }
}
