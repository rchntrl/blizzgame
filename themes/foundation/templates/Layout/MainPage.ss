<% require themedCSS('hots') %>
    <section class="home-page-content">
        <div style="position: relative; height: auto;" class="hide-for-small">
        <% with $HomePageConfig %>
            <ul class="example-orbit" data-orbit data-options="animation:fade;next_on_click:false;timer:false;navigation_arrows:false;bullets:false;slide_number:false;">
                <li data-orbit-slide="heroes">
                    <div id="heroes-section" class="panel" style="background: url($HeroesBackground.getUrl()); background-size: cover">
                        <h2 class="widget-title text-center">Heroes of the Storm</h2>
                        <h3 class="widget-title text-center">Герои недели</h3>
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
                        <div class="widget-text">
                            $HeroesSaleText
                        </div>
                    </div>
                </li>
                <li data-orbit-slide="hearthstone">
                    <div id="hearthstone-section" class="panel" style="background: url($HearthBackground.getUrl()); background-size: cover">
                        <h2 class="widget-title text-center">HEARTHSTONE</h2>
                        <div class="widget-text">
                            $HearthStoneText
                        </div>
                    </div>
                </li>
            </ul>
        <% end_with %>
            <div style="position: absolute; bottom: 0; right: 0;">
                <ul class="button-group">
                    <li><a data-orbit-link="heroes" class="small button">Heroes of the Storm</a></li>
                    <li><a data-orbit-link="hearthstone" class="small button">Hearthstone</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="large-7 columns">
                <div class="panel blizzgame-panel">
                    <h3>Последние пополнения в галерее</h3>
                    <ul class="gallery-list clearing-thumbs large-block-grid-3 medium-block-grid-3 small-block-grid-2">
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
                                    <a href="<% if $Type == external && Top.SiteConfig.ReturnExternal %>
                                        $External
                                    <% else_if $Type == download && Top.SiteConfig.ReturnExternal %>
                                        $Download.Link
                                    <% else %>
                                        $alternateAbsoluteLink
                                    <% end_if %>">
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