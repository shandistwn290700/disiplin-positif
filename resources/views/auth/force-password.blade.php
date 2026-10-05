<x-guest-layout>
    <div class="mb-6">
        <div class="icon-tile bg-amber-50 text-amber-600 mb-4"><x-icon name="lock" /></div>
        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Ganti Password Terlebih Dahulu</h1>
        <p class="text-sm text-slate-500 mt-1.5">
            Demi keamanan akunmu, silakan buat password baru yang kuat sebelum melanjutkan.
        </p>
    </div>

    <x-validation-errors />

    <form method="POST" action="{{ route('force-password.update') }}" class="space-y-5" id="change-password-form">
        @csrf

        <div>
            <label class="form-label">Password Saat Ini</label>
            <input type="password" name="current_password" required autofocus
                   class="form-control w-full">
        </div>

        <div>
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" id="new-password" required
                   class="form-control w-full">

            {{-- Indikator kekuatan password --}}
            <div class="mt-2.5">
                <div class="flex items-center justify-between mb-1.5">
                    <span id="strength-text" class="text-xs font-medium" style="color:#6b7280;">Kekuatan Password</span>
                    <span id="strength-percent" class="text-xs font-semibold" style="color:#6b7280;">0%</span>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden bg-slate-200">
                    <div id="strength-bar" class="h-2 rounded-full" style="width:0%; background-color:#e5e7eb; transition: width 0.4s cubic-bezier(0.4,0,0.2,1), background-color 0.4s ease;"></div>
                </div>
                <p id="strength-label" class="form-hint" style="color:#6b7280;">Minimal 8 karakter, kombinasi huruf besar, kecil, angka, dan simbol.</p>
            </div>
        </div>

        <div>
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" required
                   class="form-control w-full">
        </div>

        <button type="submit" class="btn-primary w-full !py-3">
            Simpan Password Baru
        </button>
    </form>

    <script>
        const input = document.getElementById('new-password');
        const bar = document.getElementById('strength-bar');
        const label = document.getElementById('strength-label');
        const percentEl = document.getElementById('strength-percent');
        const textEl = document.getElementById('strength-text');

        let currentPercent = 0;
        let animFrame = null;

        // Hitung skor kekuatan password (0-100) berdasarkan panjang & variasi karakter
        function calculateStrength(val) {
            if (val.length === 0) return 0;

            let score = 0;

            // Panjang password (bobot terbesar, makin panjang makin kuat)
            score += Math.min(val.length / 16, 1) * 40;

            // Variasi jenis karakter
            let variety = 0;
            if (/[a-z]/.test(val)) variety++;
            if (/[A-Z]/.test(val)) variety++;
            if (/[0-9]/.test(val)) variety++;
            if (/[^A-Za-z0-9]/.test(val)) variety++;
            score += (variety / 4) * 40;

            // Bonus panjang minimal aman (>= 8 karakter)
            if (val.length >= 8) score += 20;

            return Math.round(Math.min(score, 100));
        }

        // Interpolasi warna dari merah -> oranye -> kuning -> hijau berdasarkan persentase
        function getColorForPercent(percent) {
            const stops = [
                { p: 0,   color: [229, 231, 235] }, // abu-abu (kosong)
                { p: 25,  color: [220, 38, 38] },   // merah
                { p: 50,  color: [245, 158, 11] },  // oranye
                { p: 75,  color: [234, 179, 8] },   // kuning
                { p: 100, color: [22, 163, 74] },   // hijau
            ];

            if (percent <= 0) return stops[0].color;

            let lower = stops[0], upper = stops[stops.length - 1];
            for (let i = 0; i < stops.length - 1; i++) {
                if (percent >= stops[i].p && percent <= stops[i + 1].p) {
                    lower = stops[i];
                    upper = stops[i + 1];
                    break;
                }
            }

            const range = upper.p - lower.p || 1;
            const ratio = (percent - lower.p) / range;
            const rgb = lower.color.map((c, i) => Math.round(c + (upper.color[i] - c) * ratio));
            return rgb;
        }

        function getLabelText(percent) {
            if (percent === 0) return 'Minimal 8 karakter, kombinasi huruf besar, kecil, angka, dan simbol.';
            if (percent < 35) return 'Lemah — tambahkan huruf besar, angka, dan simbol.';
            if (percent < 65) return 'Sedang — masih bisa lebih kuat.';
            if (percent < 90) return 'Cukup kuat.';
            return 'Kuat! Password sudah bagus.';
        }

        // Animasikan angka persentase dari nilai lama ke nilai baru
        function animatePercent(from, to, duration = 400) {
            if (animFrame) cancelAnimationFrame(animFrame);
            const start = performance.now();

            function step(now) {
                const elapsed = now - start;
                const t = Math.min(elapsed / duration, 1);
                // easing ease-out
                const eased = 1 - Math.pow(1 - t, 3);
                const value = Math.round(from + (to - from) * eased);

                percentEl.textContent = value + '%';
                const rgb = getColorForPercent(value);
                const rgbStr = `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;
                percentEl.style.color = value === 0 ? '#6b7280' : rgbStr;

                if (t < 1) {
                    animFrame = requestAnimationFrame(step);
                } else {
                    currentPercent = to;
                }
            }

            animFrame = requestAnimationFrame(step);
        }

        input.addEventListener('input', function () {
            const val = input.value;
            const percent = calculateStrength(val);
            const rgb = getColorForPercent(percent);
            const colorStr = `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;

            bar.style.width = percent + '%';
            bar.style.backgroundColor = colorStr;

            label.textContent = getLabelText(percent);
            label.style.color = percent === 0 ? '#6b7280' : colorStr;

            textEl.style.color = percent === 0 ? '#6b7280' : colorStr;

            animatePercent(currentPercent, percent);
        });
    </script>
</x-guest-layout>
