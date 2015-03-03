<div class="page-section small-12 medium-12 large-12 columns">
    <article class="chronicle-section">
        <h1>$Title</h1>
        <div class="large-9 column">
            $Content
        </div>
        <div class="large-3 column">
            <ul class="side-nav tab-style">
                <% loop $Closest() %>
                    <li <%if $Top.ID == $ID %>class="active"<% end_if %>><a href="$Link">$MenuTitle</a></li>
                <% end_loop %>
            </ul>
        </div>
        $Form
    </article>
    <% include CommentList %>
</div>
