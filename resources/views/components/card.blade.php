@props(['title' => null, 'toolbar' => null])

<div {{ $attributes->merge(['class' => 'card card-custom gutter-b']) }}>
    @if ($title)
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{ $title }}
                </h3>
            </div>
            @if ($toolbar)
                <div class="card-toolbar">
                    {{ $toolbar }}
                </div>
            @endif
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
