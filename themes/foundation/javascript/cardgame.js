window.i18n = {
    "Ally": "Союзник",
    "Armor": "Броня",
    "Boss": "Босс",
    "Hero": "Герой",
    "Item": "Предмет",
    "Location": "Локация",
    "Main Hero": "Главный герой",
    "Quest": "Задание",
    "Spell": "Заклинание",
    "Weapon": "Оружие",

    "Warrior": "Воин",
    "Druid": "Друид",
    "Priest": "Жрец",
    "Mage": "Маг",
    "Monk": "Монах",
    "Hunter": "Охотник",
    "Paladin": "Паладин",
    "Rogue": "Разбойник",
    "Death Knight": "Рыцарь смерти",
    "Warlock": "Чернокнижник",
    "Shaman": "Шаман",

    "Free": "Низкий",
    "Common": "Обычный",
    "Uncommon": "Необычный",
    "Rare": "Редкий",
    "Epic": "Эпический",
    "Legendary": "Легендарный"
};

var Card = function (data) {
    return data;
};

var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));

var app = angular.module("blizzgame", [
    "ngRoute",
    "localize",
    "ngResource",
    "mm.foundation"
]);

angular.module("localize").config(function ($provide) {
    $provide.decorator("localizeConfig", function ($delegate) {
        $delegate.observableAttrs = /^data-(?!ng-|localize)/;
        return $delegate;
    });
});

app.filter("unsafe", function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    };
});

app.value("cardGameData", {
    title: pageContainer.data("title"),
    pageUrl: pageContainer.data("pageUrl"),
    baseHref: angular.element(document.querySelector("base")).attr("href"),
    pageID: pageContainer.data("pageId"),
    totalSize: 1,
    filterByClasses: {hearthStone: true},
    currentPage: 1,
    viewMode: "",
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

app.factory("cardGame", function (cardGameData, $http, $routeParams, $location, $anchorScroll, $resource) {
    var apiUrl = cardGameData.baseHref + "api/v1/";
    var start = 0;
    var size = 20;
    var currentPage = 1;
    var card = $resource(apiUrl + "CardGamePage/:id/Items", {id: cardGameData.pageID}, {});

    function loadCardList() {
        if (cardGameData.items.length < cardGameData.totalSize) {
            card.get(function (data) {
                cardGameData.totalSize = data.totalSize;
                $.each(data.items, function () {
                    cardGameData.items.push(new Card(this));
                });
                if (cardGameData.items[0].Hearthstone == 0) {
                    cardGameData.filterByClasses = {onlyHeartStone: false};
                }
                selectCard();
            }, function (error) {
                console.log(error);
            });
        }
    }

    function loadDetails() {
        $location.hash('');
        $anchorScroll();
        size = 8;
        if (!cardGameData.selectedCard.CoverCard.Filename) {
            cardGameData.selectedCard.page = cardGameData.currentPage;
            $http({
                url: cardGameData.selectedCard.CoverCard.href
            }).success(function (data) {
                $.extend(cardGameData.selectedCard.CoverCard, data);
            });
        }
        if (!cardGameData.selectedCard.LinkToArt.Title) {
            cardGameData.selectedCard.page = cardGameData.currentPage;
            $http({
                url: cardGameData.selectedCard.LinkToArt.href
            }).success(function (data) {
                $.extend(cardGameData.selectedCard.LinkToArt, data);
            });
        }
        if (!cardGameData.selectedCard.Artist.TitleEN) {
            cardGameData.selectedCard.page = cardGameData.currentPage;
            $http({
                url: cardGameData.selectedCard.Artist.href
            }).success(function (data) {
                $.extend(cardGameData.selectedCard.Artist, data);
            });
        }
    }

    function selectCard() {
        if (cardGameData.items.length && $routeParams.pageName) {
            cardGameData.selectedCard = cardGameData.items.filter(function (obj) {
                return obj.LastLinkSegment == $routeParams.pageName;
            });
            cardGameData.selectedCard = cardGameData.selectedCard[0];
            loadDetails();
        } else {
            size = 20;
            setCurrentPage(1)
        }
    }

    function setCurrentPage(page) {
        currentPage = page;
        start = (currentPage - 1) * size;
    }

    return {
        setStart: function (s) {
            start = s;
        },
        getStart: function () {
            return start;
        },
        setCurrentPage: setCurrentPage,
        currentPage: function () {
            return currentPage;
        },
        getSize: function () {
            return size;
        },
        setSize: function (s) {
            size = s;
        },
        selectCard: selectCard,
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
            controller: "cards",
            templateUrl: baseHref + pageUrl + "ng/template/?ID=CardGameList"
        })
        .when(pageUrl + ":pageName", {
            controller: "cards",
            templateUrl: baseHref + pageUrl + "ng/template/?ID=CardGameView"
        })
    ;
    $locationProvider.html5Mode(true);
});

app.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
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
 * @description
 * gallery pagination, view, filter
 */
app.controller("cards", function (cardGame, cardGameData, $scope, $http, $routeParams) {
    $scope.cardGameData = cardGameData;
    $scope.cardGame = cardGame;
    if (cardGameData.pageReady) {
        cardGame.loadCardList();
    }
    cardGame.selectCard();
    cardGameData.pageReady = $routeParams.pageName ? false : true;
    $scope.search = {
        Class: ""
    };

    $scope.paginate = function (page) {
        cardGame.setCurrentPage(page);
    };
});
