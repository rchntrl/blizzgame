<% if $current_stage == 'Live' %>
<!-- KAMENT -->
<div id="kament_comments"></div>
<script type="text/javascript">
    var kament_page_name = "{$ClassName}_{$ID}";
    var kament_subdomain = 'blizzgame';
    (function() {
        var node = document.createElement('script'); node.type = 'text/javascript'; node.async = true;
        node.src = 'http://' + kament_subdomain + '.svkament.ru/js/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(node);
    })();
</script>
<noscript>Для отображения комментариев нужно включить Javascript</noscript>
<!-- /KAMENT -->
<% end_if %>