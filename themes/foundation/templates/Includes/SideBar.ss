<%--SideBar.ss is not used in the Foundation theme--%>
<aside class="left-off-canvas-menu">
    <ul class="off-canvas-list">
        <% loop Menu(1) %>
            <li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %>">
                <a href="$Link" title="Go to the $Title.ATT">$MenuTitle</a>
            </li>
            <% if not $Last %><li class="divider"></li><% end_if %>
        <% end_loop %>
    </ul>
</aside>