<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Work OS' }} | Vulnerability Scanner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!-- Core Metronic Styles -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!-- Public Theme Styles (Optional override) -->
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
            padding-top: 100px;
            padding-bottom: 50px;
        }
    </style>

    @stack('styles')
</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

    <div class="d-flex flex-column flex-root public-wrapper">
        <!-- Simple Header -->
        <div class="bg-white shadow-sm py-4">
            <div class="container d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="text-dark font-weight-bold font-size-h4 text-hover-primary">
                    <i class="flaticon2-shield text-primary mr-2"></i> Work-OS <span
                        class="text-muted font-weight-normal">Security Tools</span>
                </a>
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light-primary font-weight-bold mr-2">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline"></form>
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light-danger font-weight-bold">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light-primary font-weight-bold">Login</a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="public-content mt-5">
            <div class="container">
                {{ $slot }}
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
