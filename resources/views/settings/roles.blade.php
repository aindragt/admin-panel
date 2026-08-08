@extends('layouts.app')

@section('title', 'Role & Permission — ' . config('app.name'))
@section('page-title', 'Role & Permission')

@section('content')
    @php
    $roles = [
        ['id' => 1, 'name' => 'Super Admin',  'description' => 'Akses penuh ke semua fitur',         'user_count' => 1,  'is_system' => true,  'permissions' => ['user_view', 'user_create', 'user_edit', 'user_delete', 'content_view', 'content_create', 'content_edit', 'content_delete', 'reports_view', 'reports_export', 'system_view', 'system_manage', 'system_roles_manage']],
        ['id' => 2, 'name' => 'Manajer',      'description' => 'Akses ke laporan dan pengguna',       'user_count' => 3,  'is_system' => false, 'permissions' => ['user_view', 'user_create', 'user_edit', 'content_view', 'reports_view', 'reports_export', 'system_view']],
        ['id' => 3, 'name' => 'Kasir',        'description' => 'Akses ke data transaksi saja',        'user_count' => 8,  'is_system' => false, 'permissions' => ['content_view', 'content_create', 'content_edit']],
        ['id' => 4, 'name' => 'Viewer',       'description' => 'Hanya bisa melihat data',             'user_count' => 12, 'is_system' => false, 'permissions' => ['content_view', 'reports_view', 'system_view']],
    ];

    $permissionGroups = [
        [
            'title' => 'User Management',
            'icon' => '<svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            'permissions' => [
                ['key' => 'user_view', 'label' => 'Lihat Pengguna'],
                ['key' => 'user_create', 'label' => 'Tambah Pengguna'],
                ['key' => 'user_edit', 'label' => 'Edit Pengguna'],
                ['key' => 'user_delete', 'label' => 'Hapus Pengguna'],
            ]
        ],
        [
            'title' => 'Content Management',
            'icon' => '<svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
            'permissions' => [
                ['key' => 'content_view', 'label' => 'Lihat Konten'],
                ['key' => 'content_create', 'label' => 'Buat Konten'],
                ['key' => 'content_edit', 'label' => 'Edit Konten'],
                ['key' => 'content_delete', 'label' => 'Hapus Konten'],
            ]
        ],
        [
            'title' => 'Reports & Analytics',
            'icon' => '<svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
            'permissions' => [
                ['key' => 'reports_view', 'label' => 'Lihat Laporan'],
                ['key' => 'reports_export', 'label' => 'Export Laporan'],
            ]
        ],
        [
            'title' => 'System Settings',
            'icon' => '<svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            'permissions' => [
                ['key' => 'system_view', 'label' => 'Lihat Pengaturan'],
                ['key' => 'system_manage', 'label' => 'Kelola Pengaturan'],
                ['key' => 'system_roles_manage', 'label' => 'Kelola Role & Permission'],
            ]
        ],
    ];
    @endphp

    <div x-data="{
        roles: {{ Js::from($roles) }},
        permissionGroups: {{ Js::from($permissionGroups) }},
        showModal: false,
        showDeleteConfirm: false,
        roleToDelete: null,
        editMode: false,
        roleId: null,
        roleName: '',
        roleDescription: '',
        selectedPermissions: [],

        openAdd() {
            this.editMode = false;
            this.roleId = null;
            this.roleName = '';
            this.roleDescription = '';
            this.selectedPermissions = [];
            this.showModal = true;
        },

        openEdit(role) {
            this.editMode = true;
            this.roleId = role.id;
            this.roleName = role.name;
            this.roleDescription = role.description;
            this.selectedPermissions = [...role.permissions];
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        toggleGroup(groupIndex) {
            const groupPerms = this.permissionGroups[groupIndex].permissions.map(p => p.key);
            const allSelected = groupPerms.every(key => this.selectedPermissions.includes(key));
            
            if (allSelected) {
                // remove all keys of this group
                this.selectedPermissions = this.selectedPermissions.filter(key => !groupPerms.includes(key));
            } else {
                // add missing keys of this group
                groupPerms.forEach(key => {
                    if (!this.selectedPermissions.includes(key)) {
                        this.selectedPermissions.push(key);
                    }
                });
            }
        },

        isGroupFullySelected(groupIndex) {
            const groupPerms = this.permissionGroups[groupIndex].permissions.map(p => p.key);
            return groupPerms.every(key => this.selectedPermissions.includes(key));
        },

        confirmDelete(role) {
            if (role.is_system) return;
            this.roleToDelete = role;
            this.showDeleteConfirm = true;
        },

        deleteRole() {
            if (this.roleToDelete) {
                this.roles = this.roles.filter(r => r.id !== this.roleToDelete.id);
                this.showDeleteConfirm = false;
                this.roleToDelete = null;
            }
        },

        saveRole() {
            if (!this.roleName.trim()) return;

            if (this.editMode) {
                // Edit existing
                this.roles = this.roles.map(r => {
                    if (r.id === this.roleId) {
                        return {
                            ...r,
                            name: this.roleName,
                            description: this.roleDescription,
                            permissions: [...this.selectedPermissions]
                        };
                    }
                    return r;
                });
            } else {
                // Add new
                const newId = this.roles.length ? Math.max(...this.roles.map(r => r.id)) + 1 : 1;
                this.roles.push({
                    id: newId,
                    name: this.roleName,
                    description: this.roleDescription,
                    user_count: 0,
                    is_system: false,
                    permissions: [...this.selectedPermissions]
                });
            }
            this.closeModal();
        }
    }" class="space-y-6">

        {{-- BREADCRUMBS & HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-2">
            <div>
                {{-- Breadcrumbs --}}
                <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="ml-1 md:ml-2">Settings</span>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                <span class="ml-1 md:ml-2 text-gray-800 dark:text-gray-200 font-medium">Role & Permission</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Role & Permission</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola peran pengguna dan konfigurasi izin akses fitur secara granular.</p>
            </div>
            
            <div>
                <x-form.button @click="openAdd()" variant="primary" class="w-full md:w-auto">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Role
                </x-form.button>
            </div>
        </div>

        {{-- TABLE: DAFTAR ROLE --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Role</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah Pengguna</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <template x-for="role in roles" :key="role.id">
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                                {{-- Nama & Deskripsi --}}
                                <td class="px-6 py-4.5">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white" x-text="role.name"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="role.description"></p>
                                    </div>
                                </td>

                                {{-- Jumlah Pengguna --}}
                                <td class="px-6 py-4.5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300">
                                        <span x-text="role.user_count"></span> User
                                    </span>
                                </td>

                                {{-- Status (System / Custom) --}}
                                <td class="px-6 py-4.5">
                                    <template x-if="role.is_system">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                            System Role
                                        </span>
                                    </template>
                                    <template x-if="!role.is_system">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Custom Role
                                        </span>
                                    </template>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4.5 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-form.button @click="openEdit(role)" variant="ghost" size="sm" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700">
                                            Edit
                                        </x-form.button>

                                        <x-form.button 
                                            @click="confirmDelete(role)" 
                                            variant="ghost" 
                                            size="sm" 
                                            class="text-red-600 dark:text-red-400 hover:text-red-700 disabled:opacity-30 disabled:cursor-not-allowed"
                                            ::disabled="role.is_system"
                                        >
                                            Hapus
                                        </x-form.button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-800 text-center">
                <p class="text-xs text-gray-400 dark:text-gray-500" x-text="'Menampilkan ' + roles.length + ' dari ' + roles.length + ' role'"></p>
            </div>
        </div>

        {{-- MODAL FORM: TAMBAH / EDIT ROLE --}}
        <div 
            x-show="showModal" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="closeModal()"
        >
            {{-- Dark Overlay --}}
            <div class="fixed inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm" @click="closeModal()"></div>

            {{-- Modal Wrapper --}}
            <div class="flex items-center justify-center min-h-screen p-4">
                <div 
                    x-show="showModal"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative w-full max-w-4xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]"
                >
                    
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between px-6 py-4.5 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="editMode ? 'Edit Role: ' + roleName : 'Tambah Role Baru'"></h3>
                        <button @click="closeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Body (Scrollable) --}}
                    <div class="p-6 overflow-y-auto space-y-6 flex-1">
                        
                        {{-- Form Inputs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-form.input 
                                    name="role_name" 
                                    label="Nama Role" 
                                    placeholder="Masukkan nama role (contoh: Editor)" 
                                    required 
                                    x-model="roleName"
                                />
                            </div>
                            <div>
                                <x-form.input 
                                    name="role_description" 
                                    label="Deskripsi" 
                                    placeholder="Masukkan deskripsi singkat fungsi role" 
                                    x-model="roleDescription"
                                />
                            </div>
                        </div>

                        {{-- Permissions Checklist Section --}}
                        <div class="space-y-4 border-t border-gray-100 dark:border-gray-800 pt-6">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Hak Akses & Otorisasi</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tentukan fitur apa saja yang dapat diakses oleh peran ini.</p>
                            </div>

                            {{-- Permissions Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <template x-for="(group, gIndex) in permissionGroups" :key="group.title">
                                    <div class="bg-gray-50/50 dark:bg-gray-800/20 border border-gray-200/60 dark:border-gray-800/80 rounded-xl p-4.5 space-y-3.5">
                                        
                                        {{-- Group Header --}}
                                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
                                            <div class="flex items-center gap-2">
                                                <span x-html="group.icon" class="flex-shrink-0"></span>
                                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200" x-text="group.title"></span>
                                            </div>
                                            <button 
                                                type="button" 
                                                @click="toggleGroup(gIndex)"
                                                class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300"
                                                x-text="isGroupFullySelected(gIndex) ? 'Lepas Semua' : 'Pilih Semua'"
                                            ></button>
                                        </div>

                                        {{-- Group Checkboxes --}}
                                        <div class="space-y-2.5">
                                            <template x-for="perm in group.permissions" :key="perm.key">
                                                <div class="flex items-start gap-2.5">
                                                    <div class="flex h-5 items-center">
                                                        <input
                                                            type="checkbox"
                                                            :id="'perm_' + perm.key"
                                                            :value="perm.key"
                                                            x-model="selectedPermissions"
                                                            class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0"
                                                        />
                                                    </div>
                                                    <div class="text-sm leading-5">
                                                        <label :for="'perm_' + perm.key" class="font-medium text-gray-700 dark:text-gray-300 cursor-pointer select-none" x-text="perm.label"></label>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                    </div>
                                </template>
                            </div>

                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/10">
                        <x-form.button @click="closeModal()" variant="secondary">
                            Batal
                        </x-form.button>
                        <x-form.button @click="saveRole()" variant="primary" ::disabled="!roleName.trim()">
                            Simpan Perubahan
                        </x-form.button>
                    </div>

                </div>
            </div>
        </div>

        {{-- CONFIRM DELETE MODAL --}}
        <div 
            x-show="showDeleteConfirm" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            {{-- Dark Overlay --}}
            <div class="fixed inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm" @click="showDeleteConfirm = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4">
                <div 
                    x-show="showDeleteConfirm"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative w-full max-w-md bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-xl p-6 space-y-4"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">Hapus Peran?</h4>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Apakah Anda yakin ingin menghapus peran <strong x-text="roleToDelete ? roleToDelete.name : ''"></strong>? Pengguna dengan peran ini tidak akan bisa mengakses resource terkait. Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <x-form.button @click="showDeleteConfirm = false" variant="secondary" size="sm">
                            Batal
                        </x-form.button>
                        <x-form.button @click="deleteRole()" variant="danger" size="sm">
                            Ya, Hapus
                        </x-form.button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
