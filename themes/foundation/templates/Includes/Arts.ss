<ul class="gallery-list clearing-thumbs large-block-grid-3 small-block-grid-4" data-clearing>
    <% loop GalleryImages %>
        <li>
            <a href="$Image.Link()" class="th" role="button" aria-label="Thumbnail" >
                <img class="art-thumbnail" data-caption="$Title" src="$Image.CroppedImage(300, 100).getUrl()" />
            </a>
        </li>
    <% end_loop %>
</ul>