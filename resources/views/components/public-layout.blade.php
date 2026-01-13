@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Work OS' }} | Security Tools</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!-- Core Metronic Styles -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!-- Public Theme Styles -->
    <style>
        body {
            background-color: #f3f6f9;
        }

        .public-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .public-content {
            flex: 1;
            padding-top: 30px;
            padding-bottom: 50px;
        }

        .sticky-sidebar {
            position: -webkit-sticky;
            position: sticky;
            top: 100px;
            z-index: 90;
        }
    </style>

    @stack('styles')
</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

    <div class="d-flex flex-column flex-root public-wrapper">
        <!-- Header -->
        <div class="bg-white shadow-sm py-4 mb-5" style="z-index: 100;">
            <div class="container-fluid px-5 d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="text-dark font-weight-bold font-size-h4 text-hover-primary mr-5">
                    <i class="flaticon2-shield text-primary mr-2"></i> Work-OS <span
                        class="text-muted font-weight-normal">Security Tools</span>
                </a>

                <div>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-sm btn-light-primary font-weight-bold mr-2">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light-danger font-weight-bold">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light-primary font-weight-bold">Login</a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="public-content">
            <div class="container-fluid px-5">
                <div class="row">
                    <!-- Sidebar Navigation -->
                    <div class="col-lg-2 mb-5 mb-lg-0">
                        <div class="card card-custom gutter-b sticky-sidebar">
                            <div class="card-header border-0 pb-0">
                                <h3 class="card-title font-weight-bolder text-dark">Tools Menu</h3>
                            </div>
                            <div class="card-body pt-2">
                                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('vuln-scanner.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('vuln-scanner.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon-safe-shield-protection"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Vuln Scanner</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('subdomain-finder.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('subdomain-finder.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon-search"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Subdomain Finder</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('dns-checker.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('dns-checker.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-world"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">DNS Checker</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('ssl-checker.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('ssl-checker.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon-lock"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">SSL Checker</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('dnssec-analyzer.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('dnssec-analyzer.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-shield"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">DNSSEC Analyzer</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('domain-checker.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('domain-checker.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon-search"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Whois Lookup</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-lg-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Footer -->
        <div class="py-4 text-center text-muted font-weight-bold">
            {{ date('Y') }} &copy; Work-OS Security Team
        </div>
    </div>

    <!-- Scripts -->
    <script>
        var HOST_URL = "{{ url('/') }}";
    </script>
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

    @stack('scripts')
</body>

</html>
