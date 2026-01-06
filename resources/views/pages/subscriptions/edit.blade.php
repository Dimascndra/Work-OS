<x-metrolar-layout title="Edit Subscription">
    <x-card title="Edit Subscription: {{ $subscription->service_name }}">
        <x-slot:toolbar>
            <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('subscriptions.update', $subscription) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Service Name" name="service_name" :value="$subscription->service_name"
                        placeholder="Netflix, AWS, Spotify" required />
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <x-input label="Currency" name="currency" :value="$subscription->currency" required />
                        </div>
                        <div class="col-md-8">
                            <x-input label="Price" name="price" type="number" step="0.01" :value="$subscription->price"
                                placeholder="0.00" required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="billing_cycle">Billing Cycle</label>
                        <select class="form-control form-control-solid select2" name="billing_cycle" id="billing_cycle">
                            <option value="monthly" {{ $subscription->billing_cycle == 'monthly' ? 'selected' : '' }}>
                                Monthly</option>
                            <option value="yearly" {{ $subscription->billing_cycle == 'yearly' ? 'selected' : '' }}>
                                Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="next_billing_date">Next Billing Date</label>
                        <input type="date"
                            class="form-control form-control-solid @error('next_billing_date') is-invalid @enderror"
                            name="next_billing_date" id="next_billing_date"
                            value="{{ $subscription->next_billing_date ? $subscription->next_billing_date->format('Y-m-d') : '' }}" />
                        @error('next_billing_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-between">
                <button type="button" class="btn btn-danger font-weight-bold"
                    onclick="document.getElementById('delete-form').submit();">Delete Subscription</button>
                <button type="submit" class="btn btn-primary font-weight-bold ml-auto">Update Subscription</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('subscriptions.destroy', $subscription) }}" method="POST"
            class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </x-card>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#billing_cycle').select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    @endpush
</x-metrolar-layout>
