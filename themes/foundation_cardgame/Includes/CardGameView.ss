<h1 data-ng-bind-html="cardGameData.selectedCard.TitleRU | unsafe"></h1>
<div class="medium-12">
    <a data-ng-href="{{ cardGameData.pageUrl }}" class="small button secondary all" title="Вернуться к списку"><i class="fi-thumbnails"></i></a>
</div>
<div class="medium-4 column art-container">
    <img data-ng-src="{{ cardGameData.selectedCard.CoverCard.Filename }}" />
</div>
<div class="medium-3 column">
    <div class="book-info">
        <dl>
            <dt>Набор:</dt>
            <dd data-ng-bind="cardGameData.title">
            </dd>
            <dt>Тип:</dt><dd data-ng-bind="cardGameData.selectedCard.Type"></dd>
            <dt>Класс:</dt><dd data-ng-bind="cardGameData.selectedCard.Class"></dd>
            <dt>Качество:</dt><dd data-ng-bind="cardGameData.selectedCard.Rarity"></dd>
            <dt>Художник :</dt><dd data-ng-bind="cardGameData.selectedCard.Artist.TitleEN"></dd>
        </dl>
    </div>
</div>

<div class="medium-5 column">
    <a target="_blank" data-ng-show="cardGameData.selectedCard.LinkToArt.ID" data-ng-href="{{ cardGameData.selectedCard.LinkToArt.Link }}">Ссылка на арт</a>
    <br/>
    <img data-ng-src="{{ cardGameData.selectedCard.LinkToArt.PageSize }}" />
</div>
<div class="medium-12 column">
    <div data-ng-bind-html="cardGameData.selectedCard.Rules | unsafe"></div>
    <div data-ng-bind-html="cardGameData.selectedCard.Flavor | unsafe"></div>
</div>
<hr/>
<div class="small-12 medium-12 columns">
    <h3>Карты из этого набора</h3>
    <ul class="card-list small-block-grid-4 medium-block-grid-8">
        <li data-ng-repeat="(key, card) in (filtered = (cardGameData.items | filter:search:strict)) | startFrom:cardGame.getStart() | limitTo:cardGame.getSize()">
            <a class="th hearthstone-link" href="{{ cardGameData.pageUrl + card.LastLinkSegment }}">
                <img class="card-img" data-ng-src="{{ card.CoverThumbnail }}" src="" data-ng-class="{ 'loading' :  !card.CoverThumbnail }" />
                <div class="info">
                    <p class="crop-text">{{ card.TitleRU }}</p>
                </div>
            </a>
        </li>
    </ul>
</div>
<div class="small-12 medium-12 columns">
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