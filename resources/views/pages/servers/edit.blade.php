<x-metrolar-layout title="Edit Server">
    <x-card title="Edit Server: {{ $server->name }}">
        <x-slot:toolbar>
            <a href="{{ route('servers.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('servers.update', $server) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="font-weight-bold text-dark mb-5">Server Information</h5>

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Server Name" name="name" :value="$server->name" placeholder="e.g. Production Web 01"
                        required />
                </div>
                <div class="col-md-6">
                    <x-input label="IP Address" name="ip_address" :value="$server->ip_address" placeholder="192.168.1.1"
                        required />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <x-input label="SSH Port" name="port" type="number" :value="$server->port" required />
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="os_type">OS Type <span class="text-danger">*</span></label>
                        <select class="form-control form-control-solid select2 @error('os_type') is-invalid @enderror"
                            id="os_type" name="os_type">
                            <option value="ubuntu" {{ $server->os_type == 'ubuntu' ? 'selected' : '' }}>Ubuntu</option>
                            <option value="centos" {{ $server->os_type == 'centos' ? 'selected' : '' }}>CentOS</option>
                            <option value="debian" {{ $server->os_type == 'debian' ? 'selected' : '' }}>Debian</option>
                            <option value="linux" {{ $server->os_type == 'linux' ? 'selected' : '' }}>Linux</option>
                            <option value="other" {{ $server->os_type == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('os_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="checkbox-inline">
                            <label class="checkbox checkbox-lg">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ $server->is_active ? 'checked' : '' }} />
                                <span></span>
                                Active
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="separator separator-dashed my-7"></div>

            <h5 class="font-weight-bold text-dark mb-5">SSH Authentication</h5>

            <div class="row">
                <div class="col-md-6">
                    <x-input label="SSH Username" name="username" :value="$server->username" placeholder="root" required />
                </div>
                <div class="col-md-6">
                    <x-input label="SSH Password (Optional)" name="password" type="password" :value="$server->password"
                        placeholder="Password for SSH authentication" />
                    <small class="form-text text-muted">Stored securely with encryption. Leave blank to keep current
                        password.</small>
                </div>
            </div>

            <div class="form-group">
                <label for="private_key">SSH Private Key (Optional)</label>
                <textarea class="form-control form-control-solid @error('private_key') is-invalid @enderror" id="private_key"
                    name="private_key" rows="5" placeholder="-----BEGIN RSA PRIVATE KEY-----...">{{ old('private_key', $server->private_key) }}</textarea>
                <small class="form-text text-muted">For key-based authentication. Stored securely with
                    encryption.</small>
                @error('private_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="public_key">SSH Public Key (Optional)</label>
                <textarea class="form-control form-control-solid @error('public_key') is-invalid @enderror" id="public_key"
                    name="public_key" rows="3" placeholder="ssh-rsa AAAAB3NzaC1yc2E...">{{ old('public_key', $server->public_key) }}</textarea>
                <small class="form-text text-muted">Your public key for reference.</small>
                @error('public_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="separator separator-dashed my-7"></div>

            <div class="form-group">
                <label for="description">Description / Notes (Optional)</label>
                <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3" placeholder="Additional notes or description about this server...">{{ old('description', $server->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('servers.index') }}" class="btn btn-secondary mr-3">Cancel</a>
                <button type="submit" class="btn btn-primary font-weight-bold">Update Server</button>
            </div>
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#os_type').select2({
                    placeholder: "Select OS Type",
                    allowClear: true
                });
            });
        </script>
    @endpush
</x-metrolar-layout>
