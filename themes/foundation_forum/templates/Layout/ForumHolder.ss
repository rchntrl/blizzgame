<% include ForumHeader %>

<table class="forum-topics">

    <% if GlobalAnnouncements %>
        <tr class="">
            <td colspan="4"><% _t('ForumHolder_ss.ANNOUNCEMENTS', 'Announcements') %></td>
        </tr>
        <% loop GlobalAnnouncements %>
            <% include ForumHolder_List %>
        <% end_loop %>
    <% end_if %>

    <% if ShowInCategories %>
        <% loop Forums %>
            <tr class="">
                <th>$Title</th>
                <th><% _t('ForumHolder_ss.THREADS','Threads') %></th>
                <th><% _t('ForumHolder_ss.POSTS','Posts') %></th>
                <th><% _t('ForumHolder_ss.LASTPOST','Last Post') %></th>
            </tr>
            <% loop CategoryForums %>
                <% include ForumHolder_List %>
            <% end_loop %>
        <% end_loop %>
    <% else %>
        <tr class="">
            <td><% _t('ForumHolder_ss.FORUM','Forum') %></td>
            <td><% _t('ForumHolder_ss.THREADS','Threads') %></td>
            <td><% _t('ForumHolder_ss.POSTS','Posts') %></td>
            <td><% _t('ForumHolder_ss.LASTPOST','Last Post') %></td>
        </tr>
        <% loop Forums %>
            <% include ForumHolder_List %>
        <% end_loop %>
    <% end_if %>
</table>

<% include ForumFooter %>