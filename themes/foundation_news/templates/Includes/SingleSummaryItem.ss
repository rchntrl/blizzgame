<% if $Impression %>
    <div class="large-2">
        <a href="$Link" class="impressionLink"><% with Impression %>$SetSize(50,50)<% end_with %></a>
    </div>
<% else_if $Top.SiteConfig.DefaultImage %>
    <div class="large-2">
        <a href="$Link" class="impressionLink large-2">$Top.SiteConfig.DefaultImage.SetSize(50,50)</a>
    </div>
<% end_if %>
<% if $Type == external && Top.SiteConfig.ReturnExternal %>
    <h4><a href='$External' target="_blank">$Title</a></h4>
<% else_if $Type == download && Top.SiteConfig.ReturnExternal %>
    <h4><a href='$Download.Link' title='Downloadable file'>$Title (<%t NewsHolderPage.DOWNLOADABLE "Download" %>)</a></h4>
<% else %>
    <h4><a href="$Link">$Title</a></h4>
<% end_if %>
<h4><%t NewsHolderPage.DATEPUBLISH "{date} " date=$Published %></h4>
<% if $Synopsis %>
    <p>$Synopsis</p>
<% else %>
    <p>$Content.Summary</p>
<% end_if %>
<% if $Tags.Count > 0 %>
    <div class="large-12">
        <% loop Tags %>
            <a href="$Link">$Title</a><% if Last %><% else %>&nbsp;|&nbsp;<% end_if %>
        <% end_loop %>
    </div>
<% end_if %>
