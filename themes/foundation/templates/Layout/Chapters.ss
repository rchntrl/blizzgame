<div class="small-12 medium-12 large-12 columns">
    <article>
        <h1><%t Book.TRANSLATE_INDEX_PAGE_TITLE 'Оглавление. {Name}' Name=$MenuTitle %></h1>
        <ul class="side-nav"  role="navigation" title="Книги">
            <% loop Chapters %>
                <li><a href="$link">$Title</a></li>
            <% end_loop%>
        </ul>
        $Form
    </article>
</div>
