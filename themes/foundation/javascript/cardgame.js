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

function Card(data) {
    for (var key in data) {
        this[key] = data[key];
    }
}

var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));

var app = angular.module("blizzgame", [
    "ngRoute",
    "localize",
    "ngResource",
    "mm.foundation"
]);


app.value("cardGameData", {
    title: pageContainer.data("title"),
    pageUrl: pageContainer.data("pageUrl"),
    baseHref: angular.element(document.querySelector("base")).attr("href"),
    pageID: pageContainer.data("pageId"),
    totalSize: 1,
    selectedCard: null,
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

app.factory("cardGame", function(cardGameData, $http, $routeParams, $location, $anchorScroll, $resource) {
    var apiUrl = cardGameData.baseHref + "api/blizz/";
    var start = 0;
    var size = 20;
    var currentPage = 1;
    var card = $resource(apiUrl + ":object/:id/:relation", {
        object: "@object",
        id: "@id",
        relation: "@relation"
    }, {});
    var title = angular.element(document.querySelector("title"));

    function load() {
        var id = $routeParams.pageName;
        if (id) {
            if (cardGameData.items.length) {
                cardGameData.selectedCard = getByLink(id);
                loadDetails(cardGameData.selectedCard);
            } else {
                card.get({
                    object: "CardGameItem",
                    id: id
                }, function(data) {
                    cardGameData.selectedCard = new Card(data);
                    title.html(cardGameData.selectedCard.Title);
                    loadDetails(cardGameData.selectedCard);
                });
            }
            $location.hash('');
            $anchorScroll();
        }
        if (!cardGameData.items.length) {
            card.get({
                object: "CardGamePage",
                relation: "Items",
                id: cardGameData.pageID
            }, function(data) {
                cardGameData.totalSize = data.totalSize;
                cardGameData.items.length = 0;
                for (var item in data.items) {
                    cardGameData.items.push(new Card(data.items[item]));
                }
                if (cardGameData.items[0].Hearthstone == 0) {
                    cardGameData.filterByClasses = {onlyHeartStone: false};
                }
            });
        }

    }

    function loadDetails() {
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

    /**
     *
     * @param link
     * @returns {Card}
     */
    function getByLink(link) {
        if (cardGameData.items.length) {
            cardGameData.selectedCard = cardGameData.items.filter(function(obj) {
                return obj.LastLinkSegment == link;
            });
            return cardGameData.selectedCard[0];
        }
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
        loadDetails: loadDetails,
        load: load
    };
});

app.config(function($routeProvider, $locationProvider) {
    var pageUrl = location.origin + pageContainer.data("pageUrl");
    var baseHref = angular.element(document.querySelector("base")).attr("href");
    pageUrl = pageUrl.replace(baseHref, "/");
    console.log(baseHref);
    $routeProvider
        .when(pageUrl, {
            controller: "loadCardGameData",
            templateUrl: baseHref + "themes/foundation/templates/html/card-game/list.html"
        })
        .when(pageUrl + ":pageName", {
            controller: "loadCardGameData",
            templateUrl: baseHref + "themes/foundation/templates/html/card-game/card.html"
        })
    ;
    $locationProvider.html5Mode(true);
});

angular.module("localize").config(function($provide) {
    $provide.decorator("localizeConfig", function($delegate) {
        $delegate.observableAttrs = /^data-(?!ng-|localize)/;
        return $delegate;
    });
});

/**
 * @ngDoc controller
 * @name ng.module:cards
 *
 * @description
 * cards pagination, view, filter
 */
app.controller("cards", function(cardGame, cardGameData, $scope) {
    $scope.cardGameData = cardGameData;
    $scope.cardGame = cardGame;
    $scope.search = {
        Class: ""
    };

    $scope.paginate = function(page) {
        cardGame.setCurrentPage(page);
    };
});

app.controller("loadCardGameData", function(cardGame) {
    cardGame.load();
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
