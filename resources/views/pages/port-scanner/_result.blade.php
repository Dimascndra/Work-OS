@if (isset($res))
    <x-card class="card-stretch gutter-b">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title font-weight-bolder">Hasil Pemindaian untuk {{ $res['target'] }}</h3>
        </div>
        <div class="card-body">
            <!-- Score Widget -->
            <div class="d-flex flex-column align-items-center mb-10 text-center">
                @if ($res['open_count'] === 0)
                    <div class="symbol symbol-100 symbol-circle symbol-light-success">
                        <span class="symbol-label">
                            <i class="flaticon2-shield icon-4x text-success"></i>
                        </span>
                    </div>
                    <h3 class="font-weight-bolder text-success mt-4">Sangat Aman</h3>
                    <p class="text-muted font-weight-bold">Tidak ada port administratif atau port umum terbuka ke publik.</p>
                @else
                    <div class="symbol symbol-100 symbol-circle symbol-light-warning">
                        <span class="symbol-label">
                            <i class="flaticon2-warning icon-4x text-warning"></i>
                        </span>
                    </div>
                    <h3 class="font-weight-bolder text-warning mt-4">Ditemukan {{ $res['open_count'] }} Port Terbuka</h3>
                    <p class="text-muted font-weight-bold">Beberapa port terbuka ke publik. Pastikan port ini terlindungi firewall.</p>
                @endif
            </div>

            <!-- Table of Ports -->
            <div class="table-responsive">
                <table class="table table-borderless table-vertical-center">
                    <thead>
                        <tr class="text-left bg-light">
                            <th class="pl-4 rounded-left" style="width: 100px;">Port</th>
                            <th style="width: 120px;">Layanan</th>
                            <th>Penjelasan & Fungsi</th>
                            <th class="text-right pr-4 rounded-right" style="width: 120px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($res['ports'] as $item)
                            <tr>
                                <td class="pl-4 font-weight-bolder text-dark font-size-lg">
                                    #{{ $item['port'] }}
                                </td>
                                <td>
                                    <span class="label label-light-dark font-weight-bold label-inline">
                                        {{ $item['name'] }}
                                    </span>
                                </td>
                                <td class="text-dark-75 font-size-sm">
                                    {{ $item['desc'] }}
                                </td>
                                <td class="text-right pr-4">
                                    @if ($item['status'] === 'open')
                                        <span class="label label-light-success label-inline font-weight-bold">
                                            Terbuka <i class="flaticon2-check-mark text-success icon-sm ml-1"></i>
                                        </span>
                                    @else
                                        <span class="label label-light-light text-muted label-inline font-weight-bold">
                                            Tertutup
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-card>
@elseif(isset($error))
    <x-card class="card-stretch gutter-b bg-light-danger">
        <div class="d-flex flex-column align-items-center text-center p-5">
            <i class="flaticon2-warning icon-4x text-danger mb-4"></i>
            <h4 class="font-weight-bold text-danger">{{ $error }}</h4>
            <p class="text-dark-50 font-weight-bold">Silakan periksa nama domain/IP target dan coba lagi.</p>
        </div>
    </x-card>
@else
    <x-card class="card-stretch gutter-b">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
            <div class="symbol symbol-100 symbol-light-primary mb-5">
                <span class="symbol-label">
                    <i class="flaticon-computer icon-4x text-primary"></i>
                </span>
            </div>
            <h4 class="font-weight-bolder text-dark">Masukkan IP / domain untuk dipindai</h4>
            <p class="text-muted font-weight-bold">Kami akan memindai status 12 port jaringan utama server.</p>
        </div>
    </x-card>
@endif
