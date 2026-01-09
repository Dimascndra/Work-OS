<x-metrolar-layout title="Web Vulnerability Scanner">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-4">
            <x-card title="🛡️ Vulnerability Scanner" class="card-stretch gutter-b">
                <form action="{{ route('vuln-scanner.scan') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Target URL <span
                                class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control form-control-solid form-control-lg"
                            placeholder="https://example.com" required value="{{ old('url') }}">
                        <span class="form-text text-muted">Enter the full URL (including https://).</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Scan Website <i class="flaticon-search ml-2"></i>
                    </button>
                </form>
            </x-card>

            <x-card title="ℹ️ Scoring Guide" class="card-stretch gutter-b">
                <div class="table-responsive">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td>SSL/TLS</td>
                            <td class="text-right font-weight-bold">20 pts</td>
                        </tr>
                        <tr>
                            <td>Security Headers</td>
                            <td class="text-right font-weight-bold">20 pts</td>
                        </tr>
                        <tr>
                            <td>Cookie & Session</td>
                            <td class="text-right font-weight-bold">15 pts</td>
                        </tr>
                        <tr>
                            <td>HTTPS Enforcement</td>
                            <td class="text-right font-weight-bold">10 pts</td>
                        </tr>
                        <tr>
                            <td>File/Info Exposure</td>
                            <td class="text-right font-weight-bold">15 pts</td>
                        </tr>
                        <tr>
                            <td>CORS</td>
                            <td class="text-right font-weight-bold">10 pts</td>
                        </tr>
                        <tr>
                            <td>Error Handling</td>
                            <td class="text-right font-weight-bold">10 pts</td>
                        </tr>
                        <tr class="border-top">
                            <td><strong>Total</strong></td>
                            <td class="text-right font-weight-bold"><strong>100 pts</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="mt-3">
                    <span class="label label-inline label-light-success font-weight-bold mr-2">90-100</span> Sangat Aman
                    <div class="separator separator-border-dashed my-2"></div>
                    <span class="label label-inline label-light-primary font-weight-bold mr-2">75-89</span> Aman
                    <div class="separator separator-border-dashed my-2"></div>
                    <span class="label label-inline label-light-warning font-weight-bold mr-2">60-74</span> Perlu
                    Perbaikan
                    <div class="separator separator-border-dashed my-2"></div>
                    <span class="label label-inline label-light-danger font-weight-bold mr-2">
                        <60< /span> Berisiko
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-8">
            @if (session('result'))
                @php $res = session('result'); @endphp
                <x-card title="📊 Security Report for {{ $res['url'] }}" class="card-stretch gutter-b">

                    <!-- Grade Section -->
                    <div
                        class="d-flex align-items-center justify-content-between mb-10 p-5 bg-light-{{ $res['color'] }} rounded">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-70 symbol-circle symbol-white mr-5">
                                <span class="symbol-label font-size-h2 font-weight-boldest text-{{ $res['color'] }}">
                                    {{ $res['grade'] }}
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <h3 class="font-weight-bolder text-{{ $res['color'] }}">Score: {{ $res['score'] }}/100
                                </h3>
                                <span class="text-dark-50 font-weight-bold">
                                    @if ($res['score'] >= 90)
                                        Sangat Aman
                                    @elseif($res['score'] >= 75)
                                        Aman
                                    @elseif($res['score'] >= 60)
                                        Perlu Perbaikan
                                    @else
                                        Berisiko
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bolder font-size-h5 text-dark-50">HTTP {{ $res['status_code'] }}</div>
                    </div>

                    <!-- Summary Section -->
                    <div class="alert alert-custom alert-light-{{ $res['color'] }} fade show mb-10" role="alert">
                        <div class="alert-icon"><i class="flaticon-info"></i></div>
                        <div class="alert-text font-weight-bold">
                            {{ $res['summary'] }}
                        </div>
                    </div>

                    <!-- Categories Breakdown -->
                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample">
                        @foreach ($res['categories'] as $key => $cat)
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title" data-toggle="collapse"
                                        data-target="#collapse{{ $key }}">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <span>
                                                <i class="flaticon-interface-6 mr-2"></i> {{ $cat['title'] }}
                                            </span>
                                            <span
                                                class="label label-light-{{ $cat['score'] == $cat['max'] ? 'success' : ($cat['score'] > 0 ? 'warning' : 'danger') }} label-inline font-weight-bold ml-auto">
                                                {{ $cat['score'] }} / {{ $cat['max'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse{{ $key }}" class="collapse show"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($cat['checks'] as $check)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $check['msg'] }}
                                                    @if ($check['status'] === 'pass')
                                                        <i class="flaticon2-check-mark text-success icon-md"></i>
                                                    @elseif($check['status'] === 'warn')
                                                        <i class="flaticon2-warning text-warning icon-md"></i>
                                                    @else
                                                        <i class="flaticon2-cross text-danger icon-md"></i>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Recommendations Section -->
                    @if (isset($res['recommendations']) && count($res['recommendations']) > 0)
                        <div class="mt-10">
                            <h3 class="font-weight-bolder text-dark mb-5">
                                <i class="flaticon-light icon-lg text-warning mr-2"></i> Saran Perbaikan
                            </h3>

                            @foreach ($res['recommendations'] as $rec)
                                <div class="card card-custom gutter-b">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            @if ($rec['priority'] === 'critical')
                                                <span
                                                    class="label label-danger label-inline font-weight-bold mr-3">CRITICAL</span>
                                            @elseif($rec['priority'] === 'high')
                                                <span
                                                    class="label label-warning label-inline font-weight-bold mr-3">HIGH</span>
                                            @elseif($rec['priority'] === 'medium')
                                                <span
                                                    class="label label-info label-inline font-weight-bold mr-3">MEDIUM</span>
                                            @else
                                                <span
                                                    class="label label-light label-inline font-weight-bold mr-3">LOW</span>
                                            @endif
                                            <h5 class="font-weight-bolder text-dark mb-0">{{ $rec['title'] }}</h5>
                                        </div>
                                        <p class="text-dark-75 mb-3">{{ $rec['description'] }}</p>
                                        <div class="bg-light-dark p-4 rounded">
                                            <code class="text-dark-50"
                                                style="white-space: pre-wrap;">{{ $rec['code'] }}</code>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </x-card>
            @elseif(session('error'))
                <x-card title="❌ Error" class="card-stretch gutter-b bg-light-danger">
                    <div class="d-flex flex-column align-items-center text-center p-5">
                        <i class="flaticon-exclamation-2 icon-4x text-danger mb-4"></i>
                        <h4 class="font-weight-bold text-danger">{{ session('error') }}</h4>
                    </div>
                </x-card>
            @else
                <x-card title="⏳ Waiting for Input" class="card-stretch gutter-b">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
                        <div class="symbol symbol-100 symbol-light-info mb-5">
                            <span class="symbol-label">
                                <i class="flaticon-safe-shield-protection icon-4x text-info"></i>
                            </span>
                        </div>
                        <h4 class="font-weight-bolder text-dark">Enter a website URL</h4>
                        <p class="text-muted">Scan using strict security scoring standards.</p>
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-metrolar-layout>
