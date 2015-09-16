<nav role="navigation" data-ng-controller="breadcrumbs">
    <ul data-ng-show="!breadcrumbs" class="breadcrumbs">
        <% if $isForumBreadcrumbs($Breadcrumbs) %>
           <% loop $fixForumBreadcrumb($Breadcrumbs) %>
               <li<% if $Last %> class="current"<% end_if %>>$Text</li>
            <% end_loop %>
        <% else %>
            $Breadcrumbs
        <% end_if %>
    </ul>
    <ul data-ng-show="breadcrumbs" class="breadcrumbs">
        <li data-ng-repeat="crumb in breadcrumbs">{{ crumb.Title }}</li>
    </ul>
</nav>
