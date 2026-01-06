@props(['title', 'toolbar' => null])

<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                {{ $title }}
            </h3>
        </div>
        @if($toolbar)
            <div class="card-toolbar">
                {{ $toolbar }}
            </div>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
