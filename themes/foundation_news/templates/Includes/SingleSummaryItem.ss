<% if $Impression %>
    <a href="$alternateAbsoluteLink" class="impressionLink">
        <div class="news-image" style="background-image: url($Impression.CroppedImage(200,200).getURL())"></div>
    </a>
<% else_if $Top.SiteConfig.DefaultImage %>
    <a href="$alternateAbsoluteLink" class="impressionLink">
        <div class="news-image" style="background-image: url($Top.SiteConfig.DefaultImage.setRatioSize(200,200).getURL())"></div>
    </a>
<% end_if %>
<div class="news-content">
    <% if $Type == external && Top.SiteConfig.ReturnExternal %>
        <h4><a href='$External' target="_blank">$Title</a></h4>
    <% else_if $Type == download && Top.SiteConfig.ReturnExternal %>
        <h4><a href='$Download.Link' title='Downloadable file'>$Title (<%t NewsHolderPage.DOWNLOADABLE "Download" %>)</a></h4>
    <% else %>
        <h4><a class="blank" href="$alternateAbsoluteLink">$Title</a></h4>
    <% end_if %>
    <% if $Synopsis %>
        <p>$Synopsis.Summary(20)</p>
    <% else %>
        <p>$Content.Summary(20)</p>
    <% end_if %>
    <div xmlns="http://www.w3.org/1999/xhtml" class="article-meta">
		<span class="publish-date" title="$PublishFrom.format('d M Y')">
				$PublishFrom.format('d/m/Y')
		</span>
    </div>
</div>