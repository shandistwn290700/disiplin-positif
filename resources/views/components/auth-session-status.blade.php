@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success']) }}>
        <x-icon name="check-circle" />
        <span>{{ $status }}</span>
    </div>
@endif
