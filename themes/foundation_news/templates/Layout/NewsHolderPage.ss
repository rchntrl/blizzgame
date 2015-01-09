<section class="row">
    <% cached 'NewsHolderPage', List(News).max(LastEdited), List(News).count() %>

        <div class="large-8 columns">
            <% if $allNews %>
                <% loop $allNews %>
                    <div class="large-4 $FirstLast">
                        <% include SingleSummaryItem %>
                    </div>
                <% end_loop %>
                <div class="clearfix"></div>
                <!--Setup the pagination-->
                <div class='row pagination pagination-sm'>
                    <% if $allNews.NotFirstPage %>
                        <li>
                            <a class='<%t NewsHolderPage.PREVIOUS_PAGE "Previous" %>' href="$allNews.PrevLink"><%t NewsHolderPage.PREVIOUS_PAGE "Previous" %></a>
                        </li>
                    <% end_if %>
                    <% loop $allNews.PaginationSummary %>
                        <% if $CurrentBool %>
                            <li class="active">
                                <a>$PageNum</a>
                            </li>
                        <% else %>
                            <% if $Link %>
                                <li>
                                    <a href="$Link" title='<%t NewsHolderPage.JUMPTO_PAGE "Jump to page" %> $PageNum'>$PageNum</a>
                                </li>
                            <% else %>
                                <li class="disabled">
                                    <a>...</a>
                                </li>
                            <% end_if %>
                        <% end_if %>
                    <% end_loop %>
                    <% if $allNews.NotLastPage %>
                        <li>
                            <a class='<%t NewsHolderPage.NEXT_PAGE "Next" %>' href="$allNews.NextLink"><%t NewsHolderPage.NEXT_PAGE "Next" %></a>
                        </li>
                    <% end_if %>
                </div>
            <% end_if %>
        </div>
        <!--Optional, include the sidebar with Archive overview-->
        <div id="sidebar" class="large-4 columns">
            <div class="row">
                <div class="eleven columns offset-by-one">
                    <% include ArchiveOverview %>
                </div>
            </div>
        </div>

    <% end_cached %>
</section>
