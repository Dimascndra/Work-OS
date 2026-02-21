<x-metrolar-layout title="Edit Domain Monitor">
    <x-card title="Edit Monitor: {{ $domainMonitor->domain_url }}">
        <x-slot:toolbar>
            <a href="{{ route('domain-monitors.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('domain-monitors.update', $domainMonitor) }}" method="POST">
            @csrf
            @method('PUT')

            <x-input label="Domain URL" name="domain_url" :value="$domainMonitor->domain_url" placeholder="https://example.com" required />

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid select2 @error('status') is-invalid @enderror"
                    id="status" name="status">
                    <option value="healthy" {{ $domainMonitor->status == 'healthy' ? 'selected' : '' }}>Healthy</option>
                    <option value="warning" {{ $domainMonitor->status == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="down" {{ $domainMonitor->status == 'down' ? 'selected' : '' }}>Down</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Update Monitor</button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#status').select2({
                    placeholder: "Select Status",
                    allowClear: false
                });
            });
        </script>
    @endpush
</x-metrolar-layout>
