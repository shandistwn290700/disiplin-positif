@php
    $favicon = \App\Models\SiteSetting::current()->favicon ?? null;
@endphp
@if($favicon)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $favicon) }}">
@endif
