<div class="small-12 medium-12 large-12 columns">
    <article>
        <h1>$Title</h1>
        <% if $allNews %>
            <% loop $allNews %>
                <div class="news $FirstLast">
                    <% include SingleSummaryItem %>
                </div>
            <% end_loop %>
        <% end_if %>
    </article>
</div>

