<% require themedCSS("hots") %>
<div class="small-12 medium-12 large-12 columns" xmlns="http://www.w3.org/1999/html">
    <section class="home-page-content">
        <ul class="example-orbit" data-orbit>
            <% loop $LastArts.Limit(7) %>
                <li>
                    <a href="$AbsoluteLink"><img src="$Image.CroppedImage(1024, 330).getUrl()" alt="slide 1" /></a>
                    <div class="orbit-caption">
                        $Title (скоро здесь вместо артов будут новости)
                    </div>
                </li>
            <% end_loop %>
        </ul>
        <div class="row">
            <hr>
            <div class="large-12 columns">
                <h3>Ротация героев Heroes of the Storm</h3>
            </div>
            <div class="large-7 columns">
                $HomePageConfig.HeroesSaleText
            </div>
            <div class="large-5 columns">
                <% with $HomePageConfig %>
                    <div class="hero-select-area">
                        <ul class="hero-widget__thumbnail-list">
                            <% loop $HeroesRotation %>
                                <li class="hero-thumbnail released">
                                    <div xmlns="http://www.w3.org/1999/xhtml" class="hero-thumbnail__backing">
                                        <a xmlns="http://www.w3.org/1999/xhtml" href="#" class="hero-thumbnail__link $Class"></a>
                                    </div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                <% end_with %>
            </div>
        </div>
        <div class="row">
            <hr>
            <div class="large-12 columns">
                <h3>Последние добавленные арты</h3>
            </div>
            <% loop $LastArts.Limit(8) %>
                <div class="large-3 small-6 columns">
                    <a href="$AbsoluteLink"><img title="$Title" src="$Image.CroppedImage(230, 230).getUrl()" /></a>
                    <div class="panel">
                        <p class="crop-text">$Title</p>
                    </div>
                </div>
            <% end_loop %>
        </div>
        <hr>
        <% if $allNews %>
        <% loop $allNews %>
            <div class="news $FirstLast">
                <% include SingleSummaryItem %>
            </div>
        <% end_loop %>
        <% end_if %>
        <a href="{$BaseHref}news/" data-start="12" class="button large-12 small-12 secondary load-more-art">Архив новостей</a>
    </section>
</div>