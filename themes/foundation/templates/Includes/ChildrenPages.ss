
    <% loop Children %>
        <div class="PageHolderRow">
            <% loop Icon %>
                <div class="PageHolderImg">
                    <% if Icon %>
                        <% if Content %><a href="{$LinkURL}" title="$TitleRU.ATT ($TitleEN.ATT)"><% end_if %>
                        <img alt="$TitleRU.ATT ($TitleEN.ATT)" src="<% loop Icon %><% loop CroppedImage(64,64) %>$URL<% end_loop %><% end_loop %>" class="nolink">
                        <% if Content %></a><% end_if %>
                    <% else %>
                        <img alt="" src="/assets/blizz-icon{$Top.SubsiteID}.png" class="nolink">
                    <% end_if %>
                </div>
            <% end_loop %>
            <div class="PageHolderContent">
                <% if Content %>
                    <a href="{$Link}" title="{$Title.ATT}">$Title</a>
                <% else %>
                    <% if Children %>
                        <a href="{$Link}" title="{$Title.ATT}">$Title</a>
                    <% else %>
                        <% if LinkTo %>
                            <a href="{$Link}" title="{$Title.ATT}">$Title</a>
                        <% else %>
                            <i>$Title</i>
                        <% end_if %>
                    <% end_if %>
                <% end_if %><br />
                <% if LinkTo %>
                    <% loop LinkTo %>
                        <% loop Content.NoHTML %>
                            <% loop LimitWordCount(20) %>
                                $NoHTML
                            <% end_loop %>
                        <% end_loop %>
                    <% end_loop %>
                <% else %>
                    <% loop Content.NoHTML %>
                        <% loop LimitWordCount(20) %>
                            $NoHTML
                        <% end_loop %>
                    <% end_loop %>
                <% end_if %>
            </div>
        </div>
    <% end_loop %>