<h1>$Title</h1>
<% if $PageConfig.View == 'AlbumView' %>
    <ul class="small-block-grid-3">
        <% loop PaginatedPages %>
            <li>
                <a class="th" href="$Link" title="$TitleRU" role="button">
                    <% if $Cover %>
                        <img alt="$MenuTitle" src="$Cover.albumView.getUrl()" />
                    <% else %>
                        <img alt="$MenuTitle" src="$SiteConfig.DefaultBookCover.albumView.getUrl()" />
                    <% end_if %>
                    <p class="crop-text">$MenuTitle</p>
                </a>
            </li>
        <% end_loop %>
    </ul>
<% else %>
    <ul class="small-block-grid-4">
        <% loop PaginatedPages %>
            <li>
                <a class="th" href="$Link" title="$TitleRU" role="button">
                    <% if $Cover %>
                        <img alt="$MenuTitle" src="$Cover.bookView.getUrl()" />
                    <% else %>
                        <img alt="$MenuTitle" src="$SiteConfig.DefaultBookCover.bookView.getUrl()" />
                    <% end_if %>
                    <p class="crop-text">$MenuTitle</p>
                </a>
            </li>
        <% end_loop %>
    </ul>
<% end_if %>
