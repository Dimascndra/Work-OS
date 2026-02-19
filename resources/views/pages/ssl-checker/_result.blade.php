@if (isset($res))
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
@elseif(isset($error))
    <x-card class="card-stretch gutter-b bg-light-danger">
        <div class="d-flex flex-column align-items-center text-center p-5">
            <i class="flaticon-exclamation-2 icon-4x text-danger mb-4"></i>
            <h4 class="font-weight-bold text-danger">{{ $error }}</h4>
            <p class="text-dark-50 font-weight-bold">Please check the domain name and try again.</p>
        </div>
    </x-card>
@else
    <x-card class="card-stretch gutter-b">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
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
