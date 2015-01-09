<div class="small-12 medium-12 large-12 columns">
    <h1>$Title</h1>
    <ul class="small-block-grid-4">
        <% loop PaginatedPages %>
            <li>
                <a href="$Top.Link()$LastLinkSegment" role="button">
                    $Title
                </a>
            </li>
        <% end_loop %>
    </ul>
    <% include Pagination %>
</div>