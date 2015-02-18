<h1>$Title</h1>
<div class="chronicle-section">

<% if $ChronicleItems.Count <= 6 %>
    <div class=" large-9 column">
        <div class="tabs-content">
            <% loop $ChronicleItems %>
                <div id="tab$ID" class="content<% if first %> active<% end_if %>">
                    <div>$Content</div>
                </div>
            <% end_loop %>
        </div>
    </div>
    <div class="large-3 column">
        <ul class="tabs vertical" data-tab role="tablist">
            <% loop $ChronicleItems %>
                <li class="tab-title<% if first %> active<% end_if %>"><a href="#tab{$ID}">$Title</a></li>
            <% end_loop %>
        </ul>
    </div>
<% else %>
    <ul class="side-nav">
        <% loop $ChronicleItems %>
            <li><a href="$Link">$TitleRU</a></li>
        <% end_loop %>
    </ul>
<% end_if %>
</div>