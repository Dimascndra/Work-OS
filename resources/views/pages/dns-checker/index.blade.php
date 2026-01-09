<x-metrolar-layout title="DNS Propagation Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-12">
            <x-card title="🌍 DNS Propagation Checker" class="card-stretch gutter-b">
                <form action="{{ route('dns-checker.check') }}" method="POST" class="form-inline mb-5">
                    @csrf
                    <div class="form-group mr-3 mb-2">
                        <label class="sr-only">Domain</label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('domain') }}" style="min-width: 300px;">
                    </div>

                    <div class="form-group mr-3 mb-2">
                        <label class="sr-only">Record Type</label>
                        <select name="type" class="form-control form-control-solid form-control-lg">
                            @foreach (['A', 'AAAA', 'MX', 'CNAME', 'NS', 'TXT', 'PTR', 'SOA'] as $t)
                                <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>
                                    {{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder mb-2">
                        Check DNS <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>

                @if (session('results'))
                    @php
                        $res = session('results');
                        $domain = old('domain');
                        $type = old('type');
                    @endphp

                    <h3 class="font-weight-bold text-dark mt-5 mb-5">Results for {{ $domain }}
                        ({{ $type }})</h3>

                    <div class="table-responsive">
                        <table class="table table-bordered table-vertical-center">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 200px;">Resolver</th>
                                    <th>Status</th>
                                    <th>Records</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Local -->
                                <tr>
                                    <td class="font-weight-bolder">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40 symbol-light-primary mr-3">
                                                <span class="symbol-label font-size-h5 font-weight-bold">L</span>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">Local
                                                    Server</a>
                                                <span class="text-muted font-weight-bold d-block">System DNS</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($res['local']['status'] == 'success')
                                            <span
                                                class="label label-inline label-light-success font-weight-bold">Resolved</span>
                                        @elseif($res['local']['status'] == 'empty')
                                            <span class="label label-inline label-light-warning font-weight-bold">No
                                                Records</span>
                                        @else
                                            <span
                                                class="label label-inline label-light-danger font-weight-bold">Error</span>
                                        @endif
                                    </td>
                                    <td class="font-family-monospace">
                                        @if (!empty($res['local']['data']))
                                            @foreach ($res['local']['data'] as $rec)
                                                <div class="mb-1">{{ $rec }}</div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Google -->
                                <tr>
                                    <td class="font-weight-bolder">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40 symbol-light-danger mr-3">
                                                <span class="symbol-label font-size-h5 font-weight-bold">G</span>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">Google
                                                    DNS</a>
                                                <span class="text-muted font-weight-bold d-block">8.8.8.8</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($res['google']['status'] == 'success')
                                            <span
                                                class="label label-inline label-light-success font-weight-bold">Resolved</span>
                                        @elseif($res['google']['status'] == 'empty')
                                            <span class="label label-inline label-light-warning font-weight-bold">No
                                                Records</span>
                                        @else
                                            <span
                                                class="label label-inline label-light-danger font-weight-bold">Error</span>
                                        @endif
                                    </td>
                                    <td class="font-family-monospace">
                                        @if (!empty($res['google']['data']))
                                            @foreach ($res['google']['data'] as $rec)
                                                <div class="mb-1">{{ $rec }}</div>
                                            @endforeach
                                        @elseif($res['google']['status'] == 'error')
                                            <span class="text-danger">{{ $res['google']['message'] }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Cloudflare -->
                                <tr>
                                    <td class="font-weight-bolder">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40 symbol-light-warning mr-3">
                                                <span class="symbol-label font-size-h5 font-weight-bold">C</span>
                                            </div>
                                            <div>
                                                <a href="#"
                                                    class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">Cloudflare</a>
                                                <span class="text-muted font-weight-bold d-block">1.1.1.1</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($res['cloudflare']['status'] == 'success')
                                            <span
                                                class="label label-inline label-light-success font-weight-bold">Resolved</span>
                                        @elseif($res['cloudflare']['status'] == 'empty')
                                            <span class="label label-inline label-light-warning font-weight-bold">No
                                                Records</span>
                                        @else
                                            <span
                                                class="label label-inline label-light-danger font-weight-bold">Error</span>
                                        @endif
                                    </td>
                                    <td class="font-family-monospace">
                                        @if (!empty($res['cloudflare']['data']))
                                            @foreach ($res['cloudflare']['data'] as $rec)
                                                <div class="mb-1">{{ $rec }}</div>
                                            @endforeach
                                        @elseif($res['cloudflare']['status'] == 'error')
                                            <span class="text-danger">{{ $res['cloudflare']['message'] }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center min-h-200px text-center">
                        <div class="symbol symbol-100 symbol-light-primary mb-5">
                            <span class="symbol-label">
                                <i class="flaticon2-world icon-4x text-primary"></i>
                            </span>
                        </div>
                        <h4 class="font-weight-bolder text-dark">Check Global Propagation</h4>
                        <p class="text-muted">See how your DNS records are propagating across major providers.</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-metrolar-layout>
