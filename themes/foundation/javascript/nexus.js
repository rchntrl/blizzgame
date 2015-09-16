var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));
var baseUrl = angular.element(document.querySelector("base")).attr("href");

var HeroOfNexus = function(data) {
    data.url = pageContainer.data("pageUrl") + data.LastLinkSegment;
    return data;
};


var app = angular.module("blizzgame", [
    "ngRoute",
    "ngResource"
]);

app.config(function ($routeProvider, $locationProvider) {
    var pageUrl = location.origin + pageContainer.data("pageUrl");
    pageUrl = pageUrl.replace(baseUrl , "/");
    $routeProvider
        .when(pageUrl, {
            controller: "nexus",
            templateUrl: baseUrl  + "themes/foundation/templates/html/nexus/list.html"
        })
        .when(pageUrl + ":heroName", {
            controller: "nexus",
            templateUrl: baseUrl  + "themes/foundation/templates/html/nexus/hero.html"
        })
    ;
    $locationProvider.html5Mode(true);
});

app.value("nexusData", {
    title: pageContainer.data("title"),
    heroSelected: false,
    breadcrumbs: null,
    heroId: null,
    selectedHero: null,
    totalSize: 1,
    items:[]

});

app.factory("heroes", function(nexusData, $http, $routeParams, $location, $anchorScroll, $resource) {
    var apiUrl = baseUrl + "api/v1/";
    var hero = $resource(
        apiUrl + "StormHero/:id",
        {
            id: "@id"
        }
    );
    function load() {
        hero.get(function (data) {
            nexusData.totalSize = data.totalSize;
            for (var item in data.items) {
                nexusData.items.push(new HeroOfNexus(data.items[item]));
            }
        });
    }

    function selectHero() {
        if (nexusData.items.length && $routeParams.heroName) {
            nexusData.selectedHero = nexusData.items.filter(function (obj) {
                return obj.LastLinkSegment == $routeParams.heroName;
            });
            nexusData.selectedHero = nexusData.selectedHero[0];
            hero.get({id: nexusData.heroId}, function (data) {
                nexusData.selectedHero = new HeroOfNexus(data);
            });
        }
    }
    return {
        load: load,
        selectOne: selectHero
    }
});

app.controller("nexus", function (nexusData, heroes, $scope, $http, $routeParams, $location, $anchorScroll) {
    $scope.nexusData = nexusData;
    if (!nexusData.heroSelected) {
        heroes.load();
    }
    heroes.selectOne();

    nexusData.heroSelected = $routeParams.heroName ? false : true;
});

app.controller("breadcrumbs", function (nexusData, $scope) {
    $scope.breadCrumbs = nexusData.breadCrumbs;
});
