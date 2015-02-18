<% if URLSegment == 'encyclopedia' %>
    <div>
        <% loop Children %>
            <h3><a href="$Link">$Title</a></h3>
            <% if Children %>
                <ul class="ency side-nav inline-list">
                    <% loop Children %>
                        <li class="large-3 small-4">
                            <a class="element-link" href="{$Link}" title="$Title.ATT">
                                <div class="element-link-image">
                                    <% if Icon %>
                                        <img class="icon-frame frame-56" alt="$Title" src="$Icon.setSize(56, 56).getUrl()" />
                                    <% else %>
                                        <img class="icon-frame frame-56" src="$Top.SiteConfig.DefaultElementImage().setSize(56, 56).getUrl()" />
                                    <% end_if %>
                                </div>
                                <span class="element-link-title">$Title</span>
                            </a>
                        </li>
                    <% end_loop %>
                </ul>
            <% end_if %>
        <% end_loop %>
    </div>
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
                        <p class="crop-text">$Content.NoHTML.LimitWordCountXML(20)</p>
                </li>
            <% end_loop %>
        </ul>
    </div>
<% end_if %>