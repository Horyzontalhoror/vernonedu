@php
    use App\Filament\Resources\Programs\ProgramResource;
    use App\Filament\Resources\SubPrograms\SubProgramResource;
    use App\Filament\Resources\Materis\MateriResource;
    use App\Filament\Resources\Certificates\CertificateResource;
@endphp

<div class="grid gap-6 xl:grid-cols-2">
    <div class="rounded-2xl bg-gradient-to-r from-indigo-600 via-sky-500 to-cyan-400 p-6 text-white shadow-xl">
        <h2 class="mt-2 text-2xl font-semibold">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}</h2>
        <p class="mt-2 text-white/90">Pantau perkembangan kelas, kelola peserta, dan terbitkan sertifikat langsung dari satu tempat.</p>
    </div>

    {{-- <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mt-5 grid gap-3 md:grid-cols-2">
            <a href="{{ ProgramResource::getUrl('create') }}" class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700 transition hover:border-indigo-200 hover:bg-indigo-100">Tambah Program</a>
            <a href="{{ SubProgramResource::getUrl('create') }}" class="rounded-xl border border-violet-100 bg-violet-50 px-4 py-3 text-sm font-semibold text-violet-700 transition hover:border-violet-200 hover:bg-violet-100">Tambah Sub Program</a>
            <a href="{{ MateriResource::getUrl('create') }}" class="rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 transition hover:border-amber-200 hover:bg-amber-100">Upload Materi</a>
            <a href="{{ CertificateResource::getUrl() }}" class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 transition hover:border-emerald-200 hover:bg-emerald-100">Kelola Sertifikat</a>
        </div>
    </div> --}}
</div>
