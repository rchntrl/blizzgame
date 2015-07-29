<h1>{{ cardGameData.selectedCard.TitleRU }}</h1>
<div class="medium-12">
    <a href="{{ cardGameData.pageUrl }}" class="small button secondary all" title="Вернуться к списку"><i class="fi-thumbnails"></i></a>
</div>
<div class="medium-4 column art-container">
    <img data-ng-src="{{ cardGameData.selectedCard.CoverCard.Filename }}" />
</div>
<div class="medium-3 column">
    <div class="book-info">
        <dl>
            <dt>Набор:</dt>
            <dd data-ng-bind="cardGameData.selectedCard.Set">
            </dd>
            <dt>Тип:</dt><dd data-ng-bind="cardGameData.selectedCard.Type"></dd>
            <dt>Качество:</dt><dd data-ng-bind="cardGameData.selectedCard.Rarity"></dd>
            <dt>Художник :</dt><dd data-ng-bind="cardGameData.selectedCard.Artist.TitleEN"></dd>
        </dl>
    </div>
</div>

<div class="medium-5 column">

</div>
<div class="medium-12 column">
    <div data-ng-bind-html="cardGameData.selectedCard.Rules | unsafe"></div>
    <div data-ng-bind-html="cardGameData.selectedCard.Flavor | unsafe"></div>
</div>
