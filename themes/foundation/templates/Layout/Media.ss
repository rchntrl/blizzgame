<div class="small-12 medium-9 large-10 columns">
    <h2>$Title</h2>
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
        </div>
        $Content
        $Form
    </article>
</div>
<div class="small-12 medium-3 large-2 columns">
    <ul class="side-nav tab-style" title="$HolderPage.Title">
        <li class="heading">$HolderPage.Title</li>
        <% loop $HolderPage.MediaItems() %>
            <li <%if $ID == $Top.ID %>class="active"<% end_if %>  role="menuitem">
                <a href="$link">$MenuTitle</a>
            </li>
        <% end_loop %>
    </ul>
</div>
<% include CommentList %>