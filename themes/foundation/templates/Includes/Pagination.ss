<% if $PaginatedPages.MoreThanOnePage %>
    <div class="pagination-centered">
        <ul class="pagination">
            <% if $PaginatedPages.NotFirstPage %>
                <li class="arrow"><a  href="$PaginatedPages.PrevLink">&laquo;</a></li>
            <% else %>
                <li class="arrow unavailable"><a href="#">&laquo;</a></li>
            <% end_if %>
            <% loop $PaginatedPages.Pages(10) %>
                <% if $CurrentBool %>
                    <li class="current"><a href="#">$PageNum</a></li>
                <% else %>
                    <% if $Link %>
                        <li><a  href="$Link">$PageNum</a></li>
                    <% else %>
                        ...
                    <% end_if %>
                <% end_if %>
            <% end_loop %>
            <% if $PaginatedPages.NotLastPage %>
                <li class="arrow"><a  href="$PaginatedPages.NextLink">&raquo;</a></li>
            <% else %>
                <li class="arrow unavailable"><a href="#">&raquo;</a></li>
            <% end_if %>
        </ul>
    </div>
<% end_if %>