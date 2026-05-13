<x-metrolar-layout title="Edit Credential">
    <x-card title="Edit Credential: {{ $credential->service_name }}">
        <x-slot:toolbar>
            <a href="{{ route('credentials.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('credentials.update', $credential) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Service Name" name="service_name" placeholder="e.g. Google, AWS, Facebook"
                        :value="$credential->service_name" required />
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-control form-control-solid select2 @error('category') is-invalid @enderror"
                            id="category" name="category">
                            <option value="personal" {{ $credential->category == 'personal' ? 'selected' : '' }}>
                                Personal
                            </option>
                            <option value="dev" {{ $credential->category == 'dev' ? 'selected' : '' }}>Development
                            </option>
                            <option value="social" {{ $credential->category == 'social' ? 'selected' : '' }}>Social
                                Media</option>
                            <option value="banking" {{ $credential->category == 'banking' ? 'selected' : '' }}>Banking
                            </option>
                            <option value="other" {{ $credential->category == 'other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Username / Email" name="username" placeholder="Enter username" :value="$credential->username"
                        required />
                </div>
                <div class="col-md-6">
                    <x-input label="URL (Optional)" name="url" placeholder="https://example.com"
                        :value="$credential->url" />
                </div>
            </div>

            <x-input label="Password" name="password" type="password" placeholder="Enter a new password" />
            <small class="form-text text-muted mb-4">You can update the password or leave it as is.</small>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control form-control-solid @error('notes') is-invalid @enderror" id="notes" name="notes"
                    rows="3" placeholder="Additional notes...">{{ old('notes', $credential->notes ?? '') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Update Credential</button>
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
