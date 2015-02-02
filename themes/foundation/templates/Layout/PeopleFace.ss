<div class="page-section small-12 medium-12 large-12 columns">
    <article>
        <h1>$Title</h1>
        <div class="large-12 columns">
            <% if $Photo %>
                <div style="float: right; padding: 5px 20px 0;">$Photo.setRatioSize(200, 300)</div>
            <% end_if %>
            $Content
        </div>
        <hr/>
        <br/>
        <div class="large-12 columns">
        <% if $Writer %>
            <ul class="side-nav" >
            <% loop $Books %>
                <li><a href="$AbsoluteLink">$MenuTitle</a></li>
            <% end_loop %>
            </ul>
        <% end_if %>
        <% if $Artist %>
            <ul id="arts-container" class="gallery-list clearing-thumbs large-block-grid-3 small-block-grid-4" data-clearing>
                <% loop GalleryImages().Limit(12) %>
                    <li>
                        <a href="$Image.Link()" class="th" role="button" aria-label="Thumbnail" >
                            <img class="art-thumbnail" data-caption="$Title" src="$Image.CroppedImage(300, 100).getUrl()" />
                        </a>
                    </li>
                <% end_loop %>
            </ul>
            <button style="display: none;" type="button" data-url="$Link" data-start="12" class="button large-12 secondary load-more-art">Еще...</button>
        <% end_if %>
        </div>
        $Form
    </article>
</div>
<script src="$ThemeDir/javascript/blizz-people.js"></script>