<!doctype html>
<html class="no-js" lang="$ContentLocale.ATT" dir="$i18nScriptDirection.ATT">
<head>
    <% base_tag %>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title data-ng-bind="title"><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - <% if $SubsiteID %>$SiteConfig.Title: <% end_if %>BlizzGame</title>
    <meta name="description" content="$MetaDescription.ATT" />
    <%--http://ogp.me/--%>
    <meta property="og:site_name" content="$SiteConfig.Title.ATT" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="$Title.ATT" />
    <meta property="og:description" content="$MetaDescription.ATT" />
    <meta property="og:url" content="$AbsoluteLink.ATT" />
    <% if $Image %>
        <meta property="og:image" content="<% with $Image.SetSize(500,500) %>$AbsoluteURL.ATT<% end_with %>" />
    <% end_if %>
    <link rel="alternate" hreflang="ru" href="$BaseHref" />
    <link rel="icon" type="image/png" href="$ThemeDir/favicon.png" />
    <%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>
    <link rel="stylesheet" href="$ThemeDir/css/foundation.min.css" />
    <link rel="stylesheet" href="$ThemeDir/icons/foundation-icons.css" />

    <link rel="stylesheet" href="$ThemeDir/css/common.css" />
    <% include AnalyticsTracking %>
</head>
<body class="$ClassName.ATT">
    <div class="main-content">
        $Layout
    </div>
</body>
</html>