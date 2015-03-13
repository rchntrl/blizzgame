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
    <link rel="alternate" hreflang="ru" href="$BaseHref" />
    <link rel="icon" type="image/png" href="$ThemeDir/favicon.png" />
    <%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>
    <link rel="stylesheet" href="$ThemeDir/css/foundation.min.css" />
    <link rel="stylesheet" href="$ThemeDir/icons/foundation-icons.css" />
    <link rel="stylesheet" href="$ThemeDir/css/common.css" />
    <% include LessSection %>
    <script src="framework/thirdparty/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="http://svkament.ru/js/SVEmbed.js"></script>
    <script type="text/javascript">
        SV.init({subdomain: 'blizzgame'})
    </script>
    <% include AnalyticsTracking %>
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
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter1231901 = new Ya.Metrika({id:1231901, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/1231901" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
</body>
</html>
