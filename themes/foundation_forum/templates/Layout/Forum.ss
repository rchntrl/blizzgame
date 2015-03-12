<% include ForumHeader %>

<% if ForumAdminMsg %>
	<p class="forum-message-admin">$ForumAdminMsg</p>
<% end_if %>

<% if CurrentMember.isSuspended %>
	<p class="forum-message-suspended">
		$CurrentMember.ForumSuspensionMessage
	</p>
<% end_if %>

<% if ForumPosters = NoOne %>
	<p class="message error"><% _t('Forum_ss.READONLYFORUM', 'This Forum is read only. You cannot post replies or start new threads') %></p>
<% end_if %>
<% if canPost %>
	<a class="button success small round" href="{$Link}starttopic" title="<% _t('Forum_ss.NEWTOPIC','Click here to start a new topic') %>">Start new topic</a>
<% end_if %>

<div class="forum-features">
	<% if getStickyTopics(0) %>
		<table class="forum-sticky-topics" class="topicList" summary="List of sticky topics in this forum">
			<tr class="category">
				<td colspan="3"><% _t('Forum_ss.ANNOUNCEMENTS', 'Обьявления') %></td>
			</tr>
			<% loop getStickyTopics(0) %>
				<% include TopicListing %>
			<% end_loop %>
		</table>
	<% end_if %>

	<table class="forum-topics" summary="List of topics in this forum">
		<tr>
			<th class="odd"><% _t('Forum_ss.Threads','Обсуждения') %></th>
			<th class="odd"><% _t('Forum_ss.POSTS','Сообщения') %></th>
			<th class="even"><% _t('Forum_ss.LASTPOST','Последнее сообщение') %></th>
		</tr>
		<% if Topics %>
			<% loop Topics %>
				<% include TopicListing %>
			<% end_loop %>
		<% else %>
			<tr>
				<td colspan="3" class="forumCategory"><% _t('Forum_ss.NOTOPICS','В форуме нет тем, ') %><a href="{$Link}starttopic" title="<% _t('Forum_ss.NEWTOPIC') %>"><% _t('Forum_ss.NEWTOPICTEXT','кликните здесь, чтобы начать обусждение') %>.</a></td>
			</tr>
		<% end_if %>
	</table>

	<% if $Topics.MoreThanOnePage %>
        <div class="pagination-centered">
            <ul class="pagination">
				<% if $Topics.NotFirstPage %>
                    <li class="arrow"><a  href="$Topics.FirstLink">&laquo;</a></li>
				<% else %>
                    <li class="arrow unavailable"><a href="#">&laquo;</a></li>
				<% end_if %>
				<% loop $Topics.Pages(10) %>
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
				<% if $Topics.NotLastPage %>
                    <li class="arrow"><a  href="$Topics.LastLink">&raquo;</a></li>
				<% else %>
                    <li class="arrow unavailable"><a href="#">&raquo;</a></li>
				<% end_if %>
            </ul>
        </div>
	<% end_if %>
</div><!-- forum-features. -->
<% include ForumFooter %>