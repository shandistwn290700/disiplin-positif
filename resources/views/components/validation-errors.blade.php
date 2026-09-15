@if ($errors->any())
    <div style="
        display:flex;
        gap:0.75rem;
        align-items:flex-start;
        background-color:#fef2f2;
        border:1px solid #fecaca;
        border-left:4px solid #dc2626;
        border-radius:0.75rem;
        padding:1rem 1.25rem;
        margin-bottom:1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        animation: fadeInError 0.25s ease-out;
    ">
        <div style="flex-shrink:0; margin-top:0.1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div style="flex:1;">
            <p style="font-size:0.875rem; font-weight:600; color:#991b1b; margin:0 0 0.35rem 0;">
                {{ $errors->count() > 1 ? 'Ada beberapa hal yang perlu diperbaiki' : 'Ada yang perlu diperbaiki' }}
            </p>
            <ul style="margin:0; padding:0; list-style:none; display:flex; flex-direction:column; gap:0.25rem;">
                @foreach ($errors->all() as $error)
                    <li style="font-size:0.8125rem; color:#b91c1c; display:flex; gap:0.4rem; align-items:flex-start;">
                        <span style="color:#dc2626; line-height:1.4;">&bull;</span>
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
