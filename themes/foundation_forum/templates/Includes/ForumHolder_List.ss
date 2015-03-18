<tr class="forumCategory">
    <td>
        <h5><a class="topicTitle" href="$Link">$Title</a></h5>
        <% if Content || Moderators %>
            <div class="summary">
                <p>$Content.LimitCharacters(80)</p>
                <% if Moderators %>
                    <p>Модераторы: <% loop Moderators %>
                        <a href="$Link">$Nickname</a>
                        <% if not Last %>, <% end_if %><% end_loop %></p>
                <% end_if %>
            </div>
        <% end_if %>
    </td>
    <td class="count post-details">
        $NumTopics
    </td>
    <td class="count post-details">
        $NumPosts
    </td>
    <td class="">
        <% if LatestPost %>
            <% with LatestPost %>
                <a class="topicTitle" href="$LastLink">
                    <p class="crop-text">$Title</p>
                </a>
                <p class="post-date">$Created.Ago</p>
                <% with Author %>
                    <p>от <% if Link %><a href="$Link"><% if Nickname %>$Nickname<% else %>Anon<% end_if %></a><% else %><span>Anon</span><% end_if %></p>
                <% end_with %>
            <% end_with %>
        <% end_if %>
    </td>
</tr>