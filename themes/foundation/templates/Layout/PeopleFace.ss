<div class="page-section small-12 medium-12 large-12 columns">
    <article>
        <h1>$Title</h1>
        <div class="large-12 columns">
            <% if $Photo %>
                <div style="float: right; padding: 5px 20px 0;">$Photo.setRatioSize(200, 300)</div>
            <% end_if %>
            $Content
        </div>
        <div class="large-12 small-12 columns">
        <% if $Books %>
            <hr/>
            <h3>Произведения</h3>
            <ul class="book-list inline-list">
            <% loop $Books %>
                <li><a class="th" href="$AbsoluteLink">$Cover.CroppedImage(100, 150)</a></li>
            <% end_loop %>
            </ul>
        <% end_if %>
        <% if $Artist %>
            <div id="paints-cover">
                <h3>Оформление обложек</h3>
                <ul class="book-list inline-list">
                    <% loop $PaintsCover %>
                        <li><a class="th" href="$AbsoluteLink">$Cover.CroppedImage(100, 150)</a></li>
                    <% end_loop %>
                </ul>
            </div>
            <div id="paints-pages">
                <h3>Оформление страниц</h3>
                <ul class="book-list inline-list">
                    <% loop $PaintsPages %>
                        <li><a class="th" href="$AbsoluteLink">$Cover.CroppedImage(100, 150)</a></li>
                    <% end_loop %>
                </ul>
            </div>
            <div id="arts-section" style="display: none;">
                <hr/>
                <h3>Рисунки</h3>
                <ul class="gallery-list clearing-thumbs"></ul>
                <button type="button" data-url="$Link" data-start="0" class="button large-12 small-12 secondary load-more-art">Еще...</button>
            </div>
        <% end_if %>
        </div>
        $Form
    </article>
    <br/>
    <% include CommentList %>
</div>
<script src="$ThemeDir/javascript/blizz-people.js"></script>