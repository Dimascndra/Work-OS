<x-metrolar-layout title="Add Domain Monitor">
    <x-card title="Add Domain Monitor">
        <x-slot:toolbar>
            <a href="{{ route('domain-monitors.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('domain-monitors.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Domain URL" name="domain_url" placeholder="https://example.com" required />
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="server_id">Linked Server (Optional)</label>
                        <select class="form-control form-control-solid select2 @error('server_id') is-invalid @enderror"
                            id="server_id" name="server_id">
                            <option value="">None</option>
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
            </div>

            <div class="form-group">
                <label for="status">Initial Status <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid select2 @error('status') is-invalid @enderror"
                    id="status" name="status">
                    <option value="healthy">Healthy</option>
                    <option value="warning">Warning</option>
                    <option value="down">Down</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Monitor</button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#server_id').select2({
                    placeholder: "Select Server (Optional)",
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
