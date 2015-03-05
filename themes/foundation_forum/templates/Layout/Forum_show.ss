<% include ForumHeader %>
<h2 class="post-title">$ForumThread.Title</h2>
<% loop Posts %>
    <% include SinglePost %>
<% end_loop %>
<div class="row">
    <div class="large-2 column">
        <% if ForumThread.canCreate %>
            <a class="button success small round" href="$ReplyLink" title="<% _t('Forum_show_ss.CLICKREPLY', 'Click to Reply') %>"><% _t('Forum_show_ss.REPLY', 'Reply') %></a>
        <% end_if %>
    </div>
    <div class="large-2 column"><strong>$ForumThread.NumViews <% _t('Forum_show_ss.VIEWS','Views') %></strong></div>
    <div class="large-8 column">
        <% with Posts %>
            <% if $MoreThanOnePage %>
                <div class="right">
                    <ul class="pagination">
                        <% if $NotFirstPage %>
                            <li class="arrow"><a  href="$PrevLink">&laquo;</a></li>
                        <% else %>
                            <li class="arrow unavailable"><a href="#">&laquo;</a></li>
                        <% end_if %>
                        <% loop $Pages(10) %>
                            <% if $CurrentBool %>
                                <li class="current"><a href="#">$PageNum</a></li>
                            <% else %>
                                <% if $Link %>
                                    <li><a  href="$Link">$PageNum</a></li>
                                <% else %>
                                    ...
                                <% end_if %>
                            <% end_if %>
                        <% end_loop %>
                        <% if $NotLastPage %>
                            <li class="arrow"><a  href="$NextLink">&raquo;</a></li>
                        <% else %>
                            <li class="arrow unavailable"><a href="#">&raquo;</a></li>
                        <% end_if %>
                    </ul>
                </div>
            <% end_if %>
        <% end_with %>
        <div class="views">

        </div>
    </div>
</div>
<% if AdminFormFeatures %>
    <div class="forum-admin-features">
        <h3>Forum Admin Features</h3>
        $AdminFormFeatures
    </div>
<% end_if %>
<% include ForumFooter %>