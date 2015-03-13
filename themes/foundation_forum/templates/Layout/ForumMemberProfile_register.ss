
$Content
<div class="row"  id="UserProfile">
	<% if CurrentMember %>
		<p><% _t('ForumMemberProfile_register_ss.PLEASELOGOUT', 'Please logout before you register') %> - <a href="Security/logout"><% _t('ForumMemberProfile_register_ss.LOGOUT', 'Logout') %></a></p>
	<% else %>
		<div class="large-5 column">
			<h4>Авторизация</h4>
			$LoginForm
		</div>
		<div class="large-7 column">
            <h4>Регистрация</h4>
			$RegistrationForm
		</div>
	<% end_if %>
</div>

