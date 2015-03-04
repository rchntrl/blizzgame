<% with $SiteConfig %>
    @BackgroundVerticalPosition: $BackgroundVerticalPosition%;
    @BackgroundImage: "<% if $BackgroundImage %>$BackgroundImage.getUrl()<% end_if %>";
    @LogoImage: "$LogoImage.getUrl()";
    @DefaultElementImage: "$DefaultElementImage.getUrl()";
<% end_with %>
@ThemeDir: "{$BaseHref}$ThemeDir";
@import "$BaseUrl{$ThemeDir}/css/common.less";