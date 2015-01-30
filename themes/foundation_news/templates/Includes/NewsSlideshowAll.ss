<ul class="clearing-thumbs small-block-grid-4" data-clearing>
	<% loop SlideshowImages %>
        <li>
            <a title="$Description" rel="lightbox.$Up.Title" href="$Image.Link" class="th" role="button" aria-label="Thumbnail">
                <img data-caption="$Title" src="$Image.CroppedImage(200, 200).getUrl()" />
            </a>
        </li>
	<% end_loop %>
</ul>