<ul class="gallery-list">
    <% loop GalleryImages %>
        <li>
            <a title="$Title" href="$Image.setRatioSize(1024, 3000).getUrl()" data-lightbox="example-set" data-title="$Title" class="th">
                <img class="art-thumbnail" src="$Image.CroppedImage(300, 100).getUrl()" />
            </a>
        </li>
    <% end_loop %>
</ul>