<div class="row">
    <div class="small-12 columns">
        <label for="searchByTitle">Поиск по названию</label>
        <input id="searchByTitle" type="text" placeholder="Поиск по названию (вообще подумываю сделать поиск по ключевым словам)" data-ng-model="search.TitleRU" />
    </div>
</div>
<ul class="small-block-grid-4 medium-block-grid-5">
    <li data-ng-repeat="(key, card) in cardGameData.items | filter:search:strict">
        <a class="th" href="javascript:;">
            <img alt="card.TitleRU" data-ng-src="{{ card.CoverCard.Filename }}" />
            <p class="crop-text">{{ card.TitleRU }}</p>
        </a>
    </li>
</ul>