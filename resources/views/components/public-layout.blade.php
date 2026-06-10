@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Web Security Scanner Tools' }}</title>
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
            top: 90px;
        }

        /* Off-canvas mobile menu styles */
        .offcanvas-menu {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background-color: #ffffff;
            z-index: 1050;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            padding: 24px;
        }
        .offcanvas-menu.active {
            left: 0;
        }
        .offcanvas-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
            z-index: 1040;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .offcanvas-backdrop.active {
            display: block;
            opacity: 1;
        }

        /* Horizontal Scroll Navigation styles */
        .mobile-nav-scroll-container {
            position: relative;
            margin-left: -15px;
            margin-right: -15px;
            padding-bottom: 8px;
        }
        
        .mobile-nav-scroll {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 0 15px 5px 15px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        
        .mobile-nav-scroll::-webkit-scrollbar {
            display: none;
        }
        
        .mobile-nav-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .mobile-nav-chip {
            display: inline-flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #e4e6ef;
            padding: 8px 16px;
            margin-right: 8px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #3f4254;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
            flex-shrink: 0;
        }
        
        .mobile-nav-chip.active {
            background: linear-gradient(135deg, #3699ff 0%, #187de4 100%);
            border-color: #3699ff;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(54, 153, 255, 0.3);
        }
        
        .mobile-nav-chip:active {
            transform: scale(0.95);
        }

        .mobile-nav-scroll-container::before,
        .mobile-nav-scroll-container::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 8px;
            width: 30px;
            pointer-events: none;
            z-index: 2;
            transition: opacity 0.2s ease;
        }

        .mobile-nav-scroll-container::before {
            left: 0;
            background: linear-gradient(to right, #f3f6f9, transparent);
        }

        .mobile-nav-scroll-container::after {
            right: 0;
            background: linear-gradient(to left, #f3f6f9, transparent);
        }

        .public-header {
            z-index: 1000;
            left: 0;
            top: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Modern UI/UX Refactoring CSS Overrides */
        body {
            background: radial-gradient(at 0% 0%, #f8fafc 0, transparent 50%), 
                        radial-gradient(at 50% 0%, #f1f5f9 0, transparent 50%), 
                        radial-gradient(at 100% 0%, #f8fafc 0, transparent 50%), 
                        #f8fafc !important;
            font-family: 'Poppins', 'Inter', -apple-system, sans-serif !important;
        }

        /* Card lifts on hover and elegant shadow */
        .card, .card-custom {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02) !important;
            background-color: #ffffff !important;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .card:hover, .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.05) !important;
        }

        /* Modern input fields */
        .form-control-solid {
            background-color: #f3f6f9 !important;
            border: 1px solid transparent !important;
            border-radius: 12px !important;
            padding: 12px 20px !important;
            font-weight: 500 !important;
            color: #3f4254 !important;
            transition: all 0.2s ease-in-out !important;
        }
        .form-control-solid:focus {
            background-color: #ffffff !important;
            border-color: #3699ff !important;
            box-shadow: 0 0 0 4px rgba(54, 153, 255, 0.15) !important;
            color: #181c32 !important;
        }

        /* Vibrant linear gradient buttons */
        .btn-primary {
            background: linear-gradient(135deg, #3699ff 0%, #0072ff 100%) !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(54, 153, 255, 0.25) !important;
            border-radius: 12px !important;
            transition: all 0.2s ease-in-out !important;
            font-weight: 600 !important;
        }
        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(54, 153, 255, 0.35) !important;
        }
        .btn-primary:active {
            transform: translateY(1px) !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #1bc5bd 0%, #11998e 100%) !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(27, 197, 189, 0.25) !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease-in-out !important;
        }
        .btn-success:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(27, 197, 189, 0.35) !important;
        }
        .btn-success:active {
            transform: translateY(1px) !important;
        }

        /* Clean responsive tables and text wrapping */
        .table-responsive {
            border-radius: 12px !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .table td, .table th {
            padding: 1.1rem 1.25rem !important;
            vertical-align: middle !important;
            white-space: normal !important;
            word-break: break-word !important;
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(243, 246, 249, 0.45) !important;
        }
        .table tbody tr {
            border-bottom: 1px solid #ebedf3 !important;
            transition: background-color 0.2s ease !important;
        }
        .table tbody tr:hover {
            background-color: rgba(243, 246, 249, 0.8) !important;
        }

        /* Flex list wrapping for clean mobile views */
        .list-group-item {
            border-radius: 10px !important;
            border: 1px solid rgba(0, 0, 0, 0.03) !important;
            margin-bottom: 6px !important;
            padding: 12px 18px !important;
            background-color: #fcfdfe !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
        }
        .list-group-item:hover {
            background-color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03) !important;
            border-color: rgba(54, 153, 255, 0.1) !important;
        }

        /* Modern accordions */
        .accordion-solid .card {
            border: 1px solid rgba(0,0,0,0.04) !important;
            margin-bottom: 10px !important;
            border-radius: 12px !important;
            box-shadow: none !important;
        }
        .accordion-solid .card-header {
            background-color: #f8fafc !important;
            border-bottom: none !important;
            border-radius: 12px !important;
            padding: 0.85rem 1.5rem !important;
        }
        .accordion-solid .card-header:hover {
            background-color: #f1f5f9 !important;
        }
        
        .label-inline {
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Mobile chip styles */
        .mobile-nav-chip {
            background-color: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 10px 20px !important;
            margin-right: 10px !important;
            border-radius: 30px !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            transition: all 0.25s ease !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02) !important;
        }
        .mobile-nav-chip:hover {
            background-color: #ffffff !important;
            border-color: rgba(54, 153, 255, 0.3) !important;
            color: #3699ff !important;
        }
        .mobile-nav-chip.active {
            background: linear-gradient(135deg, #3699ff 0%, #0072ff 100%) !important;
            border-color: transparent !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(54, 153, 255, 0.3) !important;
        }

        /* Sidebar active style */
        .navi-link {
            border-radius: 12px !important;
            padding: 12px 18px !important;
            transition: all 0.2s ease !important;
        }
        .navi-link:hover {
            background-color: rgba(54, 153, 255, 0.05) !important;
        }
        .navi-link.active {
            background: linear-gradient(135deg, rgba(54, 153, 255, 0.08) 0%, rgba(0, 114, 255, 0.08) 100%) !important;
            color: #3699ff !important;
        }
        .navi-link.active .navi-text {
            color: #3699ff !important;
            font-weight: 700 !important;
        }
        .navi-link.active .navi-icon i {
            color: #3699ff !important;
        }
    </style>
    @stack('styles')
</head>

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

    <!-- Mobile Off-Canvas Menu Drawer -->
    <div id="mobile-menu-drawer" class="offcanvas-menu d-lg-none">
        <div class="d-flex align-items-center justify-content-between mb-8 pb-4 border-bottom">
            <span class="font-weight-boldest text-dark font-size-h4">
                <i class="flaticon2-shield text-primary mr-1"></i> WSS Tools
            </span>
            <button id="mobile-menu-close" class="btn btn-icon btn-light btn-sm" style="border-radius: 50%;">
                <i class="flaticon2-cross font-size-xs text-muted"></i>
            </button>
        </div>

        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
            <div class="navi-item mb-2">
                <a href="{{ url('/') }}" class="navi-link py-3 {{ request()->is('/') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-browser text-dark"></i>
                    </span>
                    <span class="navi-text">Beranda</span>
                </a>
            </div>
            
            <div class="separator separator-border-dashed my-4"></div>
            <span class="text-muted font-size-sm font-weight-bolder text-uppercase mb-3 d-block">Menu Alat</span>
            
            <div class="navi-item mb-2">
                <a href="{{ route('vuln-scanner.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('vuln-scanner.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-protection text-danger"></i>
                    </span>
                    <span class="navi-text">Pemindai Kerentanan</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('subdomain-finder.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('subdomain-finder.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-search-1 text-primary"></i>
                    </span>
                    <span class="navi-text">Pencari Subdomain</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('dns-checker.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('dns-checker.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-world text-info"></i>
                    </span>
                    <span class="navi-text">Pemeriksa DNS</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('ssl-checker.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('ssl-checker.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-lock text-success"></i>
                    </span>
                    <span class="navi-text">Pemeriksa SSL</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('dnssec-analyzer.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('dnssec-analyzer.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-shield text-warning"></i>
                    </span>
                    <span class="navi-text">Penganalisis DNSSEC</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('domain-checker.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('domain-checker.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-search text-dark"></i>
                    </span>
                    <span class="navi-text">WHOIS Domain</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('web-analyzer.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('web-analyzer.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon2-browser-2 text-primary"></i>
                    </span>
                    <span class="navi-text">Penganalisis Web</span>
                </a>
            </div>
            <div class="navi-item mb-2">
                <a href="{{ route('port-scanner.index') }}"
                    class="navi-link py-3 {{ request()->routeIs('port-scanner.*') ? 'active' : '' }}">
                    <span class="navi-icon mr-2">
                        <i class="flaticon-computer text-warning"></i>
                    </span>
                    <span class="navi-text">Pemindai Port</span>
                </a>
            </div>
        </div>
        
    </div>
    <div id="mobile-menu-backdrop" class="offcanvas-backdrop d-lg-none"></div>

    <div class="d-flex flex-column flex-root public-wrapper">
        <!-- Header -->
        <div class="shadow-sm py-3 mb-5 position-fixed w-100 public-header">
            <div class="container-fluid px-4 px-md-5 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <button id="mobile-menu-toggle" class="btn btn-icon btn-clean btn-lg d-lg-none mr-2" style="border-radius: 8px;">
                        <i class="flaticon-menu-1 font-size-h3 text-dark"></i>
                    </button>
                    <a href="{{ url('/') }}" class="text-dark font-weight-bold font-size-h4 text-hover-primary">
                        <i class="flaticon2-shield text-primary mr-1"></i>
                        <span class="d-none d-sm-inline">Web Security Scanner Tools</span>
                        <span class="d-inline d-sm-none">WSS Tools</span>
                    </a>
                </div>

                <div>
                </div>
            </div>
        </div>

        <div class="public-content" style="margin-top: 70px;">
            <div class="container-fluid px-4 px-md-5">
                <div class="row">
                    <!-- Sidebar Navigation (Desktop only) -->
                    <div class="col-lg-2 mb-5 mb-lg-0 d-none d-lg-block">
                        <div class="card card-custom gutter-b sticky-sidebar shadow-sm border-0" style="border-radius: 12px;">
                            <div class="card-header border-0 pb-0 bg-transparent">
                                <h3 class="card-title font-weight-bolder text-dark font-size-h5">Menu Alat</h3>
                            </div>
                            <div class="card-body pt-2">
                                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('vuln-scanner.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('vuln-scanner.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-protection text-danger"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Pemindai Kerentanan</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('subdomain-finder.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('subdomain-finder.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-search-1 text-primary"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Pencari Subdomain</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('dns-checker.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('dns-checker.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-world text-info"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Pemeriksa DNS</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('ssl-checker.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('ssl-checker.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-lock text-success"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Pemeriksa SSL</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('dnssec-analyzer.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('dnssec-analyzer.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-shield text-warning"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Penganalisis DNSSEC</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('domain-checker.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('domain-checker.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-search text-dark"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">WHOIS Domain</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('web-analyzer.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('web-analyzer.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon2-browser-2 text-primary"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Penganalisis Web</span>
                                        </a>
                                    </div>
                                    <div class="navi-item mb-2">
                                        <a href="{{ route('port-scanner.index') }}"
                                            class="navi-link py-4 {{ request()->routeIs('port-scanner.*') ? 'active' : '' }}">
                                            <span class="navi-icon mr-2">
                                                <i class="flaticon-computer text-warning"></i>
                                            </span>
                                            <span class="navi-text font-size-lg">Pemindai Port</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-12 col-lg-10">
                        <!-- Mobile Horizontal Scroll Navigation -->
                        <div class="mobile-nav-scroll-container d-lg-none">
                            <div class="mobile-nav-scroll">
                                <a href="{{ route('vuln-scanner.index') }}" class="mobile-nav-chip {{ request()->routeIs('vuln-scanner.*') ? 'active' : '' }}">
                                    <i class="flaticon2-protection mr-2 {{ request()->routeIs('vuln-scanner.*') ? 'text-white' : 'text-danger' }}"></i> Pemindai
                                </a>
                                <a href="{{ route('subdomain-finder.index') }}" class="mobile-nav-chip {{ request()->routeIs('subdomain-finder.*') ? 'active' : '' }}">
                                    <i class="flaticon2-search-1 mr-2 {{ request()->routeIs('subdomain-finder.*') ? 'text-white' : 'text-primary' }}"></i> Subdomain
                                </a>
                                <a href="{{ route('dns-checker.index') }}" class="mobile-nav-chip {{ request()->routeIs('dns-checker.*') ? 'active' : '' }}">
                                    <i class="flaticon2-world mr-2 {{ request()->routeIs('dns-checker.*') ? 'text-white' : 'text-info' }}"></i> DNS
                                </a>
                                <a href="{{ route('ssl-checker.index') }}" class="mobile-nav-chip {{ request()->routeIs('ssl-checker.*') ? 'active' : '' }}">
                                    <i class="flaticon2-lock mr-2 {{ request()->routeIs('ssl-checker.*') ? 'text-white' : 'text-success' }}"></i> SSL
                                </a>
                                <a href="{{ route('dnssec-analyzer.index') }}" class="mobile-nav-chip {{ request()->routeIs('dnssec-analyzer.*') ? 'active' : '' }}">
                                    <i class="flaticon2-shield mr-2 {{ request()->routeIs('dnssec-analyzer.*') ? 'text-white' : 'text-warning' }}"></i> DNSSEC
                                </a>
                                <a href="{{ route('domain-checker.index') }}" class="mobile-nav-chip {{ request()->routeIs('domain-checker.*') ? 'active' : '' }}">
                                    <i class="flaticon2-search mr-2 {{ request()->routeIs('domain-checker.*') ? 'text-white' : 'text-dark' }}"></i> WHOIS
                                </a>
                                <a href="{{ route('web-analyzer.index') }}" class="mobile-nav-chip {{ request()->routeIs('web-analyzer.*') ? 'active' : '' }}">
                                    <i class="flaticon2-browser-2 mr-2 {{ request()->routeIs('web-analyzer.*') ? 'text-white' : 'text-primary' }}"></i> Web
                                </a>
                                <a href="{{ route('port-scanner.index') }}" class="mobile-nav-chip {{ request()->routeIs('port-scanner.*') ? 'active' : '' }}">
                                    <i class="flaticon-computer mr-2 {{ request()->routeIs('port-scanner.*') ? 'text-white' : 'text-warning' }}"></i> Port
                                </a>
                            </div>
                        </div>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Simple Footer -->
        <div class="py-4 text-center text-muted font-weight-bold">
            {{ date('Y') }} &copy; Web Security Scanner Tools
        </div>
    </div>

    <!-- Scripts -->
    <script>
        var HOST_URL = "{{ url('/') }}";
    </script>
    
    <!-- Recent Scans and Auto-Scan Logic -->
    <script>
        (function() {
            // Tool metadata configuration
            const toolMetadata = {
                '/vuln-scanner': {
                    name: 'Pemindai Kerentanan',
                    route: '/vuln-scanner',
                    icon: 'flaticon2-protection',
                    color: 'danger',
                    paramName: 'url'
                },
                '/subdomain-finder': {
                    name: 'Pencari Subdomain',
                    route: '/subdomain-finder',
                    icon: 'flaticon2-search-1',
                    color: 'primary',
                    paramName: 'url'
                },
                '/dns-checker': {
                    name: 'Pemeriksa DNS',
                    route: '/dns-checker',
                    icon: 'flaticon2-world',
                    color: 'info',
                    paramName: 'domain'
                },
                '/ssl-checker': {
                    name: 'Pemeriksa SSL',
                    route: '/ssl-checker',
                    icon: 'flaticon2-lock',
                    color: 'success',
                    paramName: 'domain'
                },
                '/dnssec-analyzer': {
                    name: 'Penganalisis DNSSEC',
                    route: '/dnssec-analyzer',
                    icon: 'flaticon2-shield',
                    color: 'warning',
                    paramName: 'domain'
                },
                '/domain-checker': {
                    name: 'WHOIS Domain',
                    route: '/domain-checker',
                    icon: 'flaticon2-search',
                    color: 'dark',
                    paramName: 'domain'
                },
                '/web-analyzer': {
                    name: 'Penganalisis Web',
                    route: '/web-analyzer',
                    icon: 'flaticon2-browser-2',
                    color: 'primary',
                    paramName: 'url'
                },
                '/port-scanner': {
                    name: 'Pemindai Port',
                    route: '/port-scanner',
                    icon: 'flaticon-computer',
                    color: 'warning',
                    paramName: 'target'
                }
            };

            function saveRecentScan(newScan) {
                const key = 'wss_recent_scans';
                let scans = [];
                try {
                    scans = JSON.parse(localStorage.getItem(key)) || [];
                } catch(e) {
                    scans = [];
                }
                if (!Array.isArray(scans)) {
                    scans = [];
                }
                // Remove existing scan for the same route and target to avoid duplication
                scans = scans.filter(s => !(s.route === newScan.route && s.target.toLowerCase() === newScan.target.toLowerCase()));
                // Add to beginning
                scans.unshift(newScan);
                // Keep only top 10 recent scans
                scans = scans.slice(0, 10);
                localStorage.setItem(key, JSON.stringify(scans));

                // Dispatch event so that welcome page (or other pages) can update UI reactively
                window.dispatchEvent(new CustomEvent('wss_recent_scans_updated'));
            }

            // Intercept window.fetch to capture scan results dynamically
            const originalFetch = window.fetch;
            window.fetch = async function(...args) {
                const response = await originalFetch.apply(this, args);
                try {
                    const urlStr = args[0];
                    const options = args[1] || {};
                    
                    // Parse pathname
                    let pathname = '';
                    try {
                        pathname = new URL(urlStr, window.location.origin).pathname;
                    } catch (e) {
                        pathname = urlStr;
                    }
                    // Strip trailing slash
                    pathname = pathname.replace(/\/$/, '');

                    if (toolMetadata[pathname]) {
                        const meta = toolMetadata[pathname];
                        
                        // Extract target value
                        let targetValue = '';
                        if (options.body instanceof FormData) {
                            targetValue = options.body.get(meta.paramName) || '';
                        }
                        
                        if (targetValue) {
                            // Clone the response to inspect JSON without consuming it
                            const clone = response.clone();
                            clone.json().then(data => {
                                if (data && data.success) {
                                    saveRecentScan({
                                        toolName: meta.name,
                                        target: targetValue,
                                        route: meta.route,
                                        icon: meta.icon,
                                        color: meta.color,
                                        paramName: meta.paramName,
                                        timestamp: Date.now()
                                    });
                                }
                            }).catch(err => {
                                // Silent fail if not JSON or parsing fails
                            });
                        }
                    }
                } catch (e) {
                    // Fail-safe to avoid breaking application
                    console.error('Fetch intercept error:', e);
                }
                return response;
            };

            // Delegated global form submission handler to prevent page refresh and show loading overlays
            document.addEventListener('submit', function(e) {
                var form = e.target;
                if (form && form.id === 'scanForm') {
                    e.preventDefault();

                    var url = form.action;
                    var formData = new FormData(form);
                    var resultContainer = document.getElementById('resultContainer');
                    if (!resultContainer) return;

                    var loadingMessage = form.getAttribute('data-loading-message') || 'Memproses...';
                    var loadingBtnText = form.getAttribute('data-loading-btn') || 'Memproses...';

                    // Block UI
                    if (typeof KTApp !== 'undefined' && typeof KTApp.block === 'function') {
                        KTApp.block(resultContainer, {
                            overlayColor: '#000000',
                            state: 'primary',
                            message: loadingMessage,
                            opacity: 0.3
                        });
                    }

                    // Disable submit button and add spinner
                    var btn = form.querySelector('button[type="submit"]');
                    var originalBtnHtml = btn ? btn.innerHTML : '';
                    if (btn) {
                        btn.innerHTML = '<i class="spinner spinner-white spinner-right pr-4"></i> ' + loadingBtnText;
                        btn.disabled = true;
                    }

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.html) {
                            resultContainer.innerHTML = data.html;
                        }

                        // Special tool callback for DNS Checker map initialization
                        if (data.results && typeof window.initDnsMap === 'function') {
                            window.initDnsMap(data.results);
                        }

                        if (data.error) {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(data.error);
                            } else {
                                alert(data.error);
                            }
                        }

                        // Scroll to result
                        resultContainer.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    })
                    .catch(function(error) {
                        console.error('Scan Error:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Terjadi kesalahan saat melakukan pemindaian.');
                        }
                    })
                    .finally(function() {
                        if (typeof KTApp !== 'undefined' && typeof KTApp.unblock === 'function') {
                            KTApp.unblock(resultContainer);
                        }
                        if (btn) {
                            btn.innerHTML = originalBtnHtml;
                            btn.disabled = false;
                        }
                    });
                }
            });

            // Auto-fill & auto-submit on page load
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const targetUrl = urlParams.get('url');
                const targetDomain = urlParams.get('domain');
                const targetParam = urlParams.get('target');
                const target = targetUrl || targetDomain || targetParam;

                if (target) {
                    const form = document.getElementById('scanForm');
                    if (form) {
                        const inputUrl = form.querySelector('input[name="url"]');
                        const inputDomain = form.querySelector('input[name="domain"]');
                        const inputTarget = form.querySelector('input[name="target"]');
                        const input = inputUrl || inputDomain || inputTarget;
                        if (input) {
                            input.value = target;
                            // Trigger scanning with a minor delay so scripts settle
                            setTimeout(() => {
                                const submitBtn = form.querySelector('button[type="submit"]');
                                if (submitBtn) {
                                    submitBtn.click();
                                } else {
                                    form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                                }
                            }, 400);
                        }
                    }
                }
            });
        })();
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

    <!-- Mobile Navigation Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('mobile-menu-toggle');
            var close = document.getElementById('mobile-menu-close');
            var drawer = document.getElementById('mobile-menu-drawer');
            var backdrop = document.getElementById('mobile-menu-backdrop');
            
            if (toggle && drawer && backdrop) {
                function openDrawer() {
                    drawer.classList.add('active');
                    backdrop.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
                
                function closeDrawer() {
                    drawer.classList.remove('active');
                    backdrop.classList.remove('active');
                    document.body.style.overflow = '';
                }
                
                toggle.addEventListener('click', openDrawer);
                if (close) close.addEventListener('click', closeDrawer);
                backdrop.addEventListener('click', closeDrawer);
            }

            // Scroll the active mobile nav chip into view
            var activeChip = document.querySelector('.mobile-nav-chip.active');
            if (activeChip) {
                var container = document.querySelector('.mobile-nav-scroll');
                if (container) {
                    var containerWidth = container.offsetWidth;
                    var chipLeft = activeChip.offsetLeft;
                    var chipWidth = activeChip.offsetWidth;
                    container.scrollLeft = chipLeft - (containerWidth / 2) + (chipWidth / 2);
                }
            }

        });
    </script>

    @stack('scripts')
</body>
</html>
