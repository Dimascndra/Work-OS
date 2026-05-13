@if (isset($res))
    <x-card title="📊 Subdomains for {{ $res['domain'] }}" class="card-stretch gutter-b">

        <div class="d-flex align-items-center justify-content-between mb-5">
            <span class="font-weight-bolder font-size-h5 text-dark-75">
                Found {{ $res['count'] }} unique subdomains
                <span class="label label-light-success label-inline font-weight-bold ml-2">{{ $res['resolved_count'] ?? 0 }} resolved</span>
                <span class="label label-light-info label-inline font-weight-bold ml-2">{{ $res['source_count'] ?? 0 }} sources</span>
            </span>
            <a href="https://crt.sh/?q={{ $res['domain'] }}" target="_blank"
                class="btn btn-light-primary btn-sm font-weight-bold">
                View on crt.sh <i class="flaticon2-new-email ml-2"></i>
            </a>
        </div>

        @if ($res['count'] > 0)
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
                    <thead>
                        <tr class="text-left">
                            <th style="min-width: 50px" class="pl-7"><span class="text-dark-75">No</span>
                            </th>
                            <th style="min-width: 250px">Subdomain</th>
                            <th style="min-width: 150px">IP</th>
                            <th style="min-width: 180px">DNS Detail</th>
                            <th style="min-width: 250px">Provider</th>
                            <th style="min-width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($res['subdomains'] as $index => $item)
                            <tr>
                                <td class="pl-7 py-3">
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <a href="http://{{ $item['subdomain'] }}" target="_blank"
                                        class="text-primary font-weight-bolder font-size-lg text-hover-primary">
                                        {{ $item['subdomain'] }}
                                    </a>
                                </td>
                                <td>
                                    <span class="text-dark-75 font-weight-bold d-block font-size-lg">
                                        {{ $item['ip'] ?? 'Not Resolved' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted font-weight-bold d-block font-size-sm">
                                        AAAA: {{ $item['aaaa'] ?? '-' }}
                                    </span>
                                    <span class="text-muted font-weight-bold d-block font-size-sm">
                                        CNAME: {{ Str::limit($item['cname'] ?? '-', 28) }}
                                    </span>
                                    <span class="label label-light-primary label-inline font-weight-bold mt-1">
                                        {{ implode(', ', $item['sources'] ?? ['Public records']) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark-75 font-weight-bolder font-size-lg">
                                            {{ $item['provider'] }}
                                        </span>
                                        <span class="text-muted font-weight-bold font-size-sm">
                                            {{ $item['location'] }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a href="http://{{ $item['subdomain'] }}" target="_blank"
                                        class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                        <i class="flaticon2-next"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-custom alert-light-warning fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon2-warning"></i></div>
                <div class="alert-text font-weight-bold">
                    No subdomains found for this domain in public records.
                </div>
            </div>
        @endif

    </x-card>
@elseif(isset($error))
    <x-card title="❌ Error" class="card-stretch gutter-b bg-light-danger">
        <div class="d-flex flex-column align-items-center text-center p-5">
            <i class="flaticon2-warning icon-4x text-danger mb-4"></i>
            <h4 class="font-weight-bold text-danger">{{ $error }}</h4>
        </div>
    </x-card>
@else
    <x-card title="⏳ Waiting for Input" class="card-stretch gutter-b">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
            <div class="symbol symbol-100 symbol-light-primary mb-5">
                <span class="symbol-label">
                    <i class="flaticon2-world icon-4x text-primary"></i>
                </span>
            </div>
            <h4 class="font-weight-bolder text-dark">Enter a domain to scan</h4>
            <p class="text-muted">Find subdomains using Certificate Transparency logs.</p>
        </div>
    </x-card>
@endif
