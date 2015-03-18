<tr class="<% if IsSticky || IsGlobalSticky %>sticky<% end_if %> <% if IsGlobalSticky %>global-sticky<% end_if %>">
	<td class="topicName">
		<a class="topic-title" href="$Link">$Title</a>
		<p class="topic-summary">
			<% _t('TopicListing_ss.BY','От') %>
			<% with FirstPost %>
				<% with Author %>
					<% if Link %>
						<a href="$Link" title="<% _t('TopicListing_ss.CLICKTOUSER','Click here to view') %>"><% if Nickname %>$Nickname<% else %>Anon<% end_if %></a>
					<% else %>
						<span>Anon</span>
					<% end_if %>
				<% end_with %>
				$Created.Ago
			<% end_with %>
		</p>
	</td>
	<td class="count">
		$NumPosts
	</td>
	<td class="last-post">
		<% with LatestPost %>
			<p class="">$Created.Ago</p>
			<p class="">
				<% _t('TopicListing_ss.BY','от') %>
				<% with Author %>
					<% if Link %>
						<a href="$Link" title="<% _t('TopicListing_ss.CLICKTOUSER') %> <% if Nickname %>$Nickname.XML<% else %>Anon<% end_if %><% _t('TopicListing_ss.CLICKTOUSER2') %>">
							<% if Nickname %>$Nickname<% else %>Anon<% end_if %>
						</a>
					<% else %>
						<span>Anon</span>
					<% end_if %>
				<% end_with %> 
				<a href="$Link" title="<% sprintf(_t('TopicListing_ss.GOTOFIRSTUNREAD','Go to the first unread post in the %s topic.'),$Title.XML) %>"><i class="fi-anchor"></i></a>
			</p> 
		<% end_with %>
	</td>
</tr>