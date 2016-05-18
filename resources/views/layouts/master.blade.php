<html>

<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="/files/img/favicon.png" type="image/png">
    <script type="text/javascript" src="/dist/libraries/JQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="/dist/libraries/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/dist/libraries/bootstrap-3.3.6-dist/css/bootstrap.css">

    <script type="text/javascript" src="/dist/js/script.js"></script>
    <script type="text/javascript" src="/dist/libraries/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js"></script>
    
    <link rel="stylesheet" href="/dist/css/style.css">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

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
                <div class="advert">
                    {{$MainController->BigAdsense()}}
                </div>
                {{$MainController->WidgetArtists()}}
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <span class="copyright">{{date('Y', time())}}</span>&nbsp;<span>Club Mixes Download</span>
        </div>
    </footer>

</div>
<script>
    //********* Autocomplete ****************
    $('#search-article').autocomplete({
        serviceUrl: '/search',
        deferRequestBy: 200,
        onSelect: function (suggestion) {
            window.location ='/mix/' + suggestion.block_page_url;
        },
        onSearchComplete: function (query, suggestions) {
            console.log(suggestions);
        }
    });

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-77906667-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>