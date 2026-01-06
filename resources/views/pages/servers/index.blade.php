<x-metrolar-layout title="Servers">
    <x-card title="Managed Servers">
        <x-slot:toolbar>
            <a href="{{ route('servers.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add New
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>IP Address</th>
                        <th>OS</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servers as $server)
                        <tr>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $server->name }}</span>
                                <span class="text-muted font-weight-bold">{{ $server->username }}</span>
                            </td>
                            <td>{{ $server->ip_address }}:{{ $server->port }}</td>
                            <td>
                                <span
                                    class="label label-lg label-light-info label-inline">{{ strtoupper($server->os_type) }}</span>
                            </td>
                            <td>
                                @if ($server->is_active)
                                    <span class="label label-lg label-light-success label-inline">Active</span>
                                @else
                                    <span class="label label-lg label-light-danger label-inline">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('servers.edit', $server) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                    <i class="flaticon2-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No servers found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-metrolar-layout>
