<x-metrolar-layout title="Add SSH Key">
    <x-card title="Add New SSH Key">
        <x-slot:toolbar>
            <a href="{{ route('ssh-keys.index') }}" class="btn btn-light-primary font-weight-bolder btn-sm">
                <i class="ki ki-long-arrow-back icon-sm"></i> Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('ssh-keys.store') }}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control"
                        placeholder="Enter Title (e.g. My Production Server)" value="{{ old('title') }}" required />
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>IP Server <span class="text-danger">*</span></label>
                    <input type="text" name="ip_server" class="form-control" placeholder="Enter IP Address"
                        value="{{ old('ip_server') }}" required />
                    @error('ip_server')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label>Port <span class="text-danger">*</span></label>
                    <input type="number" name="port" class="form-control" placeholder="Enter Port"
                        value="{{ old('port', 22) }}" required />
                    @error('port')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="Enter Username"
                        value="{{ old('username') }}" required />
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password (Optional)"
                        value="{{ old('password') }}" />
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Public Key</label>
                <textarea name="public_key" class="form-control" rows="5" placeholder="Enter Public Key">{{ old('public_key') }}</textarea>
                @error('public_key')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </x-card>
</x-metrolar-layout>
