<div class="small-12 medium-12 large-12 columns">
    <h1>$Title</h1>
    <ul class="small-block-grid-4">
        <% loop PaginatedPages %>
            <li>
                <a href="$Top.Link()$LastLinkSegment" role="button">
                    <% if $Cover.CroppedImage(240, 390).getUrl() %>
                        <img alt="$MenuTitle" src="$Cover.CroppedImage(240, 390).getUrl()" />
                    <% else %>
                        <img alt="$MenuTitle" src="$SiteConfig.DefaultBookCover.CroppedImage(240, 390).getUrl()" />
                    <% end_if %>
                    $MenuTitle
                </a>
            </li>
        <% end_loop %>
    </ul>
    <% include Pagination %>
</div>