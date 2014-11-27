<div class="small-12 medium-12 large-12 columns">
    <article>
        <h1>$Title</h1>
        <% if URLSegment == 'encyclopedia' %>
            <% include SideBar %>

        <% else %>
            $Content
            $Form
        <% end_if %>
    </article>

    <% include ChildrenPages %>
</div>
