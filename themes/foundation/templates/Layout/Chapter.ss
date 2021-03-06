<div class="small-12 medium-9 large-10 columns">
    <article>
        <h1>$Title</h1>
        $Content
        <% if $AttachedImages %>
            <ul>
                <% loop $AttachedImages %>
                    <li>$Image</li>
                <% end_loop %>
            </ul>
        <% end_if %>
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
    <ul class="side-nav tab-style">
        <% loop Book.Chapters %>
            <li <% if $ID = $Top.ID %>class="active"<% end_if %>><a title="$MetaTitle" href="$link">$Title</a></li>
        <% end_loop%>
    </ul>
</div>
<% include CommentList %>