@extends('layouts.master')
@section('content')

    <div id="breadcrumbs-wrapper">
        <!-- Search for small screen -->
        <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
        </div>
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title">Create Product</h5>
                    <ol class="breadcrumbs">
                        <li><a href="index.html">Dashboard</a>
                        </li>
                        <li><a href="#">Users</a>
                        </li>
                        <li class="active">Create</li>
                    </ol>
                </div>
                <div class="col s2 m6 l6">
                    <a class="btn dropdown-settings waves-effect waves-light breadcrumbs-btn right gradient-45deg-light-blue-cyan gradient-shadow" href="#!" data-activates="dropdown1">
                        <i class="material-icons hide-on-med-and-up">settings</i>
                        <span class="hide-on-small-onl">Settings</span>
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="#!" class="grey-text text-darken-2">Access<span class="badge">1</span></a>
                        </li>
                        <li><a href="#!" class="grey-text text-darken-2">Profile<span class="new badge">2</span></a>
                        </li>
                        <li><a href="#!" class="grey-text text-darken-2">Notifications</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section">
            <p class="caption">Forms are the standard way to receive user inputted data. The transitions and smoothness
                of these elements are very important because of the inherent user interaction associated with forms.</p>
            <div class="divider"></div>
            <h4 class="header">Input fields</h4>
            <p>Text fields allow user input. The border should light up simply and clearly indicating which field the
                user is currently editing. You must have a <code class="language-markup">.input-field</code> div
                wrapping your input and label. This helps our jQuery animate the label. This is only used in our Input
                and Textarea form elements.</p>
            <p>The validate class leverages HTML5 validation and will add a <code class="language-markup">valid</code>
                and <code class="language-markup">invalid</code> class accordingly. If you don't want the Green and Red
                validation states, just remove the <code class="language-markup">validate</code> class from your inputs.
            </p>
            <br>
            <form class="row">
                <div class="col s12">
                    <div class="input-field col s6">
                        <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" type="text">
                        <label for="last_name">Last Name</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input disabled value="I am not editable" id="disabled" type="text" class="validate">
                        <label for="disabled">Disabled</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate">
                        <label for="email" data-error="wrong" data-success="right">Email</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="col s12">
                        This is an inline input field:
                        <div class="input-field inline">
                            <input id="email" type="email" class="validate">
                            <label for="email" data-error="wrong" data-success="right">Email</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
