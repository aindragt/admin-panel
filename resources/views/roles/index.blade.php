@extends('layouts.app')

@section('title', 'Role & Permission - Admin Panel')

@section('content')
<div x-data="{
    showDeleteModal: false,
    selectedRoleName: '',
    selectedRoleUserCount: 0,
    selectedRoleId: null,
    
    openDeleteModal(role) {
        this.selectedRoleId = role.id;
        this.selectedRoleName = role.name;
        this.selectedRoleUserCount = role.user_count;
        this.showDeleteModal = true;
    },
    
    closeDeleteModal() {
        this.showDeleteModal = false;
        this.selectedRoleId = null;
        this.selectedRoleName = '';
        this.selectedRoleUserCount = 0;
    }
}" class="space-y-6">
    {{-- Header & Breadcrumbs --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 md:ml-2 text-gray-400 dark:text-gray-500">Settings</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 md:ml-2 font-medium text-gray-700 dark:text-gray-300">Role & Permission</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Hak Akses</h1>
        </div>
        
        <div>
            <a href="{{ route('roles.create') }}">
                <x-form.button variant="primary">
                    <svg class="w-5 h-5 -ml-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Role Baru
                </x-form.button>
            </a>
        </div>
    </div>

    @php
    $roles = [
        [
            'id'          => 1,
            'name'        => 'Super Administrator',
            'description' => 'Memiliki akses penuh ke seluruh sistem tanpa batasan.',
            'user_count'  => 1,
            'color'       => 'purple',
            'is_system'   => true,
        ],
        [
            'id'          => 2,
            'name'        => 'Administrator',
            'description' => 'Mengelola konten dan pengguna, namun tidak dapat mengubah konfigurasi sistem.',
            'user_count'  => 3,
            'color'       => 'indigo',
            'is_system'   => false,
        ],
        [
            'id'          => 3,
            'name'        => 'Editor',
            'description' => 'Dapat membuat dan mengedit konten, namun tidak dapat menghapus atau mengelola pengguna.',
            'user_count'  => 8,
            'color'       => 'blue',
            'is_system'   => false,
        ],
        [
            'id'          => 4,
            'name'        => 'Moderator',
            'description' => 'Fokus pada moderasi komentar dan konten yang diajukan pengguna.',
            'user_count'  => 5,
            'color'       => 'green',
            'is_system'   => false,
        ],
        [
            'id'          => 5,
            'name'        => 'Viewer',
            'description' => 'Hanya dapat melihat data laporan dan dashboard. Tidak ada akses tulis.',
            'user_count'  => 0,
            'color'       => 'gray',
            'is_system'   => false,
        ],
    ];

    $colorMap = [
        'purple' => 'bg-purple-500',
        'indigo' => 'bg-indigo-500',
        'blue'   => 'bg-blue-500',
        'green'  => 'bg-green-500',
        'gray'   => 'bg-gray-400',
    ];
    @endphp

    {{-- Main Card Table --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30 text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Role</th>
                        <th class="px-6 py-4 text-center">User</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($roles as $role)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $colorMap[$role['color']] ?? 'bg-gray-400' }}"></span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $role['name'] }}</span>
                                    @if ($role['is_system'])
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border border-purple-100 dark:border-purple-800/50">
                                            System
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-200/50 dark:border-gray-700/50">
                                    {{ $role['user_count'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600 dark:text-gray-400 line-clamp-2 max-w-lg">{{ $role['description'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('roles.edit', $role['id']) }}">
                                        <x-form.button variant="ghost" size="sm">
                                            Edit
                                        </x-form.button>
                                    </a>
                                    
                                    <x-form.button 
                                        variant="danger" 
                                        size="sm" 
                                        :disabled="$role['is_system']"
                                        @click="openDeleteModal({{ Js::from($role) }})"
                                    >
                                        Hapus
                                    </x-form.button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Interactive Alpine.js Modal for Dual Actions (Warning vs Standard Confirmation) --}}
    <template x-teleport="body">
        <div 
            x-show="showDeleteModal" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;"
            @keydown.escape.window="closeDeleteModal()"
        >
            {{-- Backdrop overlay --}}
            <div 
                x-show="showDeleteModal" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black/60 backdrop-blur-sm"
                @click="closeDeleteModal()"
            ></div>

            {{-- Modal Wrapper --}}
            <div class="flex items-center justify-center min-h-screen p-4">
                <div 
                    x-show="showDeleteModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-md w-full border border-gray-100 dark:border-gray-800 overflow-hidden transition-all"
                >
                    {{-- Warning Modal: user_count > 0 --}}
                    <div x-show="selectedRoleUserCount > 0" class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-amber-50 dark:bg-amber-950/30 text-amber-500 dark:text-amber-400 rounded-full mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-center text-gray-900 dark:text-white mb-2">⚠️ Tidak Dapat Menghapus Role</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center leading-relaxed mb-6">
                            Role <strong class="text-gray-900 dark:text-white">"<span x-text="selectedRoleName"></span>"</strong> tidak dapat dihapus karena masih digunakan oleh <strong class="text-gray-900 dark:text-white"><span x-text="selectedRoleUserCount"></span> pengguna aktif</strong>.
                            <br><br>
                            Pindahkan semua pengguna ke role lain terlebih dahulu sebelum menghapus role ini.
                        </p>
                        <div class="flex justify-center">
                            <x-form.button variant="secondary" class="w-full sm:w-auto px-6" @click="closeDeleteModal()">
                                Mengerti
                            </x-form.button>
                        </div>
                    </div>

                    {{-- Standard Confirmation Modal: user_count === 0 --}}
                    <div x-show="selectedRoleUserCount === 0" class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-50 dark:bg-red-950/30 text-red-500 dark:text-red-400 rounded-full mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-center text-gray-900 dark:text-white mb-2">Konfirmasi Hapus Role</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                            Apakah Anda yakin ingin menghapus role <strong class="text-gray-900 dark:text-white">"<span x-text="selectedRoleName"></span>"</strong>? Tindakan ini tidak dapat dibatalkan.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                            <x-form.button variant="secondary" class="w-full sm:w-auto" @click="closeDeleteModal()">
                                Batal
                            </x-form.button>
                            <x-form.button variant="danger" class="w-full sm:w-auto" @click="closeDeleteModal()">
                                Ya, Hapus Role
                            </x-form.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
