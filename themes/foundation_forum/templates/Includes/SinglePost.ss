<div id="post{$ID}" class="forum-post">
    <div class="forum-post-content">
        <div class="row">
            <div class="large-3 column">
                <div class="forum-post-content-header">

                    <div class="media author-details">

                        <div class="img-circle-holder left">
                            <img class="avatar" src="$Author.FormattedAvatar" alt="Avatar">
                        </div>
                        <div class="media-body">
                            <% with $Author %>
                                <h5 class="alt-style1">
                                    <a class="author-link" href="$Link" title="Перейти к профилю пользователя">$Nickname</a>
                                </h5>
                                <p class="small">
                                    <% if ForumRank %>$ForumRank,<% end_if %>
                                    <% if NumPosts %>
                                        $NumPosts
                                    <% end_if %>
                                    <% if NumPosts = 1 %>
                                        <% _t('SinglePost_ss.POST', 'Сообщение') %>
                                    <% else %>
                                        <% _t('SinglePost_ss.POSTS', 'Сообщений') %>
                                    <% end_if %>
                                </p>
                            <% end_with %>
                            <p class="small">
                                $Created.Long в $Created.Time
                            </p>
                            <p class="small">
                                <% if Updated %>
                                    <strong><% _t('SinglePost_ss.LASTEDITED','Отредактирован:') %> $Updated.format('d/m/Y') <% _t('SinglePost_ss.AT','в') %> $Updated.Time</strong>
                                <% end_if %>
                            </p>
                        </div>
                    </div>
                </div><!-- user-info. -->
            </div>
           <div class="large-9 column">
               <div class="quick-reply">
                   <% if Thread.canPost %>
                       <p>$Top.ReplyLink</p>
                   <% end_if %>
               </div>

               <% if EditLink || DeleteLink %>
                   <ul class="inline-list">
                       <% if EditLink %>
                           <li>$EditLink</li>
                       <% end_if %>
                       <% if DeleteLink %>
                           <li>$DeleteLink </li>
                       <% end_if %>
                       <% if MarkAsSpamLink %>
                           <li>$MarkAsSpamLink</li>
                       <% end_if %>
                       <% if BanLink || GhostLink %>
                           <% if BanLink %><li>$BanLink</li><% end_if %>
                           <% if GhostLink %><li>$GhostLink</li><% end_if %>
                       <% end_if %>
                   </ul>
               <% end_if %>
               <div class="post-type">
                   $Content.Parse(BBCodeParser)
               </div>

               <% if Thread.DisplaySignatures %>
                   <% with Author %>
                       <% if Signature %>
                           <div class="signature">
                               <p>$Signature</p>
                           </div>
                       <% end_if %>
                   <% end_with %>
               <% end_if %>

               <% if Attachments %>
                   <div class="attachments">
                       <strong><% _t('SinglePost_ss.ATTACHED','Attached Files') %></strong>
                       <ul class="post-attachments">
                           <% loop Attachments %>
                               <li>
                                   <a href="$Link"><img src="$Icon"></a>
                                   <a href="$Link">$Name</a><br />
                                   <% if ClassName = "Image" %>$Width x $Height - <% end_if %>$Size
                               </li>
                           <% end_loop %>
                       </ul>
                   </div>
               <% end_if %>
           </div>
        </div>
    </div>

</div><!-- forum-post. -->
