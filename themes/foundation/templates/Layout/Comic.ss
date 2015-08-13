<div id="container">
    <div id="main">
        <div id='pages'>
            <div id='cover'>$Cover</div>
            <% loop $AttachedImages %>
                <div id="$Title" class="page">$Image</div>
            <% end_loop %>
        </div>
    </div>
    <nav class="control">
        <div class="button-bar">
            <ul class="button-group">
                <li>
                    <a id="first" title="На начало" class="small button"><i class="fi-home"></i></a>
                </li>
                <li>
                    <a id="back" title="Листаем назад" class="small button"><i class="fi-arrow-left"></i></a>
                </li>
                <li>
                    <a id="next" title="Листаем вперед" class="small button"><i class="fi-arrow-right"></i></a>
                </li>
                <li>
                    <a id="zoomin" title="Увеличить" class="small button"><i class="fi-zoom-in"></i></a>
                </li>
                <li>
                    <a id="zoomout" title="Уменьшить" class="small button"><i class="fi-zoom-out"></i></a>
                </li>
                <li>
                    <a id="fullscreen" title="Переключение между режимами экрана" class="small button"><i class="fi-arrows-out"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pages').wowBook({
            height: 700
            , width: 1100
            , centeredWhenClosed: true
            , hardcovers: true
            , turnPageDuration: 1000
            , numberedPages: [1, -2]
            , controls: {
                zoomIn: '#zoomin',
                zoomOut: '#zoomout',
                next: '#next',
                back: '#back',
                first: '#first',
                last: '#last',
                slideShow: '#slideshow',
                flipSound: '#flipsound',
                thumbnails: '#thumbs',
                fullscreen: '#fullscreen'
            }
            , scaleToFit: "#container"
            , thumbnailsPosition: 'bottom'
            , onFullscreenError: function () {
                var msg = "Fullscreen failed.";
                if (self != top) msg = "The frame is blocking full screen mode. Click on 'remove frame' button above and try to go full screen again."
                alert(msg);
            }
        }).css({'display': 'none', 'margin': 'auto'}).fadeIn(1000);

        $("#cover").click(function () {
            $.wowBook("#pages").advance();
        });

        var book = $.wowBook("#pages");

        function rebuildThumbnails() {
            book.destroyThumbnails();
            book.showThumbnails();
            $("#thumbs_holder").css("marginTop", -$("#thumbs_holder").height() / 2)
        }

        $("#thumbs_position button").on("click", function () {
            var position = $(this).text().toLowerCase();
            if ($(this).data("customized")) {
                position = "top";
                book.opts.thumbnailsParent = "#thumbs_holder";
            } else {
                book.opts.thumbnailsParent = "body";
            }
            book.opts.thumbnailsPosition = position;
            rebuildThumbnails();
        });
        $("#thumb_automatic").click(function () {
            book.opts.thumbnailsSprite = null;
            book.opts.thumbnailWidth = null;
            rebuildThumbnails();
        });
        $("#thumb_sprite").click(function () {
            book.opts.thumbnailsSprite = "images/thumbs.jpg";
            book.opts.thumbnailWidth = 136;
            rebuildThumbnails();
        });
        $("#thumbs_size button").click(function () {
            var factor = 0.02 * ( $(this).index() ? -1 : 1 );
            book.opts.thumbnailScale = book.opts.thumbnailScale + factor;
            rebuildThumbnails();
        });
    });
</script>