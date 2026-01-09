<x-metrolar-layout title="SSL Expiry Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5">
            <x-card title="🔒 SSL Checker" class="card-stretch gutter-b">
                <form action="{{ route('ssl-checker.check') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Domain URL <span
                                class="text-danger">*</span></label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('domain') }}">
                        <span class="form-text text-muted">Enter the domain name (with or without https://).</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg font-weight-bolder btn-block py-4">
                        Check Expiry <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
            </x-card>

            <!-- Recent/Tips Section (Optional) -->
            <div class="alert alert-custom alert-light-primary fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon-info"></i></div>
                <div class="alert-text">
                    This tool connects to the server and retrieves the SSL certificate to check its validity period.
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="col-lg-7">
            @if (session('result'))
                @php $res = session('result'); @endphp
                <x-card title="📊 Result for {{ $res['domain'] }}" class="card-stretch gutter-b">
                    <div class="d-flex flex-column align-items-center mb-10">
                        @if ($res['status'] === 'valid')
                            <div class="symbol symbol-100 symbol-circle symbol-light-success">
                                <span class="symbol-label">
                                    <i class="flaticon2-check-mark icon-4x text-success"></i>
                                </span>
                            </div>
                            <h3 class="font-weight-bolder text-success mt-4">Valid Certificate</h3>
                        @elseif($res['status'] === 'warning')
                            <div class="symbol symbol-100 symbol-circle symbol-light-warning">
                                <span class="symbol-label">
                                    <i class="flaticon-warning-sign icon-4x text-warning"></i>
                                </span>
                            </div>
                            <h3 class="font-weight-bolder text-warning mt-4">Expiring Soon</h3>
                        @else
                            <div class="symbol symbol-100 symbol-circle symbol-light-danger">
                                <span class="symbol-label">
                                    <i class="flaticon2-cross icon-4x text-danger"></i>
                                </span>
                            </div>
                            <h3 class="font-weight-bolder text-danger mt-4">Expired / Invalid</h3>
                        @endif

                        <div class="text-dark-50 font-weight-bold font-size-lg mt-2">
                            Expires in {{ $res['days_remaining'] }} days
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless table-vertical-center">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bolder text-dark">Issuer</td>
                                    <td class="text-muted text-right">{{ $res['issuer'] }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bolder text-dark">Valid From</td>
                                    <td class="text-muted text-right">{{ $res['valid_from'] }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bolder text-dark">Valid To</td>
                                    <td class="text-muted text-right">{{ $res['valid_to'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @elseif(session('error'))
                <x-card title="❌ Error" class="card-stretch gutter-b bg-light-danger">
                    <div class="d-flex flex-column align-items-center text-center p-5">
                        <i class="flaticon-exclamation-2 icon-4x text-danger mb-4"></i>
                        <h4 class="font-weight-bold text-danger">{{ session('error') }}</h4>
                        <p class="text-dark-50">Please check the domain name and try again.</p>
                    </div>
                </x-card>
            @else
                <x-card title="⏳ Waiting for Input" class="card-stretch gutter-b">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
                        <div class="symbol symbol-100 symbol-light-info mb-5">
                            <span class="symbol-label">
                                <i class="flaticon-safe-shield-protection icon-4x text-info"></i>
                            </span>
                        </div>
                        <h4 class="font-weight-bolder text-dark">Enter a domain to check</h4>
                        <p class="text-muted">We will scan port 443 for SSL certificate details.</p>
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-metrolar-layout>
