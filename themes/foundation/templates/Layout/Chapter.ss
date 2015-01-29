<div class="small-12 medium-9 large-10 columns">
    <article>
        <h1>$Title</h1>
        $Content
        $Form
    </article>
    <ul class="left side-nav">
        <% if $Previous %>
            <li><a href="$Previous.Link">&laquo; $Previous.Title</a></li>
        <% end_if %>
    </ul>
    <ul class="right side-nav">
        <% if $Next %>
            <li><a href="$Next.Link">$Next.Title &raquo;</a></li>
        <% end_if %>
    </ul>
</div>
<div class="medium-3 large-2 columns">
    <ul class="side-nav">
        <% loop Book.Chapters %>
            <li <% if $ID = $Top.ID %>class="active"<% end_if %>><a href="$link">$Title</a></li>
        <% end_loop%>
    </ul>
</div>
