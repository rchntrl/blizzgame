<% if getArchiveList %>
    <div id="archivelist" class="row">
        <ul class="archive">
            <% loop getArchiveList.GroupedBy(YearCreated) %>
                <li class="$FirstLast month">
                    <a href="$Top.Link(archive)/$YearCreated">$YearCreated</a>
                    <% if Children %>
                        <ul class="archive">
                            <% loop Children.GroupedBy(MonthCreated) %>
                                <li class="$FirstLast month <% if Middle %>Middle<% end_if %>">
                                    <a href="$Top.Link(archive)/{$Up.Up.YearCreated}/$MonthCreated">$Children.First.PublishFrom.FormatI18N("%B")</a>
                                </li>
                            <% end_loop %>
                        </ul>
                    <% end_if %>
                </li>
            <% end_loop %>
        </ul>
    </div>
<% end_if %>
