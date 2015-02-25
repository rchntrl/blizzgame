    <% if $Member.IsBanned %>
        <h2>This user has been banned. Please contact us if you believe this is a mistake</h2>
    <% else_if $Member.isGhost %>
        <h2>This user has been ghosted. Please contact us if you believe this is a mistake</h2>
    <% else %>
        <% with Member %>
            <div class="large-12">
                <div class="media forum-profile-block">
                    <div class="img-circle-holder img-xl left">
                        <img class="avatar" src="$FormattedAvatar" width="80"/>
                    </div>
                    <div class="media-body">
                        <h2 class="profile-name">
                            $Nickname
                            <% if $ID == $CurrentMember.ID%>
                                <a class="small action-link" href="ForumMemberProfile/edit/$ID"><span class="fi-pencil"></span></a>
                            <% end_if %>
                        </h2>
                        <ul class="inline-list icon-set">
                            <li>
                                <a href="" data-toggle="tooltip" title="" class="fi-link icon-ball" data-original-title="Visit "></a>
                            </li>
                            <li>
                                <a data-toggle="tooltip" class="fi-at-sign icon-ball" title="" href="mailto:$Email" data-original-title="Email at $Email"></a>
                            </li>
                            <% if $City %>
                                <li>
                                    <a target="_blank" href="https://www.google.com/maps/place/$City,+/" class="icon-ball ion-location" data-toggle="tooltip" title="" data-original-title="Lives in $City, "></a>
                                </li>
                            <% end_if %>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="medium-6">
                <div class="media">
                    <span class="left round-badge badge-md">
                        <span class="icon fi-comment"></span>
                    </span>
                    <div class="media-body">
                        <p class="text-muted media-label"><% _t('ForumMemberProfile_show_ss.FORUMRANK','Forum ranking') %>
                            <small class="readonly">($NumPosts сообщений) </small>
                        </p>
                        <h3>
                            <% if ForumRank %>
                                $ForumRank
                            <% else %>
                                <% _t('ForumMemberProfile_show_ss.NORANK','No ranking') %>
                            <% end_if %>
                        </h3>
                    </div>
                </div>
            </div>
        <% end_with %>
    <% end_if %>
<% include ForumFooter %>
