<% if $UseButtonTag %>
    <button $getAttributesHTML('class') class="button $extraClass">
        <% if $ButtonContent %>$ButtonContent<% else %>$Title<% end_if %>
    </button>
<% else %>
    <input $getAttributesHTML('class') class="button $extraClass" />
<% end_if %>

