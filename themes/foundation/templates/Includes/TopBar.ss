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
<div class="contain-to-grid sticky">
    <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <!-- Title Area -->
            <li class="name">
                <h1><a href="#"><span>$SiteConfig.Title</span></a></h1>
            </li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
                <li class="name"><!-- Leave this empty --></li>
                <% loop Menu(1) %>
                    <li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %>">
                        <a href="$Link" title="Go to the $Title.ATT">$MenuTitle</a>
                    </li>
                    <% if not $Last %><li class="divider"></li><% end_if %>
                <% end_loop %>
            </ul>
        </section>
    </nav>
</div>