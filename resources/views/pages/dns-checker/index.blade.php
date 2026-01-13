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
        <div class="col-12 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mr-5 mb-2">
                        <div class="symbol symbol-50 symbol-light-primary mr-4">
                            <span class="symbol-label">
                                <i class="flaticon2-world icon-lg text-primary"></i>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-weight-bolder text-dark mb-0">Global DNS Checker</h3>
                            <span class="text-muted font-weight-bold">Check propagation across multiple servers</span>
                        </div>
                    </div>

                    <form action="{{ route('dns-checker.check') }}" method="POST"
                        class="d-flex align-items-center flex-grow-1 header-search">
                        @csrf
                        <div class="input-group input-group-lg input-group-solid flex-grow-1 mr-3">
                            <input type="text" name="domain" class="form-control pl-5"
                                placeholder="Enter domain (e.g. google.com)" required value="{{ old('domain') }}">
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
                        <button type="submit" class="btn btn-primary btn-lg font-weight-bolder px-5">
                            Search
                        </button>
                    </form>
                </div>
            </x-card>
        </div>

        @if (session('results'))
            @php $res = session('results'); @endphp

            <!-- Map Section -->
            <div class="col-lg-12 mb-5">
                <div class="card card-custom gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder">Propagation Map</h3>
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
                        <h3 class="card-title font-weight-bolder">Propagation Results</h3>
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
                                            <td class="pl-2">
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
                                            <td class="text-right pr-5">
                                                <div class="d-flex flex-column align-items-end">
                                                    @if ($r['status'] == 'success' && !empty($r['data']))
                                                        @foreach (array_slice($r['data'], 0, 1) as $rec)
                                                            <span
                                                                class="text-primary font-weight-bolder font-size-h6">{{ $rec }}</span>
                                                        @endforeach
                                                        @if (count($r['data']) > 1)
                                                            <span
                                                                class="text-muted font-size-xs">+{{ count($r['data']) - 1 }}
                                                                more</span>
                                                        @endif
                                                    @elseif($r['status'] == 'empty')
                                                        <span class="text-muted font-weight-bold">No Records</span>
                                                    @else
                                                        <span class="text-danger font-weight-bold">Error</span>
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
                        <h3 class="font-size-h3 font-weight-bolder text-dark">Global DNS Propagation Checker</h3>
                        <p class="font-size-lg text-muted mt-3">
                            Check A, MX, NS, CNAME, TXT and other DNS records against multiple DNS servers located in
                            different parts of the world.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/custom/jqvmap/jqvmap.bundle.js') }}"></script>

        @if (session('results'))
            <script>
                jQuery(document).ready(function() {
                    var successfulCodes = [];
                    var failedCodes = [];

                    @foreach (session('results') as $r)
                        @if ($r['status'] == 'success' && isset($r['code']) && strlen($r['code']) == 2)
                            successfulCodes.push("{{ strtolower($r['code']) }}");
                        @endif
                        @if ($r['status'] != 'success' && isset($r['code']) && strlen($r['code']) == 2)
                            failedCodes.push("{{ strtolower($r['code']) }}");
                        @endif
                    @endforeach

                    var colors = {};
                    // Default gray
                    // Set green for success
                    successfulCodes.forEach(function(c) {
                        colors[c] = '#1BC5BD'; // success color
                    });
                    // Set red for fail (overwrite if mixed, maybe?)
                    failedCodes.forEach(function(c) {
                        if (!colors[c]) colors[c] = '#F64E60'; // danger color
                    });


                    jQuery('#kt_jqvmap_world').vectorMap({
                        map: 'world_en',
                        backgroundColor: 'transparent',
                        color: '#E5EAEE', // base color
                        borderColor: '#ffffff',
                        borderWidth: 1,
                        hoverColor: '#3699FF', // hover
                        hoverOpacity: 0.7,
                        selectedColor: '#666666',
                        enableZoom: true,
                        showTooltip: true,
                        scaleColors: ['#C8EEFF', '#006491'],
                        normalizeFunction: 'polynomial',
                        colors: colors
                    });
                });
            </script>
        @endif
    @endpush
</x-public-layout>
