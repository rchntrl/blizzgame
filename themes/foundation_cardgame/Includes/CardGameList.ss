<h1>{{ cardGameData.Title }}</h1>
<div class="small-12 medium-12 columns">
    <div ng-show="cardGameData.totalSize > 1" class="small-12 columns">
        <label for="searchByTitle">Поиск</label>
        <input id="searchByTitle" type="text" placeholder="Поиск" data-ng-model="search.Keywords" />
    </div>
    <div ng-show="cardGameData.totalSize > 1" class="small-12 large-12 columns card-classes">
        <ul class="button-group large-block-grid-12 medium-block-grid-6 small-block-grid-4">
            <li><button type="button" class="button small secondary all" data-ng-model="search.Class" btn-radio="''">Все</button></li>
            <li data-ng-repeat="item in cardGameData.classes | filter: {hearthStone: true}">
                <button type="button" data-ng-class="item.class" class="button small secondary"
                        data-ng-model="search.Class"
                        btn-radio="'{{ item.value }}'">
                </button>
            </li>
        </ul>
    </div>
    <div class="small-12 medium-6 columns">

    </div>
    <div class="small-12 medium-12 columns">
        <div ng-hide="cardGameData.totalSize > 1" class="preloader"></div>
        <ul class="card-list small-block-grid-3 medium-block-grid-5">
            <li data-ng-repeat="(key, card) in (filtered = (cardGameData.items | filter:search:strict)) | startFrom:cardGame.getStart() | limitTo:cardGame.getSize()">
                <a class="th hearthstone-link" data-ng-href="{{ card.Link }}">
                    <img class="card-img" data-ng-src="{{ card.CoverThumbnail }}" src="" data-ng-class="{ 'loading' :  !card.CoverThumbnail }" />
                    <div class="info">
                        <p data-ng-bind-html="card.TitleRU | unsafe" class="crop-text"></p>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div ng-show="cardGameData.totalSize > 1" class="small-12 medium-12 columns">
        <div class="pagination-centered ng-scope">
            <pagination on-select-page="paginate(page)"
                        boundary-links="true"
                        previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"
                        max-size="5"
                        total-items="filtered.length"
                        page="cardGameData.currentPage"
                        items-per-page="cardGame.getSize()">
            </pagination>
        </div>
    </div>
</div>