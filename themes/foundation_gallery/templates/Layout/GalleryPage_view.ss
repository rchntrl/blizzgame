<link rel="stylesheet" type="text/less" href="$ThemeDir/css/gallery.css" />
<div class="large-10 columns">
    <div class="large-centered columns">
        <img class="gallery-image small-centered columns" src="$Image.setSize(1024, 760).getUrl()" />
    </div>
</div>
<aside class="large-2 columns">
    <h4 class="gallery-title">$Title</h4>
    <div class="artist">
        <div class="photo"> </div>
        <p><%t Gallery.AUTHOR 'Автор' %>: $Author.Title</p>
    </div>
    <ul class="inline-list">
        <% loop Tags %>
            <li><a href="$Top.getFilterUrl('tag', $LastLinkSegment)">$Title</a></li>
        <% end_loop %>
    </ul>
    $Previous.Thumbnail
    $Next.Thumbnail
</aside>
<% require javascript(themes/foundation/bower_components/jquery/dist/jquery.min.js) %>
<% require javascript(themes/foundation/javascript/gallery.js) %>