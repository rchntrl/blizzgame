<div class="page-section small-12 medium-12 large-12 columns">
    <div class="">
        <h1>$Title</h1>
        <article class="large-9 column">
            $Content
            <ul class="side-nav">
                <% loop Children %>
                    <li><a href="$Link">$MenuTitle</a></li>
                <% end_loop %>
                <% loop $ChronicleItems %>
                    <li><a href="$Link">$Title</a></li>
                <% end_loop %>
            </ul>
        </article>
    </div>
</div>
