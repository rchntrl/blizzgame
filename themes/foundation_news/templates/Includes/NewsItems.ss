<ul id="newsitems" class="side-nav">
	<% loop NewsArchive(3) %> <%-- Check code/extensions/NewsExtension.php for configuration --%>
		<li>
			<% if $Type == external && Top.SiteConfig.ReturnExternal %>
               <a href='$External' target="_blank">$Title</a>
			<% else_if $Type == download && Top.SiteConfig.ReturnExternal %>
               <a href='$Download.Link' title='Файл для скачивания'>$Title (<%t NewsHolderPage.DOWNLOADABLE "Скачать" %>)</a>
			<% else %>
               <a class="blank" href="$alternateAbsoluteLink">$Title</a>
			<% end_if %>
		</li>
	<% end_loop %>
</ul>