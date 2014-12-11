<!-- HEADER SECTION -->
<div class="header-section">
    <!-- TOPBAR SECTION -->
    <nav class="top-bar important-class" data-topbar>

        <!-- TITLE AREA & LOGO -->
        <ul class="title-area">
            <li class="name">
                <img src="$themedir/images/Acme_Colour.png" data-large-src="$themedir/images/Acme_Monogram_Colour" data-small-src="$themedir/images/Acme_Colour.png" alt="$SiteConfig.Title" id="logo-image">
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
        </ul> <!-- END TITLE AREA & LOGO -->

        <!-- MENU ITEMS -->
        <section class="top-bar-section">
            <ul class="right">
                <% loop Menu(1) %>
                    <li class="<% if $LinkingMode == "current" || $LinkingMode == "section" %>active<% end_if %>">
                        <a href="$Link" title="Go to the $Title.ATT">$MenuTitle</a>
                    </li>
                    <% if not $Last %><li class="divider"></li><% end_if %>
                <% end_loop %>
            </ul>
        </section> <!-- END MENU ITEMS -->
    </nav> <!-- END TOPBAR SECTION -->
</div> <!-- END HEADER SECTION

		<!-- CONTENT FILL WHEN SCROLL = 0 -->
<div class="header-fill"></div>
