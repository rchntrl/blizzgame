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
                <% if $Authors %>
                    <% loop $Authors %>$Title<% if not $Last %>, <% end_if %><% end_loop %>
                <% end_if %>
            </dd>
            <% if $PaintsCover %>
                <dt>Обложка:</dt><dd><% loop $PaintsCover %>$Title<% if not $Last %>, <% end_if %><% end_loop %></dd>
            <% end_if %>
            <dt>Мировой издатель (Дата):</dt><dd>$PublisherEN ($DateSaleEN.format("d.m.Y"))</dd>
            <dt>Продолжительность:</dt><dd>$Duration</dd>
        </dl>
    </div>
    <article class="small-7 columns">
        $Content
        $Form
    </article>
</div>
<div class="small-12 medium-3 large-2 columns">
    <ul class="side-nav" title="$Title">
        <li class="heading">$HolderPage.MenuTitle</li>
        <% loop $HolderPage.MediaItems() %>
            <li <%if $ID == $Top.ID %>class="active"<% end_if %>  role="menuitem">
                <a href="$link">$MenuTitle</a>
            </li>
        <% end_loop %>
    </ul>
</div>
<% include CommentList %>