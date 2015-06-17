<div class="small-12 medium-12 columns">
    <div class="small-12 columns">
        <label for="searchByTitle">Поиск по названию</label>
        <input id="searchByTitle" type="text" placeholder="Поиск по названию" data-ng-model="search.TitleRU" />
    </div>
    <div class="small-12 medium-6 columns">
        <ul class="button-group medium-block-grid-5">
            <li><button type="button" class="button small secondary" data-ng-model="search.Class" btn-radio="''">Все</button></li>
            <li data-ng-repeat="item in cardGameData.classes | filter: {hearthStone: true}">
                <button type="button" class="button small secondary"
                        data-ng-bind="item.title"
                        data-ng-model="search.Class"
                        btn-radio="'{{ item.value }}'">
                    <i class="class-icon {{ item.class }}"></i>
                </button>
            </li>
        </ul>
    </div>
    <div class="small-12 medium-6 columns">
        {{filtered.length}}
    </div>

    <ul class="card-list small-block-grid-4 medium-block-grid-5">
        <li data-ng-repeat="(key, card) in (filtered = (cardGameData.items | filter:search:strict)) | startFrom:cardGame.getStart() | limitTo:cardGame.getSize()">
            <a class="th hearthstone-link" href="javascript:;"
               data-tooltip-placement="right"
               data-tooltip-popup-delay="600"
               data-tooltip-animation="true"
               data-tooltip-html-unsafe="{{ '<div class=rules>' + card.Rules + '<div class=flavor>' + card.Flavor + '</div>' }}">
                <img data-ng-src="{{ card.CoverCard.Filename }}" src="" data-ng-class="{ 'loading' :  !card.CoverCard.Filename }" />
                <div class="info">
                    <p class="crop-text">{{ card.TitleRU }}</p>
                </div>
            </a>
        </li>
    </ul>
    <div class="pagination-centered ng-scope">
        <pagination on-select-page="paginate(page)"
                    boundary-links="true"
                    previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"
                    max-size="5"
                    total-items="filtered.length"
                    page="cardGameData.currentPage"
                    items-per-page="cardGame.getSize()" >
        </pagination>
    </div>
</div>