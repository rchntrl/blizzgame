<% with ForumHolder %>
	<div class="forum-footer">
		<% if $CurrentlyOnlineEnabled %>
		<div>
			<strong><% _t('ForumFooter_ss.CURRENTLYON','Сейчас онлайн:') %></strong>
			<% if $CurrentlyOnline %>
            <ul class="inline-list">
				<% loop CurrentlyOnline %>
					<li>
						<% if Link %>
                            <a class="element-link" href="$Link" title="<% if Nickname %>$Nickname<% else %>Anon<% end_if %>">
                                <span class="element-link-image">
                                    <img class="icon-frame frame-56" src="$FormattedAvatar" />
								</span>
                            </a>
						<% else %>
                            <span>Anon</span>
						<% end_if %>
                    </li>
				<% end_loop %>
            </ul>
			<% else %>
				<span><% _t('ForumFooter_ss.NOONLINE','Нет никого в онлайне.') %></span>
			<% end_if %>
		</div>
		<% end_if %>
		<p>
			<strong><% _t('ForumFooter_ss.LATESTMEMBER','Приветствуем нового пользователя:') %></strong>
			<% if $LatestMembers(1) %>
				<% loop $LatestMembers(1) %>
					<% if Link %>
						<a href="$Link" <% if Nickname %>title="$Nickname<% _t('ForumFooter_ss.ISONLINE') %>"<% end_if %>><% if Nickname %>$Nickname<% else %>Anon<% end_if %></a><% if Last %><% else %>,<% end_if %> 
					<% else %>
						<span>Anon</span><% if Last %><% else %>,<% end_if %> 
					<% end_if %>
				<% end_loop %>
			<% end_if %>
		</p>
	</div><!-- forum-footer. -->
<% end_with %>
<script type="text/javascript" src="framework/thirdparty/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
	$("#Form_PostMessageForm").attr("novalidate", true);
    tinyMCE.init({
        theme : "advanced",
        mode : "none",
        plugins : "bbcode",
        theme_advanced_buttons1 : "bold,italic,underline,undo,redo,link,unlink,image,forecolor,removeformat,cleanup, code, showbbcode",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        content_css : "{$BaseHref}{$ThemeDir}/css/bbcode.css",
		height: 400,
        entity_encoding : "raw",
        add_unload_trigger : false,
        remove_linebreaks : false,
        inline_styles : false,
        convert_fonts_to_spans : false,
    });
    tinyMCE.execCommand('mceToggleEditor', false, 'Form_PostMessageForm_Content');
</script>