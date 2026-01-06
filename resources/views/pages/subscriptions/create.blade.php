<x-metrolar-layout title="Add Subscription">
    <x-card title="Add New Subscription">
        <x-slot:toolbar>
            <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary btn-sm font-weight-bolder">
                Back
            </a>
        </x-slot:toolbar>

        <form action="{{ route('subscriptions.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <x-input label="Service Name" name="service_name" placeholder="Netflix, AWS, Spotify" required />
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <x-input label="Currency" name="currency" value="IDR" required />
                        </div>
                        <div class="col-md-8">
                            <x-input label="Price" name="price" type="number" step="0.01" placeholder="0.00"
                                required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="billing_cycle">Billing Cycle</label>
                        <select class="form-control form-control-solid select2" name="billing_cycle" id="billing_cycle">
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="next_billing_date">Next Billing Date</label>
                        <input type="date"
                            class="form-control form-control-solid @error('next_billing_date') is-invalid @enderror"
                            name="next_billing_date" id="next_billing_date" />
                        @error('next_billing_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Subscription</button>
            </div>
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
