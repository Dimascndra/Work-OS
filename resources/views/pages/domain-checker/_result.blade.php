@if (isset($res))
    <x-card title="📊 Hasil untuk {{ $res['domain'] }}" class="card-stretch gutter-b">
        <!-- Status Header -->
        <div class="d-flex flex-column align-items-center mb-10">
            @if ($res['is_registered'])
                <div class="symbol symbol-100 symbol-circle symbol-light-danger">
                    <span class="symbol-label">
                        <i class="flaticon2-cross icon-4x text-danger"></i>
                    </span>
                </div>
                <h3 class="font-weight-bolder text-danger mt-4">Domain Sudah Terdaftar</h3>
                <p class="text-dark-50 font-weight-bold">Terdaftar / Aktif</p>
            @else
                <div class="symbol symbol-100 symbol-circle symbol-light-success">
                    <span class="symbol-label">
                        <i class="flaticon2-check-mark icon-4x text-success"></i>
                    </span>
                </div>
                <h3 class="font-weight-bolder text-success mt-4">Kemungkinan Tersedia</h3>
                <p class="text-dark-50 font-weight-bold">Tidak ada DNS record aktif yang ditemukan</p>
            @endif
        </div>

        @if (!empty($res['whois_summary']) || !empty($res['dns_summary']))
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="bg-light-primary rounded p-5 h-100">
                        <h5 class="font-weight-bolder text-dark mb-4">Ringkasan WHOIS</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted font-weight-bold">Registrar</span>
                            <span class="text-dark font-weight-bold text-right">{{ $res['whois_summary']['registrar'] ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted font-weight-bold">Dibuat</span>
                            <span class="text-dark font-weight-bold text-right">{{ $res['whois_summary']['created'] ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted font-weight-bold">Kadaluarsa</span>
                            <span class="text-dark font-weight-bold text-right">{{ $res['whois_summary']['expires'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-5 mt-md-0">
                    <div class="bg-light-info rounded p-5 h-100">
                        <h5 class="font-weight-bolder text-dark mb-4">Ringkasan DNS</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted font-weight-bold">A</span>
                            <span class="text-dark font-weight-bold">{{ count($res['dns_summary']['a'] ?? []) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted font-weight-bold">AAAA</span>
                            <span class="text-dark font-weight-bold">{{ count($res['dns_summary']['aaaa'] ?? []) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted font-weight-bold">NS</span>
                            <span class="text-dark font-weight-bold">{{ count($res['dns_summary']['ns'] ?? []) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted font-weight-bold">MX</span>
                            <span class="text-dark font-weight-bold">{{ count($res['dns_summary']['mx'] ?? []) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Whois Data -->
        <div class="form-group">
            <label class="font-weight-bolder">Data WHOIS:</label>
            <textarea class="form-control form-control-solid font-family-monospace" rows="15" readonly>{{ $res['whois'] }}</textarea>
        </div>
    </x-card>
@elseif(isset($error))
    <x-card title="❌ Error" class="card-stretch gutter-b bg-light-danger">
        <div class="d-flex flex-column align-items-center text-center p-5">
            <i class="flaticon2-warning icon-4x text-danger mb-4"></i>
            <h4 class="font-weight-bold text-danger">{{ $error }}</h4>
        </div>
    </x-card>
@else
    <x-card title="⏳ Menunggu Input" class="card-stretch gutter-b">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
            <div class="symbol symbol-100 symbol-light-info mb-5">
                <span class="symbol-label">
                    <i class="flaticon2-search icon-4x text-info"></i>
                </span>
            </div>
            <h4 class="font-weight-bolder text-dark">Masukkan domain untuk diperiksa</h4>
            <p class="text-muted">Periksa ketersediaan dan detail WHOIS.</p>
        </div>
    </x-card>
@endif
