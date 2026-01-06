<x-metrolar-layout title="Backups">
    <x-card title="Backup Records">
        <x-slot:toolbar>
            <a href="{{ route('server-backups.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add Record
            </a>
        </x-slot:toolbar>
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Server</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                        <tr>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $backup->file_name }}</span>
                                <span class="text-muted font-size-sm">{{ $backup->storage_path }}</span>
                            </td>
                            <td>{{ $backup->server->name }}</td>
                            <td>{{ $backup->size_mb }} MB</td>
                            <td>
                                @if ($backup->status == 'success')
                                    <span class="label label-lg label-light-success label-inline">Success</span>
                                @else
                                    <span class="label label-lg label-light-danger label-inline">Failed</span>
                                @endif
                            </td>
                            <td>{{ $backup->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No backups found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-metrolar-layout>
