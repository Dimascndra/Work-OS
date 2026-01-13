<x-public-layout title="Web Analyzer">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 mb-4 mb-lg-0">
            <x-public.sidebar />
        </div>

        <!-- Content -->
        <div class="col-lg-10">
            <!-- Search Card -->
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40 symbol-light-primary mr-3">
                        <span class="symbol-label">
                            <i class="flaticon2-browser-2 text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-dark-75 font-weight-bold font-size-h6">Web Analyzer</div>
                        <div class="text-muted font-size-sm">Analyze Performance, SEO, and Security Headers</div>
                    </div>
                </div>

                <form action="{{ route('web-analyzer.analyze') }}" method="POST">
                    @csrf
                    <div class="form-group mb-0">
                        <div class="input-group input-group-lg input-group-solid">
                            <input type="url" name="url" class="form-control pl-5"
                                placeholder="https://example.com" required value="{{ old('url') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary font-weight-bold px-10">
                                    Analyze <i class="flaticon-search ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="separator separator-border-dashed my-5"></div>

                <div class="text-muted">
                    <p class="mb-2"><i class="flaticon2-correct text-success mr-1"></i> Checks Load Time, Page Size,
                        and SEO Metadata.</p>
                    <p class="mb-0"><i class="flaticon2-shield text-warning mr-1"></i> Verifies Security Headers (CSP,
                        HSTS, X-Frame).</p>
                </div>
            </x-card>

            @if (session('result'))
                @php $res = session('result'); @endphp

                <!-- Summary Row -->
                <div class="row">
                    <div class="col-lg-3">
                        <div
                            class="card card-custom gutter-b bg-light-{{ $res['overall_score'] >= 90 ? 'success' : ($res['overall_score'] >= 70 ? 'warning' : 'danger') }}">
                            <div class="card-body text-center p-5">
                                <h4 class="card-label font-weight-bolder text-dark-75 mb-2">Overall Score</h4>
                                <div class="display-3 font-weight-boldest text-dark mb-2">{{ $res['overall_score'] }}
                                </div>
                                <div class="text-dark-50 font-weight-bold">/ 100</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <x-card class="card-stretch gutter-b">
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-primary mr-3">
                                    <span class="symbol-label"><i class="flaticon-stopwatch text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-dark-75 font-weight-bold font-size-lg">Performance</div>
                                    <span class="text-muted font-weight-bold">{{ $res['performance']['grade'] }}
                                        Grade</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-dark-50 font-weight-bold">Load Time:</span>
                                <span class="text-dark font-weight-bold">{{ $res['performance']['load_time'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark-50 font-weight-bold">Page Size:</span>
                                <span class="text-dark font-weight-bold">{{ $res['performance']['size'] }}</span>
                            </div>
                        </x-card>
                    </div>

                    <div class="col-lg-3">
                        <x-card class="card-stretch gutter-b">
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-info mr-3">
                                    <span class="symbol-label"><i class="flaticon-search text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-dark-75 font-weight-bold font-size-lg">SEO stats</div>
                                    <span class="text-muted font-weight-bold">Meta Tags</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-dark-50 font-weight-bold">Title:</span>
                                <span
                                    class="label label-light-{{ $res['seo_data']['title'] ? 'success' : 'danger' }} label-inline font-weight-bold">
                                    {{ $res['seo_data']['title'] ? 'Found' : 'Missing' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark-50 font-weight-bold">Desc:</span>
                                <span
                                    class="label label-light-{{ $res['seo_data']['description'] ? 'success' : 'danger' }} label-inline font-weight-bold">
                                    {{ $res['seo_data']['description'] ? 'Found' : 'Missing' }}
                                </span>
                            </div>
                        </x-card>
                    </div>

                    <div class="col-lg-3">
                        <x-card class="card-stretch gutter-b">
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-40 symbol-light-warning mr-3">
                                    <span class="symbol-label"><i class="flaticon2-shield text-warning"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-dark-75 font-weight-bold font-size-lg">Tech Stack</div>
                                    <span class="text-muted font-weight-bold">Server Info</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-dark-50 font-weight-bold">Server:</span>
                                <span
                                    class="text-dark font-weight-bold">{{ Str::limit($res['tech']['Server'], 10) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark-50 font-weight-bold">App:</span>
                                <span
                                    class="text-dark font-weight-bold">{{ Str::limit($res['tech']['X-Powered-By'], 10) }}</span>
                            </div>
                        </x-card>
                    </div>
                </div>

                <!-- Details Row -->
                <div class="row">
                    <!-- SEO Details -->
                    <div class="col-lg-6">
                        <x-card title="SEO Analysis" class="card-stretch gutter-b" :toolbar="false">
                            <div class="table-responsive">
                                <table class="table table-borderless table-vertical-center">
                                    <tbody>
                                        @foreach ($res['seo'] as $key => $check)
                                            <tr>
                                                <td class="pl-0" style="width: 40px">
                                                    <div
                                                        class="symbol symbol-40 symbol-light-{{ $check['passed'] ? 'success' : 'danger' }}">
                                                        <span class="symbol-label">
                                                            <i
                                                                class="flaticon2-{{ $check['passed'] ? 'check-mark' : 'cross' }} text-{{ $check['passed'] ? 'success' : 'danger' }}"></i>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="pl-0">
                                                    <div class="text-dark-75 font-weight-bolder font-size-lg">
                                                        {{ $key }}</div>
                                                </td>
                                                <td class="text-right pr-0">
                                                    <span
                                                        class="text-muted font-weight-bold">{{ $check['val'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-card>
                    </div>

                    <!-- Security Details -->
                    <div class="col-lg-6">
                        <x-card title="Security Headers" class="card-stretch gutter-b" :toolbar="false">
                            <div class="table-responsive">
                                <table class="table table-borderless table-vertical-center">
                                    <tbody>
                                        @foreach ($res['security'] as $header => $info)
                                            <tr>
                                                <td class="pl-0" style="width: 40px">
                                                    <div
                                                        class="symbol symbol-40 symbol-light-{{ $info['passed'] ? 'success' : 'danger' }}">
                                                        <span class="symbol-label">
                                                            <i
                                                                class="flaticon2-{{ $info['passed'] ? 'lock' : 'cross' }} text-{{ $info['passed'] ? 'success' : 'danger' }}"></i>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="pl-0">
                                                    <div class="text-dark-75 font-weight-bolder font-size-lg">
                                                        {{ $header }}</div>
                                                    <span
                                                        class="text-muted font-size-sm d-block">{{ $info['desc'] }}</span>
                                                </td>
                                                <td class="text-right pr-0">
                                                    <span
                                                        class="label label-light-{{ $info['passed'] ? 'success' : 'danger' }} label-inline font-weight-bold">
                                                        {{ $info['passed'] ? 'Present' : 'Missing' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-card>
                    </div>
                </div>

                <!-- Recommendations Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="card card-custom gutter-b {{ empty($res['recommendations']) ? 'bg-light-success' : 'bg-light-warning' }}">
                            <div class="card-header border-0">
                                <h3 class="card-title font-weight-bolder text-dark">
                                    {{ empty($res['recommendations']) ? '🎉 Perfect! No Improvements Needed' : '🚀 Optimization Recommendations' }}
                                </h3>
                            </div>
                            <div class="card-body pt-0">
                                @if (empty($res['recommendations']))
                                    <p class="text-dark-75 font-weight-bold font-size-lg mb-0">
                                        Your website passed all our checks with flying colors! Keep up the great work.
                                    </p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-vertical-center">
                                            <tbody>
                                                @foreach ($res['recommendations'] as $rec)
                                                    <tr>
                                                        <td style="width: 40px" class="pl-0">
                                                            <div class="symbol symbol-40 symbol-light-danger">
                                                                <span class="symbol-label">
                                                                    <i class="flaticon2-exclamation text-danger"></i>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <span
                                                                class="text-dark-75 font-weight-bold font-size-lg">{{ $rec }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted font-weight-bold">Fixing these issues will improve your
                                            Overall Score towards 100/100.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(session('error'))
                <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{{ session('error') }}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="ki ki-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
