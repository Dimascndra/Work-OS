@extends('layouts.index')
@section('title', 'Dashboard')
@section('styles')
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('subheader')
    @component('layouts.partials._subheader.subheader-v1')
        @slot('title')
            Dashboard
        @endslot
        @slot('other')
            <span class="text-muted font-weight-bold mr-4">#XRS-45670</span>
            <a href="#" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</a>
        @endslot
        @slot('action')
            <div class="d-flex align-items-center">
                <!--begin::Actions-->
                <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Today</a>
                <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Month</a>
                <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Year</a>
                <!--end::Actions-->
                <!--begin::Daterange-->
                <a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" id="kt_dashboard_daterangepicker"
                    data-toggle="tooltip" title="Select dashboard daterange" data-placement="left">
                    <span class="text-muted font-size-base font-weight-bold mr-2"
                        id="kt_dashboard_daterangepicker_title">Today</span>
                    <span class="text-primary font-size-base font-weight-bolder" id="kt_dashboard_daterangepicker_date">Aug
                        16</span>
                </a>
                <!--end::Daterange-->
                <!--begin::Dropdowns-->
                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
                    <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="svg-icon svg-icon-success svg-icon-lg">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a>
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
                        <!--begin::Navigation-->
                        <ul class="navi navi-hover py-5">
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-drop"></i>
                                    </span>
                                    <span class="navi-text">New Group</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-list-3"></i>
                                    </span>
                                    <span class="navi-text">Contacts</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-rocket-1"></i>
                                    </span>
                                    <span class="navi-text">Groups</span>
                                    <span class="navi-link-badge">
                                        <span class="label label-light-primary label-inline font-weight-bold">new</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-bell-2"></i>
                                    </span>
                                    <span class="navi-text">Calls</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-gear"></i>
                                    </span>
                                    <span class="navi-text">Settings</span>
                                </a>
                            </li>
                            <li class="navi-separator my-3"></li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-magnifier-tool"></i>
                                    </span>
                                    <span class="navi-text">Help</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-bell-2"></i>
                                    </span>
                                    <span class="navi-text">Privacy</span>
                                    <span class="navi-link-badge">
                                        <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!--end::Navigation-->
                    </div>
                </div>
                <!--end::Dropdowns-->
            </div>
        @endslot
    @endcomponent
@endsection
@section('content')
    <!--begin::Container-->
    <div class="container-fluid">
        <!-- Row 1 -->
        <div class="row">
            <!-- Todo List Widget -->
            <div class="col-xl-4 col-lg-6 mb-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder text-dark">Todo List</h3>
                        <div class="card-toolbar">
                            <span class="label label-light-primary label-inline font-weight-bold mr-2">{{ $todosCount }}
                                Tasks</span>
                            <a href="{{ route('todos.index') }}"
                                class="btn btn-sm btn-light-primary font-weight-bolder">View All</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        @foreach ($recentTodos as $todo)
                            <div class="d-flex align-items-center mb-6">
                                <span
                                    class="bullet bullet-bar bg-{{ $todo->is_completed ? 'success' : 'warning' }} align-self-stretch mr-4"></span>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                        {{ Str::limit($todo->title, 40) }}
                                    </a>
                                    <span class="text-muted font-weight-bold">
                                        {{ $todo->due_date ? $todo->due_date->format('M d, Y') : 'No due date' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Snippets Widget -->
            <div class="col-xl-4 col-lg-6 mb-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder text-dark">Snippets</h3>
                        <div class="card-toolbar">
                            <span class="label label-light-info label-inline font-weight-bold mr-2">{{ $snippetsCount }}
                                Items</span>
                            <a href="{{ route('snippets.index') }}"
                                class="btn btn-sm btn-light-info font-weight-bolder">Manage</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        @foreach ($recentSnippets as $snippet)
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-40 symbol-light-info mr-5">
                                    <span class="symbol-label">
                                        <i class="flaticon-file-2 text-info"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                        {{ Str::limit($snippet->title, 30) }}
                                    </a>
                                    <span class="text-muted font-weight-bold">{{ $snippet->language ?? 'Text' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Servers Widget -->
            <div class="col-xl-4 col-lg-6 mb-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder text-dark">Servers</h3>
                        <div class="card-toolbar">
                            <span
                                class="label label-light-success label-inline font-weight-bold mr-2">{{ $serversActive }}
                                / {{ $serversCount }} Up</span>
                            <a href="{{ route('servers.index') }}"
                                class="btn btn-sm btn-light-success font-weight-bolder">Monitor</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        @foreach ($recentServers as $server)
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <i class="flaticon2-console text-success"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                        {{ Str::limit($server->name, 30) }}
                                    </a>
                                    <span class="text-muted font-weight-bold">{{ $server->ip_address }}</span>
                                </div>
                                <span
                                    class="label label-dot label-{{ $server->is_active ? 'success' : 'danger' }} label-xl"></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row">
            <!-- Domain Monitor Widget -->
            <div class="col-xl-4 col-lg-6 mb-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder text-dark">Domain Monitors</h3>
                        <div class="card-toolbar">
                            <span
                                class="label label-light-warning label-inline font-weight-bold mr-2">{{ $monitorsCount }}
                                Domains</span>
                            <a href="{{ route('domain-monitors.index') }}"
                                class="btn btn-sm btn-light-warning font-weight-bolder">Check</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        @foreach ($recentMonitors as $monitor)
                            <div class="d-flex align-items-center mb-6">
                                <span class="bullet bullet-bar bg-warning align-self-stretch mr-4"></span>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                        {{ Str::limit($monitor->domain, 30) }}
                                    </a>
                                    <span class="text-muted font-weight-bold">Expires:
                                        {{ $monitor->domain_expires_at ? $monitor->domain_expires_at->format('Y-m-d') : 'N/A' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- User Manager Widget -->
            <div class="col-xl-4 col-lg-6 mb-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder text-dark">User Manager</h3>
                        <div class="card-toolbar">
                            <span class="label label-light-danger label-inline font-weight-bold mr-2">{{ $usersCount }}
                                Users</span>
                            <a href="{{ route('users.index') }}"
                                class="btn btn-sm btn-light-danger font-weight-bolder">Users</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        @foreach ($recentUsers as $user)
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-40 symbol-light-danger mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-danger">
                                            <!-- Simple User Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path
                                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path
                                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                        fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                        {{ $user->name }}
                                    </a>
                                    <span class="text-muted font-weight-bold">{{ $user->email }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Credentials Widget -->
            <div class="col-xl-4 col-lg-6 mb-6">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder text-dark">Credentials</h3>
                        <div class="card-toolbar">
                            <span
                                class="label label-light-dark label-inline font-weight-bold mr-2">{{ $credentialsCount }}
                                stored</span>
                            <a href="{{ route('credentials.index') }}"
                                class="btn btn-sm btn-light-dark font-weight-bolder">Vault</a>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        @foreach ($recentCredentials as $credential)
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-40 symbol-light-dark mr-5">
                                    <span class="symbol-label">
                                        <i class="flaticon-lock text-dark"></i>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                        {{ Str::limit($credential->name ?? $credential->username, 30) }}
                                    </a>
                                    <span class="text-muted font-weight-bold">{{ $credential->type ?? 'Login' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
@endsection
@section('scripts')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

    <!--end::Page Vendors-->

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
@endsection
