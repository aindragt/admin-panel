@extends('layouts.app')

@section('title', 'Data Table — ' . config('app.name'))
@section('page-title', 'Data Table (CRUD)')

@section('content')
@php
    
    $users = [
        ['id' => 1,  'name' => 'Budi Santoso',     'email' => 'budi@example.com',     'role' => 'Administrator', 'status' => 'active',   'created_at' => '12 Jan 2025'],
        ['id' => 2,  'name' => 'Siti Rahayu',      'email' => 'siti@example.com',     'role' => 'Editor',        'status' => 'active',   'created_at' => '15 Jan 2025'],
        ['id' => 3,  'name' => 'Ahmad Fauzi',      'email' => 'ahmad@example.com',    'role' => 'Viewer',        'status' => 'inactive', 'created_at' => '20 Jan 2025'],
        ['id' => 4,  'name' => 'Dewi Lestari',     'email' => 'dewi@example.com',     'role' => 'Editor',        'status' => 'active',   'created_at' => '25 Jan 2025'],
        ['id' => 5,  'name' => 'Rizky Pratama',    'email' => 'rizky@example.com',    'role' => 'Viewer',        'status' => 'active',   'created_at' => '01 Feb 2025'],
        ['id' => 6,  'name' => 'Maya Putri',       'email' => 'maya@example.com',     'role' => 'Editor',        'status' => 'inactive', 'created_at' => '05 Feb 2025'],
        ['id' => 7,  'name' => 'Hendra Wijaya',    'email' => 'hendra@example.com',   'role' => 'Administrator', 'status' => 'active',   'created_at' => '10 Feb 2025'],
        ['id' => 8,  'name' => 'Fitri Handayani',  'email' => 'fitri@example.com',    'role' => 'Viewer',        'status' => 'active',   'created_at' => '14 Feb 2025'],
        ['id' => 9,  'name' => 'Rudi Hartono',     'email' => 'rudi@example.com',     'role' => 'Editor',        'status' => 'active',   'created_at' => '18 Feb 2025'],
        ['id' => 10, 'name' => 'Ayu Kusuma',       'email' => 'ayu@example.com',      'role' => 'Viewer',        'status' => 'inactive', 'created_at' => '22 Feb 2025'],
    ];
@endphp

{{-- Page Header --}}
<div class="mb-6">
    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 mb-2" aria-label="Breadcrumb">
        <a href="{{ url('/') }}" class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">Home</a>
        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-700 dark:text-gray-200">Data Table</span>
    </nav>

    {{-- Title Row --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Manajemen Pengguna</h1>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Kelola daftar pengguna, peran, dan status akses mereka.</p>
        </div>
        {{-- Tombol Tambah --}}
        <button
            id="btn-add-user"
            @click="$dispatch('open-modal', { id: 'modal-add-user' })"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm shadow-indigo-500/20 transition-colors flex-shrink-0"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </button>
    </div>
</div>

{{-- Stats Summary --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @php
        $summaryStats = [
            ['label' => 'Total Pengguna', 'value' => '10',  'color' => 'indigo', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Aktif',          'value' => '7',   'color' => 'emerald','icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Non-aktif',      'value' => '3',   'color' => 'red',    'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Administrator',  'value' => '2',   'color' => 'amber',  'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        ];
    @endphp
    @foreach ($summaryStats as $stat)
        @php
            $colorMap = [
                'indigo'  => ['bg' => 'bg-indigo-50 dark:bg-indigo-900/20',  'icon' => 'text-indigo-600 dark:text-indigo-400', 'text' => 'text-indigo-700 dark:text-indigo-300'],
                'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-900/20','icon' => 'text-emerald-600 dark:text-emerald-400','text' => 'text-emerald-700 dark:text-emerald-300'],
                'red'     => ['bg' => 'bg-red-50 dark:bg-red-900/20',        'icon' => 'text-red-600 dark:text-red-400',       'text' => 'text-red-700 dark:text-red-300'],
                'amber'   => ['bg' => 'bg-amber-50 dark:bg-amber-900/20',    'icon' => 'text-amber-600 dark:text-amber-400',   'text' => 'text-amber-700 dark:text-amber-300'],
            ];
            $c = $colorMap[$stat['color']];
        @endphp
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 flex items-center gap-3 shadow-sm">
            <div class="w-10 h-10 rounded-lg {{ $c['bg'] }} flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
            </div>
        </div>
    @endforeach
</div>

{{-- Main Table Card --}}
<div
    x-data="{
        search: '',
        sortCol: 'id',
        sortDir: 'asc',
        selectedRows: [],
        allSelected: false,
        filterStatus: 'all',
        perPage: 10,
        users: {{ json_encode($users) }},
        get filtered() {
            let data = this.users;
            if (this.filterStatus !== 'all') {
                data = data.filter(u => u.status === this.filterStatus);
            }
            if (this.search.trim() !== '') {
                const q = this.search.toLowerCase();
                data = data.filter(u =>
                    u.name.toLowerCase().includes(q) ||
                    u.email.toLowerCase().includes(q) ||
                    u.role.toLowerCase().includes(q)
                );
            }
            return data.sort((a, b) => {
                let valA = a[this.sortCol];
                let valB = b[this.sortCol];
                if (typeof valA === 'string') valA = valA.toLowerCase();
                if (typeof valB === 'string') valB = valB.toLowerCase();
                if (valA < valB) return this.sortDir === 'asc' ? -1 : 1;
                if (valA > valB) return this.sortDir === 'asc' ? 1 : -1;
                return 0;
            });
        },
        setSort(col) {
            if (this.sortCol === col) {
                this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortCol = col;
                this.sortDir = 'asc';
            }
        },
        toggleAll() {
            if (this.allSelected) {
                this.selectedRows = this.filtered.map(u => u.id);
            } else {
                this.selectedRows = [];
            }
        },
        deleteUser(id) {
            if (confirm('Apakah kamu yakin ingin menghapus pengguna ini?')) {
                this.users = this.users.filter(u => u.id !== id);
                this.selectedRows = this.selectedRows.filter(r => r !== id);
            }
        },
        deleteSelected() {
            if (confirm('Hapus ' + this.selectedRows.length + ' pengguna yang dipilih?')) {
                this.users = this.users.filter(u => !this.selectedRows.includes(u.id));
                this.selectedRows = [];
                this.allSelected = false;
            }
        }
    }"
    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden"
>
    {{-- Table Toolbar --}}
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center gap-3">
        {{-- Search --}}
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input
                x-model="search"
                type="text"
                placeholder="Cari nama, email, atau role..."
                class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 transition"
            />
        </div>

        {{-- Filter Status --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            <select
                x-model="filterStatus"
                class="text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 transition"
            >
                <option value="all">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Non-aktif</option>
            </select>

            {{-- Bulk Delete button (muncul saat ada yang dipilih) --}}
            <button
                x-show="selectedRows.length > 0"
                x-transition
                @click="deleteSelected()"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors"
                style="display: none;"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus (<span x-text="selectedRows.length"></span>)
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    {{-- Checkbox All --}}
                    <th class="w-10 px-4 py-3">
                        <input
                            type="checkbox"
                            x-model="allSelected"
                            @change="toggleAll()"
                            class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500"
                        />
                    </th>
                    {{-- Sortable Headers --}}
                    @php
                        $headers = [
                            ['key' => 'id',         'label' => '#'],
                            ['key' => 'name',       'label' => 'Nama'],
                            ['key' => 'role',       'label' => 'Role'],
                            ['key' => 'status',     'label' => 'Status'],
                            ['key' => 'created_at', 'label' => 'Bergabung'],
                        ];
                    @endphp
                    @foreach ($headers as $header)
                        <th
                            @click="setSort('{{ $header['key'] }}')"
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer select-none hover:text-gray-700 dark:hover:text-gray-200 transition-colors whitespace-nowrap"
                        >
                            <div class="flex items-center gap-1">
                                {{ $header['label'] }}
                                <span x-show="sortCol === '{{ $header['key'] }}'" class="text-indigo-500">
                                    <svg x-show="sortDir === 'asc'"  class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                    <svg x-show="sortDir === 'desc'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                                <svg x-show="sortCol !== '{{ $header['key'] }}'" class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </div>
                        </th>
                    @endforeach
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                {{-- Empty State --}}
                <template x-if="filtered.length === 0">
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada data ditemukan</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Coba ubah kata kunci pencarian atau filter.</p>
                            </div>
                        </td>
                    </tr>
                </template>

                {{-- Data Rows --}}
                <template x-for="user in filtered" :key="user.id">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors" :class="selectedRows.includes(user.id) ? 'bg-indigo-50/50 dark:bg-indigo-900/10' : ''">
                        {{-- Checkbox --}}
                        <td class="px-4 py-3">
                            <input
                                type="checkbox"
                                :value="user.id"
                                x-model="selectedRows"
                                class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500"
                            />
                        </td>
                        {{-- ID --}}
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 font-mono text-xs" x-text="'#' + String(user.id).padStart(3, '0')"></td>
                        {{-- Nama & Email --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                    x-text="user.name.split(' ').map(n => n[0]).join('').slice(0,2).toUpperCase()">
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate" x-text="user.name"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="user.email"></p>
                                </div>
                            </div>
                        </td>
                        {{-- Role Badge --}}
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium"
                                :class="{
                                    'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-400': user.role === 'Administrator',
                                    'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400': user.role === 'Editor',
                                    'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400': user.role === 'Viewer',
                                }"
                                x-text="user.role"
                            ></span>
                        </td>
                        {{-- Status Badge --}}
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="{
                                    'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400': user.status === 'active',
                                    'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400': user.status === 'inactive',
                                }"
                            >
                                <span
                                    class="w-1.5 h-1.5 rounded-full"
                                    :class="{
                                        'bg-emerald-500': user.status === 'active',
                                        'bg-gray-400 dark:bg-gray-500': user.status === 'inactive',
                                    }"
                                ></span>
                                <span x-text="user.status === 'active' ? 'Aktif' : 'Non-aktif'"></span>
                            </span>
                        </td>
                        {{-- Tanggal Bergabung --}}
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-sm" x-text="user.created_at"></td>
                        {{-- Tombol Aksi --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                {{-- Tombol Detail --}}
                                <button
                                    @click="$dispatch('open-modal', { id: 'modal-detail-user', data: user })"
                                    title="Lihat Detail"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/20 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                {{-- Tombol Edit --}}
                                <button
                                    @click="$dispatch('open-modal', { id: 'modal-edit-user', data: user })"
                                    title="Edit Pengguna"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                {{-- Tombol Hapus --}}
                                <button
                                    @click="deleteUser(user.id)"
                                    title="Hapus Pengguna"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:text-red-400 dark:hover:bg-red-900/20 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    {{-- Table Footer: Count + Pagination --}}
    <div class="px-5 py-3.5 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan <span class="font-medium text-gray-700 dark:text-gray-300" x-text="filtered.length"></span> dari
            <span class="font-medium text-gray-700 dark:text-gray-300" x-text="users.length"></span> pengguna
            <template x-if="selectedRows.length > 0">
                <span class="text-indigo-600 dark:text-indigo-400"> · <span x-text="selectedRows.length"></span> dipilih</span>
            </template>
        </p>

        {{-- Pagination Demo (statis) --}}
        <div class="flex items-center gap-1">
            <button class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors disabled:opacity-40" disabled>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="px-3 py-1.5 text-xs rounded-lg bg-indigo-600 text-white font-medium">1</button>
            <button class="px-3 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">2</button>
            <button class="px-3 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">3</button>
            <button class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- ============================================================
     MODALS
     ============================================================ --}}

{{-- Modal: Tambah Pengguna --}}
<div
    x-data="{ open: false, user: null }"
    @open-modal.window="if ($event.detail.id === 'modal-add-user') { open = true }"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 z-10"
    >
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Tambah Pengguna Baru</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Isi data pengguna yang akan ditambahkan.</p>
            </div>
            <button @click="open = false" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        {{-- Modal Body --}}
        <div class="px-6 py-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form.input name="add_first_name" label="Nama Depan" placeholder="Budi" :required="true" />
                <x-form.input name="add_last_name"  label="Nama Belakang" placeholder="Santoso" />
            </div>
            <x-form.input name="add_email" type="email" label="Alamat Email" placeholder="budi@example.com" :required="true" />
            <x-form.input name="add_password" type="password" label="Password" placeholder="Min. 8 karakter" :required="true" />
            <x-form.select
                name="add_role"
                label="Role"
                :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer']"
                :required="true"
            />
        </div>
        {{-- Modal Footer --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            <x-form.button variant="secondary" type="button" @click="open = false">Batal</x-form.button>
            <x-form.button variant="primary" type="button">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna
            </x-form.button>
        </div>
    </div>
</div>

{{-- Modal: Edit Pengguna --}}
<div
    x-data="{ open: false, user: {} }"
    @open-modal.window="if ($event.detail.id === 'modal-edit-user') { user = $event.detail.data; open = true }"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative w-full max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 z-10"
    >
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Edit Pengguna</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui data pengguna <span class="font-medium text-indigo-600 dark:text-indigo-400" x-text="user.name"></span>.</p>
            </div>
            <button @click="open = false" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                <input type="text" :value="user.name" class="w-full px-3.5 py-2.5 rounded-lg text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 transition" />
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email</label>
                <input type="email" :value="user.email" class="w-full px-3.5 py-2.5 rounded-lg text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 transition" />
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Role</label>
                <select :value="user.role" class="w-full px-3.5 py-2.5 rounded-lg text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 transition">
                    <option value="Administrator" :selected="user.role === 'Administrator'">Administrator</option>
                    <option value="Editor" :selected="user.role === 'Editor'">Editor</option>
                    <option value="Viewer" :selected="user.role === 'Viewer'">Viewer</option>
                </select>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                <select :value="user.status" class="w-full px-3.5 py-2.5 rounded-lg text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 transition">
                    <option value="active"   :selected="user.status === 'active'">Aktif</option>
                    <option value="inactive" :selected="user.status === 'inactive'">Non-aktif</option>
                </select>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            <x-form.button variant="secondary" type="button" @click="open = false">Batal</x-form.button>
            <x-form.button variant="primary" type="button">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan
            </x-form.button>
        </div>
    </div>
</div>

{{-- Modal: Detail Pengguna --}}
<div
    x-data="{ open: false, user: {} }"
    @open-modal.window="if ($event.detail.id === 'modal-detail-user') { user = $event.detail.data; open = true }"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 z-10"
    >
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Detail Pengguna</h2>
            <button @click="open = false" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5">
            {{-- Avatar --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold flex-shrink-0"
                    x-text="user.name ? user.name.split(' ').map(n => n[0]).join('').slice(0,2).toUpperCase() : ''">
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-900 dark:text-white" x-text="user.name"></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="user.email"></p>
                    <span
                        class="mt-1 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="{
                            'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400': user.status === 'active',
                            'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400': user.status === 'inactive',
                        }"
                    >
                        <span class="w-1.5 h-1.5 rounded-full"
                            :class="{ 'bg-emerald-500': user.status === 'active', 'bg-gray-400': user.status !== 'active' }">
                        </span>
                        <span x-text="user.status === 'active' ? 'Aktif' : 'Non-aktif'"></span>
                    </span>
                </div>
            </div>
            {{-- Detail List --}}
            <dl class="space-y-3">
                <div class="flex justify-between text-sm">
                    <dt class="text-gray-500 dark:text-gray-400">ID Pengguna</dt>
                    <dd class="font-mono font-medium text-gray-900 dark:text-white" x-text="'#' + String(user.id ?? '').padStart(3, '0')"></dd>
                </div>
                <div class="flex justify-between text-sm">
                    <dt class="text-gray-500 dark:text-gray-400">Role</dt>
                    <dd class="font-medium text-gray-900 dark:text-white" x-text="user.role"></dd>
                </div>
                <div class="flex justify-between text-sm">
                    <dt class="text-gray-500 dark:text-gray-400">Bergabung</dt>
                    <dd class="font-medium text-gray-900 dark:text-white" x-text="user.created_at"></dd>
                </div>
            </dl>
        </div>
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            <x-form.button variant="secondary" type="button" @click="open = false">Tutup</x-form.button>
            <x-form.button variant="primary" type="button" @click="open = false; $dispatch('open-modal', { id: 'modal-edit-user', data: user })">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </x-form.button>
        </div>
    </div>
</div>

@endsection
