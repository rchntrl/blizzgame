<div class="small-9 medium-8 large-9 columns">
    <h2>$Title</h2>
    <div class="small-5 columns">
        $Cover
        <dl>
            <dt>Автор(ы):</dt><dd>$Author</dd>
            <dt>Переводчик(и):</dt><dd>$TranslatedBy</dd>
            <dt>Обложка:</dt><dd><% loop $PaintsCover %>$Title, <% end_loop %></dd>
            <dt>Мировой Издатель:</dt><dd>$PublisherEN</dd>
            <dt>Количество страниц:</dt><dd>$CountPage</dd>
        </dl>
    </div>
    <article class="small-7 columns">
        <% if TextContent %>
            <h3>Сюжет</h3>
            $TextContent.RAW
        <% end_if %>

        <% if TextDescription %>
            <h3>Описание</h3>
            $TextDescript.RAW
        <% end_if %>
        <% if $Chapters.Count() %>
            <a class="button" href="{$LinkToChapters}" ><%t Book.READ_BOOK_BUTTON 'Читать {Title}' Title=$MenuTitle %></a>
        <% end_if %>
        $Form
    </article>
</div>
<div class="small-3 medium-4 large-3 columns">
    <ul class="side-nav"  role="navigation" title="Книги">
        <li class="heading">Книги</li>
        <% loop $HolderPage.Books() %>
            <li <%if $ID == $Top.ID %>class="active"<% end_if %>  role="menuitem">
                <a href="$link">$MenuTitle</a>
            </li>
        <% end_loop %>
    </ul>
</div>