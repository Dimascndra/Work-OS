@if (isset($res))
    @if (isset($summary))
        <div class="col-lg-12 mb-5">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="font-size-h2 font-weight-boldest text-primary">{{ $summary['success'] }}/{{ $summary['providers'] }}</div>
                            <div class="text-muted font-weight-bold">Resolver berhasil</div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="font-size-h2 font-weight-boldest text-{{ $summary['consistent'] ? 'success' : 'warning' }}">
                                {{ $summary['consistent'] ? 'Konsisten' : $summary['variants'] . ' variasi' }}
                            </div>
                            <div class="text-muted font-weight-bold">Konsistensi jawaban</div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="font-size-h2 font-weight-boldest text-info">
                                {{ $summary['ttl_min'] ?? '-' }}{{ $summary['ttl_max'] && $summary['ttl_max'] !== $summary['ttl_min'] ? ' - ' . $summary['ttl_max'] : '' }}
                            </div>
                            <div class="text-muted font-weight-bold">Rentang TTL</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-size-h2 font-weight-boldest text-{{ $summary['dnssec_validated'] > 0 ? 'success' : 'muted' }}">
                                {{ $summary['dnssec_validated'] }}
                            </div>
                            <div class="text-muted font-weight-bold">Jawaban DNSSEC AD</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Map Section -->
    <div class="col-lg-12 mb-5">
        <div class="card card-custom gutter-b">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title font-weight-bolder">Peta Propagasi</h3>
            </div>
            <div class="card-body">
                <div id="kt_jqvmap_world" class="jqvmap" style="height:400px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- List Section -->
    <div class="col-lg-12">
        <div class="card card-custom gutter-b">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title font-weight-bolder">Hasil Propagasi</h3>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-borderless table-vertical-center">
                        <tbody>
                            @foreach ($res as $key => $r)
                                <tr class="border-bottom">
                                    <!-- Flag -->
                                    <td style="width: 40px;" class="pl-0">
                                        <div class="symbol symbol-30 symbol-light">
                                            @if (isset($r['flag']))
                                                <img src="{{ asset('assets/media/svg/flags/' . $r['flag']) }}"
                                                    class="h-100 align-self-center" alt="{{ $r['code'] }}"
                                                    onerror="this.style.display='none'" />
                                            @elseif(isset($r['code']) && $r['code'] !== 'global' && $r['code'] !== 'local')
                                                <span
                                                    class="symbol-label font-size-sm font-weight-bold">{{ strtoupper($r['code']) }}</span>
                                            @else
                                                <span
                                                    class="symbol-label font-size-sm font-weight-bold">{{ strtoupper(substr($r['name'], 0, 1)) }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Location & Provider -->
                                    <td class="pl-2" style="white-space: nowrap; vertical-align: middle;">
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                                class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">
                                                {{ $r['location'] }}
                                            </a>
                                            <span class="text-muted font-size-sm font-weight-bold">
                                                {{ $r['name'] }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- IP / Result (Right Aligned, Blue) -->
                                    <td class="text-right pr-5" style="word-break: break-all; min-width: 150px; max-width: 300px; vertical-align: middle;">
                                        <div class="d-flex flex-column align-items-end">
                                            @if ($r['status'] == 'success' && !empty($r['data']))
                                                @foreach (array_slice($r['data'], 0, 1) as $rec)
                                                    <span
                                                        class="text-primary font-weight-bolder font-size-h6" style="word-break: break-all;">{{ $rec }}</span>
                                                @endforeach
                                                @if (count($r['data']) > 1)
                                                    <span class="text-muted font-size-xs">+{{ count($r['data']) - 1 }}
                                                        lainnya</span>
                                                @endif
                                            @elseif($r['status'] == 'empty')
                                                <span class="text-muted font-weight-bold">Tidak Ada Record</span>
                                            @else
                                                <span class="text-danger font-weight-bold">Gagal</span>
                                            @endif
                                            @if (!empty($r['records'][0]['ttl']))
                                                <span class="text-muted font-size-xs">TTL {{ $r['records'][0]['ttl'] }}s</span>
                                            @endif
                                            @if (!empty($r['dnssec']))
                                                <span class="label label-light-success label-inline font-weight-bold mt-1">DNSSEC</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Status Icon -->
                                    <td style="width: 40px;" class="text-right pr-0">
                                        @if ($r['status'] == 'success')
                                            <i class="flaticon2-check-mark text-success icon-md"></i>
                                        @else
                                            <i class="flaticon2-cross text-danger icon-md"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="col-12">
        <div class="card card-custom gutter-b">
            <div class="card-body text-center p-10">
                <div class="symbol symbol-100 symbol-light-primary mb-5">
                    <span class="symbol-label">
                        <i class="flaticon2-world icon-4x text-primary"></i>
                    </span>
                </div>
                <h3 class="font-size-h3 font-weight-bolder text-dark">Pemeriksa Propagasi DNS Global</h3>
                <p class="font-size-lg text-muted mt-3">
                    Periksa DNS record A, MX, NS, CNAME, TXT, dan lainnya pada beberapa server DNS dari berbagai belahan dunia.
                </p>
            </div>
        </div>
    </div>
@endif
