@props(['title', 'subtitle' => null, 'back' => null])

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
    <div class="min-w-0">
        @if($back)
            <a href="{{ $back }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-700 transition mb-2">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Kembali
            </a>
        @endif
        <h1 class="page-title">{{ $title }}</h1>
        @if($subtitle)
            <p class="page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @if($slot->isNotEmpty())
        <div class="flex flex-wrap gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
