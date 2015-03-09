<nav role="navigation">
    <ul class="breadcrumbs">
        <% if $isForumBreadcrumbs($Breadcrumbs) %>
           <% loop $fixForumBreadcrumb($Breadcrumbs) %>
               <li<% if $Last %> class="current"<% end_if %>>$Text</li>
            <% end_loop %>
        <% else %>
            $Breadcrumbs
        <% end_if %>
    </ul>
</nav>
