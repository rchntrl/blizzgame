<dl class="sub-nav">
    <dt><%t Gallery.FILTER_SIZE_TITLE 'Фильтр по размерам' %>:</dt>
    <% loop FilterBySize %>
        <dd <%if $Current %>class="active"<% end_if %> >
            <a href="$Top.getFilterUrl('size', $Name)" title="$Title" >$ShortName</a>
        </dd>
    <% end_loop %>
</dl>
<ul class="button-group">
    <li> <button href="#" data-dropdown="filter-by-author" aria-controls="filter-by-author" aria-expanded="false" class="small secondary radius button dropdown">
        <%t Gallery.FILTER_AUTHOR_TITLE 'Фильтр по художнику' %>
    </button>
        <br>
        <ul id="filter-by-author" data-dropdown-content class="small f-dropdown" aria-hidden="true" tabindex="-1">
            <% loop filterByAuthor %>
                <li><a href="$Top.getFilterUrl('author', $LastLinkSegment)"><span>$TitleEN</span></a></li>
            <% end_loop %>
        </ul>
    </li>
    <li>
        <button href="#" data-dropdown="filter-by-tag" aria-controls="filter-by-tag" aria-expanded="false" class="small secondary radius button dropdown">
            <%t Gallery.FILTER_TAG_TITLE 'Фильтр по тегам' %>
        </button>
        <br>
        <ul id="filter-by-tag" data-dropdown-content class="small f-dropdown" aria-hidden="true" tabindex="-1">
            <% loop FilterByTags %>
                <li><a href="$Top.getFilterUrl('tag', $LastLinkSegment)"><span>$TitleEN</span></a></li>
            <% end_loop %>
        </ul>
    </li>
</ul>