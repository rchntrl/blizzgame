<h1>$Title</h1>
<div class="large-12">
    <% include FilterWidget %>
    <ul class="clearing-thumbs small-block-grid-4">
        <% loop GalleryImages %>
            <li>
                <a href="$Top.Link()$LastLinkSegment" class="th" role="button" aria-label="Thumbnail" >
                    <img data-caption="$Title" src="$Image.CroppedImage(200, 200).getUrl()">
                </a>
            </li>
        <% end_loop %>
    </ul>
    <% include Imagination %>
</div>