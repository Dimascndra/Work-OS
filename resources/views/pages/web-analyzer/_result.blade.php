@if (isset($res))
    <!-- Summary Row -->
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-5">
            <div
                class="card card-custom gutter-b bg-light-{{ $res['overall_score'] >= 90 ? 'success' : ($res['overall_score'] >= 70 ? 'warning' : 'danger') }}" style="height: 100%;">
                <div class="card-body text-center p-5 d-flex flex-column align-items-center justify-content-center">
                    <h4 class="card-label font-weight-bolder text-dark-75 mb-2">Skor Keseluruhan</h4>
                    <div class="display-3 font-weight-boldest text-dark mb-2">{{ $res['overall_score'] }}
                    </div>
                    <div class="text-dark-50 font-weight-bold">/ 100</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40 symbol-light-primary mr-3">
                        <span class="symbol-label"><i class="flaticon2-time text-primary"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="text-dark-75 font-weight-bold font-size-lg">Kinerja</div>
                        <span class="text-muted font-weight-bold">Kategori {{ $res['performance']['grade'] }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-dark-50 font-weight-bold mr-2">Waktu Pemuatan:</span>
                    <span class="text-dark font-weight-bold text-right">{{ $res['performance']['load_time'] }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-dark-50 font-weight-bold mr-2">Ukuran Halaman:</span>
                    <span class="text-dark font-weight-bold text-right">{{ $res['performance']['size'] }}</span>
                </div>
            </x-card>
        </div>

        <div class="col-md-6 col-lg-3 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40 symbol-light-info mr-3">
                        <span class="symbol-label"><i class="flaticon2-search text-info"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="text-dark-75 font-weight-bold font-size-lg">Statistik SEO</div>
                        <span class="text-muted font-weight-bold">Tag Meta</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-dark-50 font-weight-bold mr-2">Judul:</span>
                    <span
                        class="label label-light-{{ $res['seo_data']['title'] ? 'success' : 'danger' }} label-inline font-weight-bold">
                        {{ $res['seo_data']['title'] ? 'Ditemukan' : 'Tidak Ditemukan' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-dark-50 font-weight-bold mr-2">Deskripsi:</span>
                    <span
                        class="label label-light-{{ $res['seo_data']['description'] ? 'success' : 'danger' }} label-inline font-weight-bold">
                        {{ $res['seo_data']['description'] ? 'Ditemukan' : 'Tidak Ditemukan' }}
                    </span>
                </div>
            </x-card>
        </div>

        <div class="col-md-6 col-lg-3 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40 symbol-light-warning mr-3">
                        <span class="symbol-label"><i class="flaticon2-shield text-warning"></i></span>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="text-dark-75 font-weight-bold font-size-lg">Teknologi</div>
                        <span class="text-muted font-weight-bold">Info Server</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-dark-50 font-weight-bold mr-2">Server:</span>
                    <span class="text-dark font-weight-bold text-right" title="{{ $res['tech']['Server'] }}">{{ Str::limit($res['tech']['Server'], 12) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-dark-50 font-weight-bold mr-2">Aplikasi:</span>
                    <span class="text-dark font-weight-bold text-right" title="{{ $res['tech']['X-Powered-By'] }}">{{ Str::limit($res['tech']['X-Powered-By'], 12) }}</span>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Details Row -->
    <div class="row">
        <!-- SEO Details -->
        <div class="col-lg-6 mb-5">
            <x-card title="Analisis SEO" class="card-stretch gutter-b" :toolbar="false">
                <div class="table-responsive">
                    <table class="table table-borderless table-vertical-center mb-0">
                        <tbody>
                            @foreach ($res['seo'] as $key => $check)
                                <tr>
                                    <td class="pl-0" style="width: 40px; vertical-align: middle;">
                                        <div
                                            class="symbol symbol-40 symbol-light-{{ $check['passed'] ? 'success' : 'danger' }}">
                                            <span class="symbol-label">
                                                <i
                                                    class="flaticon2-{{ $check['passed'] ? 'check-mark' : 'cross' }} text-{{ $check['passed'] ? 'success' : 'danger' }}"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="pl-3" style="white-space: nowrap; vertical-align: middle; width: 140px;">
                                        <div class="text-dark-75 font-weight-bolder font-size-lg">
                                            {{ $key }}</div>
                                    </td>
                                    <td class="text-right pr-0" style="vertical-align: middle; word-break: break-word;">
                                        <span class="text-muted font-weight-bold">{{ $check['val'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Security Details -->
        <div class="col-lg-6 mb-5">
            <x-card title="Header Keamanan" class="card-stretch gutter-b" :toolbar="false">
                <div class="table-responsive">
                    <table class="table table-borderless table-vertical-center mb-0">
                        <tbody>
                            @foreach ($res['security'] as $header => $info)
                                <tr>
                                    <td class="pl-0" style="width: 40px; vertical-align: middle;">
                                        <div
                                            class="symbol symbol-40 symbol-light-{{ $info['passed'] ? 'success' : 'danger' }}">
                                            <span class="symbol-label">
                                                <i
                                                    class="flaticon2-{{ $info['passed'] ? 'lock' : 'cross' }} text-{{ $info['passed'] ? 'success' : 'danger' }}"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="pl-3" style="vertical-align: middle;">
                                        <div class="text-dark-75 font-weight-bolder font-size-lg" style="white-space: nowrap;">
                                            {{ $header }}</div>
                                        <span class="text-muted font-size-sm d-block" style="word-break: break-word;">{{ $info['desc'] }}</span>
                                    </td>
                                    <td class="text-right pr-0" style="white-space: nowrap; vertical-align: middle; width: 120px;">
                                        <span
                                            class="label label-light-{{ $info['passed'] ? 'success' : 'danger' }} label-inline font-weight-bold" style="white-space: nowrap;">
                                            {{ $info['passed'] ? 'Ada' : 'Tidak Ada' }}
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

    @if (!empty($res['advanced']))
        <div class="row">
            <div class="col-lg-12 mb-5">
                <x-card title="Sinyal Lanjutan" class="card-stretch gutter-b" :toolbar="false">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <span class="text-muted font-weight-bold d-block">Kompresi</span>
                            <span class="text-dark font-weight-bolder">{{ $res['advanced']['compression'] }}</span>
                        </div>
                        <div class="col-md-4 mb-4">
                            <span class="text-muted font-weight-bold d-block">Kontrol Cache</span>
                            <span class="text-dark font-weight-bolder">{{ Str::limit($res['advanced']['cache_control'], 45) }}</span>
                        </div>
                        <div class="col-md-4 mb-4">
                            <span class="text-muted font-weight-bold d-block">robots.txt</span>
                            <span class="text-dark font-weight-bolder">{{ $res['advanced']['robots_txt'] }}</span>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <span class="text-muted font-weight-bold d-block">Kanonikal</span>
                            <span class="text-dark font-weight-bolder">{{ Str::limit($res['advanced']['canonical'], 45) }}</span>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <span class="text-muted font-weight-bold d-block">Open Graph</span>
                            <span class="text-dark font-weight-bolder">{{ $res['advanced']['open_graph_tags'] }} tag</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted font-weight-bold d-block">Bahasa</span>
                            <span class="text-dark font-weight-bolder">{{ $res['advanced']['language'] }}</span>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    @endif

    <!-- Recommendations Row -->
    <div class="row">
        <div class="col-lg-12">
            <div
                class="card card-custom gutter-b {{ empty($res['recommendations']) ? 'bg-light-success' : 'bg-light-warning' }}">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bolder text-dark">
                        {{ empty($res['recommendations']) ? '🎉 Sempurna! Tidak Ada Perbaikan yang Diperlukan' : '🚀 Rekomendasi Optimalisasi' }}
                    </h3>
                </div>
                <div class="card-body pt-0">
                    @if (empty($res['recommendations']))
                        <p class="text-dark-75 font-weight-bold font-size-lg mb-0">
                            Website Anda lolos semua pemeriksaan kami dengan sangat baik! Pertahankan kinerja luar biasa ini.
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
                            <p class="text-muted font-weight-bold">Memperbaiki masalah ini akan meningkatkan Skor Keseluruhan Anda mendekati 100/100.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@elseif(isset($error))
    <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon2-warning"></i></div>
        <div class="alert-text">{{ $error }}</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
@endif
