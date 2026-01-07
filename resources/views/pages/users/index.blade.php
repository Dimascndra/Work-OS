<x-metrolar-layout title="User Manager">
    <x-card title="Managed Users">
        <x-slot:toolbar>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add New
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $user->name }}</span>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-right">
                                <a href="{{ route('users.edit', $user) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                    <i class="flaticon2-edit"></i>
                                </a>
                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-light btn-hover-danger btn-sm">
                                            <i class="flaticon2-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-metrolar-layout>
