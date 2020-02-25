<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

    <link rel="icon" href="assets/images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon/apple-touch-icon-152x152.png">

    <title>Reloop - Source Recycling</title>

    <!-- CSS -->
    <link href="/assets/css/themes/collapsible-menu/materialize.css" type="text/css" rel="stylesheet">
    <link href="/assets/css/themes/collapsible-menu/style.css" type="text/css" rel="stylesheet">
    <link href="/assets/css/custom/custom.css" type="text/css" rel="stylesheet">
    <link href="/assets/vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
    <link href="/assets/vendors/jvectormap/jquery-jvectormap.css" type="text/css" rel="stylesheet">
    <link href="/assets/vendors/flag-icon/css/flag-icon.min.css" type="text/css" rel="stylesheet">
    <link href="/assets/vendors/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">
    <link href="/assets/vendors/flag-icon/css/flag-icon.min.css" type="text/css" rel="stylesheet">

</head>

<body>
@include('includes.header')

<div id="main">
    <div class="wrapper">
        @include('includes.leftSidebar')
        @include('includes.rightSideBar')
        @yield('content')
    </div>
</div>

@include('includes.footer')
@include('includes.scripts')
</body>
</html>
