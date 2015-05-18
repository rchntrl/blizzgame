<div class="gallery-section">
    <h1 class="gallery-title">$Title</h1>
    <!--filter start-->
    <dl class="sub-nav">
        <dt><%t Gallery.FILTER_SIZE_TITLE 'Фильтр по размерам' %>:</dt>
        <dd data-ng-repeat="item in gallery.sizes"
            data-ng-class="{ 'active': item.Name == gallery.appliedFilters.size }">
            <a data-ng-click="selectSize(item.Name)" href="javascript:;" title="{{ item.Title }}" >{{ item.MenuTitle }}</a>
        </dd>
    </dl>
    <dl id="applied-filters" class="sub-nav" data-ng-show="gallery.appliedFilters.tag.length">
        <h4 id="inline-lists"></h4>
        <dt><%t Gallery.FILTER_SIZE_TITLE 'Примененные теги' %>:</dt>
        <dd data-ng-repeat="tag in gallery.appliedFilters.tag | orderBy : 'TitleRU'">
            <a data-ng-click="deleteFilterTag(tag)" href="javascript:;" title="{{ tag.TitleEN }}">
                <span class="label radius">{{ tag.TitleRU }} <i class="fi-x"></i></span>
            </a>
        </dd>
    </dl>
    <ul class="button-group">
        <li>
            <button data-dropdown="filter-by-author" aria-controls="filter-by-author" aria-expanded="false" class="small secondary radius button dropdown">
                <%t Gallery.FILTER_AUTHOR_TITLE 'Фильтр по художнику' %>
            </button>
            <a href="javascript:;" data-ng-show="gallery.appliedFilters.author" data-ng-click="setAuthor('')" class="small radius button">
                <span>{{ gallery.appliedFilters.author.TitleEN }}</span> <i class="fi-x"></i>
            </a>
            <br>
            <ul id="filter-by-author" data-dropdown-content class="small f-dropdown" aria-hidden="true" tabindex="-1">
                <li data-ng-hide="artist.LastLinkSegment == gallery.gallerySearch.author"  data-ng-repeat="artist in gallery.artists">
                    <a data-ng-click="setAuthor(artist)" href="javascript:;"><span>{{ artist.Title }}</span></a>
                </li>
            </ul>
        </li>

        <li>
            <button data-dropdown="filter-by-tag" aria-controls="filter-by-tag" aria-expanded="false" class="small secondary radius button dropdown">
                <%t Gallery.FILTER_TAG_TITLE 'Фильтр по тегам' %>
            </button>
            <br>
            <ul id="filter-by-tag" data-dropdown-content class="small f-dropdown" aria-hidden="true" tabindex="-1">
                <li  data-ng-hide="isUsedTag(tag)" data-ng-repeat="tag in gallery.tags | orderBy : 'TitleRU'">
                    <a data-ng-click="addFilterTag(tag)" href="javascript:;"><span data-ng-bind="tag.Title"></span></a>
                </li>
            </ul>
        </li>
    </ul>
    <!--filter end-->
    <ul class="gallery-list clearing-thumbs large-block-grid-5 medium-block-grid-4 small-block-grid-2" data-ng-class="{ 'loading' : loadingState == true }">
        <li data-ng-repeat="(key,art) in gallery.arts">
            <a data-ng-href="{{art.Link}}" data-ng-click="showArt(key)" class="th" role="button" aria-label="Thumbnail">
                <img class="art-thumbnail" title="{{ art.Title }}" data-ng-src="{{ art.Image.Thumbnail }}" />
                <p class="crop-text">{{ art.Title }}</p>
            </a>
        </li>
    </ul>
</div>
<div class="pagination-centered">
    <paging
            class="small"
            page="gallery.currentPage"
            page-size="gallery.pageSize"
            total="gallery.total"
            ul-class="pagination"
            active-class="current"
            paging-action="paginate(page, pageSize)">
    </paging>
</div>