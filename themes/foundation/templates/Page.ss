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
	<link rel="icon" type="image/png" href="$ThemeDir/favicon.ico" />
	<%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>
	<link rel="stylesheet" href="$ThemeDir/css/app.css" />
	<link rel="stylesheet" href="$ThemeDir/css/style.css" />
	<link rel="stylesheet" type="text/less" href="$ThemeDir/css/common.less" />
	<script src="$ThemeDir/bower_components/modernizr/modernizr.js"></script>
    <script>
        less = {
            logLevel: 1
        }
    </script>
	<script src="$ThemeDir/javascript/less-1.7.0.min.js"></script>
</head>
<body class="$ClassName.ATT">
    <header class="header" role="banner">
        <% include TopBar %>
    </header>
    <% include SideBar %>
    <!-- CONTENT SECTION -->
    <div class="row content-section">
        <div class="main-content">
            $Layout
        </div>
    </div>
	<nav role="navigation">
		<div class="row">
			<div class="large-12 columns">
				<% include Breadcrumbs %>
			</div>
		</div>
	</nav>

	<footer class="footer" role="contentinfo">
		<div class="row">
			<div class="large-12 columns">
				<p>&copy; $Now.Year $SiteConfig.Title</p>
			</div>
		</div>
	</footer>

	<%--Login Modal--%>
	<div id="login-form-modal" class="reveal-modal medium" data-reveal>
		<h2>Login</h2>
		$LoginForm
		<a class="close-reveal-modal">&#215;</a>
	</div>

	<%--See [Requirements](http://doc.silverstripe.org/framework/en/reference/requirements) for loading from controller--%>
	<script src="$ThemeDir/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="$ThemeDir/bower_components/foundation/js/foundation.min.js"></script>
	<script src="$ThemeDir/javascript/app.js"></script>
	<script src="$ThemeDir/javascript/init.js"></script>
</body>
</html>
