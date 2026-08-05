@extends('layouts.app')

@section('title', 'UI Components — ' . config('app.name'))
@section('page-title', 'UI Components')

@section('content')
<div class="mx-auto max-w-5xl space-y-12 px-4 py-8">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Interactive UI Components</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Demo komponen interaktif yang reusable — Modal (Dialog Konfirmasi) dan Toast Notifications.
        </p>
    </div>

    {{-- ================= SECTION 1: MODAL DEMOS ================= --}}
    <section class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">1. Modal (Dialog Konfirmasi & Sizing)</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gunakan modal untuk dialog konfirmasi tindakan penting atau menampilkan formulir mini.
            </p>
        </div>

        <div class="flex flex-wrap gap-4 p-6 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            
            {{-- Demo 1: Konfirmasi Hapus --}}
            <div x-data="{ open: false }">
                <x-form.button variant="danger" @click="open = true">
                    Modal Konfirmasi
                </x-form.button>

                <x-ui.modal title="Hapus Pengguna" size="sm">
                    <p class="text-gray-600 dark:text-gray-300">
                        Apakah kamu yakin ingin menghapus user <strong>Budi Santoso</strong>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <x-slot name="footer">
                        <x-form.button variant="secondary" size="sm" @click="open = false">Batal</x-form.button>
                        <x-form.button variant="danger" size="sm" @click="open = false">Hapus Sekarang</x-form.button>
                    </x-slot>
                </x-ui.modal>
            </div>

            {{-- Demo 2: Modal Ukuran Sedang (md) --}}
            <div x-data="{ open: false }">
                <x-form.button variant="primary" @click="open = true">
                    Modal Sedang (md)
                </x-form.button>

                <x-ui.modal title="Informasi Sistem" size="md">
                    <p class="mb-3 text-gray-600 dark:text-gray-300">
                        Sistem sedang memproses sinkronisasi data periodik. Hal ini mungkin membutuhkan waktu beberapa menit.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 font-semibold">
                        Langkah yang direkomendasikan:
                    </p>
                    <ul class="list-disc list-inside text-xs mt-1 space-y-1 text-gray-500 dark:text-gray-400">
                        <li>Jangan mematikan tab browser saat loading berjalan.</li>
                        <li>Pastikan koneksi internet stabil.</li>
                    </ul>
                    <x-slot name="footer">
                        <x-form.button variant="primary" size="sm" @click="open = false">Paham</x-form.button>
                    </x-slot>
                </x-ui.modal>
            </div>

            {{-- Demo 3: Modal Ukuran Besar (lg) --}}
            <div x-data="{ open: false }">
                <x-form.button variant="secondary" @click="open = true">
                    Modal Besar (lg)
                </x-form.button>

                <x-ui.modal title="Syarat & Ketentuan Lisensi" size="lg">
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                        <p class="font-bold text-gray-800 dark:text-gray-200">Ketentuan Penggunaan Lisensi Template</p>
                        <p>1. Lisensi ini mengizinkan penggunaan template untuk satu produk akhir proyek komersial atau personal milik Anda sendiri.</p>
                        <p>2. Anda tidak diizinkan mendistribusikan ulang, menyewakan, atau menjual kembali template ini dalam bentuk file mentah.</p>
                        <p>3. Modifikasi kode diperbolehkan sepenuhnya untuk disesuaikan dengan kebutuhan proyek Anda.</p>
                        <p>4. Hak cipta dari struktur desain asli tetap melekat pada pembuat template.</p>
                    </div>
                    <x-slot name="footer">
                        <x-form.button variant="secondary" size="sm" @click="open = false">Tutup</x-form.button>
                        <x-form.button variant="success" size="sm" @click="open = false">Saya Setuju</x-form.button>
                    </x-slot>
                </x-ui.modal>
            </div>
            
        </div>
    </section>
</div>
@endsection
