<x-metrolar-layout title="Activity Logs">
    <x-card title="Audit Trail">

        <div class="timeline timeline-3">
            <div class="timeline-items">
                @forelse($logs as $log)
                    <div class="timeline-item">
                        <div class="timeline-media">
                            <i class="flaticon2-notification flaticon-primary"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="mr-2">
                                    <a href="#"
                                        class="text-dark-75 text-hover-primary font-weight-bold">{{ $log->action }}</a>
                                    <span class="text-muted ml-2">{{ $log->created_at->diffForHumans() }}</span>
                                    <span
                                        class="label label-light-success font-weight-bolder label-inline ml-2">{{ $log->user->name ?? 'Unknown User' }}</span>
                                </div>
                                <div class="primary font-weight-bold">
                                    {{ $log->ip_address }}
                                </div>
                            </div>
                            <p class="p-0">
                                {{ $log->description }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-custom alert-light-warning fade show mb-5" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">No activity logs recorded yet.</div>
                    </div>
                @endforelse
            </div>
        </div>

    </x-card>
</x-metrolar-layout>
