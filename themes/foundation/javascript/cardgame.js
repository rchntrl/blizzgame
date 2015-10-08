/**
 *
 * @param data
 * @constructor
 * @property Title
 * @property CoverCard
 * @property LinkToArt
 * @property Artist
 * @property Hearthstone
 */
function Card(data) {
    DataObject.call(this, data);
    this.Link = this.Class == 'None' ? '' : pageConfig.url + this.LastLinkSegment;
    this.nameOfSet = pageConfig.title;
}

var pageConfig = PageDetails.getInstance();
var app = angular.module("blizzgame", [
    "ngNewRouter",
    "ngResource",
    "mm.foundation"
]);

app.value("breadcrumbsService", {
    items: [],
    add: function(data) {
        this.items.push(data);
    },
    set: function(data) {
        this.items.length = 0;
        for (var key in data) {
            this.items.push(data[key]);
        }
    }
});

app.value("cardGameData", {
    pageID: pageConfig.pageId,
    totalSize: 1,
    selectedItem: null,
    filterByClasses: {hearthStone: true},
    currentPage: 1,
    pages: [],
    items: [],
    // Warrior, Druid, Priest, Mage, Monk, Hunter, Paladin, Rogue, Death Knight, Warlock, Shaman
    classes: [
        {
            title: "Death Knight",
            class: "death-knight",
            onlyHeartStone: false,
            value: "Death Knight"
        },
        {
            title: "Druid",
            class: "druid",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Druid"
        },
        {
            title: "Hunter",
            class: "hunter",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Hunter"
        },
        {
            title: "Mage",
            class: "mage",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Mage"
        },
        {
            title: "Monk",
            class: "monk",
            onlyHeartStone: false,
            value: "Monk"
        },
        {
            title: "Paladin",
            class: "paladin",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Paladin"
        },
        {
            title: "Priest",
            class: "priest",
            hearthStone: true,
            value: "Priest"
        },
        {
            title: "Rogue",
            class: "rogue",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Rogue"
        },
        {
            title: "Shaman",
            class: "shaman",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Shaman"
        },
        {
            title: "Warlock",
            class: "warlock",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Warlock"
        },
        {
            title: "Warrior",
            class: "warrior",
            hearthStone: true,
            onlyHeartStone: false,
            value: "Warrior"
        },
        {
            title: "Common",
            class: "common",
            hearthStone: true,
            onlyHeartStone: true,
            value: "Common"
        }
    ]
});

app.config(function ($componentLoaderProvider, $locationProvider) {
    $componentLoaderProvider.setTemplateMapping(function (name) {
        var path;
        if(name == "breadcrumbs") {
            path = "common/" + name;
        } else {
            path = "card-game/" + name;
        }
        return pageConfig.baseUrl + "themes/foundation/templates/html/" + path + ".html";
    });
    $locationProvider.html5Mode(true);
});

app.factory("cardGame", function(cardGameData, breadcrumbsService, $http, $location, $anchorScroll, $resource) {
    var itemId;
    var apiUrl = pageConfig.baseUrl + "api/blizz/";
    var start = 0;
    var size = 20;
    var currentPage = 1;
    var resource = $resource(apiUrl + ":object/:id/:relation", {
        object: "@object",
        id: "@id",
        relation: "@relation"
    }, {});

    function load() {
        if (!cardGameData.items.length) {
            resource.get({
                object: "CardGamePage",
                id: pageConfig.pageId,
                relation: "Items"
            }, function(data) {
                cardGameData.totalSize = data.totalSize;
                cardGameData.items.length = 0;
                for (var item in data.items) {
                    cardGameData.items.push(new Card(data.items[item]));
                }
                if (cardGameData.items[0].Hearthstone == 0) {
                    cardGameData.filterByClasses = {onlyHeartStone: false};
                }
                if (itemId) {
                    preparePage(itemId);
                }
            });
        }

    }

    /**
     *
     * @param obj Card
     */
    function loadDetails(obj) {
        if (!obj.loadDetailsFired) {
            obj.loadDetailsFired = true;
            if (!obj.CoverCard.Filename) {
                $http({
                    url: obj.CoverCard.href
                }).success(function(data) {
                    $.extend(obj.CoverCard, data);
                });
            }
            if (!obj.LinkToArt.Title) {
                $http({
                    url: obj.LinkToArt.href
                }).success(function(data) {
                    $.extend(obj.LinkToArt, data);
                });
            }
            if (!obj.Artist.TitleEN) {
                $http({
                    url: obj.Artist.href
                }).success(function(data) {
                    $.extend(obj.Artist, data);
                });
            }
        }
    }

    function preparePage(id) {
        itemId = id;
        cardGameData.selectedItem = getByLink(itemId);
        breadcrumbsService.set(pageConfig.breadcrumbs);
        breadcrumbsService.add(cardGameData.selectedItem);
        pageConfig.setTitle(cardGameData.selectedItem.Title);
        loadDetails(cardGameData.selectedItem);
        $anchorScroll();
    }

    /**
     *
     * @param link
     * @returns {Card}
     */
    function getByLink(link) {
        var data = cardGameData.items.filter(function(obj) {
            return obj.LastLinkSegment == link;
        });
        return data[0];
    }

    function setCurrentPage(page) {
        currentPage = page;
        start = (currentPage - 1) * size;
    }

    return {
        setStart: function(s) {
            start = s;
        },
        getStart: function() {
            return start;
        },
        setCurrentPage: setCurrentPage,
        currentPage: function() {
            return currentPage;
        },
        getSize: function() {
            return size;
        },
        setSize: function(s) {
            size = s;
        },
        getByLink: getByLink,
        prepareItem: preparePage,
        prepareList: function() {
            itemId = null;
            pageConfig.setTitle(pageConfig.title);
            breadcrumbsService.set(pageConfig.breadcrumbs);
        },
        load: load
    };
});

/**
 * @ngDoc controller
 * @name ng.module:cards
 *
 * @description
 * cards pagination, view, filter
 */
app.controller("common", function(cardGame, cardGameData, $scope, $router) {
    $scope.cardGameData = cardGameData;
    $scope.cardGame = cardGame;
    $scope.pageConfig = pageConfig;
    $scope.search = {
        Class: ""
    };
    $router.config([
        {
            path: pageConfig.path,
            components: {
                "main": "list",
                "breadcrumbs": "breadcrumbs"
            }
        },
        {
            path: pageConfig.path + ":cardName",
            component: {
                "main": "card",
                "breadcrumbs": "breadcrumbs"
            }
        }
    ]);
    cardGame.load();
    $scope.paginate = function(page) {
        cardGame.setCurrentPage(page);
    };
});


app.controller("ListController", function(cardGame) {
    this.Title = pageConfig.Title;
    cardGame.prepareList();
});

app.controller("CardController", function(cardGame, $routeParams) {
    cardGame.prepareItem($routeParams.cardName);
});

app.controller("BreadcrumbsController", function (breadcrumbsService) {
    this.items = function() {
        return breadcrumbsService.items;
    };
});

app.filter("unsafe", function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});

app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

app.filter('multipleFilter', function() {
    return function(cards, searchableItems, fieldName) {
        var items = {
            searchableItems: searchableItems,
            out: []
        };
        angular.forEach(cards, function(value, key) {
            if (this.searchableItems[value[fieldName]] === true) {
                this.out.push(value);
            }
        }, items);
        return items.out;
    };
});
