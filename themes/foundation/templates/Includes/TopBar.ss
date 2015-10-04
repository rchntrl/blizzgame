
<nav class="top-bar blizzgame-top-bar upper-top" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name"><h1></h1></li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
    </ul>
    <section class="top-bar-section">
        <ul class="right">
            <li class="game-icon <% if 0 == $SubsiteID %> active<% end_if %>">
                <a class="Blizzgame" href="http://www.blizzgame.ru" title="Главная">
                </a>
            </li>
            <% loop subSiteListMenu() %>
                <li class="game-icon <% if currentSubsiteID == $ID %> active<% end_if %>">
                    <a class="$title" href="http://$PrimaryDomain" title="$Title.ATT">
                    </a>
                </li>
            <% end_loop %>
            <li class="has-dropdown">
                <% if CurrentMember %>
                    <% with CurrentMember %>
                        <a href="#">
                            <span>$nickName</span>
                        </a>
                        <ul class="dropdown">
                            <li>
                                <a href="http://www.blizzgame.ru/forummemberprofile/show/$ID">Профиль</a>
                            </li>
                            <li>
                                <a href="$BaseHref/security/logout">Выйти</a>
                            </li>
                        </ul>
                    <% end_with %>
                <% else %>
                    <a href="#"><span>Войти</span></a>
                    <ul class="dropdown">
                        <!--<li><a href="$FacebookLoginLink">Login via Facebook</a></li>-->
                        <li><a href="$VkLoginLink">через ВКонтакте</a></li>
                        <li><a href="http://www.blizzgame.ru/forummemberprofile/register">через обычную форму</a></li>
                    </ul>
                <% end_if %>
        </ul>
    </section>
</nav>

<div id="header-branding">
    <div class="container">
        <div class="row">
            <div class="small-6 medium-7">
                <h1><a href="/"><img src="$SiteConfig.LogoImage.getUrl()" /></a></h1>
            </div>
        </div>
    </div>
</div>

<nav class="top-bar blizzgame-top-bar lower-top" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
        </li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
    </ul>
    <section class="top-bar-section">
        <ul class="left">
            <% loop Menu(1) %>
                <li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %>">
                    <a href="$Link" title="На страницу $Title.ATT">$MenuTitle <%if $IsNew %><sup>Новинка</sup><% end_if %></a>
                </li>
                <% if not $Last %><li class="divider"></li><% end_if %>
            <% end_loop %>
            <% if $SubsiteID %>
                <li class="divider"></li>
                <li><a href="http://www.blizzgame.ru/forums/" title="На форумы">Форумы</a></li>
            <% end_if %>
        </ul>
    </section>
</nav>