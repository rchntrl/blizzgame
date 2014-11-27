<div class="<% if $Children || $Parent %>large-9 large-push-3<% else %>large-12<% end_if %> columns">
    <article>
        <h2>$Title</h2>
        <% if $Query %>
            <p class="searchQuery"><strong>You searched for &quot;{$Query}&quot;</strong></p>
        <% end_if %>

        <% if $Results %>
            <ul id="SearchResults">
                <% loop $Results %>
                    <li>
                        <a class="searchResultHeader" href="$Link">
                            <% if $MenuTitle %>
                                $MenuTitle
                            <% else %>
                                $Title
                            <% end_if %>
                        </a>
                        <p>$Content.LimitWordCountXML</p>
                        <a class="readMoreLink" href="$Link"
                           title="Read more about &quot;{$Title}&quot;"
                                >Read more about &quot;{$Title}&quot;...</a>
                    </li>
                <% end_loop %>
            </ul>
        <% else %>
            <p>Sorry, your search query did not return any results.</p>
        <% end_if %>

        <% if $Results.MoreThanOnePage %>
            <div id="PageNumbers">
                <% if $Results.NotLastPage %>
                    <a class="next" href="$Results.NextLink" title="View the next page">Next</a>
                <% end_if %>
                <% if $Results.NotFirstPage %>
                    <a class="prev" href="$Results.PrevLink" title="View the previous page">Prev</a>
                <% end_if %>
                <span>
                    <% loop $Results.Pages %>
                        <% if $CurrentBool %>
                            $PageNum
                        <% else %>
                            <a href="$Link" title="View page number $PageNum">$PageNum</a>
                        <% end_if %>
                    <% end_loop %>
                </span>
                <p>Page $Results.CurrentPage of $Results.TotalPages</p>
            </div>
        <% end_if %>
        $Form
    </article>
</div>
<% if $Children || $Parent %><%--Determine if Side Nav should be rendered, you can change this logic--%>
<div class="large-3 large-pull-9 columns">
    <div class="panel">
        <% include SideNav %>
    </div>
</div>
<% end_if %>