<div class="typography page_forum">
    <% include ForumHeader %>
    <div class="forum-topics">
        <table class="forum-topics forum-sticky-topics">
            <% if GlobalAnnouncements %>
                <tr>
                    <td colspan="4"><% _t('ForumHolder_ss.ANNOUNCEMENTS', 'Обьявления') %></td>
                </tr>
                <% loop GlobalAnnouncements %>
                    <% include ForumHolder_List %>
                <% end_loop %>
            <% end_if %>
            <% if ShowInCategories %>
                <% loop Forums %>
                    <tr>
                        <th>$Title</th>
                        <th><% _t('ForumHolder_ss.THREADS','Обсуждения') %></th>
                        <th><% _t('ForumHolder_ss.POSTS','Сообщения') %></th>
                        <th><% _t('ForumHolder_ss.LASTPOST','Последнее сообщение') %></th>
                    </tr>
                    <% loop CategoryForums %>
                        <% include ForumHolder_List %>
                    <% end_loop %>
                <% end_loop %>
            <% else %>
                <tr>
                    <th><% _t('ForumHolder_ss.FORUM','Форум') %></th>
                    <th><% _t('ForumHolder_ss.THREADS','Темы') %></th>
                    <th><% _t('ForumHolder_ss.POSTS','Сообщения') %></th>
                    <th><% _t('ForumHolder_ss.LASTPOST','Последнее сообщение') %></th>
                </tr>
                <% loop Forums %>
                    <% include ForumHolder_List %>
                <% end_loop %>
            <% end_if %>
        </table>
    </div>

    <% include ForumFooter %>
</div>
