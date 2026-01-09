@push('styles')
    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endpush

<x-metrolar-layout title="Productivity Hub">
    <div class="row">
        <!-- Time Tracking Stats -->
        <div class="col-xl-4">
            <div class="card card-custom bg-light-primary gutter-b card-stretch">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h3 class="card-label text-primary font-weight-bolder">Total Hours Today</h3>
                    </div>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-0 pb-10">
                    <span class="font-weight-bolder display-3 text-primary">{{ $totalHours }}</span>
                    <span class="font-weight-bold font-size-lg text-dark-50">Hours Tracked</span>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-custom bg-light-success gutter-b card-stretch">
                <div class="card-header border-0">
                    <div class="card-title">
                        <h3 class="card-label text-success font-weight-bolder">Sessions Today</h3>
                    </div>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-0 pb-10">
                    <span class="font-weight-bolder display-3 text-success">{{ $todayEntries->count() }}</span>
                    <span class="font-weight-bold font-size-lg text-dark-50">Sessions Completed</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Overview -->
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <span class="symbol symbol-50 symbol-light-info mr-5">
                                <span class="symbol-label"><i class="flaticon-list-3 icon-lg text-info"></i></span>
                            </span>
                            <div class="d-flex flex-column flex-grow-1">
                                <a href="{{ route('tasks.index') }}"
                                    class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Tasks</a>
                                <span class="text-muted font-weight-bold">{{ $stats['tasks_completed'] }} /
                                    {{ $stats['tasks_count'] }} Completed</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <span class="symbol symbol-50 symbol-light-danger mr-5">
                                <span class="symbol-label"><i class="flaticon-code icon-lg text-danger"></i></span>
                            </span>
                            <div class="d-flex flex-column flex-grow-1">
                                <a href="{{ route('snippets.index') }}"
                                    class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Snippets</a>
                                <span class="text-muted font-weight-bold">{{ $stats['snippets_count'] }} Saved</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card card-custom bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <span class="symbol symbol-50 symbol-light-warning mr-5">
                                <span class="symbol-label"><i class="flaticon-route icon-lg text-warning"></i></span>
                            </span>
                            <div class="d-flex flex-column flex-grow-1">
                                <a href="{{ route('short-urls.index') }}"
                                    class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">Short
                                    URLs</a>
                                <span class="text-muted font-weight-bold">{{ $stats['short_urls_clicks'] }} Clicks /
                                    {{ $stats['short_urls_count'] }} Links</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Timer & Quick Start -->
    <div class="row">
        <div class="col-xl-12">
            @if ($activeTimer)
                <div
                    class="card card-custom gutter-b border-left-lg border-primary border-0 bg-light-primary shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between p-6">
                        <div class="d-flex flex-column">
                            <h3 class="text-dark font-weight-bold mb-2">Current Session Active</h3>
                            <div class="d-flex align-items-center">
                                <span class="label label-dot label-xl label-danger mr-2 animate-pulse"></span>
                                <span class="font-size-lg text-dark-75 font-weight-bolder mr-4">
                                    Started at {{ $activeTimer->start_time->format('H:i') }}
                                </span>
                                @if ($activeTimer->task)
                                    <span
                                        class="label label-light-info label-inline font-weight-bold">{{ $activeTimer->task->name }}</span>
                                @else
                                    <span
                                        class="text-muted font-italic">{{ $activeTimer->description ?? 'No description' }}</span>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('productivity.stop', $activeTimer) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger font-weight-bolder btn-lg px-6">
                                <i class="flaticon2-stop icon-md"></i> Stop Timer
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Quick Start Session</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('productivity.store') }}" method="POST"
                            class="d-flex align-items-center">
                            @csrf
                            <div class="input-icon flex-grow-1 mr-4">
                                <input type="text" name="description"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="What are you working on?">
                                <span><i class="flaticon2-pen text-muted"></i></span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg font-weight-bolder px-8">
                                <i class="flaticon2-time icon-md"></i> Start
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-open-text-book text-primary"></i>
                </span>
                <h3 class="card-label">Today's Activity</h3>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
                    <thead>
                        <tr class="text-left">
                            <th style="min-width: 150px" class="pl-7">Time</th>
                            <th style="min-width: 250px">Activity</th>
                            <th style="min-width: 150px">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayEntries as $entry)
                            <tr>
                                <td class="pl-7">
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                        {{ $entry->start_time->format('H:i') }} -
                                        {{ $entry->end_time ? $entry->end_time->format('H:i') : 'Now' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($entry->task)
                                        <span
                                            class="label label-inline label-light-info font-weight-bold mr-2">Task</span>
                                        <span class="text-dark font-weight-bold">{{ $entry->task->name }}</span>
                                    @else
                                        <span
                                            class="text-dark font-weight-bold">{{ $entry->description ?: 'Untitled Session' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="label label-lg label-light-success label-inline font-weight-bold py-4 font-mono">{{ $entry->duration_text }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-10">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="symbol symbol-60 symbol-light-warning mb-3">
                                            <span class="symbol-label"><i
                                                    class="flaticon2-time icon-2x text-warning"></i></span>
                                        </div>
                                        <h5 class="text-muted font-weight-bold">No activity recorded today</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-metrolar-layout>
