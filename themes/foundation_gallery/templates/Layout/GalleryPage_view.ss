<link rel="stylesheet" type="text/less" href="$ThemeDir/css/gallery.css" />
<div class="large-10 columns">
    <div class="large-centered columns">
        <img class="gallery-image small-centered columns" src="$GalleryImage.Image.getUrl()" />
    </div>
</div>
<aside class="large-2 columns">
    <h4 class="gallery-title">$Title</h4>
    <div class="artist">
        <div class="photo"> </div>
        <p><%t Gallery.AUTHOR 'Автор' %>: $GalleryImage.Author().Title</p>
    </div>
    <ul class="inline-list">
        <% loop $GalleryImage.Tags() %>
            <li><a href="$Top.getTagUrl($LastLinkSegment)">$Title</a></li>
        <% end_loop %>
    </ul>
</aside>
<% require javascript(themes/foundation/bower_components/jquery/dist/jquery.min.js) %>
<% require javascript(themes/foundation/javascript/gallery.js) %>