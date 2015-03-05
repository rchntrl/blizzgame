<div class="people-face-section">
    <h1>$Title</h1>
    <div class="large-11 column">
        <ul class="ency inline-list">
            <% loop $PeopleFaces %>
                <li class="large-4 small-5">
                    <a class="element-link" href="{$Link}" title="$Title.ATT">
                        <div class="element-link-image">
                            <% if Image %>
                                <img class="icon-frame frame-56" alt="$Title" src="$Image.setSize(56, 56).getUrl()" />
                            <% else %>
                                <img class="icon-frame frame-56" src="$Top.SiteConfig.DefaultElementImage().setSize(56, 56).getUrl()" />
                            <% end_if %>
                        </div>
                        <span class="element-link-title">$Title</span>
                    </a>
                </li>
            <% end_loop %>
        </ul>
    </div>
    <div class="large-1 column">
        <ul class="side-nav tab-style">
            <% loop $GroupedByAlphabet %>
                <li <% if $Title == $Top.Letter %>class="active"<% end_if %>>
                    <a href="{$Top.Link}?letter=$Title">$Title</a>
                </li>
            <% end_loop %>
        </ul>
    </div>
</div>
