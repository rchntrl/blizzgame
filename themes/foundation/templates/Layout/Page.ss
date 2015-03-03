<% require javascript('themes/foundation/javascript/page.js') %>
<div class="page-section large-12 columns">
    <h1>$Title</h1>
    <article>
        <div id="content">
            $Content
            $Form
        </div>
        <% if Children %>
            <div id="children-pages">
                <% include ChildrenPages %>
            </div>
        <% end_if %>
    </article>
</div>
<% include CommentList %>
