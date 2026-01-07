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
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $key->ip_server }}</span>
                            </td>
                            <td>{{ $key->username }}</td>
                            <td>{{ $key->port }}</td>
                            <td class="text-right">
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
</x-metrolar-layout>
