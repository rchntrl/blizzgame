@BackgroundVerticalPosition: $SiteConfig.BackgroundVerticalPosition%;
@BackgroundImage: "<% if $SiteConfig.BackgroundImage %>$SiteConfig.BackgroundImage.getUrl()<% end_if %>";
@LogoImage: "$SiteConfig.LogoImage.getUrl()";
@DefaultElementImage: "$SiteConfig.DefaultElementImage.getUrl()";
@ThemeDir: "{$BaseHref}$ThemeDir";
@import "$BaseUrl{$ThemeDir}/css/common.less";