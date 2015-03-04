<% cached current_item.URLSegment %>
<div id="newsitem" class="container">
	<% with $current_item %>
		<div class="large-12">
            <h1>$Title</h1>
            <h3><%t NewsHolderPage.DATEPUBLISH "{date} by " date=$Published %><a href='$AuthorHelper.Link' title='$Author'>$Author</a></h3>
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
		</div>
	<% end_with %>
</div>
<% end_cached %>
<%-- If you want newsitems below this, include NewsItems.ss --%>
