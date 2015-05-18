<div class="large-12 columns">
    <div class="row art-container">
        <ul class="art-navigation-control button-group stack-for-small" data-ng-show="gallery.artNavigation">
            <li><button data-ng-click="previous()" data-ng-disabled="gallery.isFirstItem" class="small button secondary previous"><i class="fi-play"></i></button></li>
            <li><button data-ng-click="backToList()" class="small button secondary all" title="Вернуться к списку"><i class="fi-thumbnails"></i></button></li>
            <li><button data-ng-click="next()" data-ng-disabled="gallery.isLastItem" class="small button secondary next" title=""><i class="fi-play"></i></button></li>
        </ul>
        <div>
            <img title="{{ gallery.currentArt.Title }}" class="gallery-art small-centered columns" data-ng-src="{{ gallery.currentArt.Image.PageSize }}" />
        </div>
    </div>
    <div class="art-info">
        <div class="right">
            <a class="small button success" title="Скачать оригинал" target="_blank" data-ng-href="{{ gallery.currentArt.Image.Original }}">Скачать <i class="fi-download"></i></a>
        </div>
        <ul data-ng-show="gallery.currentArt.Author" class="inline-list">
            <li class="heading">Автор:</li>
            <li><a data-ng-href="{{ gallery.currentArt.Author.Link }}"> {{ gallery.currentArt.Author.Title }} </a></li>
        </ul>
        <ul class="inline-list">
            <li class="heading">Метки:</li>
            <li data-ng-repeat="item in gallery.elementLinks">
                <a href="javascript:;" data-ng-click="addFilterTag(item)" title="{{ item.Title }}">{{ item.Title }}</a>
            </li>
        </ul>
    </div>

    <ul class="children-page-list">
        <li data-ng-repeat="item in gallery.elementLinks" class="children-page" data-ng-if="item.LinkToPageID !== 0">
            <div class="element-link-image">
                <a href="{{ item.Link }}" title="{{ item.Title }}">
                    <img class="icon-frame frame-56" alt="{{ item.Title }}" data-ng-src="{{ item.Icon }}" />
                </a>
            </div>
            <h6><a href="{{ item.Link }}" title="{{ item.Title }}">{{ item.Title }}</a></h6>
            <p>{{ item.SummaryText }}</p>
        </li>
    </ul>
</div>