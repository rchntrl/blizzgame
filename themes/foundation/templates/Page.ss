<!doctype html>
<html class="no-js" lang="$ContentLocale.ATT" dir="$i18nScriptDirection.ATT">
<head>
    <% base_tag %>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - $SiteConfig.Title</title>
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
    <link rel="icon" type="image/png" href="$ThemeDir/favicon.png" />
    <%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>
    <link rel="stylesheet" href="$ThemeDir/css/foundation.min.css" />
    <link rel="stylesheet" href="$ThemeDir/icons/foundation-icons.css" />

    <link rel="stylesheet" href="$ThemeDir/css/style.css" />
    <link rel="stylesheet/less" href="style/variables"/>
    <script>
        less = {
            logLevel: 1
        }
    </script>
    <script src="$ThemeDir/javascript/less-1.7.0.min.js"></script>
    <script src="framework/thirdparty/jquery/jquery.min.js"></script>
</head>
<body class="$ClassName.ATT">
        <header class="header">
            <% include TopBar %>
        </header>
        <div class=" off-canvas-wrap" role="banner" data-offcanvas>
            <div class="inner-wrap">
                <!-- CONTENT SECTION -->
                <div class="row content-section">
                    <% include Breadcrumbs %>
                    <div class="main-content pagejax-container">
                        $Layout
                    </div>
                    <a class="exit-off-canvas"></a>
                </div>
                <footer id="footerDiv" class="footer" role="contentinfo">
                    <p>&copy; $Now.Year BlizzGame</p>
                    <h6>&radic; Интересно</h6>
                    <h6>&radic; Сайты</h6>
                    <h6>&radic; О сайте</h6>
                    <hr/>
                    <% if SubsiteID = 1 %>
                        <div style="float:right;padding:10px"><img src="{$BaseHref}$ThemeDir/images/blizzardfansitegold.gif" /></div>
                    <% end_if %>
                    <ul>
                        <li><a href="http://wow.blizzgame.ru/games/world-of-warcraft-mists-of-pandaria/" title="World of Warcraft: Mists of Pandaria" rel="nofollow">World of Warcraft: Mists of Pandaria</a></li>
                        <li><a href="http://starcraft.blizzgame.ru/games/starcraft-2-heart-of-the-swarm/" title="eStarCraft II: Heart of the Swarm" rel="nofollow">StarCraft II: Heart of the Swarm</a></li>
                        <li><a href="http://diablo.blizzgame.ru/games/diablo3/" title="Diablo III" rel="nofollow">Diablo III</a></li>
                    </ul>
                    <ul>
                        <li><a href="http://wow.blizzgame.ru/" title="Вселенная Warcraft" rel="nofollow">Вселенная Warcraft</a></li>
                        <li><a href="http://diablo.blizzgame.ru/" title="Вселенная Diablo" rel="nofollow">Вселенная Diablo</a></li>
                        <li><a href="http://starcraft.blizzgame.ru/" title="Вселенная StarCraft" rel="nofollow">Вселенная StarCraft</a></li>
                    </ul>
                    <ul>
                        <li><a href="http://www.blizzgame.ru/home/feedback/" title="Связаться с нами">Связаться с нами</a></li>
                        <li><a href="http://www.blizzgame.ru/home/about/" title="Создатели сайта">Создатели сайта</a></li>
                        <li><a href="http://www.blizzgame.ru/home/partners/" title="Друзья и партнеры">Друзья и партнеры</a></li>
                    </ul>
                </footer>
            </div>
        </div>
<%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>

<script src="$ThemeDir/javascript/foundation.min.js"></script>
<script src="$ThemeDir/javascript/foundation/foundation.topbar.js"></script>

<script src="$ThemeDir/javascript/app.js"></script>
<script src="$ThemeDir/javascript/init.js"></script>
</body>
</html>
