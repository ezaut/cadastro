<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('pageTitle')</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/back/vendors/images/favicon-univasf.ico" />
    <link rel="icon" type="image/ico" sizes="32x32" href="/back/vendors/images/favicon-univasf.ico" />
    <link rel="icon" type="image/ico" sizes="16x16" href="/back/vendors/images/favicon-univasf.ico" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/back/src/plugins/jquery-steps/jquery.steps.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
    @stack('stylesheets')
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="/">
                    <img src="/back/vendors/images/logo_sead.png" alt="" />
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    @if ( Route::is('candidato.login') )
                    <li><a href="register">Registre-se</a></li>
                    @endif
                    @if ( Route::is('candidato.create') )
                    <li><a href="login">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">

        <div class="container">
            <div class="row align-items-center">
                @if (Route::is('candidato.create'))
                    <div class="col-md-6 col-lg-7">
                        <img src="/back/vendors/images/register-page-img.png" alt="" />
                    </div>
                @else
                    <div class="col-md-6 col-lg-7">
                        <img src="/back/vendors/images/login-page-img.png" alt="" />
                    </div>
                @endif

                <div class="col-md-6 col-lg-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="/back/vendors/scripts/core.js"></script>
    <script src="/back/vendors/scripts/script.min.js"></script>
    <script src="/back/vendors/scripts/process.js"></script>
    <script src="/back/vendors/scripts/layout-settings.js"></script>
    <script src="/back/src/plugins/jquery-steps/jquery.steps.js"></script>
    <script src="/back/vendors/scripts/steps-setting.js"></script>
    <script src="/back/vendors/scripts/jquery.mask.js"></script>

    <script>
        if (navigator.userAgent.indexOf("Firefox") != -1) {
                history.pushState(null, null, document.URL);
                window.addEventListener('popstate', function(){
                    history.pushState(null, null, document.URL);
                });
            }
    </script>
    @stack('scripts')
</body>

</html>
