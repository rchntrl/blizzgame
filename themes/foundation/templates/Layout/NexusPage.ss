<div class="page-section large-12 columns">
    <div ng-hide="nexusData.totalSize > 0" class="preloader"></div>
    <div data-ng-show="nexusData.totalSize > 0" class="layout">
        <div ng-viewport="main">
            <% if $Hero %>
                <div class="medium-12 columns">
                    <h1>$Hero.Title <small>$Hero.IdentityTitle</small></h1>
                    <p>$Hero.Content</p>
                </div>
                <div class="medium-9 columns">
                    <div class="speech-section">
                        <h3 id="intro-speech">Вступление</h3>
                        <ul class="hero-speech intro">
                            <% loop $Hero.IntroSpeech() %>
                                <li>
                                    <% if $Type == 'Question' %>
                                        <div class="question">
                                            <a class="element-link" href="$Top.Link{$LastLinkSegment}" title="$From.Title">
                                                <div class="element-link-image">
                                                    <img class="icon-frame frame-56" src="$OwnerIconSrc" />
                                                </div>
                                            </a>
                                            <%if $Tag %>
                                                <div class="right element-link">
                                                    <div title="$Tag.Title" class="element-link-image">
                                                        <img class="icon-frame frame-56" src="$TagIconSrc" />
                                                    </div>
                                                </div>
                                            <% end_if %>
                                            <div class="phrase">$Phrase</div>
                                            <div class="original-phrase">$OriginalPhrase</div>
                                        </div>
                                        <%if $To %>
                                            <div class="response">
                                                <a class="element-link" <%if not $To.Draft %>href="$Top.Link{$To.LastLinkSegment}"<%end_if%> title="$To.Title">
                                                    <div class="element-link-image">
                                                        <img class="icon-frame frame-56" src="$MateIconSrc" />
                                                    </div>
                                                </a>
                                                <div class="phrase">$MatePhrase</div>
                                                <div class="original-phrase">$MateOriginalPhrase</div>
                                            </div>
                                        <% end_if %>
                                    <% end_if %>
                                    <% if $Type == 'Response' %>
                                        <% if $To %>
                                            <div class="question">
                                                <a class="element-link" <%if not $To.Draft %>href="$Top.Link{$To.LastLinkSegment}"<%end_if%> title="$To.Title">
                                                    <div class="element-link-image">
                                                        <img class="icon-frame frame-56" src="$MateIconSrc" />
                                                    </div>
                                                </a>
                                                <div class="phrase">$MatePhrase</div>
                                                <div class="original-phrase">$MateOriginalPhrase</div>
                                            </div>
                                        <% end_if %>
                                        <div class="response">
                                            <a class="element-link" href="$Top.Link{$LastLinkSegment}" title="$Title">
                                                <div class="element-link-image">
                                                    <img class="icon-frame frame-56" src="$OwnerIconSrc" />
                                                </div>
                                            </a>
                                            <%if $TagIconSrc %>
                                                <div class="right element-link">
                                                    <div title="$Tag.Title" class="element-link-image">
                                                        <img class="icon-frame frame-56" src="$TagIconSrc" />
                                                    </div>
                                                </div>
                                            <% end_if %>
                                            <div class="phrase">$Phrase</div>
                                            <div class="original-phrase">$OriginalPhrase</div>
                                        </div>
                                    <% end_if %>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                    <div class="speech-section">
                        <h3 id="pissed-speech">Реплики при клике</h3>
                        <ul class="hero-speech">
                            <% loop $Hero.PissedSpeech() %>
                                <li>
                                    <% if $SkinOwnerID > 0 %>
                                        <a class="element-link" data-ng-href="$Top.Link{$LastLinkSegment}" title="$From.Title">
                                            <div class="element-link-image">
                                                <img class="icon-frame frame-56" src="$SkinIconSrc" />
                                            </div>
                                        </a>
                                    <% end_if %>
                                    <div class="phrase">$Phrase</div>
                                    <div class="original-phrase">$OriginalPhrase</div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                    <div class="speech-section">
                        <h3 id="kill-speech">Реплики при убийстве</h3>
                        <ul class="hero-speech">
                            <% loop $Hero.KillSpeech() %>
                                <li>
                                    <a class="element-link" data-ng-href="$Top.Link{$LastLinkSegment}" title="$From.Title">
                                        <div class="element-link-image">
                                            <img class="icon-frame frame-56" src="$OwnerIconSrc" />
                                        </div>
                                    </a>
                                    <% if $To %>
                                        <a class="right element-link" <%if not $To.Draft %>href="$Top.Link{$To.LastLinkSegment}"<%end_if%> title="$To.Title">
                                            <div class="element-link-image">
                                                <img class="icon-frame frame-56" src="$MateIconSrc" />
                                            </div>
                                        </a>
                                    <% else_if $Tag %>
                                        <div class="right element-link">
                                            <div class="element-link-image" title="$Tag.Title">
                                                <img class="icon-frame frame-56" src="$TagIconSrc" />
                                            </div>
                                        </div>
                                    <% end_if %>
                                    <div class="phrase">$Phrase</div>
                                    <div class="original-phrase">$OriginalPhrase</div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                    <div class="speech-section">
                        <h3 id="other-speech">Прочее</h3>
                        <ul class="hero-speech">
                            <% loop $Hero.OtherSpeech() %>
                                <li>
                                    <% if $SkinOwnerID > 0 %>
                                        <a class="element-link" data-ng-href="$Top.Link{$LastLinkSegment}" title="$From.Title">
                                            <div class="element-link-image">
                                                <img class="icon-frame frame-56" src="$OwnerIconSrc" />
                                            </div>
                                        </a>
                                    <% end_if %>
                                    <div class="phrase">$Phrase</div>
                                    <div class="original-phrase">$OriginalPhrase</div>
                                </li>
                            <% end_loop %>
                        </ul>
                    </div>
                </div>
                <div class="medium-3 columns"></div>
            <% else %>
                <h1>$Title</h1>
                <ul class="ency inline-list">
                    <% loop $Heroes %>
                        <li class="large-3 small-4">
                            <a class="element-link" href="$Top.Link{$LastLinkSegment}" title="$Title">
                                <div class="element-link-image">
                                    <img class="icon-frame frame-56" alt="$Title" src="$IconSrc()"/>
                                </div>
                                <span class="element-link-title">$Title</span>
                            </a>
                        </li>
                    <% end_loop %>
                </ul>
            <% end_if %>
        </div>
    </div>

</div>
<div id="kament_comments"></div>
<script type="text/javascript">
    var kament_page_name = "{$ClassName}_{$ID}";
    var kament_page_url = location.hostname + location.pathname;
    var kament_subdomain = 'blizzgame';
    (function() {
        var node = document.createElement('script'); node.type = 'text/javascript'; node.async = true;
        node.src = 'http://' + kament_subdomain + '.svkament.ru/js/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(node);
    })();
</script>