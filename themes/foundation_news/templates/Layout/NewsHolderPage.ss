<section class="news-section">
    <% cached 'NewsHolderPage', List(News).max(LastEdited), List(News).count() %>

        <div class="large-10 medium-9 columns">
            <% if $allNews %>
                <% loop $allNews %>
                    <div class="news $FirstLast">
                        <% include SingleSummaryItem %>
                    </div>
                <% end_loop %>
                <div class="clearfix"></div>
                <!--Setup the pagination-->
                <div class='row pagination pagination-sm'>
                   <% include Pagination %>
                </div>
            <% end_if %>
        </div>
        <!--Optional, include the sidebar with Archive overview-->
        <div id="sidebar" class="large-2 medium-3 columns">
            <div class="row">
                <div class="eleven columns offset-by-one">
                    <% include ArchiveOverview %>
                </div>
            </div>
        </div>

    <% end_cached %>
</section>
