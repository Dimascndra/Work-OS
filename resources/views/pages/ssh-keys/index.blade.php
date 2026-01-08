<x-metrolar-layout title="SSH Keys">
    <x-card title="Managed SSH Keys">
        <x-slot:toolbar>
            <a href="{{ route('ssh-keys.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add New
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>IP Server</th>
                        <th>Username</th>
                        <th>Port</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sshKeys as $key)
                        <tr>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $key->title }}</span>
                            </td>
                            <td>
                                <span class="text-muted font-weight-bold">{{ $key->ip_server }}</span>
                            </td>
                            <td>{{ $key->username }}</td>
                            <td>{{ $key->port }}</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-icon btn-light btn-hover-info btn-sm mr-2"
                                    onclick="copyToClipboard('ssh -p {{ $key->port }} {{ $key->username . '@' . $key->ip_server }}', 'SSH Command')"
                                    title="Copy SSH Command">
                                    <i class="flaticon2-copy"></i>
                                </button>
                                @if ($key->password)
                                    <button type="button" class="btn btn-icon btn-light btn-hover-warning btn-sm mr-2"
                                        onclick="copyToClipboard('{{ $key->password }}', 'Password')"
                                        title="Copy Password">
                                        <i class="flaticon-security"></i>
                                    </button>
                                @endif
                                <a href="{{ route('ssh-keys.edit', $key) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                    <i class="flaticon2-edit"></i>
                                </a>
                                <form action="{{ route('ssh-keys.destroy', $key) }}" method="POST"
                                    class="d-inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this key?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-light btn-hover-danger btn-sm">
                                        <i class="flaticon2-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No SSH Keys found</td>
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
