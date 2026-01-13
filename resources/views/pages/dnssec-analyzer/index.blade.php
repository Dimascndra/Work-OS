<x-public-layout title="DNSSEC Analyzer">
    <div class="row justify-content-center">
        <!-- Input Section -->
        <div class="col-lg-8 mb-5">
            <x-card class="card-stretch gutter-b text-center">
                <div class="d-flex flex-column align-items-center mb-5">
                    <div class="symbol symbol-60 symbol-light-primary mb-4">
                        <span class="symbol-label">
                            <i class="flaticon2-shield icon-2x text-primary"></i>
                        </span>
                    </div>
                    <h2 class="font-weight-bolder text-dark mb-2">DNSSEC Analyzer</h2>
                    <p class="text-muted font-size-lg">Analyze the DNSSEC Chain of Trust for any domain</p>
                </div>

                <form action="{{ route('dnssec-analyzer.analyze') }}" method="POST" class="mb-5">
                    @csrf
                    <div class="form-group">
                        <div class="input-group input-group-lg input-group-solid">
                            <input type="text" name="domain" class="form-control pl-5" placeholder="example.com"
                                required value="{{ old('domain') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary font-weight-bold px-10">
                                    Analyze
                                </button>
                            </div>
                        </div>
                        <span class="form-text text-muted mt-2 text-left ml-2">Enter a domain name to visualize its
                            DNSSEC signature chain.</span>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Result Section -->
        <div class="col-lg-10">
            @if (session('result'))
                @php $res = session('result'); @endphp
                <div class="card card-custom gutter-b">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder">
                            Analysis for <span class="text-primary ml-2">{{ $res['domain'] }}</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-3">
                            <div class="timeline-items">
                                @foreach ($res['analysis'] as $zone)
                                    <div class="timeline-item">
                                        <div class="timeline-media">
                                            @if ($zone['status'] === 'success')
                                                <i class="flaticon2-check-mark text-success"></i>
                                            @else
                                                <i class="flaticon-warning-sign text-warning"></i>
                                            @endif
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="mr-2">
                                                    <a href="#"
                                                        class="text-dark-75 text-hover-primary font-weight-bold font-size-h5">
                                                        {{ $zone['zone'] }}
                                                    </a>
                                                    <span class="text-muted ml-2">Zone Analysis</span>
                                                </div>
                                            </div>

                                            <div class="list list-timeline border-left-0">
                                                @foreach ($zone['events'] as $event)
                                                    <div class="d-flex align-items-center mb-4">
                                                        <div
                                                            class="symbol symbol-20 symbol-light-{{ $event['type'] }} mr-3">
                                                            <span class="symbol-label">
                                                                <i
                                                                    class="{{ $event['icon'] }} font-size-xs text-{{ $event['type'] }}"></i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex flex-column text-left">
                                                            <span
                                                                class="text-dark-75 font-weight-bold font-size-sm">{{ $event['message'] }}</span>
                                                            @if (isset($event['description']))
                                                                <span
                                                                    class="text-muted font-size-xs">{{ $event['description'] }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
