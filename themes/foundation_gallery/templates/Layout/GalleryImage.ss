
<div class="large-12 columns">
<% cached $LastLinkSegment %>
    <div class="row art-container">
        <ul class="art-navigation-control button-group stack-for-small">
            <li><a class="small button secondary previous<% if $Previous %>" title="$Previous.Title" href="$Previous.Link"<% else %> disabled"<% end_if %> ><i class="fi-play"></i></a></li>
            <li><a class="small button secondary all" title="Вернуться к списку" href="$BackURL"><i class="fi-thumbnails"></i></a></li>
            <li><a class="small button secondary next<% if $Next %>" title="$Next.Title" href="$Next.Link"<% else %> disabled"<% end_if %> ><i class="fi-play"></i></a></li>
        </ul>
        <img title="$Title" class="gallery-art small-centered columns" src="$Image.setRatioSize(1024, 3000).getUrl()" />
    </div>
    <div class="art-info">
        <div class="right">
            <a download class="small button success" title="Скачать оригинал" href="$Image.downloadLink()">Скачать <i class="fi-download"></i></a>
        </div>
        <% if $Author %>
        <ul class="inline-list">
            <li class="heading">Автор:</li>
            <li><a href="$Author.AbsoluteLink()"> $Author.Title</a></li>
        </ul>
        <% end_if %>
        <ul class="inline-list">
            <li class="heading">Метки:</li>
            <% loop $Tags %>
                <li><a href="$Top.getFilterUrl('tag', $LastLinkSegment)">$TitleRU</a></li>
            <% end_loop %>
        </ul>
    </div>
<% end_cached %>
    <ul class="children-page-list">
        <% loop Tags %>
            <% if $LinkToPage %>
                <li class="children-page">
                    <div class="element-link-image">
                        <a href="$LinkToPage.Link" title="$TitleRU.ATT ($TitleEN.ATT)">
                            <% if Icon %>
                                <img class="icon-frame frame-56" alt="$TitleRU.ATT ($TitleEN.ATT)" src="$Icon.getUrl()" />
                            <% else %>
                                <img class="icon-frame frame-56" alt="" src="$Top.SiteConfig.DefaultElementImage.getUrl()" />
                            <% end_if %>
                        </a>
                    </div>
                    <h6><a href="$LinkToPage.Link" title="{$Title.ATT}">$Title</a></h6>
                    <p>$LinkToPage.Content.NoHTML.LimitWordCountXML(20)</p>
                </li>
            <% end_if %>
        <% end_loop %>
    </ul>
    <% if $NexusTags %>
        <h4>Герои Нексуса</h4>
        <ul class="children-page-list">
            <% loop NexusTags %>
                <li class="children-page">
                    <div class="element-link-image">
                        <a href="#" title="$TitleRU.ATT">
                            <% if Icon %>
                                <img class="icon-frame frame-56" alt="$TitleRU.ATT" src="$Icon.getUrl()" />
                            <% else %>
                                <img class="icon-frame frame-56" alt="" src="$Top.SiteConfig.DefaultElementImage.getUrl()" />
                            <% end_if %>
                        </a>
                    </div>
                    <h6><a href="#" title="{$TitleRU.ATT}">$TitleRU</a></h6>
                    <p>$Content.NoHTML.LimitWordCountXML(20)</p>
                </li>
            <% end_loop %>
        </ul>
    <% end_if %>
</div>
<% include CommentList %>
