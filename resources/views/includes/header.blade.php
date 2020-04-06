<header id="header" class="page-topbar mian-header-content">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color primary-bg-color">
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen">
                            <i class="material-icons">settings_overscan</i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                  <span class="avatar-status avatar-online">
                    <img src="/assets/images/avatar/avatar-7.png" alt="avatar">
                    <i></i>
                  </span>
                        </a>
                    </li>
                </ul>

                <!-- profile-dropdown -->
                <ul id="profile-dropdown" class="dropdown-content">
                    <li>
                        {{ Form::open(['url' => route('logout'),
                                   'method' => 'POST',]) }}

                        <button type="submit" class="collapsible-header drop-down-logout-btn  waves-effect waves-cyan"><i class="material-icons">keyboard_tab</i>  Logout</button>
                        {{ Form::close() }}
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
