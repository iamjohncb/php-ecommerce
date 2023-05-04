<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin panel - @yield('title')</title>

    <link rel="stylesheet" href="/css/all.css">
    <script src="https://kit.fontawesome.com/045b3f3edb.js" crossorigin="anonymous"></script>

</head>
<body data-page-id="@yield('data-page-id')">

@include('includes.admin-slidebar')

<div class="off-canvas-content admin-title-bar" data-off-canvas-content>
    <!-- Your page content lives here -->
    <div class="title-bar">
        <div class="title-bar-left">
            <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
            <span class="title-bar-title">{{$_ENV['APP_NAME']}}</span>
        </div>
    </div>

    @yield('content')
</div>

<script src="/js/all.js"></script>
</body>
</html>