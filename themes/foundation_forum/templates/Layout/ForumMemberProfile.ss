$Content
<% if Form %>
	<div id="UserProfile">
		<% if $CurrentUser.Nickname == '' %>
            <h4>Будем редиректить на эту страницу, пока не укажете себе псевдоним))</h4>
		<% end_if %>
		$Form
	</div>
<% end_if %>
<% include ForumFooter %>