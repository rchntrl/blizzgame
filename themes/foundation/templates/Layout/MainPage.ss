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
<div class="row">
    <section class="home-page-content">
        <% with $HomePageConfig %>
            <div  style="background: url($HeroesBackground.getUrl()); background-size: cover">
                <div id="heroes-section" class="panel">
                    <h2 class="page__title text-center">Heroes of the Storm</h2>
                    <h3 class="page__title text-center">Герои недели</h3>
                    <div class="hero-select-area">
                        <ul class="inline-list hero-widget__thumbnail-list">
                            <% loop $HeroesRotation %>
                                <li>
                                    <div class="hero-thumbnail released">
                                        <div class="hero-thumbnail__backing">
                                            <a title="$MenuTitle" href="javascript:;" class="hero-thumbnail__link $Class"></a>
                                        </div>
                                    </div>
                                    <span class="hero-title">$Title</span>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                    <div class="sales-text">
                        $HeroesSaleText
                    </div>
                </div>
            </div>
        <% end_with %>
        <div class="row">
            <div class="large-7 columns">
                <div class="panel blizzgame-panel">
                    <h3>Последние пополнения в галерее</h3>
                    <ul class="gallery-list clearing-thumbs large-block-grid-3 small-block-grid-2">
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
                <div class="large-5 small-12 column">
                    <div class="panel blizzgame-panel">
                        <h3>Последние новости</h3>
                        <ul class="side-nav news-list">
                            <% loop $allNews %>
                                <li>
                                    <a href="$alternateAbsoluteLink">
                                        $Title
                                        <span class="publish-date right">$PublishFrom.format('d.m.Y')</span>
                                    </a>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                </div>
            <% end_if %>
        </div>
    </section>
</div>