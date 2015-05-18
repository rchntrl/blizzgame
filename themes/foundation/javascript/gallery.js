var baseHref = angular.element(document.querySelector("base"));
baseHref.attr("href", baseHref.attr("href") + "gallery/");

var app = angular.module("gallery", [
    "ngRoute",
    "brantwills.paging"
]);

app.value("gallery", {
    dataUrl: baseHref.attr("href") + "ng/",
    pageUrl: baseHref.attr("href"),
    pageSize: 20,
    artNavigation: false,
    metaTags: {
        title: null,
        metaDescription: null,
        metaKeywords: null
    },
    reloadArts: false,
    currentArt: null
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            controller : "arts",
            templateUrl : "ng/template/?ID=NgGalleryList"
        })
        .when("/:pageName", {
            controller: "arts",
            templateUrl: "ng/template/?ID=NgGalleryView"
        })
    ;
    $locationProvider.html5Mode(true);
});

/**
 * @ngDoc controller
 * @name ng.module:gallery
 *
 * @property dataUrl
 * @property pageUrl
 * @property gallerySearch
 * @property reloadArts
 * @property appliedFilters
 * @property tags
 * @property arts
 * @property artists
 * @property total
 * @property LastLinkSegment
 * @property pageName
 * @property currentArtKey
 *
 * @description
 * gallery pagination, view, filter
 */
app.controller("arts", function (gallery, $scope, $http, $routeParams, $location, $window, $rootScope) {
    $scope.page = $routeParams.pageName ? $routeParams.pageName: null;
    var url = $routeParams.pageName ?
    gallery.dataUrl + "gallery-view" + "?ID=" + $routeParams.pageName :
    gallery.dataUrl + ($scope.arts ? "arts" : "gallery-list") + location.search;
    if ($routeParams.pageName && !gallery.currentArt) {
        gallery.reloadArts = true;
    }
    $(document).foundation();
    if (gallery.reloadArts) {
        $scope.loadingState = true;
        $http({url: url}).success(function(response) {
            $scope.loadingState = false;
            gallery.reloadArts = false;
            $.each(response, function(key) {
                gallery[key] = this;
            });
            if (gallery.gallerySearch && $.isEmptyObject(gallery.gallerySearch)) {
                gallery.gallerySearch = {};
            }
            $scope.gallery = gallery;
        });
    } else {
        $scope.gallery = gallery;
    }
    //$window.ga('send', 'pageview', { page: $location.url() });

    $scope.loadArts = function(url, f) {
        $scope.loadingState = true;
        $http({url: url}).success(function(response) {
            $scope.loadingState = false;
            gallery.reloadArts = false;
            $.each(response, function(key) {
                gallery[key] = this;
            });
            $scope.currentArt = $scope.arts[gallery.currentArtKey];
            if ($routeParams.pageName) {
                if (gallery.currentArtKey == 0) {
                    $scope.previousArt = gallery.arts[19];
                } else if (gallery.currentArtKey == 19) {
                    $scope.nextArt = gallery.arts[0];
                }
            }
            if (gallery.gallerySearch && $.isEmptyObject(gallery.gallerySearch)) {
                gallery.gallerySearch = {};
            }
            $scope.gallery = gallery;
        });
    };

    $scope.isUsedTag = function(obj) {
        if ($scope.gallerySearch.tag) {
            return typeof $scope.gallerySearch.tag  == "object" ?
                $.inArray(obj.LastLinkSegment, $scope.gallerySearch.tag) > 0 :
                obj.LastLinkSegment == $scope.gallerySearch.tag
            ;
        }
        return false;
    };

    $scope.applyFilter = function() {
        gallery.reloadArts = true;
        $location.search($.param(gallery.gallerySearch));
        $location.path("/");
    };

    $scope.selectSize = function(value) {
        if (gallery.gallerySearch.size != value) {
            if (value == "all") {
                delete gallery.gallerySearch.size;
            } else {
                gallery.gallerySearch.size = value;
            }
            gallery.appliedFilters.size = value;
            delete gallery.gallerySearch.start;
            $scope.applyFilter();
        }
    };

    $scope.setAuthor = function(obj) {
        if (typeof obj === "object") {
            gallery.gallerySearch.author = obj.LastLinkSegment;
            gallery.appliedFilters.author = obj;
        } else {
            delete gallery.gallerySearch.author;
            gallery.appliedFilters.author = null;
        }
        delete gallery.gallerySearch.start;
        $scope.applyFilter();
    };

    $scope.addFilterTag = function(obj) {
        var value = obj.LastLinkSegment;
        switch (typeof gallery.gallerySearch.tag) {
            case "object":
                gallery.gallerySearch.tag.push(value);
                break;
            case "string":
                gallery.gallerySearch.tag = [gallery.gallerySearch.tag, value];
                break;
            default:
                gallery.gallerySearch.tag = value;
                break;
        }
        delete gallery.gallerySearch.start;
        $scope.applyFilter();
    };

    $scope.deleteFilterTag = function(obj) {
        var value = obj.LastLinkSegment;
        if (typeof gallery.gallerySearch.tag === "object") {
            gallery.gallerySearch.tag.splice(gallery.gallerySearch.tag.indexOf(value), 1);
            if (gallery.gallerySearch.tag.length == 1) {
                gallery.gallerySearch.tag = gallery.gallerySearch.tag.shift();
            }
        } else if (typeof gallery.gallerySearch.tag === "string") {
            delete gallery.gallerySearch.tag;
        }
        delete gallery.gallerySearch.start;
        $scope.applyFilter();
    };

    $scope.paginate = function(page, pageSize) {
        $scope.currentPage = page;
        gallery.gallerySearch.start = (page - 1) * pageSize;
        $scope.applyFilter();
    };

    $scope.showArt = function(key) {
        gallery.currentArtKey = key;
        gallery.artNavigation = true;
        gallery.isFirstItem = gallery.currentArtKey == 0 && gallery.currentPage == 1;
        gallery.isLastItem = gallery.arts.length == (gallery.currentArtKey + 1) && gallery.isLastPage;
        gallery.currentArt = gallery.arts[gallery.currentArtKey];
        if (gallery.currentArtKey >= 1) {
            gallery.previousArt = gallery.arts[gallery.currentArtKey - 1];
        }
        if (gallery.currentArtKey == 18) {
            gallery.nextArt = gallery.arts[gallery.currentArtKey + 1];
        }
        gallery.reloadArts = true;
    };

    $scope.previous = function() {
        if (gallery.currentArtKey == 0) {
            gallery.gallerySearch.start = ($scope.currentPage - 1) * 20;
            gallery.currentArtKey = 19;
            $scope.loadArts(gallery.dataUrl + "arts?" + $.param(gallery.gallerySearch));
        } else {
            $scope.showArt(gallery.currentArtKey - 1);
            $location.path(gallery.currentArt.LastLinkSegment);
        }
    };

    $scope.next = function() {
        if (gallery.currentArtKey == 19) {
            gallery.gallerySearch.start = ($scope.currentPage) * 20;
            gallery.currentArtKey = 0;
            $scope.loadArts(gallery.dataUrl + "arts?" + $.param(gallery.gallerySearch));
        } else {
            $scope.showArt(gallery.currentArtKey + 1);
            $location.path(gallery.currentArt.LastLinkSegment);
        }
    };

    $scope.backToList = function() {
        gallery.reloadArts = gallery.arts.length == 0;
        $location.search(gallery.gallerySearch);
        $location.path("/");
    };
});
