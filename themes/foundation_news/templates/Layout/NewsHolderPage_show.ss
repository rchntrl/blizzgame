<% cached current_item.URLSegment %>
<div id="newsitem" class="container">
    <div class="large-9 small-12 column">
		<% with $current_item %>
            <h1>$Title</h1>
            <h3>$PublishFrom.format('d.m.Y')</h3>
            <br />
            <div class="content large-12">
				<% if $Content %>
					$Content
				<% else %>
					$Synopsis
				<% end_if %>
				<% if $Type == External %>
                    <a href="$External" target="_blank">$Title</a>
				<% else_if $Type == Download %>
                    <a href="$Download.Link">$Title</a>
				<% end_if %>
            </div>
			<% if $Tags.Count > 0 %>
                <ul class="inline-list">
					<% loop Tags %>
                        <li><a href="$Link">$Title</a></li>
					<% end_loop %>
                </ul>
			<% end_if %>
			<% include NewsSlideshowAll %>
			<% if $AllowComments %>
				<% include CommentList %>
			<% end_if %>
		<% end_with %>
		<%-- If you want newsitems below this, include NewsItems.ss --%>
    </div>
	<div class="large-3 small-12 column">
		<% include LastComments %>
	</div>
</div>
<% end_cached %>

