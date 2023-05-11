<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Acme Store - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/css/all.css" >
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

</head>
<body data-page-id="@yield('data-page-id')">

@yield('body')

<script async src="/js/all.js"></script>
</body>
</html>
