<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner">
        <div class="dashboard-nav-container">
            <a href="#" class="dashboard-responsive-nav-trigger">
                <span class="hamburger hamburger--collapse" >
                    <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                </span>
                <span class="trigger-title">{{ ___('Dashboard Navigation') }}</span>
            </a>
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    <ul data-submenu-title="{{ ___('My Account') }}">
                        <li class="{{ $__env->yieldContent('active_menu') == 'dashboard' ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="icon-feather-grid"></i> {{ ___('Dashboard') }}</a></li>

                        <li class="{{ $__env->yieldContent('active_menu') == 'membership' ? 'active' : '' }}"><a href="{{ route('subscription') }}"><i class="icon-feather-gift"></i> {{ ___('Membership') }}</a></li>

                        <!-- /# QuickChatAjax Plugin-->
                        @if(is_plugin_enabled('quickchatajax'))
                            <li class="{{ $__env->yieldContent('active_menu') == 'message' ? 'active' : '' }}"><a href="{{ route('message.index') }}"><i class="icon-feather-message-square"></i> {{ ___('Message') }}</a></li>
                        @endif
                        <!-- /# QuickChatAjax Plugin-->
                    </ul>

                    <ul data-submenu-title="{{ ___('Organize and Manage') }}">
                        <li class="{{ $__env->yieldContent('active_menu') == 'post-ad' ? 'active' : '' }}"><a href="{{ route('posts.create') }}"><i class="icon-feather-plus-square"></i> {{ ___('Post Ad') }}</a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'my-ads' ? 'active' : '' }}"><a href="{{ route('posts.myListing') }}"><i class="icon-feather-briefcase"></i> {{ ___('My Ads') }}<span class="nav-tag">{{ $totalMyPosts }}</span></a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'active-ads' ? 'active' : '' }}"><a href="{{ route('posts.status',"active") }}"><i class="icon-feather-layers"></i> {{ ___('Active Ads') }}<span class="nav-tag">{{ $totalActivePosts }}</span></a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'pending-ads' ? 'active' : '' }}"><a href="{{ route('posts.status',"pending") }}"><i class="icon-feather-clock"></i> {{ ___('Pending Ads') }}<span class="nav-tag">{{ $totalPendingPosts }}</span></a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'expire-ads' ? 'active' : '' }}"><a href="{{ route('posts.status',"expire") }}"><i class="icon-feather-alert-octagon"></i> {{ ___('Expire Ads') }}<span class="nav-tag">{{ $totalExpirePosts }}</span></a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'rejected-ads' ? 'active' : '' }}"><a href="{{ route('posts.status',"rejected") }}"><i class="icon-feather-layers"></i> {{ ___('Rejected Ads') }}<span class="nav-tag">{{ $totalRejectedPosts }}</span></a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'hidden-ads' ? 'active' : '' }}"><a href="{{ route('posts.status',"hidden") }}"><i class="icon-feather-eye-off"></i> {{ ___('Hidden Ads') }}<span class="nav-tag">{{ $totalHiddenPosts }}</span></a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'favorite' ? 'active' : '' }}"><a href="{{ route('posts.myFavorite') }}"><i class="icon-feather-heart"></i> {{ ___('Favorite Ads') }}<span class="nav-tag">{{ $totalFavPosts }}</span></a></li>
                    </ul>

                    <ul data-submenu-title="{{ ___('Account') }}">
                        <li class="{{ $__env->yieldContent('active_menu') == 'transactions' ? 'active' : '' }}"><a href="{{ route('transactions') }}"><i class="icon-feather-file-text"></i> {{ ___('Transactions') }}</a></li>
                        <li class="{{ $__env->yieldContent('active_menu') == 'settings' ? 'active' : '' }}"><a href="{{ route('settings') }}"><i class="icon-feather-settings"></i> {{ ___('Account Setting') }}</a>
                        </li>
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-feather-log-out"></i> {{ ___('Logout') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
