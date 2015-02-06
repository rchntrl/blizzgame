<div class="forum-header">
    <% loop ForumHolder %>
        <div class="forum-header-forms">

            <form class="forum-jump" action="#">
                <label for="forum-jump-select"><% _t('ForumHeader_ss.JUMPTO','Jump to:') %></label>
                <select id="forum-jump-select" onchange="if(this.value) location.href = this.value">
                    <option value=""><% _t('ForumHeader_ss.JUMPTO','Jump to:') %></option>
                    <!-- option value=""><% _t('ForumHeader_ss.SELECT','Select') %></option -->
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
                    <strong><% _t('ForumHeader_ss.POSTS','Posts') %></strong>
                    <% _t('ForumHeader_ss.IN','in') %> $NumTopics <strong><% _t('ForumHeader_ss.TOPICS','Topics') %></strong>
                    <% _t('ForumHeader_ss.BY','by') %> $NumAuthors <strong><% _t('ForumHeader_ss.MEMBERS','members') %></strong>
                </p>
            <% end_if %>

        </div><!-- forum-header-forms. -->
    <% end_loop %>

    <h1 class="forum-heading"><a name='Header'>$HolderSubtitle</a></h1>
    <p class="forum-abstract">$ForumHolder.HolderAbstract</p>

    <% if Moderators %>
        <p>
            Moderators:
            <% loop Moderators %>
                <a href="$Link">$Nickname</a>
                <% if not Last %>, <% end_if %>
            <% end_loop %>
        </p>
    <% end_if %>

</div><!-- forum-header. -->
