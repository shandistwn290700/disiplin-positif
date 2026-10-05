@if ($errors->any())
    <div class="flex gap-3 items-start rounded-2xl border border-red-200 bg-red-50/80 px-5 py-4 mb-5 shadow-sm" style="animation: fadeInError .25s ease-out;">
        <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
            <x-icon name="warning" class="w-[1.1rem] h-[1.1rem]" />
        </div>
        <div class="flex-1 pt-0.5">
            <p class="text-sm font-semibold text-red-800 mb-1">
                {{ $errors->count() > 1 ? 'Ada beberapa hal yang perlu diperbaiki' : 'Ada yang perlu diperbaiki' }}
            </p>
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="flex gap-2 items-start text-[0.8125rem] text-red-700">
                        <span class="mt-[0.45rem] w-1 h-1 rounded-full bg-red-500 flex-shrink-0"></span>
                        <span>{{ $error }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <style>
        @keyframes fadeInError {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endif
