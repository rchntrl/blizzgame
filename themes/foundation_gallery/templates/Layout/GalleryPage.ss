<div class="gallery-section">
    <h1 class="gallery-title">$Title</h1>
    <% include FilterWidget %>
    <ul class="gallery-list clearing-thumbs large-block-grid-5 small-block-grid-4">
        <% loop GalleryImages %>
            <li>
                <a href="$Link" class="th" role="button" aria-label="Thumbnail" >
                    <img class="art-thumbnail" title="$Title" src="$Image.CroppedImage(200, 200).getUrl()" />
                    <p class="crop-text">$Title</p>
                </a>
            </li>
        <% end_loop %>
    </ul>
    <% include Imagination %>
</div>
