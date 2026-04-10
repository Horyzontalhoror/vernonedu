@php
    use App\Filament\Resources\Programs\ProgramResource;
    use App\Filament\Resources\SubPrograms\SubProgramResource;
    use App\Filament\Resources\Materis\MateriResource;
    use App\Filament\Resources\Certificates\CertificateResource;
@endphp

<div class="grid gap-6 xl:grid-cols-2">
    <div class="rounded-2xl bg-gradient-to-r from-indigo-600 via-sky-500 to-cyan-400 p-6 text-white shadow-xl">
        <p class="text-sm uppercase tracking-widest text-white/80">Dashboard</p>
        <h2 class="mt-2 text-2xl font-semibold">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}</h2>
        <p class="mt-2 text-white/90">Pantau perkembangan kelas, kelola peserta, dan terbitkan sertifikat langsung dari satu tempat.</p>

        <dl class="mt-6 grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl bg-white/15 p-4 backdrop-blur">
                <dt class="text-xs uppercase tracking-wide text-white/70">Peserta</dt>
                <dd class="mt-1 text-2xl font-semibold">{{ number_format($totalPeserta) }}</dd>
            </div>
            <div class="rounded-xl bg-white/15 p-4 backdrop-blur">
                <dt class="text-xs uppercase tracking-wide text-white/70">Sub Program</dt>
                <dd class="mt-1 text-2xl font-semibold">{{ number_format($totalSubPrograms) }}</dd>
            </div>
            <div class="rounded-xl bg-white/15 p-4 backdrop-blur">
                <dt class="text-xs uppercase tracking-wide text-white/70">Materi</dt>
                <dd class="mt-1 text-2xl font-semibold">{{ number_format($totalMateri) }}</dd>
            </div>
        </dl>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Aksi cepat</h3>
            <span class="text-sm text-slate-500">Pintasan harian</span>
        </div>
        <div class="mt-5 grid gap-3 md:grid-cols-2">
            <a href="{{ ProgramResource::getUrl('create') }}" class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700 transition hover:border-indigo-200 hover:bg-indigo-100">Tambah Program</a>
            <a href="{{ SubProgramResource::getUrl('create') }}" class="rounded-xl border border-violet-100 bg-violet-50 px-4 py-3 text-sm font-semibold text-violet-700 transition hover:border-violet-200 hover:bg-violet-100">Tambah Sub Program</a>
            <a href="{{ MateriResource::getUrl('create') }}" class="rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 transition hover:border-amber-200 hover:bg-amber-100">Upload Materi</a>
            <a href="{{ CertificateResource::getUrl() }}" class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 transition hover:border-emerald-200 hover:bg-emerald-100">Kelola Sertifikat</a>
        </div>

        <div class="mt-6 flex flex-wrap gap-3 text-sm text-slate-500">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span> Semua sistem aktif
            </span>
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span> 24 tugas menunggu tindak lanjut
            </span>
        </div>
    </div>
</div>
