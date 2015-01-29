<% if $GalleryImages.MoreThanOnePage %>
    <div class="pagination-centered">
        <ul class="pagination">
            <% if $GalleryImages.NotFirstPage %>
                <li class="arrow"><a  href="$GalleryImages.PrevLink">&laquo;</a></li>
            <% else %>
                <li class="arrow unavailable"><a href="#">&laquo;</a></li>
            <% end_if %>
            <% loop $GalleryImages.Pages(8) %>
                <% if $CurrentBool %>
                    <li class="current"><a href="#">$PageNum</a></li>
                <% else %>
                    <% if $Link %>
                        <li><a href="$Link">$PageNum</a></li>
                    <% else %>
                        ...
                    <% end_if %>
                <% end_if %>
            <% end_loop %>
            <% if $GalleryImages.NotLastPage %>
                <li class="arrow"><a  href="$GalleryImages.NextLink">&raquo;</a></li>
            <% else %>
                <li class="arrow unavailable"><a href="#">&raquo;</a></li>
            <% end_if %>
        </ul>
    </div>
<% end_if %>