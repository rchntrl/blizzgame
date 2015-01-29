
    <nav class="top-bar blizzgame-top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name"><h1></h1></li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
                <% loop subSiteListMenu() %>
                    <li class="game-icon <% if currentSubsiteID == $ID %> active<% end_if %>">
                        <a class="$title" href="http://$PrimaryDomain" title="Go to the $Title.ATT">
                            <span class="">$Title</span>
                        </a>
                    </li>
                <% end_loop %>
            </ul>
        </section>
    </nav>


<div id="header-branding">
    <div class="container">
        <div class="row">
            <div class="small-6 medium-7">
                <h1>
                    <a href="/">
                        <img src="$SiteConfig.LogoImage.getUrl()" />
                    </a>
                </h1>
            </div>
        </div>
    </div>
</div>

    <nav class="top-bar blizzgame-top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name">
            </li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <ul class="left">
                <% loop Menu(1) %>
                    <li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %>">
                        <a href="$Link" title="Go to the $Title.ATT">$MenuTitle</a>
                    </li>
                    <% if not $Last %><li class="divider"></li><% end_if %>
                <% end_loop %>
            </ul>
        </section>
    </nav>