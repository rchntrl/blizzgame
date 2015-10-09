var pageConfig = PageDetails.getInstance();
var app = angular.module("blizzgame", [
    "ngNewRouter",
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
    this.Link = this.Draft == 0 ? pageConfig.url + data.LastLinkSegment : null;
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
 * @property owner HeroOfNexus
 * @property mate HeroOfNexus
 */
function HeroSpeech(data) {
    DataObject.call(this, data);
}

app.config(function ($componentLoaderProvider, $locationProvider) {
    $componentLoaderProvider.setTemplateMapping(function (name) {
        var path;
        if(name == "breadcrumbs") {
            path = "common/" + name;
        } else {
            path = "nexus/" + name;
        }
        return pageConfig.baseUrl + "themes/foundation/templates/html/" + path + ".html";
    });
    $locationProvider.html5Mode(true);
});

app.value("nexusData", {
    selectedItem: null,
    totalSize: 0,
    tags: [],
    items: []
});

app.factory("heroes", function (nexusData, breadcrumbsService, $location, $anchorScroll, $resource) {
    var apiUrl = pageConfig.baseUrl + "api/blizz/";
    var heroId;
    var resource = $resource(
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
        if (!obj.loadDetailsFired) {
            obj.loadDetailsFired = true;
            if (!obj.Speech.length) {
                resource.get({id: obj.ID, relation: "Speech"}, function (data) {
                    for (var key in data.items) {
                        obj.addSpeech(data.items[key]);
                    }
                });
            }
            /*if (!obj.Skins) {
             resource.get({id: obj.ID, relation: "Skins"}, function (data) {
             obj.Skins = data.items;
             });
             }*/
        }
    }

    function load() {
        if (!nexusData.items.length) {
            resource.get(function (data) {
                nexusData.totalSize = data.totalSize;
                nexusData.items.length = 0;
                for (var item in data.items) {
                    nexusData.items.push(new HeroOfNexus(data.items[item]));
                }
                if (heroId) {
                    prepareHeroPage(heroId);
                }
            });
        }
    }

    function prepareHeroPage(id) {
        heroId = id;
        if (nexusData.items.length) {
            nexusData.selectedItem = getByLink(heroId);
            breadcrumbsService.set(pageConfig.breadcrumbs);
            breadcrumbsService.add(nexusData.selectedItem);
            pageConfig.setTitle(nexusData.selectedItem.Title + ' | ' + pageConfig.title);
            loadDetails(nexusData.selectedItem);
            $anchorScroll();
        }
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
        prepareItem: prepareHeroPage,
        prepareList: function() {
            heroId = null;
            pageConfig.setTitle(pageConfig.title);
            breadcrumbsService.set(pageConfig.breadcrumbs);
        },
        load: load
    };
});

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

app.controller("common", function (nexusData, heroes, $router, $scope) {
    $router.config([
        {
            path: pageConfig.path,
            components: {
                "main": "list",
                "breadcrumbs": "breadcrumbs"
            }
        },
        {
            path: pageConfig.path + ":heroName",
            component: {
                "main": "hero",
                "breadcrumbs": "breadcrumbs"
            }
        }
    ]);
    $scope.nexusData = nexusData;
    heroes.load();
});

app.controller("ListController", function (heroes, $window, $location) {
    this.title = pageConfig.title;
    heroes.prepareList();
    $window.ga('send', 'pageview', { page: $location.url() });
    kament_page_name = 'NexusPage_' + pageConfig.pageId;
});

app.controller("HeroController", function (heroes, nexusData, $routeParams, $window, $location) {
    heroes.prepareItem($routeParams.heroName);
    $window.ga('send', 'pageview', { page: $location.url() });
    kament_page_name = 'StormHero_' + $routeParams.heroName;
});

app.controller("BreadcrumbsController", function (breadcrumbsService) {
    this.items = function() {
        return breadcrumbsService.items;
    };
});

app.filter("unsafe", function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    };
});
