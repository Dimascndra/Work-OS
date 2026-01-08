<x-metrolar-layout title="Add New Server">
    <x-card title="Add New Server">
        <x-slot:toolbar>
            <a href="{{ route('servers.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('servers.store') }}" method="POST">
            @csrf

            <h5 class="font-weight-bold text-dark mb-5">Server Information</h5>

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Server Name" name="name" placeholder="e.g. Production Web 01" required />
                </div>
                <div class="col-md-6">
                    <x-input label="IP Address" name="ip_address" placeholder="192.168.1.1" required />
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <x-input label="SSH Port" name="port" type="number" value="22" required />
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="os_type">OS Type <span class="text-danger">*</span></label>
                        <select class="form-control form-control-solid select2 @error('os_type') is-invalid @enderror"
                            id="os_type" name="os_type">
                            <option value="ubuntu">Ubuntu</option>
                            <option value="centos">CentOS</option>
                            <option value="debian">Debian</option>
                            <option value="linux">Linux</option>
                            <option value="other">Other</option>
                        </select>
                        @error('os_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="server_type">Server Type <span class="text-danger">*</span></label>
                        <select
                            class="form-control form-control-solid select2 @error('server_type') is-invalid @enderror"
                            id="server_type" name="server_type">
                            <option value="Physical">Physical Server</option>
                            <option value="VPS" selected>VPS</option>
                            <option value="Cloud">Cloud Instance</option>
                            <option value="Container">Container</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('server_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="checkbox-inline">
                            <label class="checkbox checkbox-lg">
                                <input type="checkbox" name="is_active" value="1" checked />
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
                    <x-input label="SSH Username" name="username" placeholder="root" required />
                </div>
                <div class="col-md-6">
                    <x-input label="SSH Password (Optional)" name="password" type="password"
                        placeholder="Password for SSH authentication" />
                    <small class="form-text text-muted">Stored securely with encryption.</small>
                </div>
            </div>

            <div class="form-group">
                <label for="private_key">SSH Private Key (Optional)</label>
                <textarea class="form-control form-control-solid @error('private_key') is-invalid @enderror" id="private_key"
                    name="private_key" rows="5" placeholder="-----BEGIN RSA PRIVATE KEY-----..."></textarea>
                <small class="form-text text-muted">For key-based authentication. Stored securely with
                    encryption.</small>
                @error('private_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="public_key">SSH Public Key (Optional)</label>
                <textarea class="form-control form-control-solid @error('public_key') is-invalid @enderror" id="public_key"
                    name="public_key" rows="3" placeholder="ssh-rsa AAAAB3NzaC1yc2E..."></textarea>
                <small class="form-text text-muted">Your public key for reference.</small>
                @error('public_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="separator separator-dashed my-7"></div>

            <div class="form-group">
                <label for="description">Description / Notes (Optional)</label>
                <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3" placeholder="Additional notes or description about this server..."></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('servers.index') }}" class="btn btn-secondary mr-3">Cancel</a>
                <button type="submit" class="btn btn-primary font-weight-bold">Save Server</button>
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

                $('#server_type').select2({
                    placeholder: "Select Server Type",
                    allowClear: true
                });
            });
        </script>
    @endpush
</x-metrolar-layout>
