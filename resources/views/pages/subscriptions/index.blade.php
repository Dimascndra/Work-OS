<x-metrolar-layout title="Subscriptions">
    <x-card title="Recurring Subscriptions">
        <x-slot:toolbar>
            <a href="{{ route('subscriptions.create') }}" class="btn btn-primary btn-sm font-weight-bolder">
                <i class="ki ki-plus icon-sm"></i> Add Subscription
            </a>
        </x-slot:toolbar>

        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Cost</th>
                        <th>Cycle</th>
                        <th>Next Billing</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                        <tr>
                            <td>
                                <span
                                    class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $sub->service_name }}</span>
                            </td>
                            <td>
                                <span class="text-success font-weight-bold">{{ $sub->currency }}
                                    {{ number_format($sub->price, 2) }}</span>
                            </td>
                            <td>
                                <span
                                    class="label label-inline {{ $sub->billing_cycle == 'yearly' ? 'label-light-info' : 'label-light-warning' }}">{{ ucfirst($sub->billing_cycle) }}</span>
                            </td>
                            <td>
                                @if ($sub->next_billing_date)
                                    {{ $sub->next_billing_date->format('d M Y') }}
                                    <small
                                        class="text-muted d-block">({{ $sub->next_billing_date->diffForHumans() }})</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('subscriptions.edit', $sub) }}"
                                    class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                    <i class="flaticon2-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No subscriptions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-metrolar-layout>
