<ul class="gallery-list">
    <% loop GalleryImages %>
        <li>
            <a title="$Title" href="$AbsoluteLink" class="th">
                <img class="art-thumbnail" src="$Image.CroppedImage(300, 100).getUrl()" />
            </a>
        </li>
    <% end_loop %>
</ul>