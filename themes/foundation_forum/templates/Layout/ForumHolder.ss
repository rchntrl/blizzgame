<div class="typography page_forum">
    <% include ForumHeader %>
    <div class="forum-topics">
        <table class="forum-topics forum-sticky-topics">
            <% if GlobalAnnouncements %>
                <tr>
                    <td colspan="4"><% _t('ForumHolder_ss.ANNOUNCEMENTS', 'Announcements') %></td>
                </tr>
                <% loop GlobalAnnouncements %>
                    <% include ForumHolder_List %>
                <% end_loop %>
            <% end_if %>
            <% if ShowInCategories %>
                <% loop Forums %>
                    <tr>
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
                <tr>
                    <th><% _t('ForumHolder_ss.FORUM','Forum') %></th>
                    <th><% _t('ForumHolder_ss.THREADS','Threads') %></th>
                    <th><% _t('ForumHolder_ss.POSTS','Posts') %></th>
                    <th><% _t('ForumHolder_ss.LASTPOST','Last Post') %></th>
                </tr>
                <% loop Forums %>
                    <% include ForumHolder_List %>
                <% end_loop %>
            <% end_if %>
        </table>
    </div>

    <% include ForumFooter %>
</div>
