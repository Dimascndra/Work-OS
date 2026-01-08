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
                        <th>Server Info</th>
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
                                <span class="text-muted font-size-sm">{{ $server->username }}</span>
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
                                <button type="button" class="btn btn-icon btn-light btn-hover-info btn-sm mr-2"
                                    onclick="copyToClipboard('ssh -p {{ $server->port }} {{ $server->username . '@' . $server->ip_address }}', 'SSH Command')"
                                    title="Copy SSH Command">
                                    <i class="flaticon2-copy"></i>
                                </button>
                                @if ($server->password)
                                    <button type="button" class="btn btn-icon btn-light btn-hover-warning btn-sm mr-2"
                                        onclick="copyToClipboard('{{ $server->password }}', 'Password')"
                                        title="Copy Password">
                                        <i class="flaticon-security"></i>
                                    </button>
                                @endif
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

    @push('scripts')
        <script>
            window.copyToClipboard = function(text, type = 'Text') {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function() {
                        toastr.success(type + ' copied to clipboard!');
                    }, function(err) {
                        toastr.error('Failed to copy ' + type.toLowerCase() + '.');
                    });
                } else {
                    // Fallback for older browsers
                    var textArea = document.createElement("textarea");
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        var successful = document.execCommand('copy');
                        if (successful) toastr.success(type + ' copied to clipboard!');
                        else toastr.error('Failed to copy ' + type.toLowerCase() + '.');
                    } catch (err) {
                        toastr.error('Failed to copy ' + type.toLowerCase() + '.');
                    }
                    document.body.removeChild(textArea);
                }
            }
        </script>
    @endpush
</x-metrolar-layout>
