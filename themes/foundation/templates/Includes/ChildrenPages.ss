
    <% control Children %>
        <div class="PageHolderRow">
            <% control Icon %>
                <div class="PageHolderImg">
                    <% if Icon %>
                        <% if Content %><a href="{$LinkURL}" title="$TitleRU.ATT ($TitleEN.ATT)"><% end_if %>
                        <img alt="$TitleRU.ATT ($TitleEN.ATT)" src="<% control Icon %><% control CroppedImage(64,64) %>$URL<% end_control %><% end_control %>" class="nolink">
                        <% if Content %></a><% end_if %>
                    <% else %>
                        <img alt="" src="/assets/blizz-icon{$Top.SubsiteID}.png" class="nolink">
                    <% end_if %>
                </div>
            <% end_control %>
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
                    <% control LinkTo %>
                        <% control Content.NoHTML %>
                            <% control LimitWordCount(20) %>
                                $NoHTML
                            <% end_control %>
                        <% end_control %>
                    <% end_control %>
                <% else %>
                    <% control Content.NoHTML %>
                        <% control LimitWordCount(20) %>
                            $NoHTML
                        <% end_control %>
                    <% end_control %>
                <% end_if %>
            </div>
        </div>
    <% end_control %>