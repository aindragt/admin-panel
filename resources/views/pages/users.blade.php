@extends('layouts.app')

@section('title', 'Data Table (CRUD) — ' . config('app.name', 'Admin Panel'))
@section('page-title', 'Data Table (CRUD)')

@section('content')
<div x-data="{
    showCreateModal: false,
    showEditModal: false,
    showDeleteModal: false,
    selectedUser: null,
    searchQuery: '',
    statusFilter: 'all',
    users: [
        { id: 1, name: 'Budi Santoso', email: 'budi@example.com', role: 'admin', status: 'active', registered: '2026-07-20' },
        { id: 2, name: 'Ani Wijaya', email: 'ani@example.com', role: 'editor', status: 'active', registered: '2026-07-22' },
        { id: 3, name: 'Bambang Pamungkas', email: 'bambang@example.com', role: 'viewer', status: 'inactive', registered: '2026-07-24' },
        { id: 4, name: 'Citra Kirana', email: 'citra@example.com', role: 'editor', status: 'active', registered: '2026-07-25' },
        { id: 5, name: 'Dedi Kurniawan', email: 'dedi@example.com', role: 'viewer', status: 'active', registered: '2026-07-26' },
        { id: 6, name: 'Eka Putri', email: 'eka@example.com', role: 'viewer', status: 'inactive', registered: '2026-07-28' }
    ],
    newUser: { name: '', email: '', role: 'viewer', status: 'active' },
    editUser: { id: null, name: '', email: '', role: 'viewer', status: 'active' },
    
    get filteredUsers() {
        return this.users.filter(user => {
            const matchesSearch = user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                  user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesStatus = this.statusFilter === 'all' || user.status === this.statusFilter;
            return matchesSearch && matchesStatus;
        });
    },

    openEdit(user) {
        this.editUser = { ...user };
        this.showEditModal = true;
    },

    openDelete(user) {
        this.selectedUser = user;
        this.showDeleteModal = true;
    },

    addUser() {
        if (!this.newUser.name || !this.newUser.email) return;
        const newId = this.users.length ? Math.max(...this.users.map(u => u.id)) + 1 : 1;
        const today = new Date().toISOString().slice(0, 10);
        this.users.push({
            id: newId,
            name: this.newUser.name,
            email: this.newUser.email,
            role: this.newUser.role,
            status: this.newUser.status,
            registered: today
        });
        this.newUser = { name: '', email: '', role: 'viewer', status: 'active' };
        this.showCreateModal = false;
    },

    updateUser() {
        if (!this.editUser.name || !this.editUser.email) return;
        const index = this.users.findIndex(u => u.id === this.editUser.id);
        if (index !== -1) {
            this.users[index] = { ...this.users[index], ...this.editUser };
        }
        this.showEditModal = false;
    },

    deleteUser() {
        if (!this.selectedUser) return;
        this.users = this.users.filter(u => u.id !== this.selectedUser.id);
        this.showDeleteModal = false;
        this.selectedUser = null;
    }
}" class="space-y-6">

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        {{-- Search & Filter --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1 max-w-xl">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari nama atau email..." 
                    class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
            </div>
            <div>
                <select 
                    x-model="statusFilter" 
                    class="w-full sm:w-auto px-3.5 py-2 text-sm border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"
                >
                    <option value="all">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>

        {{-- Add Button --}}
        <div>
            <x-form.button @click="showCreateModal = true" variant="primary" class="w-full sm:w-auto gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Pengguna
            </x-form.button>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama & Email</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800 text-sm text-gray-700 dark:text-gray-300">
                    <template x-for="user in filteredUsers" :key="user.id">
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white" x-text="user.name"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="user.email"></div>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold uppercase" x-text="user.role"></td>
                            <td class="px-6 py-4">
                                <span :class="user.status === 'active' 
                                    ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400' 
                                    : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400'"
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                    x-text="user.status === 'active' ? 'Aktif' : 'Nonaktif'"
                                ></span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400" x-text="user.registered"></td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button @click="openEdit(user)" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-xs font-semibold">
                                    Edit
                                </button>
                                <button @click="openDelete(user)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-xs font-semibold">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredUsers.length === 0" style="display: none;">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data pengguna ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create Modal --}}
    <div x-show="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" x-cloak>
        <div @click="showCreateModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 dark:text-white">Tambah Pengguna Baru</h3>
                <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form @submit.prevent="addUser()" class="p-6 space-y-4">
                <x-form.input name="name" x-model="newUser.name" label="Nama Lengkap" placeholder="Masukkan nama..." :required="true" />
                <x-form.input name="email" type="email" x-model="newUser.email" label="Alamat Email" placeholder="nama@email.com" :required="true" />
                
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
                    <select x-model="newUser.role" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select x-model="newUser.status" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <x-form.button @click="showCreateModal = false" variant="secondary" type="button">Batal</x-form.button>
                    <x-form.button variant="primary" type="submit">Tambah</x-form.button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" x-cloak>
        <div @click="showEditModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 dark:text-white">Ubah Data Pengguna</h3>
                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form @submit.prevent="updateUser()" class="p-6 space-y-4">
                <x-form.input name="edit_name" x-model="editUser.name" label="Nama Lengkap" placeholder="Masukkan nama..." :required="true" />
                <x-form.input name="edit_email" type="email" x-model="editUser.email" label="Alamat Email" placeholder="nama@email.com" :required="true" />
                
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
                    <select x-model="editUser.role" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select x-model="editUser.status" class="w-full px-3.5 py-2.5 text-sm border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <x-form.button @click="showEditModal = false" variant="secondary" type="button">Batal</x-form.button>
                    <x-form.button variant="primary" type="submit">Simpan</x-form.button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" x-cloak>
        <div @click="showDeleteModal = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="p-6 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-950/30 flex items-center justify-center mx-auto text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Data Pengguna?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Apakah Anda yakin ingin menghapus data pengguna <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="selectedUser?.name"></span>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <x-form.button @click="showDeleteModal = false" variant="secondary">Batal</x-form.button>
                    <x-form.button @click="deleteUser()" variant="danger">Hapus Sekarang</x-form.button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
