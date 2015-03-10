<!doctype html>
<html class="no-js" lang="$ContentLocale.ATT" dir="$i18nScriptDirection.ATT">
<head>
    <% base_tag %>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - <% if $SubsiteID %>$SiteConfig.Title: <% end_if %>BlizzGame</title>
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
    <link rel="alternate" hreflang="$ContentLocale.ATT" href="$BaseHref" />
    <link rel="icon" type="image/png" href="$ThemeDir/favicon.png" />
    <%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>
    <link rel="stylesheet" href="$ThemeDir/css/foundation.min.css" />
    <link rel="stylesheet" href="$ThemeDir/icons/foundation-icons.css" />
    <link rel="stylesheet" href="$ThemeDir/css/common.css" />
    <link rel="stylesheet/less" href="style/variables"/>
    <script>
        less = {
            logLevel: 1
        }
    </script>
    <script src="$ThemeDir/javascript/less-1.7.0.min.js"></script>
    <script src="framework/thirdparty/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="http://svkament.ru/js/SVEmbed.js"></script>
    <script type="text/javascript">
        SV.init({subdomain: 'blizzgame'})
    </script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-60400735-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body class="$ClassName.ATT">
<header class="header">
    <% include TopBar %>
</header>
<div class="inner-wrap">
    <!-- CONTENT SECTION -->
    <div class="row content-section">
        $Layout
    </div>
    <% include Footer %>
</div>
    <%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>

<script src="$ThemeDir/javascript/modernizr.js"></script>
<script src="$ThemeDir/javascript/foundation.min.js"></script>
<script src="$ThemeDir/javascript/foundation/foundation.topbar.js"></script>

<script src="$ThemeDir/javascript/app.js"></script>
<script src="$ThemeDir/javascript/init.js"></script>
</body>
</html>
