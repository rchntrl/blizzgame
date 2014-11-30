<a href="$Link" title="Вернуться в галерею" rel="nofollow">&lt;&lt;Назад в
    галерею</a>
<h1>$Title</h1>
<div class="large-12">
    <% include FilterWidget %>
    <ul class="clearing-thumbs small-block-grid-4" data-clearing>
        <% loop GalleryImages %>
            <li>
                <a href="$Image.getUrl()" class="th" role="button" aria-label="Thumbnail" >
                    <img data-caption="$Title" src="$Image.CroppedImage(200, 200).getUrl()">
                </a>
            </li>
        <% end_loop %>
    </ul>
    <% include Pagination %>
</div>