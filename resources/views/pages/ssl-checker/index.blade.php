<x-public-layout title="SSL Expiry Checker">
    <div class="row">
        <!-- Input Section -->
        <div class="col-lg-5 mb-5">
            <x-card class="card-stretch gutter-b">
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-50 symbol-light-success mr-4">
                        <span class="symbol-label">
                            <i class="flaticon-lock icon-lg text-success"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="font-weight-bolder text-dark mb-0">SSL Expiry Checker</h3>
                        <span class="text-muted font-weight-bold">Check certificate validity</span>
                    </div>
                </div>

                <form action="{{ route('ssl-checker.check') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Domain URL <span
                                class="text-danger">*</span></label>
                        <input type="text" name="domain" class="form-control form-control-solid form-control-lg"
                            placeholder="example.com" required value="{{ old('domain') }}">
                        <span class="form-text text-muted">Enter the domain name (e.g. google.com).</span>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg font-weight-bolder btn-block py-4">
                        Check Expiry <i class="flaticon2-search-1 ml-2"></i>
                    </button>
                </form>
                <div class="text-muted mt-5">
                    <i class="flaticon-info text-primary mr-1"></i> We verify certificate expiration date and issuer
                    from port 443.
                </div>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-7">
            @if (session('result'))
                @php $res = session('result'); @endphp
                <x-card class="card-stretch gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder">Certification Results for {{ $res['domain'] }}</h3>
                    </div>
                    <div class="card-body">
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
                                        <td class="font-weight-bolder text-dark font-size-lg">Issuer</td>
                                        <td class="text-muted text-right font-weight-bold">{{ $res['issuer'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bolder text-dark font-size-lg">Valid From</td>
                                        <td class="text-muted text-right font-weight-bold">{{ $res['valid_from'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bolder text-dark font-size-lg">Valid To</td>
                                        <td class="text-muted text-right font-weight-bold">{{ $res['valid_to'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </x-card>
            @elseif(session('error'))
                <x-card class="card-stretch gutter-b bg-light-danger">
                    <div class="d-flex flex-column align-items-center text-center p-5">
                        <i class="flaticon-exclamation-2 icon-4x text-danger mb-4"></i>
                        <h4 class="font-weight-bold text-danger">{{ session('error') }}</h4>
                        <p class="text-dark-50 font-weight-bold">Please check the domain name and try again.</p>
                    </div>
                </x-card>
            @else
                <x-card class="card-stretch gutter-b">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
                        <div class="symbol symbol-100 symbol-light-success mb-5">
                            <span class="symbol-label">
                                <i class="flaticon-safe-shield-protection icon-4x text-success"></i>
                            </span>
                        </div>
                        <h4 class="font-weight-bolder text-dark">Enter a domain to check</h4>
                        <p class="text-muted font-weight-bold">We will scan port 443 for SSL certificate details.</p>
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-public-layout>
