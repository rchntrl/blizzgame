var pageConfig = PageDetails.getInstance();
var app = angular.module("blizzgame", [
    "ngRoute",
    "ngResource"
]);

/**
 * @param data
 * @constructor
 * @property TitleRU String
 * @property TitleEN String
 * @property LastLinkSegment String
 * @property Draft Int
 * @property Url String
 * @property SkinIconSrc String
 */
function HeroOfNexus(data) {
    DataObject.call(this, data);
    this.Url = this.Draft == 0 ? pageConfig.url + data.LastLinkSegment : null;
    this.ImageSrc = null;
    this.Speech = [];
}

/**
 * @param data
 * @constructor
 * @property SkinOwnerID int
 * @property SkinIconSrc string
 * @property From
 * @property To
 */
function HeroSpeech(data) {
    DataObject.call(this, data);
}

app.config(function ($routeProvider, $locationProvider) {
    var path = pageConfig.path;
    $routeProvider
        .when(path, {
            controller: "loadNexusData",
            templateUrl: pageConfig.baseUrl + "themes/foundation/templates/html/nexus/list.html"
        })
        .when(path + ":heroName", {
            controller: "loadNexusData",
            templateUrl: pageConfig.baseUrl + "themes/foundation/templates/html/nexus/hero.html"
        })
    ;
    $locationProvider.html5Mode(true);
});

app.value("nexusData", {
    breadcrumbs: null,
    selectedItem: null,
    totalSize: 0,
    tags: [],
    items: []
});

app.factory("heroes", function (nexusData, $routeParams, $location, $anchorScroll, $resource) {
    var apiUrl = pageConfig.baseUrl + "api/blizz/";
    var hero = $resource(
        apiUrl + "StormHero/:id/:relation",
        {
            id: "@id",
            relation: "@relation"
        }
    );

    HeroOfNexus.prototype.addSpeech = function (data) {
        var speech = new HeroSpeech(data);
        speech.owner = this;
        speech.mate = getById(speech.To.id);
        speech.OwnerIconSrc = speech.owner ? speech.owner.IconSrc : null;
        speech.MateIconSrc = speech.mate ? speech.mate.IconSrc : null;
        if (speech.SkinOwnerID == speech.From.id) {
            speech.OwnerIconSrc = speech.SkinIconSrc;
        } else if (speech.SkinOwnerID == speech.To.id) {
            speech.MateIconSrc = speech.SkinIconSrc;
        }
        this.Speech.push(speech);
    };

    /**
     *
     * @param obj HeroOfNexus
     */
    function loadDetails(obj) {
        if (!obj.Speech.length) {
            hero.get({id: obj.ID, relation: 'Speech'}, function (data) {
                for (var key in data.items) {
                    obj.addSpeech(data.items[key]);
                }
            });
        }
        if (!obj.Skins) {
            hero.get({id: obj.ID, relation: 'Skins'}, function (data) {
                obj.Skins = data.items;
            });
        }
    }

    function load() {
        var id = $routeParams.heroName;
        if (id) {
            if (nexusData.items.length) {
                prepareHeroPage(id);
            }
        } else {
            pageConfig.setTitle(pageConfig.title);
        }
        if (!nexusData.items.length) {
            hero.get(function (data) {
                nexusData.totalSize = data.totalSize;
                nexusData.items.length = 0;
                for (var item in data.items) {
                    nexusData.items.push(new HeroOfNexus(data.items[item]));
                }
                if (id) {
                    prepareHeroPage(id);
                }
            });
        }
    }

    function prepareHeroPage(id) {
        nexusData.selectedItem = getByLink(id);
        pageConfig.setTitle(nexusData.selectedItem.TitleRU);
        loadDetails(nexusData.selectedItem);
        $anchorScroll();
    }

    /**
     *
     * @param id
     * @returns {HeroOfNexus}
     */
    function getById(id) {
        var data = nexusData.items.filter(function (obj) {
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
        var data = nexusData.items.filter(function (obj) {
            return obj.LastLinkSegment == id;
        });
        return data[0];
    }

    return {
        getById: getById,
        getByLink: getByLink,
        load: load
    };
});

app.controller("nexus", function (nexusData, heroes, $scope) {
    $scope.nexusData = nexusData;
    $scope.title = pageConfig.title;
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
