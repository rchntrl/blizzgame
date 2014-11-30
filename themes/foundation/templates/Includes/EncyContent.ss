<% loop getLastUpdateEncyclopedia(20) %>
    <p style="clear:both">
        <a href="{$Link}" title="$Title.ATT">{$Parent.Title}: $Title</a><br />
        <% loop Icon %>
            <% if Icon %>
                <a href="{$LinkURL}" title="$TitleRU.ATT ($TitleEN.ATT)">
                    <img alt="$TitleRU.ATT ($TitleEN.ATT)" src="<% loop Icon %><% loop CroppedImage(40,40) %>$URL<% end_loop %><% end_loop %>" class="nolink" style="float:left;padding:7px 7px 7px 0px;">
                </a>
            <% else %>
                <img alt="" src="/assets/blizz-icon{$Top.SubsiteID}.png" class="nolink" width="40px" style="float:left;padding:7px 7px 7px 0px;">
            <% end_if %>
        <% end_loop %>

        <small>
            <% loop Content %>
                <% loop noHTML %>
                    $LimitWordCount(18)
                <% end_loop %>
            <% end_loop %>
        </small>
    </p>
<% end_loop %>