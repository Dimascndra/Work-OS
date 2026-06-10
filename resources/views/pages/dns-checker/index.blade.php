<x-public-layout title="DNS Propagation">
    @push('styles')
        <link href="{{ asset('assets/plugins/custom/jqvmap/jqvmap.bundle.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .jqvmap-zoomin,
            .jqvmap-zoomout {
                width: 15px;
                height: 15px;
            }
        </style>
    @endpush

    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-8 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between w-100">
                    <div class="d-flex align-items-center mr-5 mb-4 mb-md-0">
                        <div class="symbol symbol-50 symbol-light-primary mr-4">
                            <span class="symbol-label">
                                <i class="flaticon2-world icon-lg text-primary"></i>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-weight-bolder text-dark mb-0">Global DNS Checker</h3>
                            <span class="text-muted font-weight-bold">Periksa propagasi rekaman DNS secara global</span>
                        </div>
                    </div>

                    <form action="{{ route('dns-checker.check') }}" method="POST" id="scanForm" data-loading-message="Memeriksa propagasi DNS..." data-loading-btn="Memeriksa..."
                        class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center flex-grow-1 w-100 header-search">
                        @csrf
                        <div class="input-group input-group-lg input-group-solid flex-grow-1 mr-0 mr-sm-3 mb-3 mb-sm-0">
                            <input type="text" name="domain" class="form-control pl-5"
                                placeholder="Masukkan domain (contoh: google.com)" required value="{{ old('domain') }}">
                            <div class="input-group-append">
                                <select name="type" class="form-control form-control-solid bg-light border-0"
                                    style="width: 100px;">
                                    @foreach (['A', 'AAAA', 'MX', 'CNAME', 'NS', 'TXT', 'PTR', 'SOA'] as $t)
                                        <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>
                                            {{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg font-weight-bolder px-5 w-100 w-sm-auto">
                            Cari
                        </button>
                    </form>
                </div>
            </x-card>
        </div>

        <div class="col-lg-4 mb-5">
            <x-card title="ℹ️ Tentang Alat" class="card-stretch gutter-b shadow-sm">
                <div class="text-dark-75 font-size-sm">
                    <h6 class="font-weight-bolder mb-2 text-primary">Deskripsi Fungsi:</h6>
                    <p class="text-muted mb-3">Memeriksa penyebaran rekaman DNS (DNS Propagation) situs Anda di server DNS global di seluruh dunia secara real-time.</p>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Cara Penggunaan:</h6>
                    <ol class="text-muted mb-3 pl-4">
                        <li>Masukkan domain utama & pilih tipe rekaman DNS (A, MX, CNAME, dll.).</li>
                        <li>Klik <strong>Cari</strong> untuk mendeteksi penyebaran.</li>
                    </ol>
                    
                    <h6 class="font-weight-bolder mb-2 text-primary">Penjelasan Hasil:</h6>
                    <p class="text-muted mb-0">Peta dunia interaktif dan tabel status resolusi DNS per lokasi global. Status centang hijau menandakan rekaman DNS sudah terpropagasi sempurna.</p>
                </div>
            </x-card>
        </div>
    </div> <!-- End Input Row -->

    <div class="row" id="resultContainer">
        @include('pages.dns-checker._result', [
            'res' => session('dns_results'),
            'summary' => session('dns_summary'),
        ])
    </div>
</x-public-layout>

@push('scripts')
    {{-- <script src="{{ asset('assets/plugins/custom/jqvmap/jqvmap.bundle.js') }}"></script> --}}
    <!-- JQVMap via CDN to ensure integrity and no conflicts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.world.js"></script>
    <script>
        function initDnsMap(results) {
            // Clear existing if any
            var mapContainer = jQuery('#kt_jqvmap_world');
            if (mapContainer.length === 0) {
                console.warn('Map container not found');
                return;
            }

            // Ensure width is set
            mapContainer.css('width', '100%');
            mapContainer.empty();

            var successfulCodes = [];
            var failedCodes = [];

            // Iterate results (object/array)
            Object.values(results).forEach(function(r) {
                if (r.status === 'success' && r.code && r.code.length === 2) {
                    successfulCodes.push(r.code.toLowerCase());
                }
                if (r.status !== 'success' && r.code && r.code.length === 2) {
                    failedCodes.push(r.code.toLowerCase());
                }
            });

            var colors = {};
            successfulCodes.forEach(function(c) {
                colors[c] = '#1BC5BD';
            });
            failedCodes.forEach(function(c) {
                if (!colors[c]) colors[c] = '#F64E60';
            });

            console.log('Initializing map with results:', results);

            try {
                if (typeof mapContainer.vectorMap !== 'function') {
                    console.error('jqvmap plugin not loaded! mapContainer.vectorMap is undefined.');
                    // Try to wait for it? Or just alert.
                    return;
                }

                // Verify if world_en is loaded
                if (typeof jQuery.fn.vectorMap === 'undefined' || typeof jQuery.fn.vectorMap('addMap', 'world_en') ===
                    'undefined' && typeof JQVMap === 'undefined') {
                    // The jqvmap might store maps in jQuery.fn.vectorMap.maps
                    // console.log('Available maps:', jQuery.fn.vectorMap.maps);
                }

                mapContainer.vectorMap({
                    map: 'world_en',
                    backgroundColor: '#ffffff',
                    color: '#E5EAEE',
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    hoverColor: '#3699FF',
                    hoverOpacity: 0.7,
                    selectedColor: '#666666',
                    enableZoom: true,
                    showTooltip: true,
                    scaleColors: ['#C8EEFF', '#006491'],
                    normalizeFunction: 'polynomial',
                    colors: colors,
                    onLabelShow: function(event, label, code) {

                    },
                    onLoad: function(event, map) {
                        console.log('Map Loaded');
                    }
                });
            } catch (e) {
                console.error('Map Init Error:', e);
            }
        }

        // Init on load if session data exists
        @if (session('dns_results'))
            initDnsMap(@json(session('dns_results')));
        @endif
        window.initDnsMap = initDnsMap;
    </script>
@endpush
