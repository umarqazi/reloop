<aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible left-sidebar-content">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a href="{{route('home')}}" class="brand-logo darken-1">
                <img src="/assets/images/logo/reloop.png" alt="re loop logo">
            </a>
            <a href="#" class="navbar-toggler">
                <i class="material-icons">radio_button_checked</i>
            </a>
        </h1>
    </div>
    @if(Auth::user()->hasRole('admin'))
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="no-padding">
            <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan" href="{{ route('home') }}">
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
                                    <span>Users (Household)</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('supervisor.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Supervisors</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('driver.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Drivers</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold">
                    <a href="{{ route('user-subscription') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">User Subscription</span>
                    </a>
                </li>
                <li class="bold">
                    <a href="{{ route('organization.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Organizations</span>
                    </a>
                </li><li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Orders</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('orders.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>User Orders</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold">
                    <a href="{{ route('collection-requests.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Collection Requests</span>
                    </a>
                </li><li class="bold">
                    <a href="{{ route('material-category.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Material Categories</span>
                    </a>
                </li><li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Add on Products</span>
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
                                <a href="{{ route('subscription.index') }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Subscriptions</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold">
                    <a href="{{ route('coupon.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Coupons</span>
                    </a>
                </li>
                <li class="bold">
                    <a href="{{ route('all-users') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Users Reward Points</span>
                    </a>
                </li>
                <li class="bold">
                    <a class="collapsible-header  waves-effect waves-cyan">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Pages</span>
                    </a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a href="{{ route('pages.edit', 1) }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>Terms and Conditions</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pages.edit', 2) }}">
                                    <i class="material-icons">keyboard_arrow_right</i>
                                    <span>About Us</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                 <li>
                    <a href="{{ route('questions.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Questions</span>
                    </a>
                 </li>
                <li>
                    <a href="{{ route('donation-products.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Donation Products</span>
                    </a>
                </li>
                <li class="bold">
                    <a href="{{ route('settings.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
                <li class="bold">
                    <a href="{{ route('contact-us.index') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">Contact Us</span>
                    </a>
                </li>
                <li class="bold">
                    <a href="{{ route('getCities') }}">
                        <i class="material-icons">account_circle</i>
                        <span class="nav-text">City</span>
                    </a>
                </li>

                <li class="bold">
                    {{ Form::open(['url' => route('logout'),
                                   'method' => 'POST',]) }}

                    <button type="submit" class="collapsible-header logout-btn  waves-effect waves-cyan"><i class="material-icons">account_circle</i>Logout</button>
                    {{ Form::close() }}
                </li>
            </ul>
        </li>
    </ul>
    @else
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="no-padding">
                <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold">
                        <a class="collapsible-header  waves-effect waves-cyan" href="{{ route('home') }}">
                            <i class="material-icons">dashboard</i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="bold">
                        <a class="collapsible-header  waves-effect waves-cyan">
                            <i class="material-icons">account_circle</i>
                            <span class="nav-text">Orders</span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <li>
                                    <a href="{{ route('get-orders') }}">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                        <span>Manage Orders</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="bold">
                        <a href="{{ route('contact-admin-form') }}">
                            <i class="material-icons">account_circle</i>
                            <span class="nav-text">Contact Admin</span>
                        </a>
                    </li>
                    <li class="bold">
                        {{ Form::open(['url' => route('logout'),
                                       'method' => 'POST',]) }}

                        <button type="submit" class="collapsible-header logout-btn  waves-effect waves-cyan"><i class="material-icons">account_circle</i>Logout</button>
                        {{ Form::close() }}
                    </li>
                </ul>
            </li>
        </ul>
    @endif
</aside>
