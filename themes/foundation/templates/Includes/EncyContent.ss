<% control getLastUpdateEncyclopedia(20) %>
    <p style="clear:both">
        <a href="{$Link}" title="$Title.ATT">{$Parent.Title}: $Title</a><br />
        <% control Icon %>
            <% if Icon %>
                <a href="{$LinkURL}" title="$TitleRU.ATT ($TitleEN.ATT)">
                    <img alt="$TitleRU.ATT ($TitleEN.ATT)" src="<% control Icon %><% control CroppedImage(40,40) %>$URL<% end_control %><% end_control %>" class="nolink" style="float:left;padding:7px 7px 7px 0px;">
                </a>
            <% else %>
                <img alt="" src="/assets/blizz-icon{$Top.SubsiteID}.png" class="nolink" width="40px" style="float:left;padding:7px 7px 7px 0px;">
            <% end_if %>
        <% end_control %>

        <small>
            <% control Content %>
                <% control noHTML %>
                    $LimitWordCount(18)
                <% end_control %>
            <% end_control %>
        </small>
    </p>
<% end_control %>