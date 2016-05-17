<html>

<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/files/img/favicon.png" type="image/png">

    <script type="text/javascript" src="/dist/libraries/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/dist/libraries/bootstrap-3.3.6-dist/css/bootstrap.css">

    <script type="text/javascript" src="/dist/libraries/JQuery-2.2.3/jquery-2.2.3.min.js"></script>

    <script type="text/javascript" src="/dist/js/script.js"></script>
    <link rel="stylesheet" href="/dist/css/style.css">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>

<body>

<div class="main-container">

    <div class="site-logo">
        <div class="container">
            <div class="row top-site">
                <div class="col-md-2">
                    <a href="/">
                        <div class="logo-container">
                            <div class="logo-image-wrapper">
                                <img src="/files/img/favicon.png" alt="">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-10">
                    <input type="text" placeholder="Search" class="form-control" id="search-article">
                </div>
            </div>
        </div>
    </div>

    <div class="container main-wrapper">
        <div class="row">
            <div class="col-md-2 right-side-bar">
                {{$MainController->RightSideBar()}}
            </div>
            <div class="col-md-7">
                @yield('content')
            </div>
            <div class="col-md-3">
                <span>AdSense</span>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <span class="copyright">{{date('Y', time())}}</span>&nbsp;<span>Club Mixes Download</span>
        </div>
    </footer>

</div>
</body>
</html>