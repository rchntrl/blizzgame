var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));

var app = angular.module("cardGame", [
    "ngRoute",
    "mm.foundation",
    "infinite-scroll"
]);

app.value("cardGameData", {
    title: pageContainer.data("title"),
    pageUrl: pageContainer.data("pageUrl"),
    baseHref: angular.element(document.querySelector("base")).attr("href"),
    pageID: pageContainer.data("pageId"),
    defaultCardImage: "themes/foundation/images/hearthstone/cardback.png",
    totalSize: null,
    viewMode: "",
    items: [],
    // Warrior, Druid, Priest, Mage, Monk, Hunter, Paladin, Rogue, Death Knight, Warlock, Shaman
    classes: [
        {
            title: "Death Knight",
            class: "death-knight",
            value: "Death Knight"
        },
        {
            title: "Druid",
            class: "druid",
            hearthStone: true,
            value: "Druid"
        },
        {
            title: "Hunter",
            class: "hunter",
            hearthStone: true,
            value: "Hunter"
        },
        {
            title: "Mage",
            class: "mage",
            hearthStone: true,
            value: "Mage"
        },
        {
            title: "Monk",
            class: "monk",
            value: "Monk"
        },
        {
            title: "Paladin",
            class: "paladin",
            hearthStone: true,
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
            value: "Rogue"
        },
        {
            title: "Shaman",
            class: "shaman",
            hearthStone: true,
            value: "Shaman"
        },
        {
            title: "Warlock",
            class: "warlock",
            hearthStone: true,
            value: "Warlock"
        },
        {
            title: "Warrior",
            hearthStone: true,
            value: "Warrior"
        }
    ]
});

app.factory("cardGame", function(cardGameData, $http, $location) {
    var apiUrl =cardGameData.baseHref + "api/v1/";
    var start = 0;
    var size = 15;
    function setStart(s) {
        start = s;
    }
    function getStart() {
        return start;
    }
    function incStart() {
        start += size;
    }
    function setSize(s) {
        size = s;
    }
    function loadCardList() {
        $http({
            url: apiUrl + "CardGamePage/" + cardGameData.pageID + "/Items.json",
            params: {
                limit: start + "," + size
            }
        }).success(function(data) {
            if (cardGameData.items.length == 0) {
                $.extend(cardGameData, data);
            } else {
                $.each(data.items, function() {
                    cardGameData.items.push(this);
                });
            }
            $.each(cardGameData.items, function(key) {
                if(!this.CoverCard.Filename) {
                    $http({
                        url: cardGameData.items[key].CoverCard.href
                    }).success(function(data) {
                        $.extend(cardGameData.items[key].CoverCard, data);
                    });
                }
            });
        });
    }
    return {
        setStart: setStart,
        getStart: getStart,
        incStart: incStart,
        setSize: setSize,
        loadCardList: loadCardList
    };
});

app.config(function ($routeProvider, $locationProvider) {
    var pageUrl = location.origin + pageContainer.data("pageUrl");
    var baseHref = angular.element(document.querySelector("base")).attr("href");
    pageUrl = pageUrl.replace(baseHref, "/");
    $routeProvider
        .when(pageUrl, {
            controller : "cards",
            templateUrl : baseHref + pageUrl + "ng/template/?ID=CardGameList"
        })
        .when(pageUrl + ":pageName", {
            controller: "cards",
            templateUrl:  baseHref + pageUrl + "ng/template/?ID=CardGameView"
        })
    ;
    $locationProvider.html5Mode(true);
});

app.filter('multipleFilter', function () {
    return function (cards, searchableItems, fieldName) {
        var items = {
            searchableItems: searchableItems,
            out: []
        };
        angular.forEach(cards, function (value, key) {
            if (this.searchableItems[value[fieldName]] === true) {
                this.out.push(value);
            }
        }, items);
        return items.out;
    };
});


/**
 * @ngDoc controller
 * @name ng.module:gallery
 *
 *
 * @description
 * gallery pagination, view, filter
 */
app.controller("cards", function (cardGame, cardGameData, $scope, $http, $routeParams, $location, $window, $rootScope) {
    $scope.cardGameData = cardGameData;
    cardGameData.viewMode = $routeParams.pageName ? "view" : "list";
    $scope.page = $routeParams.pageName;
    $scope.search = {
        Class: ""
    };
    $scope.clickMe = function(card) {
        console.log(card);
    };
    $scope.loadMore = function() {
        if (cardGameData.totalSize >= cardGame.getStart()) {
            cardGame.loadCardList();
            cardGame.incStart();
        } else {
            return false;
        }
    };
});