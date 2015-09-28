var pageContainer = angular.element(document.querySelector("#pageConfigContainer"));
var baseUrl = angular.element(document.querySelector("base")).attr("href");
var app = angular.module("blizzgame", [
    "ngRoute",
    "ngResource"
]);

function NexusObject(data) {
    for (var key in data) {
        this[key] = data[key];
    }
}

/**
 * @param data
 * @constructor
 * @property TitleRU String
 * @property TitleEN String
 * @property LastLinkSegment String
 * @property Draft Int
 * @property Url String
 * @property IconSrc String
 * @property Speech Object
 */
function HeroOfNexus(data) {
    NexusObject.call(this, data);
    this.Url = this.Draft == 0 ?  pageContainer.data("pageUrl") + data.LastLinkSegment : null;
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
    NexusObject.call(this, data);
    this.owner = this.getById(this.From.id);
    this.mate = this.getById(this.To.id);
    this.OwnerIconSrc = this.owner ? this.owner.IconSrc : null;
    this.MateIconSrc = this.mate ? this.mate.IconSrc : null;
    if (this.SkinOwnerID == this.To.id) {
        this.MateIconSrc = this.SkinIconSrc;
    } else if (this.SkinOwnerID == this.From.id) {
        this.OwnerIconSrc = this.SkinIconSrc;
    }
}

app.config(function($routeProvider, $locationProvider) {
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
    titlePattern: '',
    title: pageContainer.data("title"),
    breadcrumbs: null,
    selectedItem: null,
    totalSize: 0,
    tags: [],
    items:[]
});

app.factory("heroes", function(nexusData, $routeParams, $location, $anchorScroll, $resource) {
    var apiUrl = baseUrl + "api/blizz/";
    var titleNode = angular.element(document.querySelector("title"));
    var hero = $resource(
        apiUrl + "StormHero/:id/:relation",
        {
            id: "@id",
            relation: "@relation"
        }
    );

    HeroSpeech.prototype.getById = function(id) {return getById(id)};
    HeroOfNexus.prototype.loadDetails = function () {
        var that = this;
        if (!this.Speech.length) {
            hero.get({id: this.ID, relation: 'Speech'},function(data) {
                for (var key in data.items) {
                    that.Speech.push(new HeroSpeech(data.items[key]));
                }
            });
        }
        if (!this.Skins) {
            hero.get({id: this.ID, relation: 'Skins'},function(data) {
                that.Skins = data.items;
            });
        }
    };

    function load() {
        var id = $routeParams.heroName;
        if (id) {
            if (nexusData.items.length) {
                prepareHeroPage(id);
            }
        } else {
            setTitle(nexusData.title);
        }
        if (!nexusData.items.length) {
            hero.get(function(data) {
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
        setTitle(nexusData.selectedItem.TitleRU);
        nexusData.selectedItem.loadDetails();
        $anchorScroll();
    }

    /**
     *
     * @param id
     * @returns {HeroOfNexus}
     */
    function getById(id) {
        data = nexusData.items.filter(function(obj) {
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
        data = nexusData.items.filter(function(obj) {
            return obj.LastLinkSegment == id;
        });
        return data[0];
    }

    function setTitle(title) {
        titleNode.html(nexusData.titlePattern.replace(/__title__/, title));
    }

    return {
        getById: getById,
        getByLink: getByLink,
        load: load
    };
});

app.controller("nexus",function(nexusData, heroes, $scope) {
    nexusData.titlePattern = $scope.titlePattern;
    $scope.nexusData = nexusData;
});

app.controller("loadNexusData",function(heroes) {
    heroes.load();
});

app.controller("breadcrumbs",function(nexusData, $scope) {
    $scope.breadCrumbs = nexusData.breadCrumbs;
});


app.filter("unsafe",function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});
