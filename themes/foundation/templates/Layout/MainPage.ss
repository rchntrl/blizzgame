<% require themedCSS('hots') %>
<div class="orbit-container">
    <ul class="example-orbit" data-orbit>
        <% loop $OrbitNews.Limit(7) %>
            <li>
                <a href="$alternateAbsoluteLink"><img src="$Impression.CroppedImage(1924, 530).getUrl()" alt="slide 1" /></a>
                <div class="orbit-caption">
                    $Title
                </div>
            </li>
        <% end_loop %>
    </ul>
</div>
<div class="large-12 columns" xmlns="http://www.w3.org/1999/html">
    <section class="home-page-content">
        <div class="row">
            <div class="text-center panel">
                <h2>Heroes of the Storm</h2>
                <h3>Герои недели</h3>
            </div>
            <div class="large-5 columns">
                <% with $HomePageConfig %>
                    <div class="hero-select-area">
                        <ul class="hero-widget__thumbnail-list">
                            <% loop $HeroesRotation %>
                                <li class="hero-thumbnail released">
                                    <div xmlns="http://www.w3.org/1999/xhtml" class="hero-thumbnail__backing">
                                        <a xmlns="http://www.w3.org/1999/xhtml" href="javascript:;" class="hero-thumbnail__link $Class"></a>
                                    </div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                <% end_with %>
            </div>
            <div class="large-7 columns">
                $HomePageConfig.HeroesSaleText
            </div>
        </div>
        <div class="row">
            <hr>
            <div class="large-8 columns">
                <div class="text-center panel">
                    <h3>Последние пополнения в галерее</h3>
                    <ul class="gallery-list clearing-thumbs large-block-grid-3 small-block-grid-4">
                        <% loop $LastArts.Limit(6) %>
                            <li>
                                <a class="th" role="button" aria-label="Thumbnail" href="$AbsoluteLink">
                                    <img class="art-thumbnail" title="$Title" src="$Image.CroppedImage(230, 230).getUrl()" />
                                    <p class="crop-text">$Title</p>
                                </a>
                            </li>
                        <% end_loop %>
                    </ul>
                </div>
            </div>

            <% if $allNews %>
                <div class="large-4 small-12 column">
                    <ul class="side-nav">
                        <% loop $allNews %>
                            <li>
                                <a href="$alternateAbsoluteLink">$Title</a>
                            </li>
                        <% end_loop %>
                    </ul>
                </div>
            <% end_if %>
        </div>
        <a href="{$BaseHref}news/" data-start="12" class="button large-12 small-12 secondary load-more-art">Архив новостей</a>
    </section>
</div>