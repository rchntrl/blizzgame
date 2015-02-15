<% require themedCSS("hots") %>
<div class="small-12 medium-12 large-12 columns" xmlns="http://www.w3.org/1999/html">
    <section class="home-page-content">
        <p><img src="http://placehold.it/1000x400&amp;text=[banner img]"></p>
        <div class="row">
            <div class="large-8 columns">
                $HomePageConfig.HeroesSaleText
            </div>
            <div class="large-4 columns">
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
            <h3>Последние добавленные арты</h3>
            <% loop $LastArts.Limit(8) %>
                <div class="large-3 small-6 columns">
                    <a href="$AbsoluteLink"><img alt="$Title" src="$Image.CroppedImage(230, 230).getUrl()" /></a>
                    <div class="panel">
                        <p>$Title</p>
                    </div>
                </div>
            <% end_loop %>
        </div>
        <% if $allNews %>
        <% loop $allNews %>
            <div class="news $FirstLast">
                <% include SingleSummaryItem %>
            </div>
        <% end_loop %>
        <% end_if %>
    </section>
</div>