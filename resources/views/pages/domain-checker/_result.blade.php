@if (isset($res))
    <x-card title="📊 Result for {{ $res['domain'] }}" class="card-stretch gutter-b">
        <!-- Status Header -->
        <div class="d-flex flex-column align-items-center mb-10">
            @if ($res['is_registered'])
                <div class="symbol symbol-100 symbol-circle symbol-light-danger">
                    <span class="symbol-label">
                        <i class="flaticon2-cross icon-4x text-danger"></i>
                    </span>
                </div>
                <h3 class="font-weight-bolder text-danger mt-4">Domain is Taken</h3>
                <p class="text-dark-50 font-weight-bold">Registered / Active</p>
            @else
                <div class="symbol symbol-100 symbol-circle symbol-light-success">
                    <span class="symbol-label">
                        <i class="flaticon2-check-mark icon-4x text-success"></i>
                    </span>
                </div>
                <h3 class="font-weight-bolder text-success mt-4">Likely Available</h3>
                <p class="text-dark-50 font-weight-bold">No active DNS records found</p>
            @endif
        </div>

        <!-- Whois Data -->
        <div class="form-group">
            <label class="font-weight-bolder">WHOIS Data:</label>
            <textarea class="form-control form-control-solid font-family-monospace" rows="15" readonly>{{ $res['whois'] }}</textarea>
        </div>
    </x-card>
@elseif(isset($error))
    <x-card title="❌ Error" class="card-stretch gutter-b bg-light-danger">
        <div class="d-flex flex-column align-items-center text-center p-5">
            <i class="flaticon-exclamation-2 icon-4x text-danger mb-4"></i>
            <h4 class="font-weight-bold text-danger">{{ $error }}</h4>
        </div>
    </x-card>
@else
    <x-card title="⏳ Waiting for Input" class="card-stretch gutter-b">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 min-h-300px text-center">
            <div class="symbol symbol-100 symbol-light-info mb-5">
                <span class="symbol-label">
                    <i class="flaticon-search icon-4x text-info"></i>
                </span>
            </div>
            <h4 class="font-weight-bolder text-dark">Enter a domain to check</h4>
            <p class="text-muted">Check availability and WHOIS details.</p>
        </div>
    </x-card>
@endif
