

<section class="row">
    <div class="large-12 columns news-holder">
        <% if $allNews %>

            <% loop $allNews %>
                <div class=" large-4 medium-6 small-12 columns $FirstLast">
                    <div class="news">
                        <% include SingleSummaryItem %>
                    </div>
                </div>
                <li class="top">
                    <div class="row">
                        <div class="two columns mobile-one">
                            <div class="number">
                                <span>1</span>
                            </div>
                        </div>
                        <div class="ten columns  mobile-three">
                            <h4 class="subheader">
                                <a href="https://gigaom.com/2014/11/17/is-the-web-dying-killed-off-by-mobile-apps-its-complicated/">Is the web dying, killed off by mobile apps? It’s complicated</a>
                            </h4>
                            <p><span>The evolution of apps *is* complicated. This article explores the growth of web apps, and how they’re affecting growth of the web itself.</span></p>
                        </div>
                    </div>
                </li>
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
