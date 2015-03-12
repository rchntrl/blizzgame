<% if $current_stage == 'Stage' %>
    <link rel="stylesheet/less" href="style/variables"/>
    <script>
        less = {
            logLevel: 1
        }
    </script>
    <script src="$ThemeDir/javascript/less-1.7.0.min.js"></script>
<% else_if $current_stage == 'Live' %>
    <link rel="stylesheet" href="{$SiteConfig.CurrentSheetName}"/>
    <link rel="stylesheet" href="$ThemeDir/css/compiled-editor.css" />
<% end_if %>