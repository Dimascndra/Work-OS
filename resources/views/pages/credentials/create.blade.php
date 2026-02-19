<x-metrolar-layout title="Add New Credential">
    <x-card title="Add New Credential">
        <x-slot:toolbar>
            <a href="{{ route('credentials.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('credentials.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Service Name" name="service_name" placeholder="e.g. Google, AWS, Facebook" required />
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-control form-control-solid select2 @error('category') is-invalid @enderror"
                            id="category" name="category">
                            <option value="personal">Personal</option>
                            <option value="dev">Development</option>
                            <option value="social">Social Media</option>
                            <option value="banking">Banking</option>
                            <option value="other">Other</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Username / Email" name="username" placeholder="Enter username" required />
                </div>
                <div class="col-md-6">
                    <x-input label="URL (Optional)" name="url" placeholder="https://example.com" />
                </div>
            </div>

            <x-input label="Password" name="password" type="password" placeholder="Enter password" required />

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control form-control-solid @error('notes') is-invalid @enderror" id="notes" name="notes"
                    rows="3" placeholder="Additional notes..."></textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Credential</button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#category').select2({
                    placeholder: "Select a category",
                    allowClear: true
                });
            });
        </script>
    @endpush
</x-metrolar-layout>
