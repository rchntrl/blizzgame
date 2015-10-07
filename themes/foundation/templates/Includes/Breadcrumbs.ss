<nav role="navigation">
    <div ng-viewport="breadcrumbs" data-ng-if="!breadcrumbs">
        <ul class="breadcrumbs">
            <% if $isForumBreadcrumbs($Breadcrumbs) %>
                <li><a href="{$baseUrl}">$SiteConfig.Title</a></li>
                <% loop $fixForumBreadcrumb($Breadcrumbs) %>
                    <li<% if $Last %> class="current"<% end_if %>>$Text</li>
                <% end_loop %>
            <% else %>
                $Breadcrumbs
            <% end_if %>
        </ul>
    </div>
</nav>
