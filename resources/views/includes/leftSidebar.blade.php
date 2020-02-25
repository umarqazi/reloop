<aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible left-sidebar-content">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a href="index.html" class="brand-logo darken-1">
                <img src="/assets/images/logo/reloop.png" alt="re loop logo">
{{--                <span class="logo-text hide-on-med-and-down">ReLoop</span>--}}
            </a>
            <a href="#" class="navbar-toggler">
                <i class="material-icons">radio_button_checked</i>
            </a>
        </h1>
    </div>
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="no-padding">
            <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">dashboard</i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Users</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('user.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="advance-ui-collapsibles.html">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Supervisors</span>
                                </a>
                            </li>
                            <li>
                                <a href="advance-ui-collapsibles.html">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Drivers</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li><li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Orders</span>
                    </a>
                </li><li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Material Categories</span>
                    </a>
                </li><li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Add on products</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('product.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="advance-ui-collapsibles.html">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Subscriptions</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Geographical Zones</span>
                    </a>
                </li><li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>