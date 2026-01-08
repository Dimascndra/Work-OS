<x-metrolar-layout title="Edit User">
    <x-card title="Edit User">
        <x-slot:toolbar>
            <a href="{{ route('users.index') }}" class="btn btn-light-primary font-weight-bolder btn-sm">
                <i class="ki ki-long-arrow-back icon-sm"></i> Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name"
                        value="{{ old('name', $user->name) }}" required />
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email address"
                        value="{{ old('email', $user->email) }}" required />
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Password <span class="text-muted">(Leave blank to keep current)</span></label>
                    <input type="password" name="password" class="form-control" placeholder="New password" />
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Confirm new password" />
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </x-card>
</x-metrolar-layout>
