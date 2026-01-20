<x-public-layout>
    <div class="row">
        <div class="col-12 mb-8">
            <div class="card card-custom bg-transparent shadow-none border-0">
                <div class="card-body p-0">
                    <h1 class="font-weight-bolder text-dark font-size-h1 mb-2">Welcome to Work-OS Security Tools</h1>
                    <p class="text-dark-50 font-size-lg text-muted">A collection of secure tools for developers and
                        system administrators.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tools Grid -->
    <div class="row">
        <!-- Vuln Scanner -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-danger mr-5">
                            <span class="symbol-label">
                                <i class="flaticon-safe-shield-protection text-danger font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('vuln-scanner.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Vuln Scanner
                            </a>
                            <span class="text-muted font-weight-bold">Web Vulnerability Scan</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Detect common security vulnerabilities in your web applications.
                    </p>
                </div>
            </div>
        </div>

        <!-- Subdomain Finder -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-primary mr-5">
                            <span class="symbol-label">
                                <i class="flaticon-search text-primary font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('subdomain-finder.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Subdomain Finder
                            </a>
                            <span class="text-muted font-weight-bold">Reconnaissance Tool</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Discover subdomains for any target domain instantly.
                    </p>
                </div>
            </div>
        </div>

        <!-- DNS Checker -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-info mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-world text-info font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('dns-checker.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                DNS Checker
                            </a>
                            <span class="text-muted font-weight-bold">Global Propagation</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Check DNS propagation across multiple global nameservers.
                    </p>
                </div>
            </div>
        </div>

        <!-- SSL Checker -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-success mr-5">
                            <span class="symbol-label">
                                <i class="flaticon-lock text-success font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('ssl-checker.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                SSL Checker
                            </a>
                            <span class="text-muted font-weight-bold">Certificate Status</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Verify SSL certificate validity, expiry, and chain issues.
                    </p>
                </div>
            </div>
        </div>

        <!-- DNSSEC Analyzer -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-warning mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-shield text-warning font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('dnssec-analyzer.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                DNSSEC Analyzer
                            </a>
                            <span class="text-muted font-weight-bold">Security Extensions</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Analyze DNSSEC configuration and chain of trust.
                    </p>
                </div>
            </div>
        </div>

        <!-- Domain WHOIS -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-dark mr-5">
                            <span class="symbol-label">
                                <i class="flaticon-search text-dark font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('domain-checker.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Domain Whois
                            </a>
                            <span class="text-muted font-weight-bold">Registration Data</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Retrieve registration and ownership details for any domain.
                    </p>
                </div>
            </div>
        </div>

        <!-- Web Analyzer -->
        <div class="col-xl-4 col-md-6 mb-6">
            <div class="card card-custom card-stretch wave wave-animate-slow">
                <div class="card-body pt-8">
                    <div class="d-flex align-items-center mb-5">
                        <span class="symbol symbol-60 symbol-light-primary mr-5">
                            <span class="symbol-label">
                                <i class="flaticon2-browser-2 text-primary font-size-h1"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column">
                            <a href="{{ route('web-analyzer.index') }}"
                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-1">
                                Web Analyzer
                            </a>
                            <span class="text-muted font-weight-bold">Tech Stack</span>
                        </div>
                    </div>
                    <p class="text-dark-75 font-weight-nomal mb-5">
                        Identify technologies framework, and server used by websites.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-public-layout>
