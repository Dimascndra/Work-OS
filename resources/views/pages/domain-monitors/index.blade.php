<x-metrolar-layout title="Domain Monitors">
    <x-card title="Domain Monitoring">
        <x-slot:toolbar>
            <a href="{{ route('domain-monitors.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add Monitor
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Domain</th>
                        <th>Server</th>
                        <th>SSL Expiry</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitors as $monitor)
                        <tr>
                            <td>
                                <a href="{{ $monitor->domain_url }}" target="_blank"
                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $monitor->domain_url }}</a>
                            </td>
                            <td>{{ $monitor->server->name ?? 'N/A' }}</td>
                            <td>
                                @if ($monitor->ssl_expires_at)
                                    {{ $monitor->ssl_expires_at->format('Y-m-d') }}
                                    <small class="text-muted">({{ $monitor->ssl_expires_at->diffForHumans() }})</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($monitor->status)
                                    @case('healthy')
                                        <span class="label label-lg label-light-success label-inline">Healthy</span>
                                    @break

                                    @case('down')
                                        <span class="label label-lg label-light-danger label-inline">Down</span>
                                    @break

                                    @case('warning')
                                        <span class="label label-lg label-light-warning label-inline">Warning</span>
                                    @break
                                @endswitch
                            </td>
                            <td class="text-right">
                                <a href="{{ route('domain-monitors.edit', $monitor) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                    <i class="flaticon2-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No monitors found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </x-metrolar-layout>
