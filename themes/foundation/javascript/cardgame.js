var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));
//angular.element(document.querySelector("base")).attr("href", pageContainer.data("pageUrl"));
var app = angular.module("cardGame", [
    "ngRoute",
    "brantwills.paging"
]);

app.value("cardGameData", {
    title: pageContainer.data("title"),
    pageUrl: pageContainer.data("pageUrl"),
    pageID: pageContainer.data("pageId"),
    viewMode: "",
    items: {}
});

app.factory("cardGame", function(cardGameData, $http, $location) {
    var apiUrl = location.origin + "api/v1/";
    function loadCardList() {
        $http({
            url: apiUrl + "CardGamePage/" + cardGameData.pageID + "/Items.json"
        }).success(function(data) {
            $.extend(cardGameData, data);
            $.each(cardGameData.items, function(key) {
                loadImageOfCard(key);
            });
        });
    }
    function loadImageOfCard(key) {
        $http({
            url: cardGameData.items[key].CoverCard.href
        }).success(function(data) {
            $.extend(cardGameData.items[key].CoverCard, data);
        });
    }
    return {
        loadCardList: loadCardList
    };
});

app.config(function ($routeProvider, $locationProvider) {
    var pageUrl = location.origin + pageContainer.data("pageUrl");
    var baseHref = angular.element(document.querySelector("base")).attr("href");
    pageUrl = pageUrl.replace(baseHref, "/");
    $routeProvider
        .when("/card-base/hearthstone/blackrock-mountain/", {
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
    if (cardGameData.viewMode == "list") {
        cardGame.loadCardList();
    }
    cardGameData.viewMode = $routeParams.pageName ? "view" : "list";
    $scope.page = $routeParams.pageName;

    $scope.imageOfCard = function(key) {
        if (!cardGameData.list[key].CoverCard["Filename"]) {
            $http({
                url: cardGameData.items[key].CoverCard.href
            }).success(function(data) {
                $.extend(cardGameData.items[key].CoverCard, data);
                cardGameData.items[key].CoverCard.Filename = location.hostname + cardGameData.items[key].CoverCard.Filename;
                console.log(cardGameData.items[key].CoverCard.Filename);
            });
        }
        return cardGameData.items[key].CoverCard.Filename;
    }
});