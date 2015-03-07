<% require themedCSS('hots') %>
<div class="orbit-container">
    <ul class="example-orbit" data-orbit>
        <% loop $OrbitNews.Limit(4) %>
            <li>
                <a href="$alternateAbsoluteLink"><img src="$Impression.CroppedImage(1924, 530).getUrl()" alt="slide 1" /></a>
                <div class="orbit-caption">
                    $Title
                </div>
            </li>
        <% end_loop %>
    </ul>
</div>
<section class="home-page-content">
    <div class="small-12 medium-8 large-9 columns">
        <% if $allNews %>
            <% loop $allNews %>
                <div class="news $FirstLast">
                    <% include SingleSummaryItem %>
                </div>
            <% end_loop %>
        <% end_if %>
        <a href="{$BaseHref}news/" data-start="12" class="button large-12 small-12 secondary load-more-art">Архив новостей</a>
    </div>
    <div class="hide-for-small medium-4 large-3 columns">
       <% include LastComments %>
    </div>
</section>

