@extends('layouts.app')
@section('title', 'Form Components — ' . config('app.name'))
@section('page-title', 'Form Design System')

@section('content')
<div class="grid grid-cols-1 gap-8">

    {{-- SECTION: Component Showcases --}}
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
        <h2 class="mb-5 text-lg font-semibold text-gray-900 dark:text-white">Daftar Komponen Individu</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <x-form.input name="normal" label="Normal Input" placeholder="Ketik sesuatu..." />
            <x-form.input name="error_input" label="Error Input" value="salah@email" error="Format email tidak valid" />
            <x-form.input name="disabled_input" label="Disabled Input" value="Tidak bisa diedit" disabled />
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <x-form.textarea name="bio_demo" label="Bio (Textarea)" placeholder="Bisa di-resize ke bawah..." />
            <x-form.select name="role_demo" label="Role Pengguna" placeholder="Pilih role..." :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer']" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <x-form.checkbox name="terms_demo" label="Saya setuju (Checkbox)" checked />
                <x-form.checkbox name="news_demo" label="Newsletter" hint="Dapatkan update terbaru." />
            </div>
            <div>
                <x-form.radio name="gender_demo" value="male" label="Laki-laki (Radio)" checked />
                <x-form.radio name="gender_demo" value="female" label="Perempuan (Radio)" />
            </div>
        </div>

        <div>
            <h3 class="mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">Variasi Tombol</h3>
            <div class="flex flex-wrap gap-3 items-center">
                <x-form.button variant="primary">Primary</x-form.button>
                <x-form.button variant="secondary">Secondary</x-form.button>
                <x-form.button variant="danger">Danger</x-form.button>
                <x-form.button variant="success">Success</x-form.button>
                <x-form.button variant="ghost">Ghost</x-form.button>
                <x-form.button variant="primary" loading>Loading...</x-form.button>
            </div>
        </div>
    </div>

    {{-- SECTION: Full Form Demo --}}
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
        <h2 class="mb-5 text-xl font-semibold text-gray-900 dark:text-white">Demo: Form Tambah User Baru</h2>
        
        <form action="#" method="POST" class="max-w-2xl bg-gray-50 dark:bg-gray-800/50 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.input name="nama_depan" label="Nama Depan" required placeholder="John" />
                <x-form.input name="nama_belakang" label="Nama Belakang" required placeholder="Doe" />
            </div>
            
            <x-form.input name="email" type="email" label="Alamat Email" required placeholder="john@example.com" />
            <x-form.input name="password" type="password" label="Password Baru" required error="Password harus mengandung kombinasi angka dan huruf." value="lemah" />
            
            <x-form.select name="role" label="Tetapkan Role" :options="['admin' => 'Administrator', 'user' => 'Regular User']" />
            
            <x-form.textarea name="bio" label="Catatan Internal" rows="3" hint="Hanya bisa dilihat oleh admin." />
            
            <hr class="my-6 border-gray-200 dark:border-gray-700">
            
            <x-form.checkbox name="notify_email" label="Kirim kredensial via Email" checked />
            
            <div class="mt-6 flex justify-end gap-3">
                <x-form.button variant="secondary" type="button">Batal</x-form.button>
                <x-form.button variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Simpan User
                </x-form.button>
            </div>
        </form>
    </div>

</div>
@endsection