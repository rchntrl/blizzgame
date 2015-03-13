<div class="row forum-header">
    <div class="medium-8 column">
        <h1 class="forum-heading"><a href="$Link" name='Header'>$HolderSubtitle</a>/</h1>
        <p class="forum-abstract">$ForumHolder.HolderAbstract</p>
        <% if Moderators %>
            <p>
                Модераторы:
                <% loop Moderators %>
                    <a href="$Link">$Nickname</a>
                    <% if not Last %>, <% end_if %>
                <% end_loop %>
            </p>
        <% end_if %>
    </div>
    <% loop ForumHolder %>
        <div class="medium-4 column">
            <form class="forum-jump" action="#">
                <label for="forum-jump-select"><% _t('ForumHeader_ss.JUMPTO','Перейти в:') %></label>
                <select id="forum-jump-select" onchange="if(this.value) location.href = this.value">
                    <option value=""><% _t('ForumHeader_ss.JUMPTO','Перейти в:') %></option>
                    <!-- option value=""><% _t('ForumHeader_ss.SELECT','Выбрать') %></option -->
                    <% if ShowInCategories %>
                        <% loop Forums %>
                            <optgroup label="$Title">
                                <% loop CategoryForums %>
                                    <% if can(view) %>
                                        <option value="$Link">$Title</option>
                                    <% end_if %>
                                <% end_loop %>
                            </optgroup>
                        <% end_loop %>
                    <% else %>
                        <% loop Forums %>
                            <% if can(view) %>
                                <option value="$Link">$Title</option>
                            <% end_if %>
                        <% end_loop %>
                    <% end_if %>
                </select>
            </form>

            <% if NumPosts %>
                <p class="forumStats">
                    $NumPosts
                    <strong><% _t('ForumHeader_ss.POSTS','Сообщений') %></strong>
                    <% _t('ForumHeader_ss.IN','в') %> $NumTopics <strong><% _t('ForumHeader_ss.TOPICS','темах') %></strong>
                    <% _t('ForumHeader_ss.BY','от') %> $NumAuthors <strong><% _t('ForumHeader_ss.MEMBERS','пользователей') %></strong>
                </p>
            <% end_if %>

        </div><!-- forum-header-forms. -->
    <% end_loop %>
</div><!-- forum-header. -->
