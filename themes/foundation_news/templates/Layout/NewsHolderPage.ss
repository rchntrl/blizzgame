

<section class="row">
    <div class="large-12 columns news-holder">
        <% if $allNews %>
            <% loop $allNews %>
                <div class=" large-4 medium-6 small-12 columns $FirstLast">
                    <div class="news">
                        <% include SingleSummaryItem %>
                    </div>
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
</section>
