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
    <% loop Children %>
        <div class="row">
            <div class="large-11 columns">
                <div class="image">
                    <a href="{$Link}" title="$TitleRU.ATT ($TitleEN.ATT)">
                        <% if Icon %>
                            <img alt="$TitleRU.ATT ($TitleEN.ATT)" src="$Url" />
                        <% else %>
                            <img alt="" src="assets/blizz-icon{$Top.SubsiteID}.png" />
                        <% end_if %>
                    </a>
                </div>
                <a href="{$Link}" title="{$Title.ATT}">$Title</a>
                $Content.NoHTML.LimitWordCount(20)
            </div>
        </div>
    <% end_loop %>
<% end_if %>