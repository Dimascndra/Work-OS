<x-metrolar-layout title="Add Backup Record">
    <x-card title="Add Backup Record">
        <x-slot:toolbar>
            <a href="{{ route('server-backups.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('server-backups.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="server_id">Server <span class="text-danger">*</span></label>
                        <select class="form-control form-control-solid select2 @error('server_id') is-invalid @enderror"
                            id="server_id" name="server_id">
                            <option value="">Select Server</option>
                            @foreach ($servers as $server)
                                <option value="{{ $server->id }}">{{ $server->name }} ({{ $server->ip_address }})
                                </option>
                            @endforeach
                        </select>
                        @error('server_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <x-input label="File Name" name="file_name" placeholder="backup-2023-01-01.zip" required />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Size (MB)" name="size_mb" type="number" step="0.01" placeholder="1024.50"
                        required />
                </div>
                <div class="col-md-6">
                    <x-input label="Storage Path" name="storage_path" placeholder="/var/backups/..." required />
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid select2 @error('status') is-invalid @enderror"
                    id="status" name="status">
                    <option value="success">Success</option>
                    <option value="failed">Failed</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Record</button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#server_id').select2({
                    placeholder: "Select Server",
                    allowClear: true
                });
                $('#status').select2({
                    placeholder: "Select Status",
                    allowClear: false
                });
            });
        </script>
    @endpush
</x-metrolar-layout>
