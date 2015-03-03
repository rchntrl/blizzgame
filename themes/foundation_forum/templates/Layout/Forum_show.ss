<% include ForumHeader %>
<h2 class="post-title">$ForumThread.Title</h2>
<% loop Posts %>
    <% include SinglePost %>
<% end_loop %>

<table class="forum-topics">
    <tr class="author">
        <td class="author">&nbsp;</td>
        <td class="topic">&nbsp;</td>
        <td class="views">
            <span><strong>$ForumThread.NumViews <% _t('Forum_show_ss.VIEWS','Views') %></strong></span>
        </td>
    </tr>
    <tr>
        <td class="page-numbers">
            <% if Posts.MoreThanOnePage %>
                <% if Posts.NotFirstPage %>
                    <a class="prev" href="$Posts.PrevLink" title="<% _t('Forum_show_ss.PREVTITLE','View the previous page') %>"><% _t('Forum_show_ss.PREVLINK','Prev') %></a>
                <% end_if %>
            <% end_if %>
        </td>
        <td class="gotoButtonTop" >
            <a href="#Header" title="<% _t('Forum_show_ss.CLICKGOTOTOP','Click here to go the top of this post') %>"><% _t('Forum_show_ss.GOTOTOP','Go to Top') %></a>
        </td>
        <td class="replyButton">
            <% if ForumThread.canCreate %>
                <a href="$ReplyLink" title="<% _t('Forum_show_ss.CLICKREPLY', 'Click to Reply') %>"><% _t('Forum_show_ss.REPLY', 'Reply') %></a>
            <% end_if %>

            <% if Posts.MoreThanOnePage %>
                <% if Posts.NotLastPage %>
                    <a class="next" href="$Posts.NextLink" title="<% _t('Forum_show_ss.NEXTTITLE','View the next page') %>"><% _t('Forum_show_ss.NEXTLINK','Next') %> &gt;</a>
                <% end_if %>
            <% end_if %>
        </td>
    </tr>
</table>

<% if AdminFormFeatures %>
    <div class="forum-admin-features">
        <h3>Forum Admin Features</h3>
        $AdminFormFeatures
    </div>
<% end_if %>

<% include ForumFooter %>