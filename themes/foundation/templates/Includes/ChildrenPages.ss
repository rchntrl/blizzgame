<% if URLSegment == 'encyclopedia' %>
    <ul>
        <% loop Children %>
            <li>
                <a href="$Link">$Title</a>
                <% if Children %>
                    <ul class="inline-list">
                        <% loop Children %>
                            <li>
                                <a href="$Link">$Title</a>
                            </li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </li>
        <% end_loop %>
    </ul>
<% else %>
    <div class="row">
        <ul class="children-page-list">
            <% loop Children %>
                <li class="large-12 columns children-page">
                    <div class="element-link-image">
                        <a href="{$Link}" title="$TitleRU.ATT ($TitleEN.ATT)">
                            <% if Icon %>
                                <img class="icon-frame frame-56" alt="$TitleRU.ATT ($TitleEN.ATT)" src="$Icon.setSize(56, 56).getUrl()" />
                            <% else %>
                                <img class="icon-frame frame-56" alt="" src="$Top.SiteConfig.DefaultElementImage().setSize(56,56).getUrl()" />
                            <% end_if %>
                        </a>
                    </div>
                        <h6><a href="{$Link}" title="{$Title.ATT}">$Title</a></h6>
                        <p>$Content.NoHTML.LimitWordCountXML(20)</p>
                </li>

            <% end_loop %>
        </ul>
    </div>
<% end_if %>