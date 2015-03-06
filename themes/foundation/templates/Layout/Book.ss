<div class="small-12 medium-9 large-10 columns">
    <h2>$TitleRU</h2>
    <article>
        <div class="large-5 small-12 columns" style="padding-left: 0; margin-right: 10px;">
            <a class="th" href="$Cover.getUrl()">
                <% if $Cover.SetRatioSize(320, 500) %>
                    $Cover.SetRatioSize(320, 500)
                <% else %>
                    $SiteConfig.DefaultBookCover.SetRatioSize(320, 500)
                <% end_if %>
            </a>
            <div class="book-info">
                <dl>
                    <dt>Автор(ы):</dt>
                    <dd>
                        <% loop $Authors %><a href="$AbsoluteLink">$Title</a><% if not $Last %>, <% end_if %><% end_loop %>
                        <% if $Author %>, $Author<% end_if %>
                    </dd>
                    <% if $TranslatedBy %>
                        <dt>Переводчик(и):</dt><dd>$TranslatedBy</dd>
                    <% end_if %>
                    <% if $PaintsCover %>
                        <dt>Оформление обложки:</dt><dd><% loop $PaintsCover %><a href="$AbsoluteLink">$Title</a><% if not $Last %>, <% end_if %><% end_loop %></dd>
                    <% end_if %>
                    <% if $PaintsPage %>
                        <dt>Оформление страниц:</dt><dd><% loop $PaintsPage %><a href="$AbsoluteLink">$Title</a><% if not $Last %>, <% end_if %><% end_loop %></dd>
                    <% end_if %>
                    <dt>Мировой издатель (Дата):</dt><dd>$PublisherEN ($DateSaleEN.format("d.m.Y"))</dd>
                    <% if $PublisherRU %>
                        <dt>Российский издатель (Дата):</dt><dd>$PublisherRU ($DateSaleRU.format("d.m.Y"))</dd>
                    <% end_if %>
                    <dt>Количество страниц:</dt><dd>$CountPage</dd>
                </dl>
            </div>
        </div>
        <% if TextContent %>
            <h3>Сюжет</h3>
            $TextContent
        <% end_if %>

        <% if TextDescription %>
            <h3>Описание</h3>
            $TextDescription
        <% end_if %>
        <% if $Chapters.Count() %>
            <a class="button large-12 small-12" href="$Chapters.first().Link()" ><%t Book.READ_BOOK_BUTTON 'Читать {Title}' Title=$MenuTitle %></a>
        <% end_if %>
        $Form
    </article>
</div>
<div class="small-12 medium-3 large-2 columns">
    <ul class="side-nav tab-style" title="Книги">
        <li class="heading">$HolderPage.Title</li>
        <% loop $Closest %>
            <li <%if $ID == $Top.ID %>class="active"<% end_if %>  role="menuitem">
                <a href="$Link">$TitleRU</a>
            </li>
        <% end_loop %>
    </ul>
</div>
<% include CommentList %>