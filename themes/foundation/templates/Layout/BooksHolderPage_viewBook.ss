<div class="small-12 medium-9 large-10 columns">
    <h2>$Title</h2>
    <div class="small-5 columns">
        <% if $Cover %>
            $Cover.SetRatioSize(320, 500);
        <% else %>
            $SiteConfig.DefaultBookCover.SetRatioSize(320, 500)
        <% end_if %>
        <dl>
            <dt>Автор(ы):</dt>
            <dd>
                <% if $Author %>
                    $Author
                <% else %>
                    <% loop $Authors %>$Title<% if not $Last %>, <% end_if %><% end_loop %>
                <% end_if %>
            </dd>
            <% if $TranslatedBy %>
                <dt>Переводчик(и):</dt><dd>$TranslatedBy</dd>
            <% end_if %>
            <% if $PaintsCover %>
                <dt>Обложка:</dt><dd><% loop $PaintsCover %>$Title<% if not $Last %>, <% end_if %><% end_loop %></dd>
            <% end_if %>
            <dt>Мировой издатель (Дата):</dt><dd>$PublisherEN ($DateSaleEN.format("d.m.Y"))</dd>
            <% if $PublisherRU %>
                <dt>Российский издатель (Дата):</dt><dd>$PublisherRU ($DateSaleRU.format("d.m.Y"))</dd>
            <% end_if %>
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
            <a class="button" href="$Chapters.first().Link()" ><%t Book.READ_BOOK_BUTTON 'Читать {Title}' Title=$MenuTitle %></a>
        <% end_if %>
        $Form
    </article>
</div>
<div class="small-12 medium-3 large-2 columns">
    <ul class="side-nav" title="Книги">
        <li class="heading">Книги</li>
        <% loop $HolderPage.Books() %>
            <li <%if $ID == $Top.ID %>class="active"<% end_if %>  role="menuitem">
                <a href="$link">$MenuTitle</a>
            </li>
        <% end_loop %>
    </ul>
</div>