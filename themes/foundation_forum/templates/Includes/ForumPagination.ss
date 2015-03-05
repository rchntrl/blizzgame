<% with SearchResults %>
	<% if $MoreThanOnePage %>
        <div class="pagination-centered">
            <ul class="pagination">
				<% if $NotFirstPage %>
                    <li class="arrow"><a  href="$PrevLink">&laquo;</a></li>
				<% else %>
                    <li class="arrow unavailable"><a href="#">&laquo;</a></li>
				<% end_if %>
				<% loop $Pages(10) %>
					<% if $CurrentBool %>
                        <li class="current"><a href="#">$PageNum</a></li>
					<% else %>
						<% if $Link %>
                            <li><a  href="$Link">$PageNum</a></li>
						<% else %>
                            ...
						<% end_if %>
					<% end_if %>
				<% end_loop %>
				<% if $NotLastPage %>
                    <li class="arrow"><a  href="$NextLink">&raquo;</a></li>
				<% else %>
                    <li class="arrow unavailable"><a href="#">&raquo;</a></li>
				<% end_if %>
            </ul>
        </div>
	<% end_if %>
<% end_with %>