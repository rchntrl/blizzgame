var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));
var baseUrl = angular.element(document.querySelector("base")).attr("href");

/**
 *
 * @param data
 * @constructor
 * @property TitleRU String
 * @property TitleEN String
 * @property LastLinkSegment String
 * @property Url String
 * @property Speech Object
 */
function HeroOfNexus(data) {
    for (var key in data) {
        this[key] = data[key];
    }
    this.Url = pageContainer.data("pageUrl") + data.LastLinkSegment;
    this.ImageSrc = null;
}

var app = angular.module("blizzgame", [
    "ngRoute",
    "ngResource"
]);

app.config(function ($routeProvider, $locationProvider) {
    var pageUrl = location.origin + pageContainer.data("pageUrl");
    pageUrl = pageUrl.replace(baseUrl , "/");
    $routeProvider
        .when(pageUrl, {
            controller: "loadNexusData",
            templateUrl: baseUrl  + "themes/foundation/templates/html/nexus/list.html"
        })
        .when(pageUrl + ":heroName", {
            controller: "loadNexusData",
            templateUrl: baseUrl  + "themes/foundation/templates/html/nexus/hero.html"
        })
    ;
    $locationProvider.html5Mode(true);
});

app.value("nexusData", {
    title: pageContainer.data("title"),
    breadcrumbs: null,
    selectedHero: null,
    totalSize: 1,
    items:[]
});

app.factory("heroes", function(nexusData, $http, $routeParams, $location, $anchorScroll, $resource) {
    var apiUrl = baseUrl + "api/blizz/";
    var hero = $resource(
        apiUrl + "StormHero/:id/:relation",
        {
            id: "@id",
            relation: "@relation"
        }
    );
    function loadDetails(obj) {
        if (!obj.Speech[0].ID) {
            hero.get({id: obj.ID, relation: 'Speech'}, function (data) {
                obj.Speech = data.items;
            });
        }
        if (!obj.Image.Filename) {
            hero.get({id: obj.ID, relation: 'Image'}, function (data) {
                obj.Image = data.items[0];
            });
        }
    }

    function load() {
        var id = $routeParams.heroName;
        if (nexusData.items.length && id) {
            nexusData.selectedHero = getByLink(id);
            loadDetails(nexusData.selectedHero);
        } else if (id) {
            hero.get({id: id}, function (data) {
                nexusData.selectedHero = new HeroOfNexus(data);
                loadDetails(nexusData.selectedHero);
            });
        }
        hero.get(function (data) {
            nexusData.totalSize = data.totalSize;
            nexusData.items.length = 0;
            for (var item in data.items) {
                nexusData.items.push(new HeroOfNexus(data.items[item]));
            }
        });
    }

    /**
     *
     * @param id
     * @returns {HeroOfNexus}
     */
    function getById(id) {
        data = nexusData.items.filter(function (obj) {
            return obj.ID == id;
        });
        return data[0];
    }

    /**
     *
     * @param id
     * @returns {HeroOfNexus}
     */
    function getByLink(id) {
        data = nexusData.items.filter(function (obj) {
            return obj.LastLinkSegment == id;
        });
        return data[0];
    }
    return {
        getById: getById,
        getByLink: getByLink,
        load: load
    }
});

app.controller("nexus", function (nexusData, heroes, $scope, $anchorScroll) {
    $scope.nexusData = nexusData;

    $scope.getHeroById = function(id) {
        if (id > 0) {
            return heroes.getById(id);
        }
        return null;
    }
});

app.controller("loadNexusData", function (heroes) {
    heroes.load();
});

app.controller("breadcrumbs", function (nexusData, $scope) {
    $scope.breadCrumbs = nexusData.breadCrumbs;
});

app.filter("unsafe", function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    };
});