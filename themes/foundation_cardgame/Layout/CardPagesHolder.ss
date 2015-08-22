<div class="small-12 medium-12 large-12 columns">
    <h1>$Title</h1>
    <ul class="small-block-grid-4">
        <% loop Children %>
            <li>
                <a class="th" href="$Link" title="$Title" role="button">
                    <% if $Image %>
                        <img alt="$MenuTitle" src="$Image.SetRatioSize(240, 370).getUrl()" />
                    <% else %>
                        <img alt="$MenuTitle" />
                    <% end_if %>
                    <p class="crop-text">$MenuTitle</p>
                </a>
            </li>
        <% end_loop %>
    </ul>
</div>