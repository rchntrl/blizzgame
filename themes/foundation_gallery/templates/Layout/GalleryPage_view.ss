<link rel="stylesheet" type="text/less" href="$ThemeDir/css/gallery.css" />
<div class="large-12 columns">
    <div class="large-centered columns">
        <img class="gallery-image small-centered columns" src="$Image.setRatioSize(1024, 3000).getUrl()" />
    </div>
    <div class="art-info">
        <div class="artist">
            <%t Gallery.AUTHOR 'Автор: {Name}' Name=$Author.Title %>
        </div>
    </div>
    <div class="row">
        <ul class="children-page-list">
            <% loop Tags %>
                <li class="large-12 columns children-page">
                    <div class="element-link-image">
                        <a href="{$Link}" title="$TitleRU.ATT ($TitleEN.ATT)">
                            <% if Icon %>
                                <img class="icon-frame frame-56" alt="$TitleRU.ATT ($TitleEN.ATT)" src="$Url" />
                            <% else %>
                                <img class="icon-frame frame-56" alt="" src="$Top.SiteConfig.DefaultElementImage.getUrl()" />
                            <% end_if %>
                        </a>
                    </div>
                    <h6><a href="{$Link}" title="{$Title.ATT}">$Title</a></h6>
                    <p>$LinkToPage.Content.NoHTML.LimitWordCountXML(20)</p>
                </li>

            <% end_loop %>
        </ul>
    </div>
</div>

<% require javascript(themes/foundation/bower_components/jquery/dist/jquery.min.js) %>
<% require javascript(themes/foundation/javascript/gallery.js) %>