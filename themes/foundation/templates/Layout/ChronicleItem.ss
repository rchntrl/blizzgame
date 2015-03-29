<% require themedCSS('lightbox') %>
<div class="page-section small-12 medium-12 large-12 columns">
    <div class="chronicle-section">
        <h1>$Title</h1>
        <article class="large-9 column">
            $Content
        </article>
        <div class="large-3 column">
            <ul class="side-nav tab-style">
                <% loop $Closest() %>
                    <li <%if $Top.ID == $ID %>class="active"<% end_if %>><a href="$Link">$MenuTitle</a></li>
                <% end_loop %>
            </ul>
        </div>
        $Form
    </div>
    <% include CommentList %>
</div>
<script src="$ThemeDir/javascript/lightbox.min.js"></script>