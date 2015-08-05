var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));

var app = angular.module("cardGame", [
    "ngRoute",
    "mm.foundation"
]);

app.filter('unsafe', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});

app.value("cardGameData", {
    title: pageContainer.data("title"),
    pageUrl: pageContainer.data("pageUrl"),
    baseHref: angular.element(document.querySelector("base")).attr("href"),
    pageID: pageContainer.data("pageId"),
    defaultCardImage: "themes/foundation/images/hearthstone/cardback.png",
    totalSize: null,
    currentPage: 1,
    viewMode: "",
    pages: [],
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

app.factory("cardGame", function(cardGameData, $http, $routeParams, $location, $anchorScroll) {
    var apiUrl =cardGameData.baseHref + "api/v1/";
    var start = 0;
    var size = 20;
    var currentPage = 1;
    function loadCardList() {
        if (!cardGameData.items.length) {
            $http({
                url: apiUrl + "CardGamePage/" + cardGameData.pageID + "/Items.json",
                params: {
                    //limit: start + "," + size
                }
            }).success(function(data) {
                if (cardGameData.items.length == 0) {
                    $.extend(cardGameData, data);
                } else {
                    $.each(data.items, function() {
                        cardGameData.items.push(this);
                    });
                }
                if ($routeParams.pageName) {
                    cardGameData.selectedCard = cardGameData.items.filter(function(obj) {
                        return obj.LastLinkSegment == $routeParams.pageName;
                    });
                    cardGameData.selectedCard = cardGameData.selectedCard[0];
                    loadDetails();
                }
            });
        }
    }
    function loadDetails() {
        $location.hash('top');
        $anchorScroll();
        size = 8;
        if (!cardGameData.selectedCard.CoverCard.Filename) {
            cardGameData.selectedCard.page = cardGameData.currentPage;
            $http({
                url: cardGameData.selectedCard.CoverCard.href
            }).success(function(data) {
                $.extend(cardGameData.selectedCard.CoverCard, data);
            });
        }
        if (!cardGameData.selectedCard.LinkToArt.Title) {
            cardGameData.selectedCard.page = cardGameData.currentPage;
            $http({
                url: cardGameData.selectedCard.LinkToArt.href
            }).success(function(data) {
                $.extend(cardGameData.selectedCard.LinkToArt, data);
            });
        }
        if (!cardGameData.selectedCard.Artist.TitleEN) {
            cardGameData.selectedCard.page = cardGameData.currentPage;
            $http({
                url: cardGameData.selectedCard.Artist.href
            }).success(function(data) {
                $.extend(cardGameData.selectedCard.Artist, data);
            });
        }
    }
    return {
        setStart: function(s) {
            start = s;
        },
        getStart: function() {
            return start;
        },
        incStart: function() {
            start += size;
        },
        setCurrentPage: function(page) {
            currentPage = page;
            start = (currentPage  - 1) * size;
        },
        currentPage: function() {
            return currentPage;
        },
        getSize: function() {
            return size;
        },
        setSize: function(s) {
            size = s;
        },
        loadDetails: loadDetails,
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

app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

app.directive('toggleClass', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                if (!element.hasClass(attrs.toggleClass)) {
                    element.closest("ul").find("li").removeClass(attrs.toggleClass);
                }
                ulTop = element.offset().top - element.closest("ul").offset().top;
                element.toggleClass(attrs.toggleClass);
                element.css("top", ulTop);
            });
        }
    };
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
app.controller("cards", function (cardGame, cardGameData, $scope, $http, $routeParams, $location, $modal, $log) {
    $scope.cardGameData = cardGameData;
    $scope.cardGame = cardGame;
    if (cardGameData.pageReady) {
        cardGame.loadCardList();
    }
    if (cardGameData.items.length && $routeParams.pageName) {
        cardGameData.selectedCard = cardGameData.items.filter(function(obj) {
            return obj.LastLinkSegment == $routeParams.pageName;
        });
        cardGameData.selectedCard = cardGameData.selectedCard[0];
        cardGame.loadDetails();
    } else {
        cardGame.setSize(20);
        cardGame.setCurrentPage(1);
    }
    cardGameData.pageReady = $routeParams.pageName ? false : true;
    $scope.search = {
        Class: ""
    };

    $scope.paginate = function(page) {
        cardGame.setCurrentPage(page);
    };
});